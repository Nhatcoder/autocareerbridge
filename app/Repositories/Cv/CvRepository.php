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

    public function getCv($id)
    {
        return $this->model->findOrFail($id)->load([
            'user',
            'experiences',
            'certificates',
            'cv_skill',
            'educations',
            'referrers'
        ]);
    }
    public function getMyCv()
    {
        return $this->model->where('user_id', auth()->id())->get();
    }
}
