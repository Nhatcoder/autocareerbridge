<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Services\Company\CompanyService;
use App\Services\Cv\CvService;
use App\Services\Job\JobService;
use App\Services\JobWishlist\JobWishlistService;
use App\Services\UserJob\UserJobService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\Job\ApplyJobRequest;

class JobsController extends Controller
{
    protected $jobService;
    protected $companyService;
    protected $jobWishlistService;
    protected $userJobService;
    protected $cvService;

    public function __construct(JobService $jobService, CompanyService $companyService, JobWishlistService $jobWishlistService, CvService $cvService, UserJobService $userJobService)
    {
        $this->jobService = $jobService;
        $this->companyService = $companyService;
        $this->userJobService = $userJobService;
        $this->jobWishlistService = $jobWishlistService;
        $this->cvService = $cvService;
    }

    public function index($slug)
    {
        $job = $this->jobService->findJob($slug);

        if (!$job || $job->is_active === INACTIVE || $job->status !== STATUS_APPROVED || ($job->end_date && $job->end_date < now())) {
            abort(404);
        }

        $slug_company = $job->company->slug;
        $company = $this->companyService->getCompanyBySlug($slug_company);
        $cvUploads = $this->cvService->getMyCv(TYPE_CV_UPLOAD);
        $cvCreate = $this->cvService->getMyCv(TYPE_CV_CREATE);
        $cvApplyLate = $this->userJobService->getLatestJobApplication();

        $data = [
            'company' => $company,
            'job' => $job,
            'cvUploads' => $cvUploads,
            'cvCreate' => $cvCreate,
            'cvApplyLate' => $cvApplyLate
        ];

        return view('client.pages.job.detailJob', $data);
    }

    /**
     * Allows a user to apply for a job.
     *
     * @param Request $request
     */
    public function applyJob(ApplyJobRequest $request)
    {
        $data = [
            'job_id' => $request->job_id,
            'cv_id' => $request->cv_id,
            'phone' => $request->phone,
            'file_cv' => $request->file_cv,
        ];

        try {
            $result = $this->jobService->userApplyJob($data);

            if (!$result) {
                return response()->json([
                    'success' => false,
                    'message' => "Nộp hồ sơ ứng tuyển thất bại"
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => "Nộp hồ sơ ứng tuyển thành công"
            ]);
        } catch (\Exception $e) {
            $this->logExceptionDetails($e);
            return response()->json([
                'success' => false,
                'message' => "Có lỗi xảy ra: " . $e->getMessage()
            ], 500);
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

            $isSave = $this->jobWishlistService->toggleWishlistJob($user->id, $jobId);

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
