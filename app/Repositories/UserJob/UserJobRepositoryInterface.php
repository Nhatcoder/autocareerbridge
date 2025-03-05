<?php

namespace App\Repositories\UserJob;

use App\Repositories\Base\BaseRepositoryInterface;

interface UserJobRepositoryInterface extends BaseRepositoryInterface
{
    public function getJobUserApply();

    public function getJobUserApplyChats();

    /**
     * Get the latest job application for the authenticated user.
     * @author Tran Van Nhat
     * @return \App\Models\UserJob|null
     */
    public function getLatestJobApplication();

    /**
     * Update the status of user job interviews.
     * @author Tran Van Nhat
     * @return mixed
     */
    public function updateStatusUserJobInterView();

    /**
     * Get all job applications for a company.
     * @return mixed Collection of user job applications
     */
    public function getAllUserJobCompany();

    /**
     * Get all user job applications for a company by job ID.
     * @return mixed Collection of user job applications
     */
    public function getAllUserJobIdCompany($id);

    /**
     * Get userjob job by user_id
     * @author TranVanNhat <tranvannhat7324@gmail.com>
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getUserJob($id);
}
