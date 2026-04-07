<?php

namespace App\Jobs;

use App\Models\User;
use App\Notifications\DailyStudyReminder;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;

class SendDailyReminderJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle(): void
    {
        $today = Carbon::today()->toDateString();

        User::whereDoesntHave('studyLogs', function ($query) use ($today) {
                $query->whereDate('studied_at', $today);
            })
            ->orWhereNull('last_study_date')
            ->each(function ($user) {
                $user->notify(new DailyStudyReminder());
            });
    }
}
