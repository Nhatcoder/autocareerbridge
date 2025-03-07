<?php

namespace App\Repositories\ScheduleInterview;

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
     *
     * @author TranVanNhat <tranvannhat7624@gmail.com>
     * @param int $eventId The ID of the event to retrieve
     * @return mixed The schedule interview data or null if not found
     */
    public function getScheduleInterviewByEventId($eventId)
    {
        return $this->model->where('event_id', $eventId)->first();
    }

    public function getDataScheduleInterview()
    {
        $events = $this->model::with(['job', 'company'])->get()->map(function ($event) {
            return [
                'id' => $event->id,
                'title' => $event->title,
                'start' => $event->start_date,
                'end' => $event->end_date,
                'extendedProps' => [
                    'description' => $event->description,
                    'company' => $event->company->name ?? 'N/A',
                    'job' => $event->job->name ?? 'N/A',
                    'attendees' => []
                ]
            ];
        });

        return $events;
    }

    public function getByEventId($id)
    {
        $schedule = $this->model::with(['job', 'interviews.user'])->find($id);

        if ($schedule) {
            $attendees = $schedule->interviews->map(function ($interview) {
                return [
                    'id' => $interview->user->id,
                    'name' => $interview->user->user_name
                ];
            })->unique('id')->values();

            return [
                'id' => $schedule->id,
                'job_id' => $schedule->job_id,
                'job_name' => $schedule->job->name ?? null,
                'title' => $schedule->title,
                'start_date' => $schedule->start_date,
                'end_date' => $schedule->end_date,
                'description' => $schedule->description,
                'location' => $schedule->location ?? '',
                'link' => $schedule->link,
                'type' => $schedule->type,
                'attendees' => $attendees
            ];
        }

        return null;
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
            ->select('id', 'job_id', 'company_id', 'title', 'description', 'start_date as start', 'end_date as end', 'type', 'location', 'link')
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
