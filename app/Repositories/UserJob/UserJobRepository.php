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
        $userCurrent = auth('admin')->user();
        $jobUserApply = UserJob::with('user', 'job.company')->where("user_id", $userCurrent->id)->get();
        return $jobUserApply;
    }
}
