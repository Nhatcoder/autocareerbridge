<?php

namespace App\Http\Controllers\University;

use App\Services\Job\JobService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

/**
 *
 *
 * @package App\Http\Controllers\Admin
 * @author Nguyen Manh Hung & Tran Van Nhat
 * @access public
 * @see show()
 * @see apply()
 */

class JobsController extends Controller
{

    protected $jobService;

    public function __construct(JobService $jobService)
    {
        $this->jobService = $jobService;
    }

    public function show($slug)
    {
        try {
            $data = $this->jobService->getJobForUniversity($slug);
            if (is_null($data)) return redirect()->back()->with('status_fail', __('message.job.not_found'));
            $user = auth()->guard('admin')->user();
            $id = '';
            if ($user->role == ROLE_UNIVERSITY) {
                $id = $user->university->id;
            }
            $checkApply = $this->jobService->checkApplyJob($id, $slug);
            return view('management.pages.university.jobs.detailJob', compact('data', 'checkApply'));
        } catch (\Exception $e) {
            Log::error($e->getFile() . ':' . $e->getLine() . ' - ' . $e->getMessage());
            return redirect()->back()->with('status_fail', $e->getLine() . $e->getMessage());
        }
    }

    public function apply(Request $request)
    {
        $checkApply = $request->checkApply;
        $job_id = $request->id;
        if ($checkApply) return redirect()->back()->with('status_fail', __('message.job.already_apply'));
        $university_id = $request->university_id;
        try {
            $data = $this->jobService->applyJob($job_id, $university_id);
            // if (!empty($data)) {
            //     return redirect()->back()->with('status_success', __('message.job.apply_success'));
            // } else {
            //     return redirect()->back()->with('status_fail', __('message.job.already_apply'));
            // }
        } catch (\Exception $e) {
            Log::error($e->getFile() . ':' . $e->getLine() . ' - ' . $e->getMessage());
            return redirect()->back()->with('status_fail', $e->getLine() . $e->getMessage());
        }
    }
}
