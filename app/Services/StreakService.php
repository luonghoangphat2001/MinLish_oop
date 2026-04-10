<?php

namespace App\Services;

use App\Models\User;
use Carbon\CarbonInterface;

class StreakService
{
    public function markStudied(User $user, CarbonInterface $studiedAt): void
    {
        $studyDate = $studiedAt->copy()->startOfDay();
        $lastStudyDate = $user->last_study_date?->copy()->startOfDay();

        if ($lastStudyDate === null) {
            $user->forceFill([
                'streak_days' => 1,
                'last_study_date' => $studyDate,
            ])->save();
            return;
        }

        if ($lastStudyDate->equalTo($studyDate)) {
            return;
        }

        $newStreak = $lastStudyDate->equalTo($studyDate->copy()->subDay())
            ? ((int) $user->streak_days + 1)
            : 1;

        $user->forceFill([
            'streak_days' => $newStreak,
            'last_study_date' => $studyDate,
        ])->save();
    }
}
