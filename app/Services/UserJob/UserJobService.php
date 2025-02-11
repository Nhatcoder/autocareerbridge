<?php

namespace App\Services\UserJob;

use App\Repositories\UserJob\UserJobRepositoryInterface;

class UserJobService
{
    protected $userJobRepository;

    public function __construct(UserJobRepositoryInterface $userJobRepository){
        $this->userJobRepository = $userJobRepository;
    }

    public function getJobUserApply(){
        return $this->userJobRepository->getJobUserApply();
    }
}
