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
     * Retrieve the list of accepted attendees for a given interview schedule ID.
     *
     * @param int $scheduleId
     * @return \Illuminate\Support\Collection
     */
    public function getAcceptedAttendeesByScheduleId($scheduleId)
    {
        return $this->model
            ->where('schedule_interview_id', $scheduleId)
            ->with('user:id,user_name,email')
            ->where('status', STATUS_JOIN)
            ->get()
            ->unique('email')
            ->pluck('user');
    }

    /**
     * Delete records based on specified conditions.
     *
     * @param array $conditions
     * @return int Number of deleted records
     */
    public function deleteWhere(array $conditions)
    {
        return $this->model->where($conditions)->delete();
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
