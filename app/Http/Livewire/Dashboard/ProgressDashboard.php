<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\SrsProgress;
use App\Models\StudyLog;
use App\Models\VocabularySet;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ProgressDashboard extends Component
{
    public function render()
    {
        $user = Auth::user();

        $statusCounts = SrsProgress::selectRaw('status, COUNT(*) as total')
            ->where('user_id', $user->id)
            ->groupBy('status')
            ->pluck('total', 'status');

        $todayLearned = StudyLog::where('user_id', $user->id)
            ->whereDate('studied_at', now()->toDateString())
            ->count();

        $dailyGoal    = $user->dailyGoal;
        $goalTotal    = ($dailyGoal->new_words_per_day ?? 10) + ($dailyGoal->review_words_per_day ?? 20);

        $sets = $user->vocabularySets()->withCount('vocabularies')->get();

        $setProgress = $sets->map(function (VocabularySet $set) use ($user) {
            $mastered = SrsProgress::where('user_id', $user->id)
                ->where('status', 'mastered')
                ->whereHas('vocabulary', fn ($q) => $q->where('set_id', $set->id))
                ->count();

            $total = max($set->vocabularies_count, 1);

            return [
                'id'          => $set->id,
                'name'        => $set->name,
                'description' => $set->description,
                'total'       => $set->vocabularies_count,
                'mastered'    => $mastered,
                'percent'     => round(($mastered / $total) * 100),
            ];
        });

        $totalWords = $sets->sum('vocabularies_count');

        return view('livewire.dashboard.progress-dashboard', [
            'statusCounts' => $statusCounts,
            'streak'       => $user->streak_days ?? 0,
            'todayLearned' => $todayLearned,
            'goalTotal'    => $goalTotal,
            'totalWords'   => $totalWords,
            'setProgress'  => $setProgress,
        ])->layout('layouts.app')->layoutData([
            'header' => view('components.page-header', [
                'title' => __('Progress Overview'),
                'icon'  => '🔥',
            ]),
        ]);
    }
}
