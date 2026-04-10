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
        $threeDaysAgo = Carbon::today()->subDays(3);

        User::whereDoesntHave('studyLogs', function ($query) use ($today) {
                $query->whereDate('studied_at', $today);
            })
            ->each(function ($user) use ($threeDaysAgo) {
                // Nếu người dùng đã từng học và lần cuối học là hơn 3 ngày trước
                if ($user->last_study_date && $user->last_study_date->lessThan($threeDaysAgo)) {
                    $user->notify(new \App\Notifications\InactivityGuiltTripNotification());
                } else {
                    // Mới nghỉ học 1-2 ngày hoặc chưa bao giờ học
                    $user->notify(new \App\Notifications\DailyStudyReminder());
                }
            });
    }
}
