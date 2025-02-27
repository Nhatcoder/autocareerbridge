<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Services\Company\CompanyService;
use App\Services\Job\JobService;
use App\Services\JobWishlist\JobWishlistService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class JobsController extends Controller
{
    protected $jobService;
    protected $companyService;
    protected $jobWishlistService;
    public function __construct(JobService $jobService, CompanyService $companyService, JobWishlistService $jobWishlistService)
    {
        $this->jobService = $jobService;
        $this->companyService = $companyService;
        $this->jobWishlistService = $jobWishlistService;
    }
    public function index($slug)
    {
        $job = $this->jobService->findJob($slug);

        if (!$job || $job->is_active === INACTIVE || $job->status !== STATUS_APPROVED || ($job->end_date && $job->end_date < now())) {
            abort(404);
        }

        $slug_company = $job->company->slug;
        $company = $this->companyService->getCompanyBySlug($slug_company);

        // Trả về view
        return view('client.pages.job.detailJob', compact('job', 'company'));
    }

    /**
     * Allows a user to apply for a job.
     *
     * @param Request $request
     */
    public function applyJob(Request $request)
    {
        $data = [
            'job_id' => $request->job_id,
        ];
        try {
            $result = $this->jobService->userApplyJob($data);
            if ($result) {
                return redirect()->back()->with('status_success', 'Ứng tuyển thành công');
            }
        } catch (\Exception $e) {
            Log::error($e->getFile() . ':' . $e->getLine() . ' - ' . $e->getMessage());
            return redirect()->back()->with('status_fail', $e->getMessage());
        }
    }

    /**
     * Toggle job wishlist status for the authenticated user.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function wishlistJob(Request $request)
    {
        try {
            $user = Auth::user();
            $jobId = $request->job_id;

            if (!$user) {

                return response()->json(['status' => 'error', 'message' => 'Bạn cần đăng nhập để lưu công việc yêu thích.'], 403);
            }

            $isSave = $this->jobWishlistService->wishlistJob($user->id, $jobId);

            return response()->json([
                'status' => $isSave == SAVE ? 'added' : 'removed',
                'message' => $isSave == SAVE ? 'Lưu công việc thành công' : 'Công việc đã bị xoá khỏi danh sách đã lưu'
            ]);
        } catch (\Exception $e) {
            $this->logExceptionDetails($e);
        }
    }


    /**
     * Retrieve the list of jobs saved to the user's wishlist.
     *
     * @return \Illuminate\View\View
     */
    public function listJobWishlist()
    {
        $getJobs = $this->jobService->getWishlistJobs();
        return view('client.pages.job.wishlist', compact('getJobs'));
    }
}
