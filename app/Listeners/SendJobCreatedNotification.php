<?php

namespace App\Listeners;

use App\Events\JobCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class SendJobCreatedNotification
{
    public function handle(JobCreated $event)
    {
        Log::info('Job Created Event Fired for: ' . $event->job->job_title);

        // You can also send emails, update cache, dispatch queues, etc.
    }
}


