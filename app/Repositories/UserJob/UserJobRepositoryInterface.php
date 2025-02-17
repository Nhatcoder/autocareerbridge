<?php

namespace App\Repositories\UserJob;

use App\Repositories\Base\BaseRepositoryInterface;

interface UserJobRepositoryInterface extends BaseRepositoryInterface
{
    public function getJobUserApply();

    public function getJobUserApplyChats();
}
