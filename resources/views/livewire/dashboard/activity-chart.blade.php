<div x-data="{
        barChart: null,
        doughnutChart: null,
        labels: @js($labels),
        barData: @js($barData),
        status: @js($statusCounts),

        init() {
            this.renderCharts();

            // Listen for refreshes via Livewire 3 event system
            $wire.on('activity-chart-refresh', (data) => {
                const updated = Array.isArray(data) ? data[0] : data;
                this.labels = updated.labels;
                this.barData = updated.barData;
                this.status = updated.status;
                this.updateCharts();
            });
        },

        renderCharts() {
            if (this.barChart) this.barChart.destroy();
            if (this.doughnutChart) this.doughnutChart.destroy();

            const canvasBar = document.getElementById('activity-bar');
            if (canvasBar) {
                this.barChart = new Chart(canvasBar.getContext('2d'), {
                    type: 'bar',
                    data: {
                        labels: this.labels,
                        datasets: [{
                            label: 'Từ vựng',
                            data: this.barData,
                            backgroundColor: '#6366f1',
                            borderRadius: 8,
                            maxBarThickness: 32,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: { legend: { display: false } },
                        scales: {
                            x: { grid: { display: false }, ticks: { font: { size: 10 }, color: '#94a3b8' } },
                            y: { beginAtZero: true, grid: { color: '#f1f5f9' }, ticks: { font: { size: 10 }, color: '#94a3b8' } }
                        }
                    }
                });
            }

            const canvasDoughnut = document.getElementById('status-doughnut');
            if (canvasDoughnut) {
                this.doughnutChart = new Chart(canvasDoughnut.getContext('2d'), {
                    type: 'doughnut',
                    data: {
                        labels: ['Mới', 'Đang học', 'Ôn tập', 'Đã thuộc'],
                        datasets: [{
                            data: this.getStatusArray(),
                            backgroundColor: ['#94a3b8', '#fbbf24', '#6366f1', '#10b981'],
                            borderWidth: 4,
                            borderColor: '#ffffff'
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        cutout: '70%',
                        plugins: {
                            legend: { position: 'bottom', labels: { usePointStyle: true, padding: 20 } }
                        }
                    }
                });
            }
        },

        updateCharts() {
            if (this.barChart) {
                this.barChart.data.labels = this.labels;
                this.barChart.data.datasets[0].data = this.barData;
                this.barChart.update();
            }
            if (this.doughnutChart) {
                this.doughnutChart.data.datasets[0].data = this.getStatusArray();
                this.doughnutChart.update();
            }
        },

        getStatusArray() {
            return [
                this.status['new'] ?? 0,
                this.status['learning'] ?? 0,
                this.status['review'] ?? 0,
                this.status['mastered'] ?? 0
            ];
        }
    }" class="space-y-6">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Activity Bar Chart --}}
        <div class="bg-white mt-6 rounded-[32px] border border-slate-100 shadow-sm p-8">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h3 class="text-[15px] font-black text-slate-900 uppercase tracking-tight">HOẠT ĐỘNG 30 NGÀY</h3>
                    <p class="text-[10px] font-black text-slate-400 mt-1 uppercase tracking-widest">SỐ TỪ ĐÃ HỌC MỖI
                        NGÀY</p>
                </div>
                <div class="w-10 h-10 rounded-2xl bg-indigo-50 flex items-center justify-center text-indigo-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                </div>
            </div>
            <div class="relative h-64">
                <canvas id="activity-bar"></canvas>
            </div>
        </div>

        {{-- SRS Status Doughnut Chart --}}
        <div class="bg-white mt-6 rounded-[32px] border border-slate-100 shadow-sm p-8">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h3 class="text-[15px] font-black text-slate-900 uppercase tracking-tight">PHÂN BỔ SRS</h3>
                    <p class="text-[10px] font-black text-slate-400 mt-1 uppercase tracking-widest">TRẠNG THÁI TỪ VỰNG
                        TRONG HỆ THỐNG</p>
                </div>
                <div class="w-10 h-10 rounded-2xl bg-emerald-50 flex items-center justify-center text-emerald-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z" />
                    </svg>
                </div>
            </div>
            <div class="relative h-64 flex items-center justify-center">
                <canvas id="status-doughnut"></canvas>
            </div>
        </div>
    </div>
</div>