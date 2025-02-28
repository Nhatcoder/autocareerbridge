<?php
namespace App\Repositories\JobWishlist;

use App\Repositories\Base\BaseRepositoryInterface;

interface JobWishlistRepositoryInterface extends BaseRepositoryInterface
{
    public function findByUserAndJob($user, $jobId);

}
