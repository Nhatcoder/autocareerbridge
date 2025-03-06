<?php

namespace App\Services\ScheduleInterView;

use Google\Service\Calendar;
use Google\Service\Calendar\Event;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Services\Managements\AuthService;
use App\Repositories\User\UserRepositoryInterface;
use App\Services\Notification\NotificationService;
use App\Repositories\UserJob\UserJobRepositoryInterface;
use App\Repositories\ScheduleInterView\ScheduleInterViewRepositoryInterface;

/**
 * CRUD, Schedule and Event Google Clendar Api of ScheduleInterViewService
 * @author TranVanNhat <tranvannhat7624@gmail.com>
 * @see scheduleInterViewStore($data)
 */
class ScheduleInterViewService
{
    protected $scheduleInterViewRepository;
    protected $authService;
    protected $userRepository;
    protected $userJobRepository;
    protected $notificationService;

    public function __construct(
        ScheduleInterViewRepositoryInterface $scheduleInterViewRepository,
        AuthService $authService,
        UserRepositoryInterface $userRepository,
        NotificationService $notificationService,
        UserJobRepositoryInterface $userJobRepository
    ) {
        $this->scheduleInterViewRepository = $scheduleInterViewRepository;
        $this->authService = $authService;
        $this->userRepository = $userRepository;
        $this->userJobRepository = $userJobRepository;
        $this->notificationService = $notificationService;
    }

    /**
     * Store scheduleInterView, Interviews in the database, Insert Google Calendar event
     * @author TranVanNhat <tranvannhat7624@gmail.com>
     * @param array $data
     * @return mixed
     */
    public function scheduleInterViewStore($data)
    {
        try {
            DB::beginTransaction();
            $attendees = [];
            if (isset($data['user_ids'])) {
                $users = $this->userRepository->getUserByIds($data['user_ids']);
                foreach ($users as $user) {
                    $attendees[] = ['email' => $user->email];
                }
            }

            $client = $this->authService->getGoogleClient();
            $service = new Calendar($client);

            $eventData = [
                'summary' => $data['summary'],
                'location' => $data['location'],
                'description' => $data['description'],
                'start' => [
                    'dateTime' => $data['start']['dateTime'],
                    'timeZone' => 'Asia/Ho_Chi_Minh',
                ],
                'end' => [
                    'dateTime' => $data['end']['dateTime'],
                    'timeZone' => 'Asia/Ho_Chi_Minh',
                ],
                'attendees' => $attendees,
                'guestsCanSeeOtherGuests' => true,
            ];

            if ($data['type'] == TYPE_SCHEDULE_ON) {
                $eventData['conferenceData'] = [
                    'createRequest' => [
                        'requestId' => uniqid(),
                        'conferenceSolutionKey' => ['type' => 'hangoutsMeet']
                    ]
                ];
                $optParams = ['conferenceDataVersion' => 1];
            } else {
                $optParams = [];
            }

            $event = new Event($eventData);
            $calendarId = 'primary';
            $event = $service->events->insert($calendarId, $event, $optParams);

            // Sotre scheduleData
            $scheduleData = [
                'company_id' => Auth::guard('admin')->user()->id,
                'job_id' => $data['job_id'],
                'title' => $data['summary'],
                'description' => $data['description'],
                'location' => $data['location'],
                'start_date' => $data['start']['dateTime'],
                'end_date' => $data['end']['dateTime'],
                'event_id' => $event->id,
                'type' => $data['type'],
            ];

            if ($data['type'] == TYPE_SCHEDULE_ON && isset($event->conferenceData->entryPoints[0]->uri)) {
                $scheduleData['link'] = $event->conferenceData->entryPoints[0]->uri;
            }

            $scheduleInterView = $this->scheduleInterViewRepository->create($scheduleData);

            // Store user_ids
            if (isset($data['user_ids'])) {
                $scheduleInterView->users()->sync($data['user_ids']);

                $firstUserJob = $this->userJobRepository->getUserJob($data['user_ids'][0]);
                $companyName = $firstUserJob->job->company->name ?? NAME_COMPANY;

                // Send notifications to users
                foreach ($data['user_ids'] as $userId) {
                    $userJob = $this->userJobRepository->getUserJob($userId);
                    if ($userJob) {
                        $notification = $this->notificationService->create([
                            'user_id' => $userJob->user_id,
                            'title' => 'Bạn có cuộc phỏng vấn với ' . $companyName .
                                ', vị trí ' . $userJob->job->name . ', vào lúc ' .
                                date('d/m/Y H:i', strtotime($scheduleInterView->start_date)),
                            'link' => route('historyJobApply'),
                        ]);

                        $this->notificationService->renderNotificationRealtimeClient($notification);
                    }
                }
            }

            DB::commit();
            return $scheduleInterView;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Delte ScheduleInterview in the database, Delete Google Calendar event
     * @author TranVanNhat <tranvannhat7624@gmail.com>
     */
    public function deleteScheduleInterview($data)
    {
        DB::beginTransaction();
        try {
            $scheduleInterview = $this->scheduleInterViewRepository->getScheduleInterViewByEventId($data['event_id']);
            if (!$scheduleInterview) {
                throw new \Exception('Schedule interview not found');
            }

            // Delete from Google Calendar
            $client = $this->authService->getGoogleClient();
            $service = new Calendar($client);
            $service->events->delete('primary', $data['event_id']);

            // Get users before detaching
            $users = $scheduleInterview->users;
            if (count($users) > 0) {
                $firstUserJob = $this->userJobRepository->getUserJob($users[0]->id);
                $companyName = $firstUserJob->job->company->name ?? NAME_COMPANY;

                // Send notifications to users
                foreach ($users as $user) {
                    $userJob = $this->userJobRepository->getUserJob($user->id);
                    if ($userJob) {
                        $notification = $this->notificationService->create([
                            'user_id' => $userJob->user_id,
                            'title' => 'Cuộc phỏng vấn với ' . $companyName .
                                ', vị trí ' . $userJob->job->name . ' đã hủy',
                            'link' => route('historyJobApply'),
                        ]);

                        $this->notificationService->renderNotificationRealtimeClient($notification);
                    }
                }
            }

            // Delete schedule interview and related data
            $scheduleInterview->users()->detach();
            $scheduleInterview->delete();

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Get list schedule interview
     * @author TranVanNhat <tranvannhat7624@gmail.com>
     */
    public function listScheduleInterView()
    {
        return  $this->scheduleInterViewRepository->listScheduleInterView();
    }

    /**
     * Change status of interview
     * @author TranVanNhat <tranvannhat7624@gmail.com>
     * @param array $data Data containing status update information
     * @return mixed
     */
    public function changeStatusInterView($data)
    {
        DB::beginTransaction();
        try {
            $interview = $this->scheduleInterViewRepository->changeStatusInterView($data);
            $title = $interview->status == STATUS_JOIN ?
                ($interview->user->name . " đã tham gia") : ($interview->user->name . " đã từ chối");
            $title .= " cuộc phỏng vấn ". $interview->scheduleInterview->title;

            $companyId = $interview->scheduleInterview->company_id;
            $notification = $this->notificationService->create([
                'title' => $title,
                'company_id' => $companyId,
                'link' => route('company.scheduleInterview'),
                'type' => TYPE_JOB,
            ]);

            $this->notificationService->renderNotificationRealtime(
                $notification,
                $companyId
            );
            DB::COMMIT();
            return $interview;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
