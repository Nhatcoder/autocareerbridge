<?php

namespace App\Repositories\Experience;

use App\Models\Experience;
use App\Repositories\Base\BaseRepository;

class ExperienceRepository extends BaseRepository implements ExperienceRepositoryInterface {

    public function getModel()
    {
        return Experience::class;
    }

    public function create($attributes = [])
    {
        return $this->model->create($attributes);
    }

    public function deleteByIds(array $ids){
        return $this->model->whereIn('id', $ids)->delete();
    }
}
