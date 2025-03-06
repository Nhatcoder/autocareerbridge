<?php

namespace App\Repositories\Interview;

use App\Repositories\Base\BaseRepositoryInterface;

interface InterviewRepositoryInterface extends BaseRepositoryInterface{
    public function getEventDetailsByEventId($eventId);

    public function getWhere(array $conditions);
}
