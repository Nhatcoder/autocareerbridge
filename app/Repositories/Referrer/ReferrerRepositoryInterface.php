<?php

namespace App\Repositories\Referrer;

use App\Repositories\Base\BaseRepositoryInterface;

interface ReferrerRepositoryInterface extends BaseRepositoryInterface
{
    public function deleteByIds(array $ids);
}
