<?php

namespace App\Repositories\ScheduleInterview;

use App\Repositories\Base\BaseRepositoryInterface;

interface ScheduleInterviewRepositoryInterface extends BaseRepositoryInterface
{
    public function getDataScheduleInterview();

    public function getScheduleInterviewByEventId($id);
}
