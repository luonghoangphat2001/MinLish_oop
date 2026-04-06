<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Jobs\SendReviewReminderJob;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        //
    ];

    protected function schedule(Schedule $schedule): void
    {
        // T23: Daily reminder at 8AM
        $schedule->job(new \App\Jobs\SendDailyReminderJob)->dailyAt('08:00');

        // T24: Review reminder at 6PM
        $schedule->job(new SendReviewReminderJob)->dailyAt('18:00');
    }

    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}

