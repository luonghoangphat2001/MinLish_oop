<?php

namespace App\Observers;

use App\Models\StudyLog;
use App\Services\StreakService;

class StudyLogObserver
{
    public function created(StudyLog $studyLog): void
    {
        $user = $studyLog->user;
        if (!$user) {
            return;
        }

        app(StreakService::class)->markStudied(
            user: $user,
            studiedAt: $studyLog->studied_at ?? now()
        );
    }
}
