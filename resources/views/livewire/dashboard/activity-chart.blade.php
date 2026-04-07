@php
    $labels = $labels ?? [];
    $barData = $barData ?? [];
    $statusCounts = $statusCounts ?? [];
@endphp

<div
    x-data="activityChart({
        labels: @js($labels),
        barData: @js($barData),
        status: @js($statusCounts),
    })"
    x-init="init()"
    class="space-y-6"
>
    <div class="bg-white border border-gray-100 rounded-xl shadow-sm p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-900">Hoạt động 30 ngày</h3>
            <p class="text-sm text-gray-500">Số từ đã học mỗi ngày</p>
        </div>
        <div class="relative">
            <canvas id="activity-bar"></canvas>
        </div>
    </div>

    <div class="bg-white border border-gray-100 rounded-xl shadow-sm p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-900">Trạng thái SRS</h3>
            <p class="text-sm text-gray-500">Phân bổ theo trạng thái</p>
        </div>
        <div class="w-full max-w-md mx-auto">
            <canvas id="status-pie"></canvas>
        </div>
    </div>
</div>

<script>
    function activityChart(initial) {
        return {
            barChart: null,
            pieChart: null,
            data: initial,
            init() {
                this.renderCharts();
                window.addEventListener('activity-chart-refresh', (event) => {
                    this.data.labels  = event.detail.labels;
                    this.data.barData = event.detail.barData;
                    this.data.status  = event.detail.status;
                    this.updateCharts();
                });
            },
            renderCharts() {
                const ctxBar = document.getElementById('activity-bar').getContext('2d');
                this.barChart = new Chart(ctxBar, {
                    type: 'bar',
                    data: {
                        labels: this.data.labels,
                        datasets: [{
                            label: 'Từ đã học',
                            data: this.data.barData,
                            backgroundColor: 'rgba(99, 102, 241, 0.7)',
                            borderRadius: 4,
                        }],
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            x: { ticks: { color: '#6b7280' } },
                            y: { ticks: { color: '#6b7280' }, beginAtZero: true },
                        },
                    },
                });

                const ctxPie = document.getElementById('status-pie').getContext('2d');
                this.pieChart = new Chart(ctxPie, {
                    type: 'doughnut',
                    data: {
                        labels: ['New', 'Learning', 'Review', 'Mastered'],
                        datasets: [{
                            data: this.statusArray(),
                            backgroundColor: [
                                'rgba(251, 146, 60, 0.8)',   // amber
                                'rgba(59, 130, 246, 0.8)',  // blue
                                'rgba(99, 102, 241, 0.8)',  // indigo
                                'rgba(16, 185, 129, 0.8)',  // emerald
                            ],
                        }],
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { position: 'bottom', labels: { color: '#374151' } },
                        },
                        cutout: '55%',
                    },
                });
            },
            updateCharts() {
                if (this.barChart) {
                    this.barChart.data.labels = this.data.labels;
                    this.barChart.data.datasets[0].data = this.data.barData;
                    this.barChart.update();
                }
                if (this.pieChart) {
                    this.pieChart.data.datasets[0].data = this.statusArray();
                    this.pieChart.update();
                }
            },
            statusArray() {
                const s = this.data.status || {};
                return [
                    s['new'] ?? 0,
                    s['learning'] ?? 0,
                    s['review'] ?? 0,
                    s['mastered'] ?? 0,
                ];
            },
        };
    }
</script>