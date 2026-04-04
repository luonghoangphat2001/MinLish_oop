<?php

namespace App\Livewire\Dashboard;

use App\Models\StudyLog;
use Livewire\Component;

class ProgressDashboard extends Component
{
    public function render()
    {
        $user = auth()->user();

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

        return view('livewire.dashboard.progress-dashboard', [
            'totalWords' => $totalWords,
            'todayStudied' => $todayStudied,
            'reviewDue' => $reviewDue,
            'recentSets' => $recentSets,
            'statusCounts' => [
                'new' => (int) ($statusCounts['new'] ?? 0),
                'learning' => (int) ($statusCounts['learning'] ?? 0),
                'review' => (int) ($statusCounts['review'] ?? 0),
                'mastered' => (int) ($statusCounts['mastered'] ?? 0),
            ],
        ]);
    }
}

