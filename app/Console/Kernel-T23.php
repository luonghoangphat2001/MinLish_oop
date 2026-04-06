<?php

/**
 * T23 Leader Copy - Kernel.php changes (ADD ONLY, 0 conflicts)
 * Copy this to real Kernel.php if needed
 */

namespace App\Console;

use App\Jobs\SendDailyReminderJob;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        //
    ];

    protected function schedule(Schedule $schedule): void
    {
        // T23: Daily Reminder at 8AM
        $schedule->job(new SendDailyReminderJob)->dailyAt('08:00');

        // Existing
        $schedule->command('inspire')->hourly();
    }

    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}

