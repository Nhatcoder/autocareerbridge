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

    public function getCvUpload($id)
    {
        return $this->model->findOrFail($id);
    }

    public function getMyCv()
    {
        return $this->model
            ->where('user_id', auth()->id())
            ->where('type', TYPE_CV_CREATE)
            ->orderBy('updated_at', 'desc')
            ->get();
    }

    public function getMyCvUpload()
    {
        return $this->model
            ->where('user_id', auth()->id())
            ->where('type', TYPE_CV_UPLOAD)
            ->orderBy('updated_at', 'desc')
            ->get();
    }
}
