<?php
namespace App\Repositories\Interview;

use App\Models\Interview;
use App\Repositories\Base\BaseRepository;

class InterviewRepository extends BaseRepository implements InterviewRepositoryInterface
{
    public function getModel()
    {
        return Interview::class;
    }

    /**
     * Get event details by event ID
     * @param string $eventId
     * @return array
     */
    public function getEventDetailsByEventId($eventId)
    {
        $event = $this->model
            ->whereHas('scheduleInterview', function ($query) use ($eventId) {
                $query->where('event_id', $eventId);
            })
            ->with(['scheduleInterview.company', 'scheduleInterview.job'])
            ->first();

        if (!$event) {
            return response()->json(['error' => 'Sự kiện không tồn tại'], 404);
        }

        $attendees = $this->model
            ->whereHas('scheduleInterview', function ($query) use ($eventId) {
                $query->where('event_id', $eventId);
            })
            ->with('user:id,user_name,email,name')
            ->where('status', STATUS_JOIN)
            ->get()
            ->unique('user.email')
            ->map(function ($interview) {
                return [
                    'name'  => $interview->user->name ?? $interview->user->user_name ?? 'Không rõ',
                    'email' => $interview->user->email ?? 'Không rõ',
                ];
            });

        return [
            'schedule_interview_id' => $event->scheduleInterview->id ?? null,
            'company'   => $event->scheduleInterview->company->name ?? 'Không có thông tin',
            'job'       => $event->scheduleInterview->job->name ?? 'Không có thông tin',
            'link'      => $event->scheduleInterview->link ?? null,
            'location'      => $event->scheduleInterview->link ?? null,
            'description' => $event->scheduleInterview->description ?? null,
            'attendees' => $attendees,
        ];
    }

    /**
     * Retrieve records based on specified conditions.
     *
     * @param array $conditions
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getWhere(array $conditions)
    {
        $query = $this->model->newQuery();

        foreach ($conditions as $key => $value) {
            if (is_array($value) && count($value) == 3) {
                [$column, $operator, $val] = $value;
                $query->where($column, $operator, $val);
            } else {
                $query->where($key, $value);
            }
        }

        return $query->get();
    }
}
