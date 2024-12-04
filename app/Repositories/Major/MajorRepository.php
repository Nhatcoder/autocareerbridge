<?php

namespace App\Repositories\Major;

use App\Models\Field;
use App\Models\Major;
use App\Models\UniversityMajor;
use App\Repositories\Base\BaseRepository;
use Illuminate\Support\Facades\Auth;

class MajorRepository extends BaseRepository implements MajorRepositoryInterface
{
    protected $universityMajor;
    public function __construct(UniversityMajor $universityMajor)
    {
        parent::__construct();
        $this->universityMajor = $universityMajor;
    }

    public function getModel()
    {
        return Major::class;
    }

    public function getMajorsCompany($request)
    {
        $companyId = Auth::guard('admin')->user()->company->id;
        $query = $this->model::with('companies')
        ->whereHas('companies', function ($query) use ($companyId) {
            $query->where('company_id', $companyId)
                ->whereNull('company_majors.deleted_at');
        });
        if ($request->has('field_id') && $request->field_id != '') {
            $query->where('field_id', $request->field_id);
        }

        if ($request->has('major_id') && $request->major_id != '') {
            $query->where('id', $request->major_id);
        }
        $query = $query->paginate(10);
        return $query;
    }

    public function storeMajorsCompany($request)
    {

        $companyId = Auth::guard('admin')->user()->company->id;

        $majors = $this->model::whereIn('id', $request->major_id)->get();
        if ($majors->isEmpty()) {
            return response()->json(['message' => 'Ngành học không tồn tại'], 404);
        }
        foreach ($majors as $major) {
            $pivot = $major->companies()->withTrashed()->where('company_id', $companyId)->first();

            if ($pivot) {
                $major->companies()->updateExistingPivot($companyId, ['deleted_at' => null]);
            } else {
                $major->companies()->attach($companyId);
            }
        }
        return $major;
    }

    public function removeMajorsCompany($majorsId)
    {
        $companyId = Auth::guard('admin')->user()->company->id;
        $major = $this->model::find($majorsId);
        if (!$major) {
            return response()->json(['message' => 'Ngành học không tồn tại'], 404);
        }
        $major->companies()->wherePivot('company_id', $companyId)
            ->update(['company_majors.deleted_at' => now()]); 
        return $major ;
    }

    public function getMajorsByField($fieldId)
    {
        
        $majors = $this->model::where('field_id', $fieldId);

        return $majors;
    }

    public function getMajorAdmins()
    {
        $query = $this->model->query();

        if ($search = request()->get('search')) {
            $query->where('name', 'like', '%' . $search . '%');
        }

        if ($status = request()->get('status')) {
            $query->where('status', $status);
        }

        return $query
            ->orderByRaw('status = ' . STATUS_PENDING . ' DESC')
            ->orderBy('id', 'desc')
            ->paginate(PAGINATE_MAJOR);
    }

    public function getMajors(array $filters)
    {
        $universityId = Auth::guard('admin')->user()->university->id;
        $query = $this->universityMajor->where('university_id', $universityId);
        if (!empty($filters['field_id']) && $filters['field_id'] != 'all') {
            $query->whereHas('major', function ($q) use ($filters) {
                $q->where('field_id', $filters['field_id']);
            });
        }

        if (!empty($filters['major_id']) && $filters['major_id'] != 'all') {
            $query->where('major_id', $filters['major_id']);
        }
        $query->orderBy('created_at', 'desc');
        return $query->paginate(LIMIT_10)->withQueryString();
    }

    public function getExistedMajorIdsByUniversity(int $universityId): array
    {
        return $this->universityMajor->where('university_id', $universityId)
            ->pluck('major_id')
            ->toArray();
    }

    public function softDelete($universityId, $majorId)
    {
        $universityMajor = $this->universityMajor->where('university_id', $universityId)
            ->where('major_id', $majorId);

        if ($universityMajor) {
            $universityMajor->delete();
            return true;
        }
        return false;
    }

    public function findByUniversityAndMajor($universityId, $majorId)
    {
        return $this->universityMajor->where('university_id', $universityId)
            ->where('major_id', $majorId);
    }

    public function restore($universityMajor)
    {
        return $universityMajor->restore();
    }

    public function createOrRestore($universityId, $majorId)
    {
        $university_major = $this->universityMajor->withTrashed()
            ->where('university_id', $universityId)
            ->where('major_id', $majorId);

        if ($university_major->first()) {
            $university_major->restore();
        } else {
            $this->universityMajor->create([
                'university_id' => $universityId,
                'major_id' => $majorId,
            ]);
        }
    }
}
