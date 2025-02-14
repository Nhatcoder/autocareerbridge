<?php

namespace App\Repositories\Education;

use App\Models\Education;
use App\Repositories\Base\BaseRepository;

class EducationRepository extends BaseRepository implements EducationRepositoryInterface
{

    public function getModel()
    {
        return Education::class;
    }
}
