<<<<<<< HEAD
<div>
    <div class="mb-6 flex flex-col gap-2 rounded-xl border bg-white p-5 shadow-sm sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-2xl font-semibold text-gray-800">Flashcard: {{ $set->name }}</h2>
            <p class="text-sm text-gray-500">Space: lật thẻ | 1: lại | 2: khó | 3: tốt | 4: dễ</p>
        </div>
        <a href="{{ route('vocabulary.words', $set) }}"
            class="rounded-md border px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">
            Quản lý từ của bộ này
        </a>
    </div>

    <div x-data="{ flipped: @entangle('showBack') }"
        x-on:keydown.window.space.prevent="$wire.flipCard()"
        x-on:keydown.window.1.prevent="$wire.submitRating('again')"
        x-on:keydown.window.2.prevent="$wire.submitRating('hard')"
        x-on:keydown.window.3.prevent="$wire.submitRating('good')"
        x-on:keydown.window.4.prevent="$wire.submitRating('easy')"
        class="mx-auto max-w-3xl">

        @if ($total === 0)
            <div class="rounded-xl border border-dashed border-gray-300 bg-white p-10 text-center shadow-sm">
                <p class="text-gray-600">Bộ từ này chưa có dữ liệu học. Hãy thêm từ trước khi bắt đầu.</p>
                <a href="{{ route('vocabulary.words', $set) }}"
                    class="mt-3 inline-flex rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700">
                    Thêm từ ngay
                </a>
            </div>
        @elseif ($completed)
            <div class="rounded-xl border bg-white p-8 text-center shadow-sm">
                <h3 class="text-2xl font-bold text-gray-900">Hoàn thành phiên học</h3>
                <p class="mt-2 text-gray-600">Bạn đã học {{ $total }} từ trong bộ này.</p>
                <div class="mx-auto mt-5 grid max-w-md grid-cols-2 gap-3 text-sm">
                    <div class="rounded-md bg-red-50 p-3 text-red-700">Lại: {{ $ratingSummary['again'] }}</div>
                    <div class="rounded-md bg-amber-50 p-3 text-amber-700">Khó: {{ $ratingSummary['hard'] }}</div>
                    <div class="rounded-md bg-emerald-50 p-3 text-emerald-700">Tốt: {{ $ratingSummary['good'] }}</div>
                    <div class="rounded-md bg-blue-50 p-3 text-blue-700">Dễ: {{ $ratingSummary['easy'] }}</div>
                </div>
                <div class="mt-6 flex justify-center gap-2">
                    <button wire:click="restartSession"
                        class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700">
                        Học lại bộ này
                    </button>
                    <a href="{{ route('dashboard') }}"
                        class="rounded-md border px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-50">
                        Về dashboard
                    </a>
                </div>
            </div>
        @elseif ($currentProgress)
            <div class="mb-4 flex items-center justify-between text-sm text-gray-600">
                <span>Từ {{ $currentIndex + 1 }}/{{ $total }}</span>
                <span>Trạng thái: <strong class="uppercase">{{ $currentProgress->status }}</strong></span>
            </div>

            <div class="rounded-2xl border bg-white p-8 shadow-sm">
                <div class="relative mx-auto h-[240px] w-full [perspective:1200px]">
                    <div class="relative h-full w-full transition-transform duration-500 [transform-style:preserve-3d]"
                         :class="flipped ? '[transform:rotateY(180deg)]' : ''">
                        <div class="absolute inset-0 rounded-xl border bg-white p-5 [backface-visibility:hidden]">
                            <div class="text-center pt-8">
                                <p class="text-3xl font-bold text-gray-900">{{ $currentProgress->vocabulary->word }}</p>
                                <p class="mt-1 text-sm text-gray-500">{{ $currentProgress->vocabulary->pronunciation ?: 'Chưa có phiên âm' }}</p>
                            </div>
                        </div>

                        <div class="absolute inset-0 rounded-xl border bg-gray-50 p-5 [backface-visibility:hidden] [transform:rotateY(180deg)]">
                            <p class="text-lg font-semibold text-indigo-700">{{ $currentProgress->vocabulary->meaning }}</p>
                            @if ($currentProgress->vocabulary->example)
                                <p class="mt-2 text-sm text-gray-600">Ví dụ: {{ $currentProgress->vocabulary->example }}</p>
                            @endif
                            @if ($currentProgress->vocabulary->collocation)
                                <p class="mt-1 text-sm text-gray-600">Cụm từ đi cùng: {{ $currentProgress->vocabulary->collocation }}</p>
                            @endif
                            @if ($currentProgress->vocabulary->note)
                                <p class="mt-1 text-sm text-gray-600">Ghi chú: {{ $currentProgress->vocabulary->note }}</p>
