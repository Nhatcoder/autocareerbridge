<?php

namespace App\Http\Controllers\Company;

use App\Helpers\LogHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Company\ScheduleInterviewUpdateRequest;
use App\Services\Managements\AuthService;
use Google\Service\Calendar;
use App\Services\Interview\InterviewService;
use App\Services\Job\JobService;
use App\Services\ScheduleInterView\ScheduleInterViewService;
use Illuminate\Http\Request;
use App\Helpers\ApiResponse;
use App\Http\Requests\ScheduleRequest;
use App\Services\UserJob\UserJobService;

/**
 * Create, update, and delete schedule interviews.
 *
 * @package App\Http\Controllers
 * @author Tran Van Nhat, KhanhNguyen (tranvannhat7624@gmail.com)
 * @access public
 * @see index()
 * @see refreshEvents()
 * @see scheduleInterviewStore()
 * @see getUserJob(Request $request)
 *
 */
class ScheduleInterviewController extends Controller
{
    use LogHelper, ApiResponse;
    protected $authService;
    protected $interviewService;
    protected $scheduleInterviewService;
    protected $jobService;
    protected $userJobService;

    public  function __construct(
        AuthService $authService,
        ScheduleInterviewService $scheduleInterviewService,
        InterviewService $interviewService,
        JobService $jobService,
        UserJobService $userJobService
    ) {
        $this->authService = $authService;
        $this->scheduleInterviewService = $scheduleInterviewService;
        $this->interviewService = $interviewService;
        $this->jobService = $jobService;
        $this->userJobService = $userJobService;
    }

    /**
     * Display a list of schedule interviews.
     * @author TranVanNhat, KhanhNguyen <tranvannhat7624@gmail.com>
     */
    public function index()
    {
        try {
            $client = $this->authService->getGoogleClient();
            $userApplyJobs = $this->userJobService->getAllUserJobCompany();
            if (method_exists($client, 'getTargetUrl')) {
                return $client;
            }

            return view('management.pages.company.schedule_interview.index', compact('userApplyJobs'));
        } catch (\Exception $e) {
            $this->logExceptionDetails($e);
            return $this->authService->redirectToGoogle();
        }
    }

    /**
     * Get events from Google Calendar
     * @return mixed|\Illuminate\Http\JsonResponse
     * @author TranVanNhat <tranvannhat7624@gmail.com>
     */
    public function refreshEvents()
    {
        try {
            $client = $this->authService->getGoogleClient();

            if (method_exists($client, 'getTargetUrl')) {
                return response()->json(['redirect_url' => $client->getTargetUrl()]);
            }

            $service = new Calendar($client);

            $optParams = array(
                'maxResults' => 2500,
                'orderBy' => 'startTime',
                'singleEvents' => true,
                'timeMin' => date('c', strtotime('-1 month')),
            );

            $results = $service->events->listEvents('primary', $optParams);
            $events = [];

            foreach ($results->getItems() as $event) {
                $events[] = [
                    'id' => $event->id,
                    'title' => $event->getSummary(),
                    'description' => $event->getDescription(),
                    'start' => $event->start->dateTime ?? $event->start->date,
                    'end' => $event->end->dateTime ?? $event->end->date,
                    'location' => $event->location,
                ];
            }

            return response()->json($events);
        } catch (\Exception $e) {
            $this->logExceptionDetails($e);
            return $this->errorResponse(
                false,
                'Failed to fetch events: ' . $e->getMessage(),
            );
        }
    }

