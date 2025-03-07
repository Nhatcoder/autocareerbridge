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

    /**
     * Get all job applications for the company.
     *
     * @return \Illuminate\Database\Eloquent\Collection Collection of job applications
     * @author Tran Van Nhat <tranvannhat7624@gmail.com>
     */
    public function getAllUserJobCompany()
    {
        return $this->userJobRepository->getAllUserJobCompany();
    }

    /**
     * Get all user apllication job for the company.
     * @return \Illuminate\Database\Eloquent\Collection
     * @author Tran Van Nhat <tranvannhat7624@gmail.com>
     */
    public function getAllUserJobIdCompany($id)
    {
        return $this->userJobRepository->getAllUserJobIdCompany($id);
    }

         /**
     * Update a user's interview status.
     * @param array $data Data containing status update information
     * Update userjob company
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function updateStatusUserInterview($data)
    {
        return $this->userJobRepository->updateStatusInterview($data);
    }
}
