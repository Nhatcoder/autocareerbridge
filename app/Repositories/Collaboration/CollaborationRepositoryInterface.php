<?php

namespace App\Repositories\Collaboration;

use App\Models\Collaboration;
use App\Repositories\Base\BaseRepositoryInterface;

interface CollaborationRepositoryInterface extends BaseRepositoryInterface
{
    public function getIndexRepository(int $status, int $page, $accountId = null);

    public function searchAcrossStatuses(?string $search, ?string $dateRange, int $page);

    public function filterUniversityCollaboration($companyId);

    public function create($data = []);
}
