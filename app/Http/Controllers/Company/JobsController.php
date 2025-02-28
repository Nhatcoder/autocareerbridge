<?php

namespace App\Http\Controllers\Company;

use Illuminate\Http\Request;
use App\Services\Job\JobService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Services\Major\MajorService;
use App\Services\Skill\SkillService;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Company\JobRequest;

/**
 * JobsController handles job management operations for companies, including listing
 * and filtering jobs by search, status, and major.
 *
 * @package App\Http\Controllers\Company
 * @author Khuat Van Duy & Tran Van Nhat
 * @access public
 * @see index()
 * @see create()
 * @see store()
 * @see edit()
 * @see update()
 * @see destroy()
 */

class JobsController extends Controller
{
    protected $jobService;
    protected $skillService;
    protected $majorService;

    public function __construct(JobService $jobService, SkillService $skillService, MajorService $majorService)
    {
        $this->jobService = $jobService;
        $this->skillService = $skillService;
        $this->majorService = $majorService;
    }

    /**
     * Display a listing of jobs with optional filters for search, status, and major.
     *
     * @param Request $request The HTTP request instance, containing filter parameters.
     * @return \Illuminate\View\View The view displaying the job list and available majors.
     *
     * @access public
     * @see JobService::getJobs()
     * @see JobService::getMajors()
     */
    public function index(Request $request)
    {
        $data = $request->only(['search', 'status', 'major']);
        $jobs = $this->jobService->getPostsByCompany($data);
        $majors = $this->majorService->getAll();
        return view('management.pages.company.jobs.index', compact('jobs', 'majors'));
    }

    /**
     * Show the form for creating a new job post.
     *
     * This method retrieves the list of all skills and majors, then returns the view
     * for creating a new job post, passing the skills and majors data to the view.
     *
     * @return \Illuminate\View\View The view displaying the form for creating a new job post.
     *
     * @access public
     */
    public function create()
    {
        $skills = $this->skillService->getAll();
        $majors = $this->majorService->getAll();
        return view('management.pages.company.jobs.create', compact('majors', 'skills'));
    }

