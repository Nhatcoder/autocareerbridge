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

                // Send notifications to users
                foreach ($data['user_ids'] as $userId) {
                    $userJob = $this->userJobRepository->getUserJob($userId);
                    if ($userJob) {
                        $notification = $this->notificationService->create([
                            'user_id' => $userJob->user_id,
                            'title' => 'Bạn có cuộc phỏng vấn với ' . ($userJob->job->company->name ?? NAME_COMPANY) .
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
}
