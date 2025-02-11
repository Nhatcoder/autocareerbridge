<?php

namespace App\Repositories\Referrer;

use App\Models\Referrer;
use App\Repositories\Base\BaseRepository;

class ReferrerRepository extends BaseRepository implements ReferrerRepositoryInterface {

    public function getModel()
    {
        return Referrer::class;
    }

    public function create($attributes = [])
    {
        return $this->model->create($attributes);
    }

    public function deleteByIds(array $ids){
        return $this->model->whereIn('id', $ids)->delete();
    }
}
