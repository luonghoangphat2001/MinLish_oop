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
=======
<div class="space-y-5">

    {{-- ── Header ── --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3
                bg-white rounded-[24px] border border-slate-100 px-6 py-5 shadow-sm">
        <div>
            <h2 class="text-[18px] font-black text-slate-900 uppercase tracking-tight">BẢNG HỌC TẬP</h2>
            <p class="text-[10px] font-black text-slate-400 mt-1 uppercase tracking-widest">THEO DÕI TIẾN ĐỘ VÀ BỘ TỪ VỰNG CỦA BẠN</p>
        </div>
        <a href="{{ route('vocabulary.sets') }}"
           class="self-start sm:self-auto inline-flex items-center gap-2 px-6 py-3.5 rounded-2xl text-[12px] font-black text-white bg-indigo-600 hover:bg-indigo-700 transition-all duration-300 shadow-xl shadow-indigo-600/20 active:scale-95 uppercase tracking-widest">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
            </svg>
            QUẢN LÝ BỘ TỪ
        </a>
    </div>

    {{-- ── Stats grid ── --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3">
        @php
            $stats = [
                ['label' => 'TỔNG SỐ TỪ',      'value' => $totalWords,   'color' => 'text-slate-900',  'bg' => 'bg-slate-50',  'border' => 'border-slate-100'],
                ['label' => 'ĐÃ HỌC HÔM NAY',   'value' => $todayStudied, 'color' => 'text-indigo-700', 'bg' => 'bg-indigo-50', 'border' => 'border-indigo-100'],
                ['label' => 'CẦN ÔN TẬP NGAY',  'value' => $reviewDue,    'color' => 'text-amber-700',  'bg' => 'bg-amber-50',  'border' => 'border-amber-100'],
                ['label' => 'STREAK HIỆN TẠI',   'value' => (auth()->user()->streak_days ?? 0) . ' NGÀY', 'color' => 'text-rose-700', 'bg' => 'bg-rose-50', 'border' => 'border-rose-100'],
            ];
        @endphp
        @foreach($stats as $s)
            <div class="rounded-[24px] border {{ $s['border'] }} {{ $s['bg'] }} p-5 shadow-sm">
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-400">{{ $s['label'] }}</p>
                <p class="mt-2 text-3xl font-black {{ $s['color'] }}">{{ $s['value'] }}</p>
            </div>
        @endforeach
    </div>

    {{-- ── Today's progress bar ── --}}
    <div class="bg-white rounded-[24px] border border-slate-100 px-6 py-5 shadow-sm">
        <div class="flex items-center justify-between mb-3">
            <p class="text-[12px] font-black text-slate-600 uppercase tracking-tight">TIẾN ĐỘ HÔM NAY</p>
            <p class="text-[12px] font-black text-slate-800 uppercase">{{ $todayStudied }}/{{ $todayTarget }} TỪ</p>
        </div>
        <div class="h-3 w-full rounded-full bg-slate-100 shadow-inner">
            <div class="h-3 rounded-full bg-gradient-to-r from-indigo-500 to-violet-500 transition-all duration-700"
                 style="width: {{ min($todayProgressPercent, 100) }}%"></div>
        </div>
        <p class="mt-2 text-[10px] font-black text-slate-400 uppercase tracking-widest">{{ $todayProgressPercent }}% HOÀN THÀNH</p>
    </div>

    {{-- ── Activity & SRS Charts ── --}}
    <livewire:dashboard.activity-chart />

    {{-- ── SRS status + Recent sets ── --}}
    <div class="grid gap-5 lg:grid-cols-3">

        {{-- SRS panel --}}
        <div class="bg-white rounded-[24px] border border-slate-100 p-6 shadow-sm">
            <h3 class="text-[14px] font-black text-slate-900 uppercase tracking-tight mb-5">TRẠNG THÁI SRS</h3>
            <div class="space-y-3">
                @php
                    $srsItems = [
                        ['label' => 'MỚI',      'key' => 'new',      'color' => 'bg-slate-400'],
                        ['label' => 'ĐANG HỌC', 'key' => 'learning', 'color' => 'bg-amber-400'],
                        ['label' => 'ÔN TẬP',   'key' => 'review',   'color' => 'bg-blue-400'],
                        ['label' => 'ĐÃ THUỘC', 'key' => 'mastered', 'color' => 'bg-emerald-400'],
                    ];
                @endphp
                @foreach($srsItems as $s)
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full {{ $s['color'] }}"></span>
                            <span class="text-[13px] font-black text-slate-600 uppercase tracking-tight">{{ $s['label'] }}</span>
                        </div>
                        <span class="text-[13px] font-black text-slate-900">{{ $statusCounts[$s['key']] ?? 0 }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Recent sets --}}
        <div class="bg-white rounded-[24px] border border-slate-100 p-6 shadow-sm lg:col-span-2">
            <div class="flex items-center justify-between mb-5">
                <h3 class="text-[14px] font-black text-slate-900 uppercase tracking-tight">BỘ TỪ GẦN ĐÂY</h3>
                <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">NHẤN ĐỂ HỌC FLASHCARD</span>
            </div>

            @if ($recentSets->isEmpty())
                <div class="rounded-[20px] border border-dashed border-slate-200 p-8 text-center">
                    <p class="text-[13px] font-black text-slate-500 uppercase tracking-tight">BẠN CHƯA CÓ BỘ TỪ NÀO</p>
                    <a href="{{ route('vocabulary.sets') }}"
                       class="mt-4 inline-flex items-center gap-2 rounded-2xl bg-indigo-600 px-6 py-3 text-[12px] font-black text-white hover:bg-indigo-700 transition-all shadow-xl shadow-indigo-600/20 uppercase tracking-widest">
                        TẠO BỘ TỪ NGAY
                    </a>
                </div>
            @else
                <div class="grid gap-3 sm:grid-cols-2">
                    @foreach ($recentSets as $set)
                        <div class="rounded-[20px] border border-slate-100 p-5 hover:border-indigo-300 hover:shadow-lg transition-all duration-300 cursor-pointer">
                            <p class="text-[14px] font-black text-slate-900 truncate uppercase tracking-tight">{{ $set->name }}</p>
                            <p class="mt-0.5 text-[11px] font-black text-slate-400 uppercase tracking-widest">{{ $set->vocabularies_count }} TỪ</p>
                            <div class="mt-3 h-1.5 w-full rounded-full bg-slate-100 shadow-inner">
                                <div class="h-1.5 rounded-full bg-emerald-400 transition-all duration-500"
                                     style="width: {{ $set->completion_percent }}%"></div>
                            </div>
                            <p class="mt-1.5 text-[10px] font-black text-slate-400 uppercase tracking-widest">HOÀN THÀNH {{ $set->completion_percent }}%</p>
                            <div class="mt-4 flex gap-2">
                                <a href="{{ route('vocabulary.words', $set) }}"
                                   class="flex-1 text-center rounded-xl border border-slate-100 px-2 py-2.5 text-[11px] font-black text-slate-600 hover:bg-slate-50 transition-colors uppercase tracking-widest">
                                    QUẢN LÝ TỪ
                                </a>
                                <a href="{{ route('learning.flashcards', $set) }}"
                                   class="flex-1 text-center rounded-xl bg-indigo-600 px-2 py-2.5 text-[11px] font-black text-white hover:bg-indigo-700 transition-colors uppercase tracking-widest shadow-lg shadow-indigo-600/20">
                                    HỌC FLASHCARD
>>>>>>> origin/main
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
