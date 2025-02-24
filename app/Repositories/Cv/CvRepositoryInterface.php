<?php

namespace App\Repositories\Cv;

use App\Repositories\Base\BaseRepositoryInterface;

interface CvRepositoryInterface extends BaseRepositoryInterface
{

    public function getCv($id);

    public function getCvUpload($id);

    public function getMyCv();

    public function getMyCvUpload();
}
