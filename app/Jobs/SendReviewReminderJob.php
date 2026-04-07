<?php

namespace App\Jobs;

use App\Models\User;
use App\Models\SrsProgress;
use App\Notifications\ReviewWordsReminder;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Notification;

class SendReviewReminderJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * T24 - Review reminder at 6PM for overdue words (next_review_at <= now)
     */

    public function handle()
    {
        $users = User::whereHas('srsProgress', function ($query) {
            $query->where('next_review_at', '<=', now());
        })->whereDate('last_study_date', '<', today())->get();

        foreach ($users as $user) {
            $overdueSets = $user->srsProgress()
                ->where('next_review_at', '<=', now())
                ->with('vocabulary.set')
                ->get()
                ->pluck('vocabulary.set')
                ->unique('id');

            Notification::send($user, new ReviewWordsReminder($overdueSets));
        }
    }
}

