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

    /**
     * Get schedule interview by event ID
     *
     * @author TranVanNhat <tranvannhat7624@gmail.com>
     * @param int $eventId The ID of the event to retrieve
     * @return mixed The schedule interview data or null if not found
     */
    public function getScheduleInterviewByEventId($eventId)
    {
        return $this->model->where('event_id', $eventId)->first();
    }
}
