<?php

namespace App\Repositories\Job;

use App\Models\CompanyWorkshop;
use App\Models\Job;
use App\Models\UniversityJob;
use App\Repositories\Base\BaseRepository;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class JobRepository extends BaseRepository implements JobRepositoryInterface
{
    protected $universityJob;
    protected $companyWorkshop;

    public function __construct(UniversityJob $universityJob, CompanyWorkshop $companyWorkshop)
    {
        $this->companyWorkshop = $companyWorkshop;
        $this->universityJob = $universityJob;
        parent::__construct();
    }

    public function getModel()
    {
        return Job::class;
    }

    public function getJobs(array $filters)
    {
        $query = $this->model;
        if (isset($filters['status'])) {
            $query = $query->where('status', $filters['status']);
        }

        if (!empty($filters['search'])) {
            $search = '%' . $filters['search'] . '%';
            $query = $query->where(function ($q) use ($search) {
                $q->where('name', 'like', $search)
                    ->orWhereHas('company', function ($q) use ($search) {
                        $q->where('name', 'like', $search);
                    });
            });
        }

        if (isset($filters['major'])) {
            $query = $query->where('major_id', $filters['major']);
        }

        $query = $query->orderBy('status');
        $query = $query->orderBy('id', 'desc');
        $query = $query->with(['user.hiring.company']);
        $data = $query->paginate(LIMIT_10)->withQueryString();

        return $data;
    }


    public function totalRecord()
    {
        $totalUsers = DB::table('users')->count();
        $totalCompanies = DB::table('companies')->count();
        $totalUniversities = DB::table('universities')->count();
        $totalJobs = DB::table('jobs')->count();

        return [
            'users' => $this->formatNumber($totalUsers),
            'companies' => $this->formatNumber($totalCompanies),
            'universities' => $this->formatNumber($totalUniversities),
            'jobs' => $this->formatNumber($totalJobs),
        ];
    }

    function formatNumber(int $number)
    {
        if ($number >= 1000000000) {
            return number_format($number / 1000000000, 1) . 'b';
        } elseif ($number >= 1000000) {
            return number_format($number / 1000000, 1) . 'm';
        } elseif ($number >= 1000) {
            return number_format($number / 1000, 1) . 'k';
        }
        return (string)$number;
    }

    public function findJob($slug)
    {
        try {
            $job = $this->model->with(['company', 'skills', 'major'])->where('slug', $slug)->first();
            return $job;
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            return [
                'error' => $exception->getMessage()
            ];
        }
    }

    public function checkStatus($data)
    {
        $id = $data['id'];
        $query = $this->model->select('id', 'slug', 'name', 'status', 'company_id', 'status', 'created_at')->where('jobs.status', '=', STATUS_PENDING)->find($id);
        return $query;
    }

    public function filterJobByMonth()
    {
        $currentYear = now()->year;
        $currentMonth = now()->month;

        $query = $this->model->select(
            DB::raw('YEAR(created_at) as year'),
            DB::raw('MONTH(created_at) as month'),
            DB::raw('COUNT(*) as total')
        )
            ->whereYear('created_at', '>=', $currentYear - 2)
            ->where(function ($query) use ($currentYear, $currentMonth) {
                $query->whereYear('created_at', $currentYear)
                    ->whereMonth('created_at', '<=', $currentMonth);
            })
            ->orWhere('created_at', '<', $currentYear)
            ->groupBy('year', 'month')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc');

        $data = $query->get();

        $result = [];
        for ($year = $currentYear - 2; $year <= $currentYear; $year++) {
            $months = ($year == $currentYear) ? $currentMonth : 12;
            $result[$year] = array_fill(1, $months, 0);
        }

        foreach ($data as $row) {
            $result[$row->year][$row->month] = $row->total;
        }

        return $result;
    }

    public function getApplyJobs()
    {
        $currentYear = now()->year;
        $currentMonth = now()->month;

        $jobsPerMonth = DB::table('university_jobs')
            ->selectRaw('MONTH(created_at) as month, COUNT(DISTINCT job_id) as job_count')
            ->whereYear('created_at', $currentYear)
            ->whereMonth('created_at', '<=', $currentMonth)
            ->where('status', STATUS_APPROVED)
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('job_count', 'month');

        // Tạo mảng kết quả với các tháng từ 1 đến tháng hiện tại
        $result = [];
        for ($month = 1; $month <= $currentMonth; $month++) {
            $result[$month] = $jobsPerMonth->get($month, 0);
        }
        return $result;
    }

    public function checkApplyJob($id, $slug)
    {
        $query = $this->model
            ->select('university_jobs.status')
            ->join('university_jobs', 'university_jobs.job_id', '=', 'jobs.id')
            ->join('universities', 'universities.id', '=', 'university_jobs.university_id')
            ->where('jobs.slug', $slug)
            ->where('universities.id', $id)->first();
        return $query;
    }

    // public function checkStudentApplyJob($job_id, $university_id)
    // {
    //     $job =
    // }

    public function applyJob($job_id, $university_id)
    {
        // $existing = $this->universityJob->where('job_id', $job_id)
        //     ->where('university_id', $university_id)
        //     ->first();

        // if ($existing) {
        //     return null;
        // }


        $newEntry = $this->universityJob->create([
            'job_id' => $job_id,
            'university_id' => $university_id,
            'status' => STATUS_PENDING,
        ]);
        return $newEntry;
    }

    public function getJob($slug)
    {
        return $this->model->with(['skills', 'major', 'universities', 'universities.universityJobs'])->where('slug', $slug)->first();
    }

    public function updateJob(string $slug, array $job)
    {
        return $this->model->where('slug', $slug)->update($job);
    }

    public function getPostsByCompany(array $filters)
    {
        $user = Auth::guard('admin')->user();
        $query = $this->model->query();

        if ($user->role === ROLE_HIRING) {
            $companyId = DB::table('hirings')
                ->where('user_id', $user->id)
                ->value('company_id');

            $query->where(function ($query) use ($companyId) {
                $query->whereIn('user_id', function ($subQuery) use ($companyId) {
                    $subQuery->select('user_id')
                        ->from('hirings')
                        ->where('company_id', $companyId);
                })
                    ->orWhere('user_id', function ($subQuery) use ($companyId) {
                        $subQuery->select('user_id')
                            ->from('companies')
                            ->where('id', $companyId);
                    });
            });
        }

        if ($user->role === ROLE_COMPANY) {
            $companyId = DB::table('companies')
                ->where('user_id', $user->id)
                ->value('id');

            $query->where(function ($query) use ($companyId, $user) {
                $query->whereIn('user_id', function ($subQuery) use ($companyId) {
                    $subQuery->select('user_id')
                        ->from('hirings')
                        ->where('company_id', $companyId);
                })
                    ->orWhere('user_id', $user->id);
            });
        }

        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                    ->orWhereIn('user_id', function ($subQuery) use ($search) {
                        $subQuery->select('user_id')
                            ->from('hirings')
                            ->where('name', 'like', '%' . $search . '%');
                    })
                    ->orWhereIn('user_id', function ($subQuery) use ($search) {
                        $subQuery->select('user_id')
                            ->from('companies')
                            ->where('name', 'like', '%' . $search . '%');
                    });
            });
        }

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['major'])) {
            $query->where('major_id', $filters['major']);
        }

        return $query->orderByDesc('created_at')->paginate(LIMIT_10);
    }


    public function getAllJobs()
    {
        return $this->model::with(['universities', 'universities.universityJobs', 'company', 'major'])
            ->orderByDesc('id')
            ->where('status', STATUS_APPROVED)
            ->where('end_date', '>=', now())
            ->paginate(LIMIT_10);
    }

    public function getAppliedJobs($university_id)
    {
        return $this->model::with(['universities', 'universities.universityJobs', 'company', 'major'])
            ->whereHas('universities.universityJobs', function ($query) use ($university_id) {
                $query->where('university_jobs.university_id', $university_id);
            })
            ->orderBy(
                \DB::raw('(SELECT `created_at` FROM `university_jobs` WHERE `university_jobs`.`job_id` = `jobs`.`id` AND `university_jobs`.`university_id` = ' . $university_id . ' LIMIT 1)'),
                'desc'
            )
            ->paginate(LIMIT_10);
    }

    public function getUniversityJob($company_id)
    {
        $universityJob = $this->universityJob->whereHas('job', function ($query) use ($company_id) {
            $query->where('company_id', $company_id);  // Lọc workshops theo university_id
        })->orderBy('updated_at', 'desc')->get();
        $pending = $universityJob->filter(function ($item) {
            return $item->status === STATUS_PENDING;
        });
        $approrved = $universityJob->filter(function ($item) {
            return $item->status === STATUS_APPROVED;
        });
        $rejected = $universityJob->filter(function ($item) {
            return $item->status === STATUS_REJECTED;
        });
        return ['pending' => $pending, 'approved' => $approrved, 'rejected' => $rejected];
    }

    public function updateStatusUniversityJob($id, $status)
    {
        return $this->universityJob->where('id', $id)->update(['status' => $status]);
    }

    public function findUniversityJob($id)
    {
        return $this->universityJob->where('id', $id)->first();
    }

    public function searchJobs($keySearch, $province, $major)
    {
        $query = $this->model->query()->with('company', 'company.addresses', 'major');

        // Sử dụng when để giảm mã lặp
        $query->when($keySearch, function ($query) use ($keySearch) {
            $query->where('name', 'like', '%' . $keySearch . '%');
        });

        $query->when($province, function ($query) use ($province) {
            $query->whereHas('company.addresses', function ($addressQuery) use ($province) {
                $addressQuery->where('province_id', $province);
            });
        });
        $query->when($major, function ($query) use ($major) {
            $query->where('major_id', $major);
        });

        return $query->paginate(PAGINATE_JOB);
    }

    public function filterJobByDateRange(array $data)
    {
        // Lấy tất cả các bản ghi, bao gồm cả những bản ghi đã xóa
        $query = $this->model->withTrashed()
            ->select(
                DB::raw('UNIX_TIMESTAMP(DATE(MAX(created_at))) * 1000 as timestamp'), // Sử dụng MAX
                DB::raw('COUNT(*) as total'),
                DB::raw('CASE WHEN deleted_at IS NULL THEN 0 ELSE 1 END as is_deleted')
            )
            ->whereBetween('created_at', [
                Carbon::createFromTimestamp($data['start_date'] / 1000)->startOfDay(),
                Carbon::createFromTimestamp($data['end_date'] / 1000)->endOfDay()
            ])
            ->where('status', STATUS_APPROVED)
            ->groupBy(DB::raw('DATE(created_at), is_deleted'))
            ->orderBy('timestamp', 'asc');

        $records = $query->get();

        // Tách bản ghi thành hai mảng
        $deletedRecords = [];
        $activeRecords = [];

        foreach ($records as $item) {
            $record = [
                (int)$item->timestamp, // Timestamp ở dạng milliseconds
                (float)$item->total    // Tổng số lượng bản ghi
            ];

            if ($item->is_deleted == 1) {
                $deletedRecords[] = $record; // Bản ghi đã bị xóa
            } else {
                $activeRecords[] = $record; // Bản ghi chưa bị xóa
            }
        }

        return [
            'active' => $activeRecords,  // Danh sách bản ghi chưa bị xóa
            'deleted' => $deletedRecords // Danh sách bản ghi đã bị xóa
        ];
    }
}
