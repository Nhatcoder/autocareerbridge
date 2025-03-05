<?php

namespace App\Repositories\ScheduleInterview;

use App\Models\ScheduleInterview;
use App\Repositories\Base\BaseRepository;

class ScheduleInterviewRepository extends BaseRepository implements ScheduleInterviewRepositoryInterface
{

    public function getModel()
    {
        return ScheduleInterview::class;
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

    public function getScheduleInterviewByEventId($id)
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
                'attendees' => $attendees
            ];
        }

        return null;
    }
}
