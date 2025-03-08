<?php

namespace App\Repositories\ScheduleInterView;

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

    /**
     * Get list schedule interview user ID
     *
     * @author TranVanNhat <tranvannhat7624@gmail.com>
     * @return mixed The schedule interview data or null if not found
     */
    public function listScheduleInterView();

    /**
     * Change status of interview
     * @author TranVanNhat <tranvannhat7624@gmail.com>
     * @param array $data Data containing status update information
     * @return mixed
     */
    public function changeStatusInterView($data);

    public function getByEventId($id);

    public function getDataScheduleInterview();

}
