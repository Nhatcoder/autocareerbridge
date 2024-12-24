<?php

namespace App\Repositories\University;

use App\Models\Address;
use App\Models\University;
use App\Models\Workshop;
use App\Repositories\Base\BaseRepository;
use App\Repositories\University\UniversityRepositoryInterface;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Exception;

class UniversityRepository extends BaseRepository implements UniversityRepositoryInterface
{
    protected $companyId;

    public function getModel()
    {
        return University::class;
    }

    public function popularUniversities()
    {
        $universitiesAll = $this->model::with('collaborations')
        ->get()
        ->sortByDesc(function ($university) {
            return $university->collaborations->count();
        });

        return $universitiesAll;
    }

    public function findUniversity($request)
    {

        $companyId = auth()->guard('admin')->user()?->company?->id;
        $name = $request->searchName;
        $provinceId = $request->searchProvince;
        $query = $this->model::query()
            ->join('addresses', 'universities.id', '=', 'addresses.university_id')
            ->select('universities.*')
            ->with('collaborations');
        if (!empty($name)) {
            $query->where('universities.name', 'like', '%' . $name . '%');
        }
        if (!empty($provinceId)) {
            $query->where('addresses.province_id', $provinceId);
        }
        if ($companyId) {
            $query->withCount([
                'collaborations as is_collaborated' => function ($subQuery) use ($companyId) {
                    $subQuery->where('company_id', $companyId)->whereIn('status', [1, 2]);
                }
            ])->orderByDesc('is_collaborated');
        } else {
            $query->inRandomOrder();
        }
        $universities = $query->paginate(LIMIT_10);

        return $universities;
    }

    public function getDetailUniversity($slug)
    {
        try {
            $detail = $this->model::with(['user', 'majors', 'students', 'collaborations'])
                ->where('universities.slug', $slug)
                ->select(
                    'universities.*'
                )->firstOrFail();
            $address = Address::query()
                ->with('province', 'district', 'ward')
                ->where('university_id', $detail->id)
                ->first();
            return [
                'detail' => $detail,
                'address' => $address,
            ];
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return back()->with('error', 'Không thể tìm thấy trường học');
        }
    }

    public function getWorkShops($slug)
    {
        $workshops = $this->model::where('slug', $slug)
        ->firstOrFail()
        ->workshops()
        ->where('status', 1)
        ->get();
        return $workshops;
    }
}
