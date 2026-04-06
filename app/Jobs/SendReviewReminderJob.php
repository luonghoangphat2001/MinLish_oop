<?php

namespace App\Jobs;

use App\Models\User;
use App\Models\SrsProgress;
use App\Models\VocabularySet;
use App\Notifications\ReviewWordsReminder;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendReviewReminderJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * T24 - Ghi chú Lead (Tiếng Việt): Job nhắc ÔN TẬP quá hạn lúc **18h (6h tối)**.
     *
     * **Điều kiện gửi:**
     * • Từ SRS: `next_review_at < hôm qua` + status != mastered
     * • User: `chưa học hôm nay` (study_logs.studied_at != today)
     *
     * **Luồng:**
     * 1. Chunk users 100 (perf safe)
     * 2. Per user: count overdue + list sets
     * 3. Notify nếu >0 overdue
     * 4. Log chi tiết
     *
     * **Lên lịch:** Kernel dailyAt('18:00')
     * **An toàn:** ChunkById, no memory leak
     */
    public function handle(): void
    {
        $cutoff = now()->subDay();

        User::whereHas('srsProgress', fn($q) => $q->where('next_review_at', '<', $cutoff)
                                                   ->where('status', '!=', 'mastered'))
            ->whereDoesntHave('studyLogs', fn($q) => $q->whereDate('studied_at', today()))
            ->chunkById(100, function ($users) {
                foreach ($users as $user) {
                    $overdueCount = $user->srsProgress()
                        ->where('next_review_at', '<', $cutoff)
                        ->where('status', '!=', 'mastered')
                        ->count();

                    if ($overdueCount > 0) {
                        $sets = SrsProgress::where('user_id', $user->id)
                            ->where('next_review_at', '<', $cutoff)
                            ->join('vocabularies', 'srs_progress.vocabulary_id', '=', 'vocabularies.id')
                            ->join('vocabulary_sets', 'vocabularies.set_id', '=', 'vocabulary_sets.id')
                            ->select('vocabulary_sets.*')
                            ->distinct()
                            ->get();

                        $user->notify(new ReviewWordsReminder($overdueCount, $sets->toArray()));

                        Log::info("Review reminder sent", [
                            'user_id' => $user->id,
                            'overdue' => $overdueCount,
                            'sets_count' => $sets->count()
                        ]);
                    }
                }
            });
    }
}

