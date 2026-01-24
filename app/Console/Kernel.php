<?php

namespace App\Console;
use App\Jobs\SendDailyUserMailJob;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule): void
    {
        $schedule->job(new SendDailyUserMailJob)
                 ->dailyAt('22:30')
                 ->name('send-daily-user-mail');
    }
    

    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');
        require base_path('routes/console.php');
    }
}
