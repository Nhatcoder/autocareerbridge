<?php

namespace App\Repositories\ScheduleInterview;

use App\Repositories\Base\BaseRepositoryInterface;

interface ScheduleInterViewRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * Get schedule interview by event ID
     *
     * @author TranVanNhat <tranvannhat7624@gmail.com>
     * @param int $eventId The ID of the event to retrieve
     * @return mixed The schedule interview data or null if not found
     */
    public function getScheduleInterviewByEventId($eventId);

    public function getByEventId($id);

    public function getDataScheduleInterview();

}
