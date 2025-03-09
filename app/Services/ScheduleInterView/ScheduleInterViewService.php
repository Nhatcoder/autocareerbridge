<?php

namespace App\Services\ScheduleInterview;

use App\Helpers\LogHelper;
use Google\Service\Calendar;
use Google\Service\Calendar\Event;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Services\UserJob\UserJobService;
use App\Services\Managements\AuthService;
use App\Repositories\User\UserRepositoryInterface;
use App\Services\Notification\NotificationService;
use App\Services\GoogleCalendar\GoogleCalendarService;
use App\Repositories\UserJob\UserJobRepositoryInterface;
use App\Repositories\Interview\InterviewRepositoryInterface;
use App\Repositories\ScheduleInterview\ScheduleInterviewRepositoryInterface;

/**
 * CRUD, Schedule and Event Google Clendar Api of ScheduleInterViewService
 * @author TranVanNhat <tranvannhat7624@gmail.com>
 * @see scheduleInterViewStore($data)
 */
class ScheduleInterviewService
{
    use LogHelper;

    protected $scheduleInterViewRepository;
    protected $authService;
    protected $userRepository;
    protected $userJobRepository;
    protected $notificationService;
    protected $googleCalendarService;
    protected $interviewRepository;
    protected $userJobService;

    public function __construct(
        ScheduleInterViewRepositoryInterface $scheduleInterViewRepository,
        AuthService $authService,
        UserJobService $userJobService,
        UserRepositoryInterface $userRepository,
        NotificationService $notificationService,
        UserJobRepositoryInterface $userJobRepository,
        GoogleCalendarService $googleCalendarService,
        InterviewRepositoryInterface $interviewRepository
    ) {
        $this->scheduleInterViewRepository = $scheduleInterViewRepository;
        $this->authService = $authService;
        $this->userRepository = $userRepository;
        $this->userJobRepository = $userJobRepository;
        $this->notificationService = $notificationService;
        $this->googleCalendarService = $googleCalendarService;
        $this->interviewRepository = $interviewRepository;
        $this->userJobService = $userJobService;
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

                // Update status userjob
                $this->userJobService->updateStatusUserInterview($data['user_ids']);

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
                            'link' => route('listScheduleInterView'),
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
            $scheduleInterview = $this->scheduleInterViewRepository->find($data['id']);
            if (!$scheduleInterview) {
                throw new \Exception('Schedule interview not found');
            }

            // Delete from Google Calendar
            $client = $this->authService->getGoogleClient();
            $service = new Calendar($client);
            $service->events->delete('primary', $scheduleInterview->event_id);

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
                            'type' => TYPE_JOB,
                            'link' => route('listScheduleInterView'),
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
            if (!$interview) {
                throw new \Exception('Interview not found');
            }

            $title = $interview->user->name . ($interview->status == STATUS_JOIN ? " đã tham gia" : " đã từ chối");
            $title .= " cuộc phỏng vấn " . $interview->scheduleInterview->title;

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

    /**
     * Update an interview schedule.
     *
     * @param int $id The interview schedule ID.
     * @param array $data The updated data.
     * @return mixed The updated interview schedule.
     * @throws \Exception If an error occurs.
     */

    public function updateScheduleInterview($id, $data)
    {
        DB::beginTransaction();

        try {
            $schedule = $this->scheduleInterViewRepository->find($id);

            if (!$schedule) {
                throw new \Exception('Interview schedule not found.');
            }

            $eventId = $schedule->event_id;

            // Update the event on Google Calendar
            $eventGoogle = $this->googleCalendarService->updateCalendarEvent($eventId, $data);

            if (!$eventGoogle) {
                throw new \Exception('Failed to update the event on Google Calendar.');
            }

            // Update schedule details in the database
            $dataToUpdate = [
                'title' => $data['title'] ?? $schedule->title,
                'start_date' => $data['start_date'] ?? $schedule->start_date,
                'end_date' => $data['end_date'] ?? $schedule->end_date,
                'description' => $data['description'] ?? $schedule->description,
                'location' => $data['type'] != TYPE_SCHEDULE_ON ? ($data['location'] ?? '') : null,
                'link' => $data['type'] == TYPE_SCHEDULE_ON && isset($eventGoogle->conferenceData->entryPoints[0]->uri)
                    ? $eventGoogle->conferenceData->entryPoints[0]->uri
                    : null,
                'type' => $data['type'],
            ];
            $schedule->update($dataToUpdate);

            // Get existing users
            $existingUserIds = $this->interviewRepository->getWhere([
                'schedule_interview_id' => $schedule->id
            ])->pluck('user_id')->toArray();

            // Get new users
            $newUserIds = $data['user_ids'] ?? [];
            $userIdsToDelete = array_diff($existingUserIds, $newUserIds);
            $userIdsToAdd = array_diff($newUserIds, $existingUserIds);

            // Remove users who are no longer selected
            if (!empty($userIdsToDelete)) {
                $this->interviewRepository->deleteWhere([
                    'schedule_interview_id' => $schedule->id,
                    'user_id' => $userIdsToDelete
                ]);
            }

            // Add newly selected users
            if (!empty($userIdsToAdd)) {
                foreach ($userIdsToAdd as $userId) {
                    $this->interviewRepository->create([
                        'schedule_interview_id' => $schedule->id,
                        'user_id' => $userId,
                        'status' => STATUS_WAIT,
                    ]);
                }
            }

            // Get company information
            $firstUserJob = $this->userJobRepository->getUserJob($newUserIds[0] ?? null);
            $companyName = $firstUserJob->job->company->name ?? NAME_COMPANY;

            //  Send notifications to new users
            foreach ($userIdsToAdd as $userId) {
                $userJob = $this->userJobRepository->getUserJob($userId);
                if ($userJob) {
                    $notification = $this->notificationService->create([
                        'user_id' => $userJob->user_id,
                        'title' => 'Bạn có cuộc phỏng vấn với ' . $companyName .
                            ', vị trí ' . $userJob->job->name . ', vào lúc ' .
                            date('d/m/Y H:i', strtotime($schedule->start_date)),
                        'link' => route('listScheduleInterView'),
                    ]);

                    $this->notificationService->renderNotificationRealtimeClient($notification);
                }
            }

            // Send notifications to existing users about the update
            foreach ($existingUserIds as $userId) {
                if (!in_array($userId, $userIdsToDelete)) {
                    $userJob = $this->userJobRepository->getUserJob($userId);
                    if ($userJob) {
                        $notification = $this->notificationService->create([
                            'user_id' => $userJob->user_id,
                            'title' => 'Cuộc phỏng vấn của bạn với công ty ' . $companyName .
                                ', vị trí ' . $userJob->job->name . ' đã có thay đổi. Vui lòng kiểm tra lại thông tin.',
                            'link' => route('listScheduleInterView'),
                        ]);

                        $this->notificationService->renderNotificationRealtimeClient($notification);
                    }
                }
            }

            // Send notifications to users who were removed
            foreach ($userIdsToDelete as $userId) {
                $userJob = $this->userJobRepository->getUserJob($userId);
                if ($userJob) {
                    $notification = $this->notificationService->create([
                        'user_id' => $userJob->user_id,
                        'title' => 'Cuộc phỏng vấn với công ty ' . $companyName .
                            ', vị trí ' . $userJob->job->name . ' đã bị hủy.',
                        'link' => route('listScheduleInterView'),
                    ]);

                    $this->notificationService->renderNotificationRealtimeClient($notification);
                }
            }

            DB::commit();

            return $schedule;
        } catch (\Exception $e) {
            DB::rollBack();

            $this->logExceptionDetails($e);

            throw $e;
        }
    }

    /**
     * Retrieve all interview schedules.
     *
     * @return mixed List of interview schedules.
     */
    public function getAllScheduleInterview()
    {
        return $this->scheduleInterViewRepository->getDataScheduleInterview();
    }

    /**
     * Retrieve an interview schedule by ID.
     *
     * @param int $id The interview schedule ID.
     * @return mixed The interview schedule details.
     */
    public function getScheduleInterviewById($id)
    {
        return $this->scheduleInterViewRepository->getByEventId($id);
    }
}
