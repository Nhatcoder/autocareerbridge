<?php

namespace App\Services\JobWishlist;

use App\Repositories\JobWishlist\JobWishlistRepositoryInterface;

class JobWishlistService
{
    protected $jobWishlistRepository;

    public function __construct(JobWishlistRepositoryInterface $jobWishlistRepository)
    {
        $this->jobWishlistRepository = $jobWishlistRepository;
    }

    /**
     * Toggle wishlist status for a specific job of the user.
     *
     * @param int $user User ID
     * @param int $jobId Job ID
     * @return int New wishlist status (SAVE or UN_SAVE)
     */
    public function wishlistJob($user, $jobId)
    {
        $wishlist = $this->jobWishlistRepository->findByUserAndJob($user, $jobId);

        if ($wishlist) {

            $newStatus = $wishlist->is_save == SAVE ? UN_SAVE : SAVE;
            $this->jobWishlistRepository->update($wishlist->id, ['is_save' => $newStatus]);

            return $newStatus;
        } else {
            $this->jobWishlistRepository->create([
                'user_id' => $user,
                'job_id' => $jobId,
                'is_save' => SAVE
            ]);

            return SAVE;
        }
    }
}
