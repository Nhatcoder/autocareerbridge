<?php

namespace App\Repositories\ScheduleInterView;

use App\Models\ScheduleInterView;
use App\Repositories\Base\BaseRepository;

class ScheduleInterViewRepository extends BaseRepository implements ScheduleInterViewRepositoryInterface
{
    public function getModel()
    {
        return ScheduleInterView::class;
    }
}
