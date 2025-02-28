<?php

namespace App\Jobs;

use App\Helpers\LogHelper;
use Illuminate\Bus\Queueable;
use App\Services\Job\JobService;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class UpdateStatusUserApplyJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, LogHelper;
    protected JobService $jobService;
    /**
     * Create a new job instance.
     */
    public function __construct(JobService $jobService)
    {
        $this->jobService = $jobService;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            $this->jobService->scheduleUpdateStatusUserJobInterView();
        } catch (\Exception $e) {
            $this->logExceptionDetails($e);
        }
    }
}
