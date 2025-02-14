<?php

namespace App\Repositories\CvSkill;

use App\Models\CvSkill;
use App\Repositories\Base\BaseRepository;

class CvSkillRepository extends BaseRepository implements CvSkillRepositoryInterface {

    public function getModel()
    {
        return CvSkill::class;
    }
}
