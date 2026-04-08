<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('inspire')->hourly();

        // T23: Daily Study Reminder - 8AM
        $schedule->job(new \App\Jobs\SendDailyReminderJob)
                 ->dailyAt('08:00')
                 ->onConnection('database');

        // T24: Review Reminder - 6PM
        $schedule->job(new \App\Jobs\SendReviewReminderJob)
                 ->dailyAt('18:00')
                 ->onConnection('database');
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
