<?php

namespace App\Repositories\UserJob;

use App\Models\UserJob;
use App\Repositories\Base\BaseRepository;
use Carbon\Carbon;

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

    /**
     * Update the status of user job interviews.
     * @author Tran Van Nhat
     * @return mixed
     */
    public function updateStatusUserJobInterView()
    {
        $users = $this->model
            ->where('status', STATUS_FIT)
            ->where('interview_time', '<', Carbon::now()->subMinutes(30))
            ->get();

        if ($users->isEmpty()) {
            return collect([]);
        }

        $this->model
            ->whereIn('id', $users->pluck('id'))
            ->update(['status' => STATUS_INTERV]);

        return $users->each->setAttribute('status', STATUS_INTERV);
    }

    /**
     * Get all user job applications with company information
     * @author TranVanNhat <tranvannhat7324@gmail.com>
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllUserJobCompany()
    {
        $currentCompanyId = auth('admin')->user()->id;
        return $this->model->with([
            'job.company' => function ($query) use ($currentCompanyId) {
                $query->where('id', $currentCompanyId);
            },
            'user'
        ])->whereHas('job.company', function ($query) use ($currentCompanyId) {
            $query->where('id', $currentCompanyId);
        })
            ->where('status', STATUS_W_EVAL)
            ->get();
    }

    /**
     * Get all user job applications with company information by job id
     * @author TranVanNhat <tranvannhat7324@gmail.com>
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllUserJobIdCompany($jobId)
    {
        $currentCompanyId = auth('admin')->user()->id;
        return $this->model->with([
            'job.company' => function ($query) use ($currentCompanyId) {
                $query->where('id', $currentCompanyId);
            },
            'user'
        ])->whereHas('job.company', function ($query) use ($currentCompanyId) {
            $query->where('id', $currentCompanyId);
        })
            ->where('job_id', $jobId)
            ->where('status', STATUS_W_EVAL)
            ->get();
    }

    /**
     * Get userjob job by user_id
     * @author TranVanNhat <tranvannhat7324@gmail.com>
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getUserJob($id)
    {
        return $this->model->where('user_id', $id)->with('job.company')->first();
    }
}
