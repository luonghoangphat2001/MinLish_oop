<?php

namespace App\Livewire\Dashboard;

use App\Models\StudyLog;
use Livewire\Component;

class ProgressDashboard extends Component
{
    public function render()
    {
        $user = auth()->user();
        $dailyGoal = $user->dailyGoal;
        $todayTarget = (int) (($dailyGoal->new_words_per_day ?? 10) + ($dailyGoal->review_words_per_day ?? 20));

        $statusCounts = $user->srsProgresses()
            ->selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        $totalWords = (int) $statusCounts->sum();
        $todayStudied = StudyLog::where('user_id', $user->id)
            ->whereDate('studied_at', now()->toDateString())
            ->count();

        $reviewDue = $user->srsProgresses()
            ->whereNotNull('next_review_at')
            ->where('next_review_at', '<=', now())
            ->count();

        $recentSets = $user->vocabularySets()
            ->withCount('vocabularies')
            ->latest()
            ->limit(6)
            ->get();

        $recentSets = $recentSets->map(function ($set) use ($user) {
            $masteredOrReview = $user->srsProgresses()
                ->whereHas('vocabulary', fn ($q) => $q->where('set_id', $set->id))
                ->whereIn('status', ['review', 'mastered'])
                ->count();

            $set->completion_percent = $set->vocabularies_count > 0
                ? (int) round(($masteredOrReview / $set->vocabularies_count) * 100)
                : 0;

            return $set;
        });

        return view('livewire.dashboard.progress-dashboard', [
            'totalWords' => $totalWords,
            'todayStudied' => $todayStudied,
            'reviewDue' => $reviewDue,
            'recentSets' => $recentSets,
            'todayTarget' => $todayTarget,
            'todayProgressPercent' => $todayTarget > 0
                ? min(100, (int) round(($todayStudied / $todayTarget) * 100))
                : 0,
            'statusCounts' => [
                'new' => (int) ($statusCounts['new'] ?? 0),
                'learning' => (int) ($statusCounts['learning'] ?? 0),
                'review' => (int) ($statusCounts['review'] ?? 0),
                'mastered' => (int) ($statusCounts['mastered'] ?? 0),
            ],
        ]);
    }
}
