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

    public function getUserJob($id);
}
