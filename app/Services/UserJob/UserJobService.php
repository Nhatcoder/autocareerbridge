<?php

namespace App\Services\UserJob;

use App\Repositories\UserJob\UserJobRepositoryInterface;

class UserJobService
{
    protected $userJobRepository;

    public function __construct(UserJobRepositoryInterface $userJobRepository)
    {
        $this->userJobRepository = $userJobRepository;
    }

    public function getJobUserApply()
    {
        return $this->userJobRepository->getJobUserApply();
    }

    public function getJobUserApplyChats()
    {
        return $this->userJobRepository->getJobUserApplyChats();
    }

    /**
     * Get the latest job application for the authenticated user.
     * @author Tran Van Nhat
     *
     */
    public function getLatestJobApplication()
    {
        return $this->userJobRepository->getLatestJobApplication();
    }
}