=======
<div class="space-y-8">
    {{-- ── Header Panel ── --}}
    <div class="flex flex-col md:flex-row items-center justify-between gap-6 bg-white rounded-[40px] border border-slate-100 p-8 shadow-sm">
        <div class="flex items-center gap-6">
            <div class="w-20 h-20 rounded-3xl bg-indigo-50 flex items-center justify-center text-indigo-600 shadow-inner">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                </svg>
            </div>
            <div>
                <h2 class="text-[18px] font-black text-slate-900 tracking-tight uppercase leading-tight">FLASHCARD: {{ $set->name }}</h2>
                <div class="flex items-center gap-3 mt-1">
                    <span class="text-[10px] font-black text-indigo-500 uppercase tracking-widest bg-indigo-50 px-3 py-1 rounded-full border border-indigo-100">PHƯƠNG PHÁP SRS</span>
                    <p class="text-[11px] font-black text-slate-400 uppercase tracking-widest">SPACE: LẬT THẺ | 1–4: ĐÁNH GIÁ</p>
                </div>
            </div>
        </div>
        <a href="{{ route('vocabulary.words', $set) }}"
           class="w-full md:w-auto inline-flex items-center justify-center gap-2 text-center px-8 py-4 text-[12px] font-black text-slate-500 bg-slate-50 rounded-2xl hover:bg-slate-100 transition-colors uppercase tracking-widest">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M7 16l-4-4m0 0l4-4m-4 4h18"/>
            </svg>
            QUẢN LÝ TỪ
        </a>
    </div>

    {{-- ── Main Flashcard Area ── --}}
    <div x-data="{ flipped: @entangle('showBack') }"
         x-on:keydown.window.space.prevent="$wire.flipCard()"
         x-on:keydown.window.1.prevent="$wire.submitRating('again')"
         x-on:keydown.window.2.prevent="$wire.submitRating('hard')"
         x-on:keydown.window.3.prevent="$wire.submitRating('good')"
         x-on:keydown.window.4.prevent="$wire.submitRating('easy')"
         class="w-full max-w-3xl mx-auto">

        {{-- ─ Trạng thái trống ─ --}}
        @if ($total === 0)
            <div class="bg-white rounded-[40px] border border-slate-100 p-16 text-center shadow-sm">
                <div class="w-24 h-24 rounded-3xl bg-slate-50 flex items-center justify-center mx-auto mb-8 shadow-inner">
                    <svg class="w-12 h-12 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <p class="text-[18px] font-black text-slate-900 uppercase tracking-tight">BỘ TỪ TRỐNG</p>
                <p class="text-[13px] font-black text-slate-400 uppercase tracking-widest mt-2">VUI LÒNG THÊM TỪ VỰNG TRƯỚC KHI BẮT ĐẦU HỌC.</p>
                <a href="{{ route('vocabulary.words', $set) }}"
                   class="inline-flex mt-8 px-10 py-4 bg-indigo-600 text-white text-[12px] font-black rounded-2xl hover:bg-indigo-700 transition-all shadow-xl shadow-indigo-600/20 uppercase tracking-widest">
                    THÊM TỪ NGAY
                </a>
            </div>

        {{-- ─ Hoàn thành phiên học ─ --}}
        @elseif ($completed)
            <div class="bg-white rounded-[40px] border border-slate-100 p-12 text-center shadow-lg">
                <div class="w-24 h-24 rounded-full bg-emerald-50 flex items-center justify-center mx-auto mb-8 shadow-inner">
                    <svg class="w-12 h-12 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0"/>
                    </svg>
                </div>
                <h3 class="text-[18px] font-black text-slate-900 uppercase tracking-tight">XUẤT SẮC! HOÀN THÀNH</h3>
                <p class="mt-4 text-[13px] font-black text-slate-500 uppercase tracking-widest">BẠN ĐÃ ÔN TẬP THÀNH CÔNG BÀI HỌC HÔM NAY.</p>

                <div class="mx-auto mt-12 grid grid-cols-2 sm:grid-cols-4 gap-4 max-w-xl">
                    <div class="rounded-3xl bg-red-50 border border-red-100 p-4 text-red-600 font-black">
                        <p class="text-2xl">{{ $ratingSummary['again'] }}</p>
                        <p class="text-[10px] uppercase tracking-widest mt-1">LẠI</p>
                    </div>
                    <div class="rounded-3xl bg-amber-50 border border-amber-100 p-4 text-amber-600 font-black">
                        <p class="text-2xl">{{ $ratingSummary['hard'] }}</p>
                        <p class="text-[10px] uppercase tracking-widest mt-1">KHÓ</p>
                    </div>
                    <div class="rounded-3xl bg-emerald-50 border border-emerald-100 p-4 text-emerald-600 font-black">
                        <p class="text-2xl">{{ $ratingSummary['good'] }}</p>
                        <p class="text-[10px] uppercase tracking-widest mt-1">TỐT</p>
                    </div>
                    <div class="rounded-3xl bg-blue-50 border border-blue-100 p-4 text-blue-600 font-black">
                        <p class="text-2xl">{{ $ratingSummary['easy'] }}</p>
                        <p class="text-[10px] uppercase tracking-widest mt-1">DỄ</p>
                    </div>
                </div>

                <div class="mt-12 flex flex-col sm:flex-row justify-center gap-4">
                    <button wire:click="restartSession"
                        class="px-10 py-4 bg-indigo-600 text-white text-[12px] font-black rounded-2xl hover:bg-indigo-700 transition-all shadow-xl shadow-indigo-600/20 uppercase tracking-widest">
                        HỌC LẠI NGAY
                    </button>
                    <a href="{{ route('dashboard') }}"
                       class="px-10 py-4 bg-slate-50 text-slate-500 text-[12px] font-black rounded-2xl hover:bg-slate-100 transition-all uppercase tracking-widest">
                        VỀ TRANG CHỦ
                    </a>
                </div>
            </div>

        {{-- ─ Phiên học đang diễn ra ─ --}}
        @elseif ($currentProgress)
            {{-- Thanh tiến độ --}}
            <div class="bg-white rounded-3xl border border-slate-100 p-6 mb-6 shadow-sm">
                <div class="flex items-center justify-between font-black text-[11px] text-slate-400 uppercase tracking-widest mb-4">
                    <span>TIẾN ĐỘ: {{ $currentIndex + 1 }} / {{ $total }}</span>
                    <span class="text-indigo-600">{{ $currentProgress->status }}</span>
                </div>
                <div class="h-3 w-full bg-slate-100 rounded-full overflow-hidden shadow-inner">
                    <div class="h-full bg-indigo-600 rounded-full transition-all duration-700 ease-out shadow-lg shadow-indigo-400/30"
                         style="width: {{ (($currentIndex + 1) / $total) * 100 }}%"></div>
                </div>
            </div>

            {{-- 3D Flashcard --}}
            <div class="bg-white rounded-[40px] border border-slate-100 p-8 shadow-xl">
                <div class="relative mx-auto h-64 sm:h-80 w-full [perspective:2000px]">
                    <div class="card-flip-inner relative h-full w-full shadow-2xl rounded-[32px] cursor-pointer"
                         @click="flipped = !flipped"
                         :class="flipped ? 'flipped' : ''">

                        {{-- Mặt trước (Câu hỏi) --}}
                        <div class="card-face absolute inset-0 flex flex-col items-center justify-center rounded-[32px] bg-indigo-600 border-4 border-white shadow-2xl p-8 text-white group">
                            <div class="absolute top-6 left-1/2 -translate-x-1/2 flex items-center gap-2 opacity-50 font-black text-[10px] uppercase tracking-widest">
                                <span>Question</span>
                            </div>
                            <p class="text-4xl sm:text-6xl font-black text-center tracking-tighter leading-tight">
                                {{ $currentProgress->vocabulary->word }}
                            </p>
                            @if($currentProgress->vocabulary->pronunciation)
                                <p class="mt-6 text-[18px] font-black bg-white/20 backdrop-blur-sm px-6 py-2 rounded-full border border-white/30">
                                    /{{ $currentProgress->vocabulary->pronunciation }}/
                                </p>
                            @endif
                            <div class="absolute bottom-6 text-[10px] font-black uppercase tracking-widest opacity-40 group-hover:opacity-100 transition-opacity">
                                NHẤN VÀO ĐỂ XEM NGHĨA
                            </div>
                        </div>

                        {{-- Mặt sau (Đáp án) --}}
                        <div class="card-face card-face-back absolute inset-0 rounded-[32px] bg-white border-4 border-indigo-600 shadow-2xl p-8 flex flex-col items-center justify-center overflow-y-auto">
                            <div class="absolute top-6 left-1/2 -translate-x-1/2 flex items-center gap-2 text-indigo-400 font-black text-[10px] uppercase tracking-widest">
                                <span>Answer</span>
                            </div>

                            <p class="text-3xl sm:text-5xl font-black text-indigo-700 text-center leading-tight uppercase tracking-tight">
                                {{ $currentProgress->vocabulary->meaning }}
                            </p>

                            @if ($currentProgress->vocabulary->example)
                                <div class="mt-8 p-6 bg-slate-50 rounded-2xl border border-slate-100 max-w-md w-full">
                                    <p class="text-[14px] font-black text-slate-600 text-center leading-relaxed">
                                        "{{ $currentProgress->vocabulary->example }}"
                                    </p>
                                </div>
                            @endif

                            @if ($currentProgress->vocabulary->note)
                                <div class="mt-4 flex items-center gap-2 text-[12px] font-black text-slate-400 uppercase tracking-widest">
                                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                    <span>{{ $currentProgress->vocabulary->note }}</span>
                                </div>
