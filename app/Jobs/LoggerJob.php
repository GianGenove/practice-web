<?php

namespace App\Jobs;

use App\Models\Job;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class LoggerJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(public Job $job_listing)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //
        Log::info('Contact page visited by user: {id}', ['id' => auth()->id() ?? 'guest']);
        Log::info('Job Listing Id: {job_id}, Title: {job_title}', [
            'job_id' => $this->job_listing->id,
            'job_title' => $this->job_listing->title
        ]);

    }
}
