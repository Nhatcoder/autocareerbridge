<?php

namespace App\Services\Job;

use App\Repositories\Job\JobRepositoryInterface;
use App\Repositories\Major\MajorRepositoryInterface;

class JobService
{
    protected $jobRepository;
    protected $majorRepository;

    public function __construct(JobRepositoryInterface $jobRepository, MajorRepositoryInterface $majorRepository)
    {
        $this->jobRepository = $jobRepository;
        $this->majorRepository = $majorRepository;
    }

    public function totalRecord(){
        return $this->jobRepository->totalRecord();
    }

    public function getJobs(array $filters)
    {
        return $this->jobRepository->getJobs($filters);
    }

    public function getMajors()
    {
        return $this->majorRepository->getAll();
    }

    public function findJob($slug){
        return $this->jobRepository->findJob($slug);
    }

    public function checkStatus(array $data){
        return $this->jobRepository->checkStatus($data);
    }

    public function update($id, array $job)
    {
        return $this->jobRepository->update($id, $job);
    }

    public function filterJobByMonth(){
        return $this->jobRepository->filterJobByMonth();
    }
}
