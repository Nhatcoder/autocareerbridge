<?php

namespace App\Http\Controllers\University;

use App\Services\Job\JobService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 *
 *
 * @package App\Http\Controllers\Admin
 * @author Nguyen Manh Hung
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
            if (is_null($data)) return redirect()->back()->with('status_fail', 'Bài đăng không tồn tại!');
            $user = auth()->guard('admin')->user();
            $id = '';
            if ($user->role == ROLE_UNIVERSITY) {
                $id = $user->university->id;
            }
            $checkApply = $this->jobService->checkApplyJob($id, $slug);
            return view('management.pages.university.jobs.detailJob', compact('data', 'checkApply'));
        } catch (\Exception $e) {
            return redirect()->back()->with('status_fail', $e->getMessage());
        }
    }

    public function apply(Request $request)
    {
        $checkApply = $request->checkApply;
        $job_id = $request->id;
        if ($checkApply) return redirect()->back()->with('status_fail', 'Đã ứng tuyển rồi, vui lòng không thực hiện lại.');
        $university_id = $request->university_id;
        try {
            $data = $this->jobService->applyJob($job_id, $university_id);
            if ($data) {
                return redirect()->back()->with('status_success', 'Ứng tuyển thành công.');
            } else {
                return redirect()->back()->with('status_fail', 'Lỗi: Không thể ứng tuyển.');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('status_fail', $e->getMessage());
        }
    }
}
