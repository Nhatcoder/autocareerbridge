<?php

namespace App\Repositories\Certificate;

use App\Models\Certificate;
use App\Repositories\Base\BaseRepository;

class CertificateRepository extends BaseRepository implements CertificateRepositoryInterface {

    public function getModel()
    {
        return Certificate::class;
    }
}
