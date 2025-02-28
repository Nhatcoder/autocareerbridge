<?php

namespace App\Repositories\JobWishlist;

use App\Models\JobWishlist;
use App\Repositories\Base\BaseRepository;

class JobWishlistRepository extends BaseRepository implements JobWishlistRepositoryInterface
{
    public function getModel()
    {
        return JobWishlist::class;
    }

    /**
     * Find a wishlist record by user ID and job ID.
     *
     * @param int $userId
     * @param int $jobId
     * @return \App\Models\JobWishlist|null
     */
    public function findByUserAndJob($userId, $jobId)
    {
        return $this->model->where('user_id', $userId)->where('job_id', $jobId)->first();
    }
}
