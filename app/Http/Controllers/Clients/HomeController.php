<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Services\Company\CompanyService;
use App\Services\Fields\FieldsService;
use App\Services\University\UniversityService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    protected $universityService;
    protected $companyService;
    protected $fieldsService;
    public function __construct(UniversityService $universityService, CompanyService $companyService, FieldsService $fieldsService)
    {
        $this->universityService = $universityService;
        $this->companyService = $companyService;
        $this->fieldsService = $fieldsService;
    }
    /**
     * Display the home page with companies, universities, and job fields data.
     * @author Dang Duc Chung
     * @access public
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function index()
    {
        try {
            $companies = $this->companyService->getCompaniesWithJobsAndAddresses();
            $universities = $this->universityService->popularUniversities();
            $getFieldsWithJobCount = $this->fieldsService->getFieldsWithJobCount();
            return view('client.pages.home', compact('companies', 'universities', 'getFieldsWithJobCount'));
        } catch (\Exception $e) {
            Log::error('Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Có lỗi xảy ra, vui lòng thử lại sau');
        }
    }
}
