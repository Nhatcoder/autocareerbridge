<?php

namespace App\Repositories\Referrer;

use App\Models\Referrer;
use App\Repositories\Base\BaseRepository;

class ReferrerRepository extends BaseRepository implements ReferrerRepositoryInterface {

    public function getModel()
    {
        return Referrer::class;
    }
}
