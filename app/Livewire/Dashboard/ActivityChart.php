<?php

namespace App\Livewire\Dashboard;

use App\Models\SrsProgress;
use App\Models\StudyLog;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ActivityChart extends Component
{
    public $labels = [];
    public $barData = [];
    public $statusCounts = [];

    public function mount()
    {
        $this->refreshData();
    }

    public function refreshData()
    {
        $activityData = $this->getActivityData();
        $this->labels = $activityData['labels'];
        $this->barData = $activityData['values'];
        $this->statusCounts = $this->getSrsDistributionData();
    }

    public function render()
    {
        return view('livewire.dashboard.activity-chart');
    }

    private function getActivityData(): array
    {
        $user = auth()->user();
        $endDate = Carbon::today();
        $startDate = Carbon::today()->subDays(29);

        // Query study logs grouped by date within the last 30 days
        $logs = StudyLog::where('user_id', $user->id)
            ->whereDate('studied_at', '>=', $startDate)
            ->select(DB::raw('DATE(studied_at) as date'), DB::raw('COUNT(*) as count'))
            ->groupBy('date')
            ->pluck('count', 'date')
            ->all();

        // Ensure all 30 days are present
        $labels = [];
        $values = [];
        $period = CarbonPeriod::create($startDate, $endDate);

        foreach ($period as $date) {
            $dateString = $date->format('Y-m-d');
            $labels[] = $date->format('d/m');
            $values[] = $logs[$dateString] ?? 0;
        }

        return [
            'labels' => $labels,
            'values' => $values,
        ];
    }

    private function getSrsDistributionData(): array
    {
        return SrsProgress::where('user_id', auth()->id())
            ->selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();
    }
}
