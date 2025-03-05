<?php

namespace App\Services\ScheduleInterview;

use App\Repositories\Interview\InterviewRepositoryInterface;
use App\Repositories\ScheduleInterview\ScheduleInterviewRepositoryInterface;
use App\Services\GoogleCalendar\GoogleCalendarService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Services\Notification\NotificationService;
use App\Helpers\LogHelper;
use App\Repositories\UserJob\UserJobRepositoryInterface;

class ScheduleInterviewService
{
    use LogHelper;

    protected $scheduleInterviewRepository;
    protected $googleCalendarService;
    protected $interviewRepository;
    protected $notificationService;
    protected $userJobRepository;

    public function __construct(ScheduleInterviewRepositoryInterface $scheduleInterviewRepository, GoogleCalendarService $googleCalendarService, InterviewRepositoryInterface $interviewRepository, NotificationService $notificationService, UserJobRepositoryInterface $userJobRepository)
    {
        $this->scheduleInterviewRepository = $scheduleInterviewRepository;
        $this->googleCalendarService = $googleCalendarService;
        $this->interviewRepository = $interviewRepository;
        $this->notificationService = $notificationService;
        $this->userJobRepository = $userJobRepository;
    }


    /**
     * Create a new interview schedule.
     *
     * @param array $data The interview schedule data.
     * @return mixed The created interview schedule.
     * @throws \Exception If an error occurs.
     */
    public function createScheduleInterview($data)
    {
        DB::beginTransaction();

        try {
            $eventId = $this->googleCalendarService->createCalendarEvent($data);

            if (!$eventId) {
                throw new \Exception('Không tạo được sự kiện trên Google Calendar');
            }

            $schedule = $this->scheduleInterviewRepository->create([
                'company_id' => auth()->guard('admin')->user()->company->id,
                'job_id' => $data['job_id'],
                'title' => $data['title'],
                'start_date' => $data['start_date'],
                'end_date' => $data['end_date'],
                'description' => $data['description'] ?? null,
                'location' => $data['location'] ?? null,
                'event_id' => $eventId,
            ]);


            $schedule->update(['event_id' => $eventId]);

            if (!empty($data['user_ids']) && is_array($data['user_ids'])) {
                foreach ($data['user_ids'] as $userId) {
                    $this->interviewRepository->create([
                        'schedule_interview_id' => $schedule->id,
                        'user_id' => $userId,
                        'status' => STATUS_WAIT,
                    ]);
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
            $schedule = $this->scheduleInterviewRepository->find($id);

            if (!$schedule) {
                throw new \Exception('Interview schedule not found.');
            }

            $eventId = $schedule->event_id;

            // Update the event on Google Calendar
            $updated = $this->googleCalendarService->updateCalendarEvent($eventId, $data);

            if (!$updated) {
                throw new \Exception('Failed to update the event on Google Calendar.');
            }

            // Update schedule details in the database
            $schedule->update([
                'title' => $data['title'] ?? $schedule->title,
                'start_date' => $data['start_date'] ?? $schedule->start_date,
                'end_date' => $data['end_date'] ?? $schedule->end_date,
                'description' => $data['description'] ?? $schedule->description,
                'location' => $data['location'] ?? $schedule->location,
            ]);

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
                        'link' => route('historyJobApply'),
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
                            'link' => route('historyJobApply'),
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
                        'link' => route('historyJobApply'),
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
        return $this->scheduleInterviewRepository->getDataScheduleInterview();
    }

    /**
     * Retrieve an interview schedule by ID.
     *
     * @param int $id The interview schedule ID.
     * @return mixed The interview schedule details.
     */
    public function getScheduleInterviewById($id)
    {
        return $this->scheduleInterviewRepository->getScheduleInterviewById($id);
    }
}
