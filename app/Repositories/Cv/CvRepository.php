<?php

namespace App\Repositories\Cv;

use App\Models\Cv;
use App\Repositories\Base\BaseRepository;

class CvRepository extends BaseRepository implements CvRepositoryInterface
{

    public function getModel()
    {
        return Cv::class;
    }

    public function create($attributes = [])
    {
        return $this->model->create($attributes);
    }

    public function getCv($id)
    {
        return $this->model->with([
            'user',
            'experiences',
            'certificates',
            'cv_skill',
            'educations',
            'referrers'
        ])->findOrFail($id);
    }
}
