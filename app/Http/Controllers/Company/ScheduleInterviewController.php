<?php

namespace App\Http\Controllers\Company;

use App\Helpers\LogHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Company\ScheduleInterviewUpdateRequest;
use App\Services\Managements\AuthService;
use Google\Service\Calendar;
use App\Models\Job;
use App\Services\Interview\InterviewService;
use App\Services\Job\JobService;
use App\Services\ScheduleInterview\ScheduleInterviewService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

/**
 *
 * create, update, and delete schedule interviews.
 *
 * @package App\Http\Controllers
 * @author Tran Van Nhat, KhanhNguyen (tranvannhat7624@gmail.com)
 * @access public
 * @see index()
 * @see refreshEvents()
 */
class ScheduleInterviewController extends Controller
{
    use LogHelper;
    protected $authService;
    protected $interviewService;
    protected $scheduleInterviewService;
    protected $jobService;


    public  function __construct(AuthService $authService, ScheduleInterviewService $scheduleInterviewService, InterviewService $interviewService, JobService $jobService)
    {
        $this->authService = $authService;
        $this->scheduleInterviewService = $scheduleInterviewService;
        $this->interviewService = $interviewService;
        $this->jobService = $jobService;
    }

    /**
     * Display a list of schedule interviews.
     * @author TranVanNhat, KhanhNguyen <tranvannhat7624@gmail.com>
     */
    public function index()
    {
        try {
            $client = $this->authService->getGoogleClient();

            if (method_exists($client, 'getTargetUrl')) {
                return $client;
            }

            $jobs = Job::all();
            return view('management.pages.company.schedule_interview.index', compact('jobs'));
        } catch (\Exception $e) {
            $this->logExceptionDetails($e);
            return $this->authService->redirectToGoogle();
        }
    }

    /**
     * Summary of refreshEvents
     * @return mixed|\Illuminate\Http\JsonResponse
     * @author TranVanNhat <tranvannhat7624@gmail.com>
     */
    public function refreshEvents()
    {
        try {
            $client = $this->authService->getGoogleClient();

            // If getGoogleClient returns a redirect response
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
                    'location' => $event->getLocation(),
                    'creator' => $event->getCreator(),
                    'organizer' => $event->getOrganizer(),
                    'attendees' => $event->getAttendees() ?? [],
                    'hangoutLink' => $event->getHangoutLink(),
                    'status' => $event->getStatus(),
                    'visibility' => $event->getVisibility(),
                    'recurrence' => $event->getRecurrence() ?? [],
                ];
            }

            return response()->json($events);
        } catch (\Exception $e) {
            $this->logExceptionDetails($e);
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch events: ' . $e->getMessage()
            ], 500);
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
                'hangoutLink' => $event->hangoutLink ?? null,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }



    public function store(Request $request)
    {
        $schedule = $this->scheduleInterviewService->createScheduleInterview($request->all());
        return response()->json($schedule);
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
}
