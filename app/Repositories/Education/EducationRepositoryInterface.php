<?php

namespace App\Repositories\Education;

use App\Repositories\Base\BaseRepositoryInterface;

interface EducationRepositoryInterface extends BaseRepositoryInterface
{
    // public function create($attributes = []);

    public function deleteByIds(array $ids);
}
