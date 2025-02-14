<?php

namespace App\Repositories\Experience;

use App\Models\Experience;
use App\Repositories\Base\BaseRepository;

class ExperienceRepository extends BaseRepository implements ExperienceRepositoryInterface {

    public function getModel()
    {
        return Experience::class;
    }
}
