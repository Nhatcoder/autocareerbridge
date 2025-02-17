<?php

namespace App\Repositories\UserJob;

use App\Models\UserJob;
use App\Repositories\Base\BaseRepository;

class UserJobRepository extends BaseRepository implements UserJobRepositoryInterface
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getModel()
    {
        return UserJob::class;
    }

    public function getJobUserApply()
    {
        $userCurrent = auth('admin')->user() ?? auth('web')->user();
        $jobUserApply = $this->model->with('user', 'job.company', 'job.skills')->where("user_id", $userCurrent->id)->paginate(PAGINATE_JOB);
        return $jobUserApply;
    }

    public function getJobUserApplyChats()
    {
        $userCurrent = auth('web')->user();

        $jobUserApply = $this->model->with('user', 'job.company')
            ->where("user_id", $userCurrent->id)
            ->latest('id')
            ->get()
            ->unique('job.company_id')
            ->values();
        return $jobUserApply;
    }
}
