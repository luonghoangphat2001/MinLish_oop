<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
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
    public function getWordsForReview($user): Collection
    {
        return $user->srsProgresses()
            ->where('next_review_at', '<=', Carbon::now())
            ->get();
    }
    public function getNewWords($user, int $limit): Collection
    {
        return $user->srsProgresses()
        ->where('status','new')
        ->limit($limit)
        ->get();
    }
}
