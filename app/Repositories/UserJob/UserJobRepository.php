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
        $userCurrent = auth('web')->user() ?? auth('admin')->user();

        $jobUserApply = $this->model->with('user', 'job.company')
            ->where("user_id", $userCurrent->id)
            ->latest('id')
            ->get()
            ->unique('job.company_id')
            ->values();
        return $jobUserApply;
    }

    /**
     * Get the latest job application for the authenticated user.
     * @author TranVanNhat
     * @return \App\Models\UserJob|null
     */
    public function getLatestJobApplication()
    {
        $userCurrent = auth('web')->user();
        if (auth('web')->user()) {
            $latestJobApplication = $this->model->with('user', 'cv')
                ->where("user_id", $userCurrent->id)
                ->latest('created_at')
                ->first();
            return $latestJobApplication;
        }

        return null;
    }
}