    /**
     * Get user by application job
     * @author TranVanNhat <tranvannhat7624@gmail.com>
     * @param Request
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function getUserJob(Request $request)
    {
        try {
            $userApplyJobs = $this->userJobService->getAllUserJobIdCompany($request->jobId);
            return $this->successResponse(
                $userApplyJobs,
                true,
            );
        } catch (\Exception $e) {
            $this->logExceptionDetails($e);
            return $this->errorResponse(
                false,
                'Failed to fetch events: ' . $e->getMessage(),
            );
        }
    }

    /**
     *  Save scheduled interview
     * @author TranVanNhat <tranvannhat7624@gmail.com>
     * @param \App\Http\Requests\ScheduleRequest $request
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function scheduleInterviewStore(ScheduleRequest $request)
    {
        $data = [
            'summary' => $request->title,
            'location' => $request->location,
            'description' => $request->description,
            'job_id' => $request->job_id,
            'user_ids' => $request->user_ids,
            'type' => $request->type,
            'start' => [
                'dateTime' => date('c', strtotime($request->startDate)),
                'timeZone' => config('app.timezone'),
            ],
            'end' => [
                'dateTime' => date('c', strtotime($request->endDate)),
                'timeZone' => config('app.timezone'),
            ],
        ];

        try {
            $scheduleInterView = $this->scheduleInterviewService->scheduleInterViewStore($data);

            return $this->successResponse(
                $scheduleInterView,
                true,
                __('message.company.schedule_interview.create_success')
            );
        } catch (\Exception $e) {
            $this->logExceptionDetails($e);
            return $this->errorResponse(
                false,
                __('message.company.schedule_interview.errorr_msg') . $e->getMessage(),
            );
        }
    }

    /**
     * Delte ScheduleInterview in the database, Delete Google Calendar event
     * @author TranVanNhat <tranvannhat7624@gmail.com>
     */
    public function deleteScheduleInterview(Request $request)
    {
        $data = [
            'id' => $request->id,
        ];
        try {
            $scheduleInterView = $this->scheduleInterviewService->deleteScheduleInterview($data);
            return $this->successResponse(
                $scheduleInterView,
                true,
                __('message.company.schedule_interview.delete_success')
            );
        } catch (\Exception $e) {
            $this->logExceptionDetails($e);
            return $this->errorResponse(
                false,
                __('message.company.schedule_interview.errorr_msg') . $e->getMessage(),
            );
        }
    }

    // get thông tin từ api theo event id
    public function getGoogleCalendarEvent($eventId)
    {
        try {
            $client = $this->authService->getGoogleClient();
            $service = new Calendar($client);
            $event = $service->events->get('primary', $eventId);

            return response()->json([
                'id' => $event->id,
                'title' => $event->getSummary(),
                'description' => $event->getDescription(),
                'start' => $event->start->dateTime ?? $event->start->date,
                'end' => $event->end->dateTime ?? $event->end->date,
                'location' => $event->location,
                'hangoutLink' => $event->hangoutLink ?? null,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Retrieve all scheduled interviews.
     *
     * @return \Illuminate\Http\JsonResponse JSON response containing the list of scheduled interviews.
     */
    public function getData()
    {
        $lists = $this->scheduleInterviewService->getAllScheduleInterview();
        return response()->json($lists);
    }


    /**
     * Get the list of attendees for a specific interview schedule.
     *
     * @param int $id The ID of the interview schedule.
     * @return \Illuminate\Http\JsonResponse JSON response containing the list of attendees.
     */
    public function getAttendees($id)
    {
        $attendees = $this->interviewService->getAttendees($id);
        return response()->json($attendees);
    }


    /**
     * Retrieve the details of a specific interview schedule.
     *
     * @param int $id The ID of the interview schedule.
     * @return \Illuminate\Http\JsonResponse JSON response containing the schedule details or an error message.
     */
    public function edit($id)
    {
        try {
            $schedule = $this->scheduleInterviewService->getScheduleInterviewById($id);

            if (!$schedule) {
                return response()->json(['message' => 'Không tìm thấy lịch phỏng vấn'], 404);
            }

            return response()->json($schedule);
        } catch (\Exception $e) {
            $this->logExceptionDetails($e);
            return response()->json(['message' => 'Có lỗi xảy ra, vui lòng thử lại sau'], 500);
        }
    }


    /**
     * Update the details of a specific interview schedule.
     *
     * @param \Illuminate\Http\Request $request The request containing updated data.
     * @param int $id The ID of the interview schedule to update.
     * @return \Illuminate\Http\JsonResponse JSON response indicating success or failure of the update operation.
     */

    public function update($id, ScheduleInterviewUpdateRequest $request)
    {
        try {
            $schedule = $this->scheduleInterviewService->updateScheduleInterview($id, $request->all());
            return response()->json([
                'message' => 'Cập nhật lịch phỏng vấn thành công',
                'schedule' => $schedule
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'Dữ liệu không hợp lệ',
                'errors' => $e->validator->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Cập nhật lịch phỏng vấn thất bại',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getAllJobInterview()
    {
        $userApplyJobs = $this->userJobService->getAllUserJobCompany();
        return $this->successResponse($userApplyJobs, true, 'Get all job interview success');
    }
}