>>>>>>> origin/main
                            @endif
                        </div>
                    </div>
                </div>

<<<<<<< HEAD
                <div class="mt-6">
                    <button wire:click="flipCard"
                        class="w-full rounded-md border px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-50">
                        {{ $showBack ? 'Ẩn mặt sau' : 'Lật thẻ' }}
                    </button>
                </div>

                <div class="mt-4 grid grid-cols-2 gap-3 sm:grid-cols-4 ">
                    <button wire:click="submitRating('again')"
                        class="inline-flex min-h-11 w-full items-center justify-center rounded-md bg-red-500 px-3 py-2 text-sm font-semibold text-white shadow hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-300">
                        1 · Lại
                    </button>
                    <button wire:click="submitRating('hard')"
                        class="inline-flex min-h-11 w-full items-center justify-center rounded-md bg-amber-500 px-3 py-2 text-sm font-semibold text-white shadow hover:bg-amber-600 focus:outline-none focus:ring-2 focus:ring-amber-300">
                        2 · Khó
                    </button>
                    <button wire:click="submitRating('good')"
                        class="inline-flex min-h-11 w-full items-center justify-center rounded-md bg-emerald-500 px-3 py-2 text-sm font-semibold text-white shadow hover:bg-emerald-600 focus:outline-none focus:ring-2 focus:ring-emerald-300">
                        3 · Tốt
                    </button>
                    <button wire:click="submitRating('easy')"
                        class="inline-flex min-h-11 w-full items-center justify-center rounded-md bg-blue-500 px-3 py-2 text-sm font-semibold text-white shadow hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-300">
                        4 · Dễ
