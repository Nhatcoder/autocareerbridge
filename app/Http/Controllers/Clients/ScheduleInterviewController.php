<?php

namespace App\Http\Controllers\Clients;

use App\Helpers\LogHelper;
use App\Helpers\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\ScheduleInterView\ScheduleInterViewService;

/**
 * List, join or reject schedule interview
 * @author TranVanNhat <tranvannhat7624@gmail.com>
 */
class ScheduleInterviewController extends Controller
{
    use ApiResponse, LogHelper;

    protected $scheduleInterViewService;
    public function __construct(ScheduleInterViewService $scheduleInterViewService)
    {
        $this->scheduleInterViewService = $scheduleInterViewService;
    }

    /**
     * View list schedule interview
     * @author TranVanNhat <tranvannhat7624@gmail.com>
     */
    public function listScheduleInterView(Request $request)
    {
        return view('client.pages.schedule_interview.index');
    }

    /**
     * Get list schedule interview
     * @author TranVanNhat <tranvannhat7624@gmail.com>
     */
    public function refreshScheduleInterView()
    {
        try {
            $listSchedule = $this->scheduleInterViewService->listScheduleInterView();
            return response()->json($listSchedule);
        } catch (\Exception $e) {
            $this->logExceptionDetails($e);
            return $this->errorResponse(false, "Error: " . $e->getMessage());
        }
    }

    /**
     * Join or reject schedule interview
     * @author TranVanNhat <tranvannhat7624@gmail.com>
     */
    public function changeStatusInterView(Request $request)
    {
        $data = [
            'id' => $request->schedule_interview_id,
            'status' => $request->status,
        ];
        try {
            $interView = $this->scheduleInterViewService->changeStatusInterView($data);
            if ($interView) {
                $msg = $interView->status == STATUS_JOIN ? 'Chấp nhận ' : 'Từ chối ';
                $msg .= 'cuộc phỏng vấn thành công.';
                return $this->successResponse($interView, true, $msg);
            }
        } catch (\Exception $e) {
            return $this->errorResponse(false, "Error: " . $e->getMessage());
        }
    }
}
