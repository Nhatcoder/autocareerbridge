<?php

namespace App\Repositories\Cv;

use App\Repositories\Base\BaseRepositoryInterface;

interface CvRepositoryInterface extends BaseRepositoryInterface
{
    // public function create($attributes = []);

    public function getCv($id);
}
