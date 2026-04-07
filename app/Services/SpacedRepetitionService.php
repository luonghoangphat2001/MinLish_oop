<?php

namespace App\Services;

use App\Models\SrsProgress;
use App\Models\User;
use App\Models\VocabularySet;
use Carbon\Carbon;
use Illuminate\Support\Collection;

/**
 * SpacedRepetitionService
 *
 * Áp dụng thuật toán SM-2 để tính lịch ôn từ vựng.
 */
class SpacedRepetitionService
{
    private const RATING_TO_QUALITY = [
        'again' => 0,
        'hard'  => 2,
        'good'  => 4,
        'easy'  => 5,
    ];

    public function calculate(float $easeFactor, int $intervalDays, int $repetitions, string $rating): array
    {
        $quality = self::RATING_TO_QUALITY[$rating] ?? 4;

        if ($rating === 'again') {
            return $this->buildResult(
                easeFactor: max(1.3, $easeFactor - 0.2),
                intervalDays: 1,
                repetitions: 0,
                status: 'learning'
            );
        }

        if ($rating === 'hard') {
            $newEaseFactor = max(1.3, $easeFactor - 0.15);
            $newInterval = max(1, (int) round($intervalDays * 1.2));

            return $this->buildResult(
                easeFactor: $newEaseFactor,
                intervalDays: $newInterval,
                repetitions: max(1, $repetitions),
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
        $status = $rating === 'easy' ? 'mastered' : 'review';

        return $this->buildResult($newEaseFactor, $newInterval, $newRepetitions, $status);
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

    /**
     * Khởi tạo tiến độ SRS cho toàn bộ vocabulary trong bộ khi user bắt đầu học.
     * Không tạo trùng: chỉ chèn những từ chưa có record của user.
     */
    public function initializeProgress(User $user, VocabularySet $set): void
    {
        $existingIds = SrsProgress::where('user_id', $user->id)
            ->whereIn('vocabulary_id', $set->vocabularies()->pluck('id'))
            ->pluck('vocabulary_id')
            ->all();

        $insertData = [];

        foreach ($set->vocabularies as $vocabulary) {
            if (in_array($vocabulary->id, $existingIds, true)) {
                continue;
            }

            $insertData[] = [
                'user_id' => $user->id,
                'vocabulary_id' => $vocabulary->id,
                'ease_factor' => 2.5,
                'interval_days' => 1,
                'repetitions' => 0,
                'status' => 'new',
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        if (!empty($insertData)) {
            SrsProgress::insert($insertData);
        }
    }

    public function getWordsForReview(User $user, ?int $setId = null): Collection
    {
        return SrsProgress::query()
            ->with('vocabulary')
            ->where('user_id', $user->id)
            ->when($setId, function ($query) use ($setId) {
                $query->whereHas('vocabulary', fn ($q) => $q->where('set_id', $setId));
            })
            ->where(function ($query) {
                $query->where('status', '!=', 'new')
                    ->whereNotNull('next_review_at')
                    ->where('next_review_at', '<=', now());
            })
            ->get();
    }

    public function getNewWords(User $user, int $limit = 20, ?int $setId = null): Collection
    {
        return SrsProgress::query()
            ->with('vocabulary')
            ->where('user_id', $user->id)
            ->when($setId, function ($query) use ($setId) {
                $query->whereHas('vocabulary', fn ($q) => $q->where('set_id', $setId));
            })
            ->where('status', 'new')
            ->limit($limit)
            ->get();
    }
}
