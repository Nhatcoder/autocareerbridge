<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Job\JobService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

/**
 * The JobsController is responsible for managing job-related operations within the admin panel.
 * It includes functionality for viewing the list of jobs, filtering jobs based on specific criteria,
 * searching for jobs, viewing detailed information about a job, and approving or rejecting job postings.
 *
 * @package App\Http\Controllers\Admin
 * @author Nguyen Manh Hung & Tran Van Nhat
 * @access public
 * @see dashboard()
 * @see index()
 * @see showBySlug()
 * @see updateStatus()
 */

class JobsController extends Controller
{

    protected $jobService;

    public function __construct(JobService $jobService)
    {
        $this->jobService = $jobService;
    }

    public function index(Request $request)
    {
        $data = $request->only(['search', 'status', 'major', 'is_active']);
        try {
            $jobs = $this->jobService->getJobs($data);
            $majors = $this->jobService->getMajors();
            return view('management.pages.admin.jobs.index', compact('jobs', 'majors'));
        } catch (Exception $e) {
            return redirect()->back()->with('status_fail', $e->getMessage());
        }
    }

    public function showBySlug($slug)
    {
        $data = $this->jobService->findJob($slug);
        $view =  view('management.components.jobs.detailJob', compact('data'));
        $status = $data->status;
        return response()->json(['html' => $view->render(), 'status' => $status], 200);
    }

    public function updateStatus(Request $request)
    {
        $dataRequest = $request->only(['status', 'id']);
        try {
            $job = $this->jobService->checkStatus($dataRequest);
            $check = $this->jobService->updateStatus($job, $dataRequest);

            if ($check) {
                return redirect()->back()->with('status_success', __('label.admin.status_update'));
            }
            return redirect()->back()->with('status_fail', __('label.admin.status_fail'));
        } catch (Exception $e) {
            return redirect()->back()->with('status_fail', $e->getMessage());
        }
    }

    public function getDataChart(Request $request)
    {
        $data = $request->only(['start_date', 'end_date']);
        try {
            $dataJobs = $this->jobService->filterJobByDateRange($data);
            return response()->json($dataJobs, 200);
        } catch (Exception $e) {
            return response()->json($e->getMessage(), 500);
        }
    }

    /**
     * Display the details of a specific job.
     *
     * @param int $id The ID of the job to be displayed.
     * @return \Illuminate\View\View|null The view for the job details page or null if not found.
     */
    public function show($id)
    {
        $data = $this->jobService->findJob($id);
        if ($data) {
            return view('management.pages.admin.jobs.detail', compact('data'));
        }
    }

    public function toggleActive(Request $request)
    {
        try {
            $job = $this->jobService->updateToggleActive($request->id, $request->all());

            if ($job) {
                return response()->json([
                    'success' => true,
                    'message' => __('label.admin.status_update'),
                    'new_status' => $job->is_active == ACTIVE ? 'active' : 'inactive',
                ]);
            }
        } catch (Exception $exception) {
            Log::error(__('label.admin.status_update_failed') . ': ' . $exception->getMessage());
            return response()->json([
                'success' => false,
                'message' => __('label.admin.status_update_failed'),
            ]);
        }
    }

    public function updateStatusBulk(Request $request)
    {
        $jobIds = $request->input('job_ids');
        $status = $request->input('status');

        try {
            $updated = $this->jobService->bulkUpdateStatusJobs($jobIds, [
                'status' => $status,
                'is_active' => $status == STATUS_APPROVED ? ACTIVE : INACTIVE
            ]);

            if ($updated) {
                return response()->json([
                    'success' => true,
                    'message' =>  __('label.admin.status_update')
                ]);
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json([
                'success' => false,
                'message' => __('label.admin.status_update_failed')
            ]);
        }
    }
}
