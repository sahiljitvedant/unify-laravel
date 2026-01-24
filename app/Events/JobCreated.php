<?php
namespace App\Events;

use App\Models\JobApplication;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class JobCreated
{
    use Dispatchable, SerializesModels;

    public $job;

    public function __construct(JobApplication $job)
    {
        $this->job = $job;
    }
}
