<div class="max-w-4xl mx-auto space-y-8 pb-12"
    x-data="{
        userInput: @entangle('userInput'),
        showAnswer: @entangle('showAnswer'),
        isCorrect: @entangle('isCorrect'),
        hasChecked: @entangle('hasChecked')
    }">

    {{-- ── Header Panel ── --}}
    <div class="bg-white rounded-3xl border border-slate-100 p-6 md:p-8 shadow-sm flex flex-col md:flex-row items-center justify-between gap-6">
        <div class="flex items-center gap-5">
            <div class="w-14 h-14 rounded-2xl bg-indigo-50 flex items-center justify-center text-indigo-600 shadow-inner">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
            </div>
            <div>
                <h2 class="text-[18px] font-black text-slate-900 uppercase leading-tight">NGỮ CẢNH: {{ $set->name }}</h2>
                <div class="flex items-center gap-2 mt-1">
                    <span class="text-[9px] font-black text-indigo-500 uppercase tracking-widest bg-indigo-50 px-3 py-0.5 rounded-full border border-indigo-100">SPELLING MODE</span>
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest hidden sm:inline">• NHẬP TỪ THEO NGỮ CẢNH</span>
                </div>
            </div>
        </div>
        <a href="{{ route('vocabulary.words', $set) }}"
            class="inline-flex items-center gap-2 px-6 py-3 text-[12px] font-black text-slate-500 bg-slate-50 rounded-xl hover:bg-slate-100 transition-all border border-slate-100 uppercase tracking-widest">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M7 16l-4-4m0 0l4-4m-4 4h18" />
            </svg>
            TRỞ LẠI BỘ TỪ
        </a>
    </div>

    @if ($total === 0)
    {{-- Empty State --}}
    <div class="bg-white border-2 border-dashed border-slate-200 rounded-3xl p-16 text-center">
        <p class="text-[14px] font-bold text-slate-400 uppercase mb-6">BỘ TỪ TRỐNG</p>
        <a href="{{ route('vocabulary.words', $set) }}" class="inline-flex items-center px-8 py-4 bg-indigo-600 text-white rounded-xl text-[12px] font-black uppercase tracking-widest hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-600/20">
            THÊM TỪ VỰNG NGAY
        </a>
    </div>

    @elseif ($completed)
    {{-- Completion State --}}
    <div class="space-y-8">
        <div class="bg-white rounded-3xl p-12 text-center border border-slate-100 shadow-sm">
            <div class="w-20 h-20 rounded-full bg-emerald-50 flex items-center justify-center mx-auto mb-8 shadow-inner">
                <svg class="w-10 h-10 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0" />
                </svg>
            </div>
            <h3 class="text-[28px] font-black text-slate-900 uppercase tracking-tight mb-2">XUẤT SẮC!</h3>
            <p class="text-[13px] font-bold text-slate-400 uppercase tracking-widest mb-10">BẠN ĐÃ HOÀN THÀNH PHIÊN HỌC QUA NGỮ CẢNH.</p>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 max-w-2xl mx-auto">
                @foreach(['again', 'hard', 'good', 'easy'] as $type)
                <div class="rounded-2xl bg-slate-50 border border-slate-100 p-6">
                    <p class="text-3xl font-black text-slate-900">{{ $ratingSummary[$type] }}</p>
                    <p class="text-[10px] uppercase font-black tracking-widest mt-1 text-slate-400">{{ strtoupper($type) }}</p>
                </div>
                @endforeach
            </div>

            <div class="mt-12 flex flex-wrap justify-center gap-4">
                <button wire:click="restartSession" class="px-10 py-4 bg-indigo-600 text-white text-[12px] font-black rounded-xl hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-600/20 uppercase tracking-widest">
                    HỌC LẠI PHIÊN NÀY
                </button>
                <a href="{{ route('dashboard') }}" class="px-10 py-4 bg-white text-slate-500 text-[12px] font-black rounded-xl hover:bg-slate-50 transition-all border border-slate-200 uppercase tracking-widest">
                    VỀ DASHBOARD
                </a>
            </div>
        </div>
    </div>

    @elseif ($currentProgress)
    {{-- Learning Session --}}
    <div class="space-y-8">
        {{-- Progress Bar --}}
        <div class="bg-white rounded-2xl border border-slate-100 p-5 shadow-sm max-w-md mx-auto">
            <div class="flex items-center justify-between font-black text-[10px] text-slate-400 uppercase tracking-widest mb-3">
                <span>TIẾN ĐỘ: {{ $currentIndex + 1 }} / {{ $total }}</span>
                <span class="text-indigo-600 bg-indigo-50 px-3 py-1 rounded-full border border-indigo-100 font-black text-[9px]">{{ strtoupper($currentProgress->status) }}</span>
            </div>
            <div class="h-2.5 w-full bg-slate-50 rounded-full overflow-hidden shadow-inner border border-slate-100">
                <div class="h-full bg-indigo-600 rounded-full transition-all duration-700"
                    style="width: {{ (($currentIndex + 1) / $total) * 100 }}%"></div>
            </div>
        </div>

        {{-- Main Question Card --}}
        <div class="bg-white rounded-[32px] border border-slate-100 shadow-sm p-10 md:p-16 text-center">

            <div class="space-y-12">
                {{-- Example Sentence --}}
                <div class="px-2">
                    <p class="text-[18px] font-black text-slate-400 uppercase tracking-widest mb-6 italic">ĐIỀN TỪ VÀO CHỖ TRỐNG</p>
                    <p class="text-[24px] md:text-[32px] font-black text-slate-900 leading-tight">
                        "{!! str_replace('________', '<span class=\"text-indigo-600 border-b-4 border-indigo-200\">________</span>', $maskedExample) !!}"
                    </p>

                    @if($showAnswer && $currentProgress->vocabulary->description_en)
                    <div class="mt-8 p-6 bg-indigo-50/50 rounded-2xl border border-indigo-100">
                        <p class="text-indigo-700 font-bold text-lg italic leading-relaxed">
                            "{{ $currentProgress->vocabulary->description_en }}"
                        </p>
                    </div>
                    @endif
                </div>

                {{-- Input & Hints --}}
                <div class="max-w-md mx-auto space-y-8">
                    <div class="relative">
                        {{-- Retry Badge --}}
                        @if(!$showAnswer && $retryCount > 0)
                        <div class="absolute -top-4 left-1/2 -translate-x-1/2 z-10 whitespace-nowrap">
                            <span class="px-3 py-1 rounded-full bg-amber-100 text-amber-700 text-[9px] font-black uppercase tracking-widest border border-amber-200">
                                LƯỢT THỬ: {{ $retryCount }}/3
                            </span>
                        </div>
                        @endif

                        <input type="text"
                            wire:model.defer="userInput"
                            wire:keydown.enter="checkSpelling"
                            class="w-full px-6 py-5 rounded-2xl bg-slate-50 border-2 {{ $hasChecked ? ($isCorrect ? 'border-emerald-500 bg-emerald-50' : 'border-rose-400 bg-rose-50') : 'border-slate-100 focus:border-indigo-600 focus:bg-white' }} text-center text-[22px] font-black uppercase tracking-widest transition-all outline-none"
                            placeholder="NHẬP TỪ CẦN ĐIỀN..."
                            {{ $hasChecked && $isCorrect ? 'disabled' : '' }}
                            x-init="$el.focus()"
                            autocomplete="off">

                        @if($hasChecked)
                        <div class="absolute -right-3 -top-3 w-10 h-10 rounded-full flex items-center justify-center shadow-lg {{ $isCorrect ? 'bg-emerald-500' : 'bg-rose-500' }} text-white">
                            @if($isCorrect)
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                            </svg>
                            @else
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            @endif
                        </div>
                        @endif
                    </div>

                    {{-- Hint Panel --}}
                    @if($hint && !$showAnswer)
                    <div class="px-6 py-4 bg-amber-50 rounded-2xl border border-amber-100 text-amber-900 font-bold text-[13px] shadow-inner text-left flex items-center gap-3">
                        <span class="text-lg">💡</span>
                        <span>{{ $hint }}</span>
                    </div>
                    @endif

                    <div class="flex items-center gap-3">
                        @if(!$showAnswer)
                        <button wire:click="checkSpelling" class="flex-1 py-4 bg-indigo-600 text-white text-[12px] font-black rounded-xl hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-600/20 uppercase tracking-widest">
                            KIỂM TRA (ENTER)
                        </button>
                        <button wire:click="revealAnswer" class="px-6 py-4 bg-white text-slate-400 text-[11px] font-black rounded-xl hover:bg-slate-50 transition-all border border-slate-200 uppercase tracking-widest">
                            GỢI Ý ĐÁP ÁN
                        </button>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Revealed Answer Section --}}
            @if($showAnswer)
            <div class="mt-16 pt-12 border-t border-slate-100 flex flex-col items-center">
                <div class="text-center mb-10">
                    <span class="text-[11px] font-black text-indigo-500 uppercase tracking-[0.3em] mb-3 block">ĐÁP ÁN ĐÚNG LÀ</span>
                    <h4 class="text-5xl font-black text-slate-900 tracking-tighter uppercase mb-4">{{ $currentProgress->vocabulary->word }}</h4>
                    <div class="flex items-center justify-center gap-4 text-slate-400">
                        <p class="text-lg font-bold">/{{ $currentProgress->vocabulary->pronunciation }}/</p>
                        <div class="w-1.5 h-1.5 bg-slate-200 rounded-full"></div>
                        <p class="text-xl font-bold text-slate-700">{{ $currentProgress->vocabulary->meaning }}</p>
                    </div>
                </div>

                <div class="w-full max-w-3xl grid grid-cols-2 sm:grid-cols-4 gap-3">
                    @foreach(['again', 'hard', 'good', 'easy'] as $rating)
                    @php
                    $styleMap = [
                    'again' => 'border-rose-100 hover:bg-rose-600 text-rose-500',
                    'hard' => 'border-amber-100 hover:bg-amber-600 text-amber-500',
                    'good' => 'border-emerald-100 hover:bg-emerald-600 text-emerald-500',
                    'easy' => 'border-blue-100 hover:bg-blue-600 text-blue-500'
                    ];
                    @endphp
                    <button wire:click="submitRating('{{ $rating }}')"
                        class="flex flex-col items-center py-5 bg-white border-2 rounded-2xl transition-all shadow-sm group {{ $styleMap[$rating] }} hover:text-white hover:border-transparent">
                        <span class="text-xl mb-1">
                            @if($rating == 'again') 🔄 @elseif($rating == 'hard') ⏳ @elseif($rating == 'good') ✅ @else ⚡ @endif
                        </span>
                        <span class="text-[10px] font-black uppercase tracking-widest">{{ $rating }}</span>
                    </button>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>
    @endif
</div>