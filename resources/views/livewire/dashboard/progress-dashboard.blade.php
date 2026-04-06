<div class="py-10">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
        {{-- Stats cards --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            @php
                $totalWords = $totalWords ?? 0;
                $mastered   = $statusCounts['mastered'] ?? 0;
                $review     = $statusCounts['review'] ?? 0;
                $learning   = $statusCounts['learning'] ?? 0;
                $new        = $statusCounts['new'] ?? 0;
            @endphp

            <div class="bg-white border border-gray-100 rounded-xl shadow-sm p-5">
                <p class="text-sm text-gray-500">Total Words</p>
                <p class="text-3xl font-semibold text-gray-900">{{ $totalWords }}</p>
            </div>

            <div class="bg-white border border-gray-100 rounded-xl shadow-sm p-5">
                <p class="text-sm text-gray-500">Mastered</p>
                <p class="text-3xl font-semibold text-emerald-600">{{ $mastered }}</p>
            </div>

            <div class="bg-white border border-gray-100 rounded-xl shadow-sm p-5">
                <p class="text-sm text-gray-500">In Review</p>
                <p class="text-3xl font-semibold text-indigo-600">{{ $review + $learning }}</p>
                <p class="text-xs text-gray-500 mt-1">Review: {{ $review }} · Learning: {{ $learning }}</p>
            </div>

            <div class="bg-white border border-gray-100 rounded-xl shadow-sm p-5">
                <p class="text-sm text-gray-500">New</p>
                <p class="text-3xl font-semibold text-amber-600">{{ $new }}</p>
            </div>
        </div>

        {{-- Streak & today progress --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="bg-white border border-gray-100 rounded-xl shadow-sm p-6 flex items-center gap-4">
                <div class="text-4xl">🔥</div>
                <div>
                    <p class="text-sm text-gray-500">Current Streak</p>
                    <p class="text-3xl font-semibold text-gray-900">{{ $streak }} ngày</p>
                </div>
            </div>

            <div class="bg-white border border-gray-100 rounded-xl shadow-sm p-6 lg:col-span-2">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Hôm nay</p>
                        <p class="text-xl font-semibold text-gray-900">{{ $todayLearned }} / {{ $goalTotal }} từ</p>
                    </div>
                    <span class="text-sm text-gray-500">Mục tiêu = từ mới + ôn tập</span>
                </div>
                @php
                    $percentToday = $goalTotal > 0 ? min(100, round(($todayLearned / $goalTotal) * 100)) : 0;
                @endphp
                <div class="mt-4 w-full bg-gray-100 rounded-full h-3 overflow-hidden">
                    <div class="h-3 bg-indigo-600" style="width: {{ $percentToday }}%"></div>
                </div>
                <p class="text-xs text-gray-500 mt-2">Hoàn thành {{ $percentToday }}%</p>
            </div>
        </div>

        {{-- Sets progress --}}
        <div class="bg-white border border-gray-100 rounded-xl shadow-sm p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Bộ từ vựng</h3>
                @php
                    $setsUrl = match (true) {
                        \Illuminate\Support\Facades\Route::has('vocabulary.sets.index') => route('vocabulary.sets.index'),
                        \Illuminate\Support\Facades\Route::has('vocabulary.sets') => route('vocabulary.sets'),
                        default => url('/vocabulary'),
                    };
                @endphp
                <a href="{{ $setsUrl }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-700">Quản lý bộ từ</a>
            </div>

            @if ($setProgress->isEmpty())
                <p class="text-sm text-gray-600">Chưa có bộ từ nào.</p>
            @else
                <div class="space-y-4">
                    @foreach ($setProgress as $set)
                        <div class="border border-gray-100 rounded-lg p-4">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="font-semibold text-gray-900">{{ $set['name'] }}</p>
                                    <p class="text-xs text-gray-500">{{ $set['mastered'] }} / {{ $set['total'] }} từ</p>
                                </div>
                                <span class="text-sm font-medium text-gray-700">{{ $set['percent'] }}%</span>
                            </div>
                            <div class="mt-3 w-full bg-gray-100 rounded-full h-2 overflow-hidden">
                                <div class="h-2 bg-emerald-500" style="width: {{ $set['percent'] }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <div class="mt-8">
            <livewire:dashboard.activity-chart />
        </div>
    </div>
</div>
