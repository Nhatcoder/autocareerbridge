<?php

namespace App\Services\Interview;

use App\Repositories\Interview\InterviewRepositoryInterface;

class InterviewService
{
    protected $interviewRepository;
    public function __construct(InterviewRepositoryInterface $interviewRepository)
    {
        $this->interviewRepository = $interviewRepository;
    }

    public function getAttendees($id)
    {
        $attendees = $this->interviewRepository->getEventDetailsByEventId($id);
        return $attendees;
    }
}
