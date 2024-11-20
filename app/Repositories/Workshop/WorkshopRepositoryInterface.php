<?php

namespace App\Repositories\Workshop;

use App\Repositories\Base\BaseRepositoryInterface;

interface WorkshopRepositoryInterface extends BaseRepositoryInterface
{
    public function getWorkshop($filters);
}
