<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Mail;

class SendDailyReminderEmailJob implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    public function handle()
    {
        $users = User::all();  // Or based on condition (e.g., active membership)

        foreach ($users as $user) {
            Mail::raw("Reminder Mail Body Here", function ($message) use ($user) {
                $message->to($user->email)
                        ->subject("Daily Reminder");
            });
        }
    }
}
