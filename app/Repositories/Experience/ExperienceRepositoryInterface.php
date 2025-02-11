<?php

namespace App\Repositories\Experience;

use App\Repositories\Base\BaseRepositoryInterface;

interface ExperienceRepositoryInterface extends BaseRepositoryInterface {
    // public function create($attributes = []);

    public function deleteByIds(array $ids);
}
