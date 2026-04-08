<?php

namespace App\Jobs;

use App\Models\User;
use App\Notifications\ReviewWordsReminder;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class SendReviewReminderJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle(): void
    {
        $yesterday = Carbon::yesterday()->toDateString();

        User::whereHas('studyLogs', function ($query) use ($yesterday) {
                $query->whereDate('studied_at', $yesterday);
            })
            ->orWhere('last_study_date', $yesterday)
            ->chunkById(100, function ($users) {
                foreach ($users as $user) {
                    $overdue = DB::table('srs_progress')
                        ->join('vocabularies', 'srs_progress.vocabulary_id', '=', 'vocabularies.id')
                        ->join('vocabulary_sets', 'vocabularies.set_id', '=', 'vocabulary_sets.id')
                        ->where('srs_progress.user_id', $user->id)
                        ->where('srs_progress.next_review_at', '<', Carbon::now()->subDay())
                        ->where('srs_progress.status', '!=', 'mastered')
                        ->select('vocabulary_sets.id', 'vocabulary_sets.name')
                        ->distinct()
                        ->get();

                    if ($overdue->count() > 0) {
                        $user->notify(new ReviewWordsReminder(
                            $overdue->count(),
                            $overdue->toArray()
                        ));
                    }
                }
            });
    }
}
