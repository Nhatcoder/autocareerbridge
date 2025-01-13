<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Services\Company\CompanyService;
use App\Services\Job\JobService;
use Illuminate\Http\Request;

class JobsController extends Controller
{
    protected $jobService;
    protected $companyService;
    public function __construct(JobService $jobService, CompanyService $companyService)
    {
        $this->jobService = $jobService;
        $this->companyService = $companyService;
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
}