    /**
     * Store a newly created job post in the storage.
     *
     * This method processes the data from the request, creates the job post,
     * associates skills with the job, and commits the transaction. If successful,
     * it redirects to the job management page with a success message. If an error occurs,
     * it rolls back the transaction, logs the error, and redirects back with an error message.
     *
     * @param JobRequest $request The HTTP request instance containing validated job data.
     * @return \Illuminate\Http\RedirectResponse A redirect response to the job management page.
     *
     * @access public
     * @throws \Exception If job creation fails or an error occurs during transaction.
     * @see JobService::createJob()
     */
    public function store(JobRequest $request)
    {
        try {
            $skills = $this->skillService->createSkill($request->skill_name);
            $this->jobService->createJob($request->all(), $skills);

            return redirect()->route('company.manageJob')->with('status_success', __('message.company.job.create_job'));
        } catch (\Exception $exception) {
            Log::error('Lỗi tạo bài tuyển dụng: ' . $exception->getMessage());
            return redirect()->back()->with('status_fail', __('message.company.job.error_create'));
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $slug)
    {
        $job = $this->jobService->getJob($slug);

        if (
            empty($job) || !in_array(Auth::guard('admin')->user()->role, [ROLE_COMPANY, ROLE_HIRING]) ||
            (Auth::guard('admin')->user()->role === ROLE_COMPANY && $job->company_id !== Auth::guard('admin')->user()->company->id) ||
            (Auth::guard('admin')->user()->role === ROLE_HIRING && $job->company_id !== Auth::guard('admin')->user()->hiring->company_id)
        ) {
            return empty($job) ?
                redirect()->route('company.manageJob')->with('status_fail', __('message.company.job.job_not_found')) :
                abort(403,  __('message.company.job.job_not_permission'));
        }

        $jobUniversities = $job->universities()
            ->with(['universityJobs' => function ($query) use ($job) {
                $query->where('job_id', $job->id);
            }])
            ->paginate(PAGINATE_DETAIL_JOB_UNIVERSITY);

        return view('management.pages.company.jobs.show', compact('job', 'jobUniversities'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $slug)
    {
        $job = $this->jobService->getJob($slug);

        if (
            empty($job) || $job->status !== STATUS_PENDING || !in_array(Auth::guard('admin')->user()->role, [ROLE_COMPANY, ROLE_HIRING])
            || (Auth::guard('admin')->user()->role === ROLE_COMPANY && $job->company_id !== Auth::guard('admin')->user()->company->id)
            || (Auth::guard('admin')->user()->role === ROLE_HIRING && $job->company_id !== Auth::guard('admin')->user()->hiring->company_id)
        ) {
            return empty($job) ?
                redirect()->route('company.manageJob')->with('status_fail', __('message.company.job.job_not_found')) :
                abort(403,  __('message.company.job.job_not_permission'));
        }

        $majors = $this->jobService->getMajors();
        $skills = $this->skillService->getAll();

        return view('management.pages.company.jobs.edit', compact('job', 'majors', 'skills'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(JobRequest $request, string $id)
    {
        DB::beginTransaction();
        try {
            $skills = [];
            $skills = $this->skillService->createSkill($request->skill_name);
            $this->jobService->updateJob($id, $request->all(), $skills);

            DB::commit();
            return redirect()->route('company.manageJob')->with('status_success', __('message.company.job.update_job'));
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('Lỗi cập nhật bài tuyển dụng: ' . $exception->getMessage());
            return redirect()->back()->with('status_fail', __('message.company.job.error_update'));
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $jobExists = $this->jobService->find($id);

            if (
                !$jobExists || !in_array(Auth::guard('admin')->user()->role, [ROLE_COMPANY, ROLE_HIRING]) ||
                (Auth::guard('admin')->user()->role === ROLE_COMPANY && $jobExists->company_id !== Auth::guard('admin')->user()->company->id) ||
                (Auth::guard('admin')->user()->role === ROLE_HIRING && $jobExists->company_id !== Auth::guard('admin')->user()->hiring->company_id)
            ) {
                return empty($jobExists) ?
                    redirect()->back()->with('status_fail', __('message.company.job.job_not_found')) :
                    abort(403, 'Bạn không có quyền xóa bài tuyển dụng này');
            }

            $this->jobService->deleteJob($id);
            return redirect()->route('company.manageJob')->with('status_success', __('message.company.job.delete_job'));
        } catch (\Exception $exception) {
            Log::error('Lỗi xóa bài tuyển dụng: ' . $exception->getMessage());
            return redirect()->back()->with('status_fail', __('message.company.job.error_delete'));
        }
    }

    /**
     * Manage university job applications.
     * This method retrieves and categorizes university job applications based on their status
     * (pending, approved, rejected). It then returns a view with the categorized data for display.
     *
     * The view for managing university job applications, including pending, approved, and rejected jobs.
     * @author Dang Duc Chung
     * @throws \Exception If retrieving or processing the job applications fails.
     * @see JobService::manageUniversityJob() for the logic behind fetching the university job data.
     */
    public function manageUniversityJob()
    {
        try {
            $universityJobs = $this->jobService->manageUniversityJob();
            $pending = $universityJobs['pending'];
            $approved = $universityJobs['approved'];
            $rejected = $universityJobs['rejected'];

            return view('management.pages.company.university_job.index', compact('pending', 'approved', 'rejected'));
        } catch (\Exception $exception) {
            Log::error('Lỗi : ' . $exception->getMessage());
            return redirect()->back()->with('status_fail', 'Lỗi');
        }
    }

    /**
     * Update the status of a university job application.
     * Manage university job applications by retrieving and displaying them categorized by status.
     *
     * @param int $id The ID of the university job application.
     * @param int $status The status to be updated. 2: Approved, 3: Rejected.
     *
     * @return \Illuminate\Http\RedirectResponse A redirect response to the previous page.
     *
     * @author Dang Duc Chung
     * @throws \Exception If updating the status fails.
     * @see JobService::updateStatusUniversityJob()
     */
    public function updateStatus($id, $status)
    {
        try {
            $this->jobService->updateStatusUniversityJob($id, $status);
            return redirect()->back()->with('status_success', __('message.company.job.update_status_job'));
        } catch (\Exception $exception) {
            Log::error('Lỗi : ' . $exception->getMessage());
            return redirect()->back()->with('status_fail', __('message.company.job.error_status_job'));
        }
    }

    /**
     * Manage user job applications.
     * This method retrieves and categorizes user job applications based on their status
     * (pending, approved, rejected). It then returns a view with the categorized data for display.
     *
     * @return \Illuminate\View\View The view for managing user job applications, including w_eval, fit, interv, hired, unfit, and all jobs.
     * @author TRAN VAN NHAT
     * @throws \Exception If retrieving or processing the job applications fails.
     * @see JobService::manageUserApplyJob() for the logic behind fetching the user job data.
     */
    public function manageUserApplyJob()
    {
        $universityJobs = $this->jobService->custommerApplicateJob();
        $data = [
            'all' => $universityJobs['all'],
            'w_eval' => $universityJobs['w_eval'],
            'fit' => $universityJobs['fit'],
            'interv' => $universityJobs['interv'],
            'hired' => $universityJobs['hired'],
            'unfit' => $universityJobs['unfit'],
        ];

        return view('management.pages.company.custommer_job.index', $data);
    }

    /**
     * Update the status of a user job application.
     *
     * @param \Illuminate\Http\Request $request The HTTP request instance containing the job application id, status, and interview time.
     * @author TRAN VAN NHAT
     * @throws \Exception If updating the status fails.
     * @see JobService::changeStatusUserAplly()
     */
    public function changeStatusUserAplly(Request $request)
    {
        try {
            DB::beginTransaction();
            $data = $request->only(['id', 'status', 'interview_time']);
            $this->jobService->changeStatusUserAplly($data);
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => __('message.company.job.update_status_job'),
            ], 201);
        } catch (\Exception $exception) {
            DB::rollBack();
            $this->logExceptionDetails($exception);

            return response()->json([
                'success' => false,
                'message' => __('message.company.job.error_status_job'),
            ]);
        }
    }

    /**
     * Check if the user has seen a job application or not.
     * If the user has seen the job application, update the seen status to 1.
     * If the user has not seen the job application, return an error message.
     *
     * @param \Illuminate\Http\Request $request The HTTP request instance containing the job application id.
     * @author TRAN VAN NHAT
     * @throws \Exception If an error occurs during the process.
     */
    public function checkUserJobSeen(Request $request)
    {
        try {
            $data = $request->only(['id']);
            $user = $this->jobService->checkUserJobSeen($data);
            if ($user->is_seen == SEEN) {
                return response()->json([
                    'success' => true,
                ], 201);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => __('message.company.job.check_seen'),
                ], 201);
            }
        } catch (\Exception $exception) {
            $this->logExceptionDetails($exception);
            return redirect()->back()->with('status_fail', $exception->getMessage());
        }
    }

    /**
     * Mark a CV as seen by the user.
     *
     * @param \Illuminate\Http\Request $request The HTTP request instance containing the job application id.
     * @author Tran Van Nhat
     * @throws \Exception If an error occurs during the process.
     */
    public function seenCvUserJob(Request $request)
    {
        try {
            $data = $request->only(['id']);
            $this->jobService->markCvAsSeen($data);
            return response()->json([
                'success' => true,
                'message' => __('message.company.job.update_status_job'),
            ], 200);
        } catch (\Exception $exception) {
            $this->logExceptionDetails($exception);
            return response()->json([
                'success' => false,
                'message' => __('message.company.job.error_status_job'),
            ], 500);
        }
    }
}
