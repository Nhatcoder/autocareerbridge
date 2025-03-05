<?php

namespace App\Http\Controllers\Company;

use App\Helpers\LogHelper;
use App\Helpers\ApiResponse;
use Google\Service\Calendar;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ScheduleRequest;
use App\Services\UserJob\UserJobService;
use App\Services\Managements\AuthService;
use App\Services\ScheduleInterView\ScheduleInterViewService;

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
    protected $userJobService;
    protected $scheduleInterviewService;

    public  function __construct(
        AuthService $authService,
        UserJobService $userJobService,
        ScheduleInterViewService $scheduleInterviewService
    ) {
        $this->authService = $authService;
        $this->userJobService = $userJobService;
        $this->scheduleInterviewService = $scheduleInterviewService;
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
                500
            );
        }
    }

    /**
     *  Save scheduled interview
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

            return response()->json([
                'success' => true,
                'message' => __('message.company.schedule_interview.create_success'),
                'event' => $scheduleInterView
            ]);
        } catch (\Exception $e) {
            $this->logExceptionDetails($e);
            return response()->json([
                'success' => false,
                'message' => __('message.company.schedule_interview.errorr_msg') . $e->getMessage()
            ], 500);
        }
    }
}