=======
                {{-- Nút lật thẻ lớn --}}
                <button @click="flipped = !flipped"
                    class="mt-10 w-full py-5 rounded-2xl bg-slate-50 border border-slate-100 text-[12px] font-black text-slate-500 hover:bg-indigo-50 hover:text-indigo-600 hover:border-indigo-200 transition-all uppercase tracking-widest">
                    {{ $showBack ? 'ẨN ĐÁP ÁN' : 'XEM ĐÁP ÁN (SPACE)' }}
                </button>

                {{-- Đánh giá 1-4 --}}
                <div class="mt-6 grid grid-cols-2 sm:grid-cols-4 gap-4">
                    <button wire:click="submitRating('again')"
                        class="group flex flex-col items-center py-5 rounded-3xl bg-red-50 hover:bg-red-600 hover:text-white transition-all border border-red-100 shadow-lg shadow-red-500/5 cursor-pointer">
                        <svg class="w-7 h-7 mb-2 text-red-400 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                        </svg>
                        <span class="text-[10px] font-black uppercase tracking-widest">1 · LẠI</span>
                    </button>
                    <button wire:click="submitRating('hard')"
                        class="group flex flex-col items-center py-5 rounded-3xl bg-amber-50 hover:bg-amber-600 hover:text-white transition-all border border-amber-100 shadow-lg shadow-amber-500/5 cursor-pointer">
                        <svg class="w-7 h-7 mb-2 text-amber-400 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                        <span class="text-[10px] font-black uppercase tracking-widest">2 · KHÓ</span>
                    </button>
                    <button wire:click="submitRating('good')"
                        class="group flex flex-col items-center py-5 rounded-3xl bg-emerald-50 hover:bg-emerald-600 hover:text-white transition-all border border-emerald-100 shadow-lg shadow-emerald-500/5 cursor-pointer">
                        <svg class="w-7 h-7 mb-2 text-emerald-400 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"/>
                        </svg>
                        <span class="text-[10px] font-black uppercase tracking-widest">3 · TỐT</span>
                    </button>
                    <button wire:click="submitRating('easy')"
                        class="group flex flex-col items-center py-5 rounded-3xl bg-blue-50 hover:bg-blue-600 hover:text-white transition-all border border-blue-100 shadow-lg shadow-blue-500/5 cursor-pointer">
                        <svg class="w-7 h-7 mb-2 text-blue-400 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                        <span class="text-[10px] font-black uppercase tracking-widest">4 · DỄ</span>
>>>>>>> origin/main
                    </button>
                </div>
            </div>
        @endif
    </div>
</div>
