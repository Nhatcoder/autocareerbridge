<?php

namespace App\Repositories\ScheduleInterView;

use App\Models\Interview;
use App\Models\ScheduleInterView;
use App\Repositories\Base\BaseRepository;

class ScheduleInterViewRepository extends BaseRepository implements ScheduleInterViewRepositoryInterface
{
    protected $interview;
    public function __construct(Interview $interview)
    {
        parent::__construct();
        $this->interview = $interview;
    }
    public function getModel()
    {
        return ScheduleInterView::class;
    }

    /**
     * Get schedule interview by event ID
     * @author TranVanNhat <tranvannhat7624@gmail.com>
     * @param int $eventId The ID of the event to retrieve
     * @return mixed The schedule interview data or null if not found
     */
    public function getScheduleInterviewByEventId($eventId)
    {
        return $this->model->where('event_id', $eventId)->first();
    }

    /**
     * Get schedule interview user ID
     * @author TranVanNhat <tranvannhat7624@gmail.com>
     * @return mixed The schedule interview data or null if not found
     */
    public function listScheduleInterView()
    {
        $userId = auth('web')->user()->id;
        return $this->model->with(['job', 'company', 'interviews' => function ($query) use ($userId) {
            $query->where('user_id', $userId);
        }])
            ->select('id', 'job_id', 'company_id', 'title', 'description', 'start_date as start', 'end_date as end', 'type', 'link')
            ->get();
    }

    /**
     * Change status of interview
     * @author TranVanNhat <tranvannhat7624@gmail.com>
     * @param array $data Data containing status update information
     * @return mixed
     */
    public function changeStatusInterView($data)
    {
        $dataNew = [
            'status' => $data['status'],
        ];

        $interview = $this->interview->find($data['id']);
        if ($interview) {
            $interview->update($dataNew);
        }
        return $interview;
    }
}
