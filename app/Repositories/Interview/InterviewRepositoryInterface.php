<?php

namespace App\Repositories\Interview;

use App\Repositories\Base\BaseRepositoryInterface;

interface InterviewRepositoryInterface extends BaseRepositoryInterface{
    public function getAcceptedAttendeesByScheduleId($scheduleId);
    public function deleteWhere(array $conditions);

    public function getWhere(array $conditions);
}
