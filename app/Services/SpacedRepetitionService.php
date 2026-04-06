<?php

namespace App\Services;

use App\Models\SrsProgress;
use App\Models\User;
use App\Models\VocabularySet;
use Carbon\Carbon;

/**
 * SpacedRepetitionService
 *
 * Áp dụng thuật toán SM-2 để tính lịch ôn từ vựng.
 */
class SpacedRepetitionService
{
    private const RATING_TO_QUALITY = [
        'again' => 0,
        'hard'  => 1,
        'good'  => 3,
        'easy'  => 5,
    ];

    private const MASTERED_INTERVAL_THRESHOLD = 21;

    public function calculate(float $easeFactor, int $intervalDays, int $repetitions, string $rating): array
    {
        $quality = self::RATING_TO_QUALITY[$rating] ?? 3;

        if ($quality < 3) {
            return $this->buildResult(
                easeFactor: max(1.3, $easeFactor - 0.2),
                intervalDays: 1,
                repetitions: 0,
                status: 'learning'
            );
        }

        $newInterval = match ($repetitions) {
            0 => 1,
            1 => 6,
            default => (int) round($intervalDays * $easeFactor),
        };

        $newEaseFactor = $easeFactor + (0.1 - (5 - $quality) * (0.08 + (5 - $quality) * 0.02));
        $newEaseFactor = max(1.3, $newEaseFactor);

        $newRepetitions = $repetitions + 1;
        $status = $newInterval >= self::MASTERED_INTERVAL_THRESHOLD ? 'mastered' : 'review';

        return $this->buildResult($newEaseFactor, $newInterval, $newRepetitions, $status);
    }

    /**
     * Khởi tạo tiến độ SRS cho toàn bộ vocabulary trong bộ khi user bắt đầu học.
     * Không tạo trùng: chỉ chèn những từ chưa có record của user.
     */
    public function initializeProgress(User $user, VocabularySet $set): void
    {
        $vocabIds = $set->vocabularies()->pluck('id');

        if ($vocabIds->isEmpty()) {
            return;
        }

        $existing = SrsProgress::where('user_id', $user->id)
            ->whereIn('vocabulary_id', $vocabIds)
            ->pluck('vocabulary_id');

        $newIds = $vocabIds->diff($existing);

        if ($newIds->isEmpty()) {
            return;
        }

        $now = Carbon::now();

        $payload = $newIds->map(fn ($vocabId) => [
            'user_id'        => $user->id,
            'vocabulary_id'  => $vocabId,
            'ease_factor'    => 2.5,
            'interval_days'  => 1,
            'repetitions'    => 0,
            'status'         => 'new',
            'next_review_at' => null,
            'last_reviewed_at' => null,
            'created_at'     => $now,
            'updated_at'     => $now,
        ])->all();

        SrsProgress::insert($payload);
    }

    private function buildResult(float $easeFactor, int $intervalDays, int $repetitions, string $status): array
    {
        return [
            'ease_factor'    => round($easeFactor, 4),
            'interval_days'  => $intervalDays,
            'repetitions'    => $repetitions,
            'next_review_at' => Carbon::now()->addDays($intervalDays),
            'status'         => $status,
        ];
    }
}
