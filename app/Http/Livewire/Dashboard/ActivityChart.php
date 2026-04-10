<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\SrsProgress;
use App\Models\StudyLog;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ActivityChart extends Component
{
    public function render()
    {
        $userId = Auth::id();

        // Last 30 days labels
        $period = CarbonPeriod::create(now()->subDays(29)->startOfDay(), '1 day', now()->startOfDay());
        $labels = collect($period)->map(fn (Carbon $date) => $date->format('d/m'))->values();

        $activity = StudyLog::selectRaw('DATE(studied_at) as day, COUNT(*) as total')
            ->where('user_id', $userId)
            ->where('studied_at', '>=', now()->subDays(29)->startOfDay())
            ->groupBy('day')
            ->pluck('total', 'day');

        $barData = collect($period)->map(function (Carbon $date) use ($activity) {
            return $activity[$date->toDateString()] ?? 0;
        })->values();

        $statusCounts = SrsProgress::selectRaw('status, COUNT(*) as total')
            ->where('user_id', $userId)
            ->groupBy('status')
            ->pluck('total', 'status');

        // Send data to browser to refresh charts
        $this->dispatch('activity-chart-refresh', labels: $labels, barData: $barData, status: $statusCounts);

        return view('livewire.dashboard.activity-chart', [
            'labels'       => $labels,
            'barData'      => $barData,
            'statusCounts' => $statusCounts,
        ]);
    }
}
