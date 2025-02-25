<?php

namespace App\Repositories\Cv;

use App\Models\Cv;
use App\Repositories\Base\BaseRepository;

class CvRepository extends BaseRepository implements CvRepositoryInterface
{
    /**
     * Get the model class.
     *
     * @return string
     */
    public function getModel()
    {
        return Cv::class;
    }

    /**
     * Get a CV by ID with related data.
     *
     * @param int $id
     * @return \App\Models\Cv
     */
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

    /**
     * Get an uploaded CV by ID.
     *
     * @param int $id
     * @return \App\Models\Cv
     */
    public function getCvUpload($id)
    {
        return $this->model->findOrFail($id);
    }

    /**
     * Get the current user's CVs by type.
     *
     * @param string $type (TYPE_CV_CREATE | TYPE_CV_UPLOAD)
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getMyCv($type)
    {
        return $this->model
            ->where('user_id', auth()->id())
            ->where('type', $type)
            ->orderBy('updated_at', 'desc')
            ->get();
    }
}
