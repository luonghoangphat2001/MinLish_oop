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
    public function render()
    {
        $activityData = $this->getActivityData();
        $statusData = $this->getStatusData();

        return view('livewire.dashboard.activity-chart', [
            'activityLabels' => $activityData['labels'],
            'activityValues' => $activityData['values'],
            'statusLabels'   => $statusData['labels'],
            'statusValues'   => $statusData['values'],
        ]);
    }

    private function getActivityData(): array
    {
        $user = auth()->user();
        $endDate = Carbon::today();
        $startDate = Carbon::today()->subDays(29);

        // Query study logs grouped by date
        $logs = StudyLog::where('user_id', $user->id)
            ->whereDate('studied_at', '>=', $startDate)
            ->select(DB::raw('DATE(studied_at) as date'), DB::raw('COUNT(*) as count'))
            ->groupBy('date')
            ->pluck('count', 'date')
            ->all();

        // Fill in missing dates with zero
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

    private function getStatusData(): array
    {
        $user = auth()->user();
        
        $counts = SrsProgress::where('user_id', $user->id)
            ->selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status')
            ->all();

        // Standard order and labels
        $statusMap = [
            'new'      => 'Mới',
            'learning' => 'Đang học',
            'review'   => 'Ôn tập',
            'mastered' => 'Đã thuộc',
        ];

        $labels = [];
        $values = [];

        foreach ($statusMap as $key => $label) {
            $labels[] = $label;
            $values[] = $counts[$key] ?? 0;
        }

        return [
            'labels' => $labels,
            'values' => $values,
        ];
    }
}
