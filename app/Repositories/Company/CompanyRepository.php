<?php

namespace App\Repositories\Company;

use App\Models\Address;
use App\Models\Company;
use App\Models\District;
use App\Models\Field;
use App\Models\Job;
use App\Models\Province;
use App\Models\University;
use App\Models\Ward;
use App\Repositories\Base\BaseRepository;
use Exception;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CompanyRepository extends BaseRepository implements CompanyRepositoryInterface
{
    public $address;
    public $province;
    public $district;
    public $ward;
    public $field;

    public function __construct(Address $address, Province $province, District $district, Ward $ward, Field $field)
    {
        parent::__construct();
        $this->address = $address;
        $this->province = $province;
        $this->district = $district;
        $this->ward = $ward;
        $this->field = $field;
    }

    public function getModel()
    {
        return Company::class;
    }

    public function getUniversity($request)
    {
        $companyId = null;
        if (auth()->guard('admin')->check()) {
            $user = auth()->guard('admin')->user();
            if ($user && $user->company) {
                $companyId = $user->company->id;
            }
        }
        $query = University::query()
            ->join('addresses', 'universities.id', '=', 'addresses.university_id')
            ->select('universities.*')
            ->with('collaborations');

        if (!empty($request->searchName)) {
            $query->where('universities.name', 'like', '%' . $request->searchName . '%');
        }
        if (!empty($request->searchProvince)) {
            $query->where('addresses.province_id', $request->searchProvince);
        }
        if ($companyId) {
            $query->withCount([
                'collaborations as is_collaborated' => function ($subQuery) use ($companyId) {
                    $subQuery->where('company_id', $companyId);
                }
            ])->orderByRaw('is_collaborated DESC');
        }
        return $query->paginate(LIMIT_10);
    }

    public function dashboard($companyId)
    {
        $company = $this->model::find($companyId);
        $countHiring = $company->hirings()->count();
        $countCollaboration = $company->collaborations()->count();
        $jobCountFromHirings = $company->hirings()->withCount('jobs')->get()->sum('jobs_count');
        $jobCountFromUsers = $company->user()->withCount('jobs')->get()->sum('jobs_count');
        $jobCount = $jobCountFromHirings + $jobCountFromUsers;;
        $countWorkShop = $company->companyWorkshops()->count();
        $currentYear = now()->year;
        $currentMonth = now()->month;
        $query = DB::table('jobs')
            ->select(
                DB::raw('YEAR(jobs.created_at) as year'),
                DB::raw('MONTH(jobs.created_at) as month'),
                DB::raw('COUNT(*) as total')
            )
            ->where(function ($query) use ($company) {
                $query->whereIn('jobs.user_id', $company->hirings()->pluck('user_id')) // Công việc từ user
                ->orWhere('jobs.user_id', $company->user_id); // Công việc từ doanh nghiệp
            })
            ->whereBetween('jobs.created_at', [now()->subYears(2)->startOfYear(), now()->endOfMonth()])
            ->groupBy('year', 'month')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc');
        $data = $query->get();
        $jobsPerMonthArray = [];
        for ($year = $currentYear - 2; $year <= $currentYear; $year++) {
            $months = ($year == $currentYear) ? $currentMonth : 12;
            $jobsPerMonthArray[$year] = array_fill(1, $months, 0);
        }

        foreach ($data as $row) {
            $jobsPerMonthArray[$row->year][$row->month] = $row->total;
        }

        return [
            'countHiring' => $countHiring,
            'countCollaboration' => $countCollaboration,
            'countWorkShop' => $countWorkShop,
            'countJob' => $jobCount,
            'jobsPerYear' => $jobsPerMonthArray,

        ];
    }

    public function getJobStats($companyId)
    {
        $company = Company::find($companyId);
        $jobs = $company->hirings()
            ->with('jobs.universities')
            ->get()
            ->pluck('jobs')
            ->flatten()
            ->merge(
                Job::where('user_id', $company->user_id)  // Lấy công việc do chính doanh nghiệp đăng
                ->with('universities')
                    ->get()
            );

        $jobsByMonthReceived = array_fill(1, 12, 0);
        $jobsByMonthNotReceived = array_fill(1, 12, 0);
        foreach ($jobs as $job) {
            $month = $job->created_at->month;
            if ($job->universities->isNotEmpty()) {
                $jobsByMonthReceived[$month]++;
            } else {
                $jobsByMonthNotReceived[$month]++;
            }
        }
        ksort($jobsByMonthReceived);
        ksort($jobsByMonthNotReceived);
        return [
            'received_jobs' => $jobsByMonthReceived,
            'not_received_jobs' => $jobsByMonthNotReceived,
        ];
    }


    public function findUniversity($requet)
    {
        $name = $requet->searchName;
        $provinceId = $requet->searchProvince;
        $query = University::query();
        $query->join('addresses', 'universities.id', '=', 'addresses.university_id');
        if (!empty($name)) {
            $query->where('universities.name', 'like', '%' . $name . '%');
        }
        if (!empty($provinceId)) {
            $query->where('addresses.province_id', $provinceId);
        }
        $universities = $query->select('universities.*')
            ->paginate(LIMIT_10);
        return $universities;
    }

    /**
     * Retrieves the company profile based on the provided user ID.
     * Includes the company address with detailed administrative divisions.
     *
     * @param int $userId
     * @access public
     * @author Hoang Duy Lap
     * @return object|null
     * @throws \Exception
     */
    public function findByUserIdAndSlug($userId)
    {
        $company = $this->model->where('user_id', $userId)
            ->first();

        if ($company) {
            $jobs = $company->jobs->all();
            $address = $this->address->query()
                ->with('province', 'district', 'ward')
                ->where('company_id', $company->id)
                ->first();

            if ($address) {
                $provinceName = $address->province->name;
                $districtName = $address->district->name;
                $wardName = $address->ward->name;

                $map = $address->specific_address . ', ' . $wardName . ', ' . $districtName . ', ' . $provinceName;
                $address->map = $map;
            }

            $company->address = $address;
            $company->jobs = $jobs;
        }

        return $company;
    }

    /**
     * Retrieves a company profile based on a specific column and value.
     * Includes related fields, address, and administrative divisions.
     *
     * @param string $column
     * @param mixed $value
     * @access public
     * @author Hoang Duy Lap
     * @return object|null
     * @throws \Exception
     */
    public function findCompany($column, $value)
    {
        $companyInfo = $this->model->where($column, $value)->first();

        $allFields = $this->field->all();
        if ($companyInfo) {
            $companyInfo->allFields = $allFields;

            // Lấy các fields liên kết với công ty
            $companyFields = $companyInfo->fields;
            $companyInfo->fields = $companyFields;

            // Lấy địa chỉ của công ty
            $address = $this->address->query()
                ->where('company_id', $companyInfo->id)
                ->with(['province', 'district', 'ward'])
                ->first();

            $companyInfo->address = $address;

            // Lấy danh sách tỉnh/thành phố
            $provinces = $this->province->all();
            $companyInfo->provinces = $provinces;

            if ($address) {
                // Lấy các quận/huyện
                $districts = $this->district->where('province_id', $address->province_id)
                    ->get();
                $companyInfo->districts = $districts;

                // Lấy các phường/xã
                $wards = $this->ward->where('district_id', $address->district_id)
                    ->get();
                $companyInfo->wards = $wards;
            }
        } else {
            // Nếu không có công ty, bạn vẫn trả về tất cả các fields
            $companyInfo = (object)[
                'allFields' => $allFields,
                'fields' => [], // không có fields liên kết khi không có công ty
                'address' => null,
                'provinces' => $this->province->all(),
                'districts' => [],
                'wards' => [],
            ];
        }

        return $companyInfo;
    }

    public function findBySlug($slug)
    {
        return $this->findCompany('slug', $slug);
    }

    public function findById($userId)
    {
        return $this->findCompany('user_id', $userId);
    }

    public function getProvinces()
    {
        $provinces = $this->province->all();
        return $provinces;
    }

    public function getDistricts($provinceId)
    {
        $districts = $this->district->where('province_id', $provinceId)->get();
        return $districts;
    }

    public function getWards($districtId)
    {
        $wards = $this->ward->where('district_id', $districtId)->get();
        return $wards;
    }

    /**
     * Updates or creates a company profile and its associated address.
     * If the company does not exist, it will be created.
     *
     * @param int|string $identifier
     * @param array $data
     * @access public
     * @author Hoang Duy Lap
     * @return object
     * @throws \Exception
     */
    public function updateProfile($identifier, $data)
    {
        // Kiểm tra xem identifier là user_id hay slug
        $company = is_numeric($identifier)
            ? $this->model->where('user_id', $identifier)->first()
            : $this->model->where('slug', $identifier)->first();

        if (empty($company)) {
            if (is_numeric($identifier)) {

                $company = $this->create([
                    'user_id' => $identifier,
                    'name' => $data['name'],
                    'slug' => $data['slug'],
                    'phone' => $data['phone'],
                    'size' => $data['size'],
                    'description' => $data['description'],
                    'about' => $data['about'],
                    'website_link' => $data['website_link'],
                    'is_active' => false
                ]);
            } else {
                throw new Exception('Không tìm thấy thông tin công ty');
            }
        } else {
            $this->update($company->id, [
                'name' => $data['name'],
                'slug' => $data['slug'],
                'size' => $data['size'],
                'phone' => $company->phone ?? $data['phone'],
                'description' => $data['description'],
                'about' => $data['about'],
                'website_link' => $data['website_link'],
            ]);
        }

        $address = $this->address->where('company_id', $company->id)->first();
        if (!$address) {
            $this->address->create([
                'company_id' => $company->id,
                'specific_address' => $data['specific_address'],
                'province_id' => $data['province_id'],
                'district_id' => $data['district_id'],
                'ward_id' => $data['ward_id'],
            ]);
        } else {
            $address->update([
                'specific_address' => $data['specific_address'],
                'province_id' => $data['province_id'],
                'district_id' => $data['district_id'],
                'ward_id' => $data['ward_id'],
            ]);
        }

        if (!empty($data['fields'])) {
            $company->fields()->sync($data['fields']);
        }

        return $company;
    }

    /**
     * Updates the company's avatar image.
     * Deletes the old avatar if it exists, uploads the new image, and updates the company record.
     *
     * @param int|string $identifier
     * @param \Illuminate\Http\UploadedFile $avatar
     * @access public
     * @author Hoang Duy Lap
     * @return string
     * @throws \Exception
     */
    public function updateAvatar($identifier, $avatar)
    {
        try {
            $company = is_numeric($identifier)
                ? $this->model->where('user_id', $identifier)->first()
                : $this->model->where('slug', $identifier)->first();

            if (!$company) {
                throw new \Exception('Không tìm thấy công ty');
            }

            if (!$avatar || !$avatar->isValid()) {
                throw new \Exception('File ảnh không hợp lệ');
            }

            if ($company->avatar_path && \Storage::disk('public')->exists($company->avatar_path)) {
                \Storage::disk('public')->delete($company->avatar_path);
            }

            $avatarPath = $avatar->store('company', 'public');
            $fullPath = 'storage/' . $avatarPath;

            $company->avatar_path = $fullPath;
            $company->save();

            return $fullPath;
        } catch (\Exception $e) {
            \Log::error('Lỗi khi tải ảnh lên: ' . $e->getMessage());
            throw $e;
        }
    }

    public function getAll()
    {
        return parent::getAll();
    }

    public function getCompanyBySlug($slug)
    {
        // Fetch company by slug with its associated addresses
        $company = $this->model->query()->where('slug', $slug)->with('addresses.ward', 'addresses.district', 'addresses.province','fields')->first();

        // Ensure company exists
        if (!$company) {
            return response()->json(['error' => 'Company not found'], 404);
        }

        $jobs = $company->jobs()->with('user','major', 'skills')
            ->where('status', STATUS_APPROVED)
            ->where('end_date', '>', Carbon::now())->get();

        $jobs->each(function ($job) {
            $job->job_time = Carbon::parse($job->end_date)->diffInDays(now());
        });

        $company->jobs = $jobs;

        $address = $company->addresses->first(); // Use the loaded addresses
        if ($address) {
            $ward = $address->ward->name ?? '';
            $district = $address->district->name ?? '';
            $province = $address->province->name ?? '';
            $fullAddress = $address->specific_address . ', ' . $ward . ', ' . $district . ', ' . $province;

            $company->province = $province;
            $company->district = $district;

            $company->address = $fullAddress;
        } else {
            $company->address = 'Address not available';
        }

        return $company;
    }


    public function getCompaniesWithJobsAndAddresses()
    {
        return Company::with(['hirings.jobs', 'addresses.province'])
            ->get()
            ->map(function ($company) {
                $jobCount = $company->hirings->sum(function ($hiring) {
                    return $hiring->jobs->count();
                });

                $company->job_count = $jobCount;

                return $company;
            })
            ->sortByDesc('job_count')
            ->take(PAGINATE_LIST_COMPANY_CLIENT); // Lấy 6 công ty có số lượng jobs nhiều nhất
    }

    public function getCompaniesWithFilters($query, $provinceId, $sortOrder)
    {
        return Company::with(['addresses.province', 'addresses.district', 'addresses.ward', 'hirings.jobs'])
            ->withCount(['hirings as job_count' => function ($query) {
                $query->select(\DB::raw('count(jobs.id)'))
                    ->join('jobs', 'jobs.user_id', '=', 'hirings.user_id',);
            }])
            ->when($query, function ($q) use ($query) {
                $q->where('name', 'LIKE', "%$query%");
            })
            ->when($provinceId, function ($q) use ($provinceId) {
                $q->whereHas('addresses.province', function ($q) use ($provinceId) {
                    $q->where('id', $provinceId);
                });
            })
            ->when($sortOrder, function ($q) use ($sortOrder) {
                if (in_array($sortOrder, ['asc', 'desc'])) {
                    $q->orderBy('job_count', $sortOrder);
                }
            })
            ->whereHas('user', function ($q) {
                $q->where('active', ACTIVE);
            })
            ->paginate(PAGINATE_LIST_COMPANY_CLIENT)
            ->withQueryString();
    }
}
