@php
    $labels      = $labels      ?? [];
    $barData     = $barData     ?? [];
    $statusCounts = $statusCounts ?? [];
@endphp

<div
    x-data="activityChart({
        labels:  @js($labels),
        barData: @js($barData),
        status:  @js($statusCounts),
    })"
    x-init="init()"
    class="space-y-4"
>
    {{-- Bar chart --}}
    <div class="bg-white rounded-[24px] border border-slate-100 shadow-sm p-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-1 mb-5">
            <h3 class="text-[14px] font-black text-slate-900 uppercase tracking-tight">HOẠT ĐỘNG 30 NGÀY</h3>
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">SỐ TỪ ĐÃ HỌC MỖI NGÀY</p>
        </div>
        <div class="relative h-48 sm:h-56">
            <canvas id="activity-bar"></canvas>
        </div>
    </div>

    {{-- Doughnut chart --}}
    <div class="bg-white rounded-[24px] border border-slate-100 shadow-sm p-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-1 mb-5">
            <h3 class="text-[14px] font-black text-slate-900 uppercase tracking-tight">TRẠNG THÁI SRS</h3>
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">PHÂN BỔ THEO TRẠNG THÁI HỌC</p>
        </div>
        <div class="max-w-xs mx-auto h-52">
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
                        backgroundColor: 'rgba(99, 102, 241, 0.75)',
                        borderRadius: 6,
                        borderSkipped: false,
                    }],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        x: { ticks: { color: '#94a3b8', font: { size: 11 } }, grid: { display: false } },
                        y: { ticks: { color: '#94a3b8', font: { size: 11 } }, beginAtZero: true, grid: { color: '#f1f5f9' } },
                    },
                },
            });

            const ctxPie = document.getElementById('status-pie').getContext('2d');
            this.pieChart = new Chart(ctxPie, {
                type: 'doughnut',
                data: {
                    labels: ['Mới', 'Đang học', 'Ôn tập', 'Đã thuộc'],
                    datasets: [{
                        data: this.statusArray(),
                        backgroundColor: [
                            'rgba(148,163,184,0.85)',
                            'rgba(251,191,36,0.85)',
                            'rgba(99,102,241,0.85)',
                            'rgba(52,211,153,0.85)',
                        ],
                        borderWidth: 2,
                        borderColor: '#fff',
                    }],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: { color: '#475569', font: { size: 11 }, padding: 12 }
                        },
                    },
                    cutout: '60%',
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
            return [s['new'] ?? 0, s['learning'] ?? 0, s['review'] ?? 0, s['mastered'] ?? 0];
        },
    };
}
</script>
