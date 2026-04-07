<?php

namespace App\Jobs;

use App\Models\User;
use App\Notifications\DailyStudyReminder;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Notification;

class SendDailyReminderJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * T23 - Daily study reminder at 8AM for users who haven't studied today
     */

    public function handle()
    {
        $users = User::whereDoesntHave('studyLogs', function ($query) {
            $query->whereDate('studied_at', today());
        })->orWhereNull('last_study_date')->get();

        Notification::send($users, new DailyStudyReminder());
    }
}

