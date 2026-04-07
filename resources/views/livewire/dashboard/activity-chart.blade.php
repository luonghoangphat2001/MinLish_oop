<div class="grid gap-6 lg:grid-cols-2">
    {{-- Hoạt động 30 ngày --}}
    <div class="rounded-xl border bg-white p-5 shadow-sm"
        x-data="{
            labels: @js($activityLabels),
            values: @js($activityValues),
            chart: null,
            init() {
                this.chart = new Chart(this.$refs.canvas, {
                    type: 'bar',
                    data: {
                        labels: this.labels,
                        datasets: [{
                            label: 'Số từ đã học',
                            data: this.values,
                            backgroundColor: '#4f46e5',
                            borderRadius: 4,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false }
                        },
                        scales: {
                            y: { beginAtZero: true, ticks: { stepSize: 1 } },
                            x: { grid: { display: false } }
                        }
                    }
                });

                this.$wire.on('refreshCharts', () => {
                    this.chart.data.labels = this.$wire.activityLabels;
                    this.chart.data.datasets[0].data = this.$wire.activityValues;
                    this.chart.update();
                });
            }
        }">
        <h3 class="mb-4 text-base font-semibold text-gray-900">Hoạt động 30 ngày qua</h3>
        <div class="h-64">
            <canvas x-ref="canvas"></canvas>
        </div>
    </div>

    {{-- Phân bổ trạng thái SRS --}}
    <div class="rounded-xl border bg-white p-5 shadow-sm"
        x-data="{
            labels: @js($statusLabels),
            values: @js($statusValues),
            chart: null,
            init() {
                this.chart = new Chart(this.$refs.canvas, {
                    type: 'doughnut',
                    data: {
                        labels: this.labels,
                        datasets: [{
                            data: this.values,
                            backgroundColor: ['#94a3b8', '#6366f1', '#fbbf24', '#10b981'],
                            borderWidth: 0,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { position: 'bottom' }
                        }
                    }
                });

                this.$wire.on('refreshCharts', () => {
                    this.chart.data.labels = this.$wire.statusLabels;
                    this.chart.data.datasets[0].data = this.$wire.statusValues;
                    this.chart.update();
                });
            }
        }">
        <h3 class="mb-4 text-base font-semibold text-gray-900">Phân bổ trạng thái</h3>
        <div class="h-64">
            <canvas x-ref="canvas"></canvas>
        </div>
    </div>
</div>
