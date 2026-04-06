<<<<<<< HEAD
<div>
    <div class="mb-6 flex items-center justify-between rounded-xl border bg-white p-5 shadow-sm">
        <h2 class="text-2xl font-semibold text-gray-800">Dashboard học tập</h2>
        <a href="{{ route('vocabulary.sets') }}"
            class="inline-flex items-center rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700">
            Quản lý bộ từ
        </a>
    </div>

    <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-4">
        <div class="rounded-xl border bg-white p-5 shadow-sm">
            <p class="text-sm text-gray-500">Tổng số từ</p>
            <p class="mt-2 text-3xl font-bold text-gray-900">{{ $totalWords }}</p>
        </div>
        <div class="rounded-xl border bg-white p-5 shadow-sm">
            <p class="text-sm text-gray-500">Đã học hôm nay</p>
            <p class="mt-2 text-3xl font-bold text-gray-900">{{ $todayStudied }}</p>
        </div>
        <div class="rounded-xl border bg-white p-5 shadow-sm">
            <p class="text-sm text-gray-500">Cần ôn tập ngay</p>
            <p class="mt-2 text-3xl font-bold text-amber-600">{{ $reviewDue }}</p>
        </div>
        <div class="rounded-xl border bg-white p-5 shadow-sm">
            <p class="text-sm text-gray-500">Streak hiện tại</p>
            <p class="mt-2 text-3xl font-bold text-rose-600">{{ auth()->user()->streak_days ?? 0 }} ngày</p>
        </div>
    </div>

    <div class="mt-6 rounded-xl border bg-white p-5 shadow-sm">
        <div class="mb-2 flex items-center justify-between">
            <p class="text-sm text-gray-600">Tiến độ hôm nay</p>
            <p class="text-sm font-semibold text-gray-800">{{ $todayStudied }}/{{ $todayTarget }} từ</p>
        </div>
        <div class="h-2.5 w-full rounded-full bg-gray-100">
            <div class="h-2.5 rounded-full bg-indigo-600 transition-all" style="width: {{ $todayProgressPercent }}%"></div>
        </div>
    </div>

    <div class="mt-6 grid gap-6 lg:grid-cols-3">
        <div class="rounded-xl border bg-white p-5 shadow-sm lg:col-span-1">
            <h3 class="text-base font-semibold text-gray-900">Trạng thái SRS</h3>
            <div class="mt-4 space-y-3 text-sm">
                <div class="flex items-center justify-between"><span class="text-gray-600">New</span><span class="font-semibold">{{ $statusCounts['new'] }}</span></div>
                <div class="flex items-center justify-between"><span class="text-gray-600">Learning</span><span class="font-semibold">{{ $statusCounts['learning'] }}</span></div>
                <div class="flex items-center justify-between"><span class="text-gray-600">Review</span><span class="font-semibold">{{ $statusCounts['review'] }}</span></div>
                <div class="flex items-center justify-between"><span class="text-gray-600">Mastered</span><span class="font-semibold">{{ $statusCounts['mastered'] }}</span></div>
            </div>
        </div>

        <div class="rounded-xl border bg-white p-5 shadow-sm lg:col-span-2">
            <div class="mb-4 flex items-center justify-between">
                <h3 class="text-base font-semibold text-gray-900">Bộ từ gần đây</h3>
                <span class="text-xs text-gray-500">Nhấn vào bộ từ để thêm từ hoặc học flashcard</span>
            </div>

            @if ($recentSets->isEmpty())
                <div class="rounded-lg border border-dashed border-gray-300 p-6 text-center">
                    <p class="text-sm text-gray-600">Bạn chưa có bộ từ nào. Tạo bộ từ mẫu ở trang "Bộ từ vựng" để xem nhanh.</p>
                    <a href="{{ route('vocabulary.sets') }}"
                        class="mt-3 inline-flex items-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-medium text-white hover:bg-indigo-700">
                        Đi tới trang bộ từ
                    </a>
                </div>
            @else
                <div class="grid gap-3 md:grid-cols-2">
                    @foreach ($recentSets as $set)
                        <div class="rounded-lg border p-4">
                            <p class="font-semibold text-gray-900">{{ $set->name }}</p>
                            <p class="mt-1 text-xs text-gray-500">{{ $set->vocabularies_count }} từ</p>
                            <div class="mt-2 h-2 w-full rounded-full bg-gray-100">
                                <div class="h-2 rounded-full bg-emerald-500" style="width: {{ $set->completion_percent }}%"></div>
                            </div>
                            <p class="mt-1 text-[11px] text-gray-500">Hoàn thành {{ $set->completion_percent }}%</p>
                            <div class="mt-3 flex gap-2">
                                <a href="{{ route('vocabulary.words', $set) }}"
                                    class="rounded-md border px-3 py-1.5 text-xs font-medium text-gray-700 hover:bg-gray-50">
                                    Quản lý từ
                                </a>
                                <a href="{{ route('learning.flashcards', $set) }}"
                                    class="rounded-md bg-indigo-600 px-3 py-1.5 text-xs font-medium text-white hover:bg-indigo-700">
                                    Học flashcard
                                </a>
=======
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
>>>>>>> main
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
<<<<<<< HEAD
=======

        <div class="mt-8">
            <livewire:dashboard.activity-chart />
        </div>
>>>>>>> main
    </div>
</div>
