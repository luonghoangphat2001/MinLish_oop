<div class="space-y-8 min-h-[80vh] flex flex-col"
    x-data="{
        userInput: @entangle('userInput'),
        showAnswer: @entangle('showAnswer'),
        isCorrect: @entangle('isCorrect'),
        hasChecked: @entangle('hasChecked'),
        init() {
            this.animateEntrance();

            Livewire.on('spelling-wrong', () => {
                this.shakeInput();
            });
        },
        animateEntrance() {
            gsap.from('.context-card', {
                y: 50,
                opacity: 0,
                duration: 1,
                ease: 'power4.out',
                stagger: 0.2
            });
            gsap.from('.hint-badge', {
                scale: 0.8,
                opacity: 0,
                duration: 0.8,
                delay: 0.5,
                stagger: 0.1,
                ease: 'back.out(1.7)'
            });
        },
        shakeInput() {
            gsap.to('.input-verify', {
                x: 10,
                duration: 0.1,
                repeat: 5,
                yoyo: true,
                onComplete: () => gsap.set('.input-verify', { x: 0 })
            });
        }
    }">
    {{-- ── Header Panel ── --}}
    <div class="flex flex-col md:flex-row items-center justify-between gap-6 bg-white/40 backdrop-blur-xl rounded-[40px] border border-white shadow-xl p-8 transition-all hover:bg-white/60">
        <div class="flex items-center gap-6">
            <div class="w-16 h-16 rounded-2xl bg-indigo-600 flex items-center justify-center text-white shadow-lg shadow-indigo-200">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
            </div>
            <div>
                <h2 class="text-xl font-black text-slate-900 tracking-tight uppercase leading-tight">CONTEXT LEARNING: {{ $set->name }}</h2>
                <div class="flex items-center gap-3 mt-1">
                    <span class="text-[10px] font-black text-indigo-500 uppercase tracking-widest bg-white/80 px-3 py-1 rounded-full border border-indigo-100 shadow-sm">SPELLING MODE</span>
                    <p class="text-[11px] font-black text-slate-400 uppercase tracking-widest">TYPE TO VERIFY | ENTER TO CHECK</p>
                </div>
            </div>
        </div>
        <a href="{{ route('vocabulary.words', $set) }}"
            class="inline-flex items-center gap-2 px-8 py-4 text-[12px] font-black text-slate-500 bg-white/80 rounded-2xl hover:bg-indigo-600 hover:text-white transition-all shadow-sm border border-slate-100 uppercase tracking-widest">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M7 16l-4-4m0 0l4-4m-4 4h18" />
            </svg>
            BACK TO SET
        </a>
    </div>

    {{-- ── Main Area ── --}}
    <div class="flex-1 flex flex-col items-center justify-center py-12 relative">
        {{-- Floating Decorations --}}
        <div class="absolute -top-10 -left-10 w-64 h-64 bg-indigo-400/10 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute -bottom-10 -right-10 w-64 h-64 bg-purple-400/10 rounded-full blur-3xl animate-pulse" style="animation-delay: 1s"></div>

        @if ($total === 0)
        {{-- Empty State --}}
        <div class="context-card bg-white rounded-[40px] border border-slate-100 p-16 text-center shadow-2xl max-w-xl w-full">
            <div class="w-24 h-24 rounded-3xl bg-slate-50 flex items-center justify-center mx-auto mb-8 shadow-inner">
                <svg class="w-12 h-12 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
            </div>
            <p class="text-2xl font-black text-slate-900 uppercase tracking-tight">SET IS EMPTY</p>
            <p class="text-sm font-black text-slate-400 uppercase tracking-widest mt-2">ADD WORDS TO START LEARNING.</p>
            <a href="{{ route('vocabulary.words', $set) }}" class="inline-flex mt-8 px-10 py-4 bg-indigo-600 text-white text-[12px] font-black rounded-2xl hover:bg-indigo-700 transition-all shadow-xl shadow-indigo-600/20 uppercase tracking-widest">
                ADD WORDS NOW
            </a>
        </div>

        @elseif ($completed)
        {{-- Completion State --}}
        <div class="context-card bg-white/60 backdrop-blur-2xl rounded-[50px] border border-white/50 p-16 text-center shadow-2xl max-w-2xl w-full">
            <div class="w-24 h-24 rounded-full bg-emerald-50 flex items-center justify-center mx-auto mb-8 shadow-xl">
                <svg class="w-12 h-12 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0" />
                </svg>
            </div>
            <h3 class="text-3xl font-black text-slate-900 uppercase tracking-tighter">EXCELLENT WORK!</h3>
            <p class="mt-4 text-[13px] font-black text-slate-500 uppercase tracking-widest leading-relaxed">YOU HAVE COMPLETED THE CONTEXT-BASED LEARNING SESSION.</p>

            <div class="mt-12 grid grid-cols-2 sm:grid-cols-4 gap-4">
                @foreach(['again', 'hard', 'good', 'easy'] as $type)
                <div class="rounded-3xl bg-white/50 border border-white p-6 shadow-sm">
                    <p class="text-3xl font-black text-slate-900">{{ $ratingSummary[$type] }}</p>
                    <p class="text-[10px] uppercase font-black tracking-widest mt-1 text-slate-400">{{ strtoupper($type) }}</p>
                </div>
                @endforeach
            </div>

            <div class="mt-12 flex flex-col sm:flex-row justify-center gap-4">
                <button wire:click="restartSession" class="px-10 py-5 bg-indigo-600 text-white text-[12px] font-black rounded-2xl hover:bg-indigo-700 transition-all shadow-xl shadow-indigo-600/20 uppercase tracking-widest">
                    LEARN AGAIN
                </button>
                <a href="{{ route('dashboard') }}" class="px-10 py-5 bg-white text-slate-500 text-[12px] font-black rounded-2xl hover:bg-slate-50 transition-all shadow-sm border border-slate-100 uppercase tracking-widest">
                    DASHBOARD
                </a>
            </div>
        </div>

        @elseif ($currentProgress)
        {{-- Learning Session --}}
        <div class="w-full max-w-4xl space-y-8">
            {{-- Progress Bar --}}
            <div class="bg-white/40 backdrop-blur-lg rounded-3xl border border-white p-6 shadow-xl w-full max-w-md mx-auto">
                <div class="flex items-center justify-between font-black text-[10px] text-slate-400 uppercase tracking-widest mb-3">
                    <span>PROGRESS: {{ $currentIndex + 1 }} / {{ $total }}</span>
                    <span class="text-indigo-600 bg-white px-3 py-1 rounded-full border border-indigo-50">{{ $currentProgress->status }}</span>
                </div>
                <div class="h-2 w-full bg-white/50 rounded-full overflow-hidden shadow-inner">
                    <div class="h-full bg-indigo-600 rounded-full transition-all duration-1000 ease-out shadow-lg"
                        style="width: {{ (($currentIndex + 1) / $total) * 100 }}%"></div>
                </div>
            </div>

            {{-- Context Master Card --}}
            <div class="context-card group relative [perspective:2000px]">
                <div class="relative bg-white/70 backdrop-blur-3xl rounded-[60px] border border-white shadow-[0_32px_128px_-32px_rgba(0,0,0,0.1)] p-12 sm:p-20 overflow-hidden transition-all duration-700 hover:shadow-[0_48px_160px_-40px_rgba(0,0,0,0.15)]">

                    {{-- 3D Floating Effect Utility (Removed Related Words) --}}
                    <div class="absolute top-10 right-10 flex gap-2">
                    </div>

                    {{-- The Challenge --}}
                    <div class="space-y-12 text-center relative z-10">
                        {{-- Collocations Removed --}}

                        {{-- Example Sentence with Mask --}}
                        <div class="relative px-4 sm:px-12">
                            <p class="text-2xl sm:text-4xl font-extrabold text-slate-900 leading-tight tracking-tight">
                                "{!! str_replace('________', '<span class=\"text-indigo-600 underline decoration-indigo-200 decoration-8 underline-offset-8\">________</span>', $maskedExample) !!}"
                            </p>
                            @if($showAnswer && $currentProgress->vocabulary->description_en)
                            <p class="mt-6 text-indigo-400 font-medium text-lg leading-relaxed max-w-2xl mx-auto italic">
                                {{ $currentProgress->vocabulary->description_en }}
                            </p>
                            @endif
                        </div>

                        {{-- Input Area --}}
                        <div class="max-w-md mx-auto space-y-8 mt-6">
                            <div class="relative group/input">
                                {{-- Retry Badge --}}
                                @if(!$showAnswer && $retryCount > 0)
                                <div class="absolute -top-3 left-6 z-20">
                                    <span class="px-3 py-1 rounded-full bg-indigo-600 text-white text-[9px] font-black uppercase tracking-[0.2em] shadow-xl shadow-indigo-600/30">
                                        LƯỢT THỬ: {{ $retryCount }}/3
                                    </span>
                                </div>
                                @endif

                                <input type="text"
                                    wire:model.defer="userInput"
                                    wire:keydown.enter="checkSpelling"
                                    class="input-verify w-full px-8 py-6 rounded-3xl bg-white border-2 {{ $hasChecked ? ($isCorrect ? 'border-emerald-500 shadow-emerald-100' : 'border-red-400 shadow-red-100') : ($retryCount > 0 ? 'border-amber-400 shadow-amber-100' : 'border-slate-100 focus:border-indigo-600 shadow-indigo-100/10') }} text-center text-2xl font-black uppercase tracking-widest transition-all duration-300 outline-none"
                                    placeholder="NHẬP TỪ TẠI ĐÂY..."
                                    {{ $hasChecked && $isCorrect ? 'disabled' : '' }}
                                    x-ref="inputField"
                                    x-init="$el.focus()">

                                @if($hasChecked || $retryCount > 0)
                                <div class="absolute -right-4 -top-4 w-12 h-12 rounded-full flex items-center justify-center shadow-xl {{ $isCorrect ? 'bg-emerald-500 text-white' : 'bg-red-500 text-white animate-bounce' }}">
                                    @if($isCorrect)
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                                    </svg>
                                    @else
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                    @endif
                                </div>
                                @endif
                            </div>

                            {{-- Hint Panel --}}
                            @if($hint && !$showAnswer)
                            <div class="hint-panel px-8 py-5 bg-amber-50 rounded-3xl border border-amber-100 text-amber-900 font-bold text-sm shadow-inner animate-in fade-in slide-in-from-top-4 duration-500">
                                <div class="flex items-center gap-3">
                                    <span class="text-xl">💡</span>
                                    <span>{{ $hint }}</span>
                                </div>
                            </div>
                            @endif

                            <div class="flex items-center justify-center gap-4">
                                @if(!$showAnswer)
                                <button wire:click="checkSpelling" class="px-10 py-5 bg-indigo-600 text-white text-[12px] font-black rounded-2xl hover:bg-indigo-700 transition-all shadow-xl shadow-indigo-600/20 uppercase tracking-widest">
                                    KIỂM TRA (ENTER)
                                </button>
                                <button wire:click="revealAnswer" class="px-8 py-5 bg-white text-slate-400 text-[12px] font-black rounded-2xl hover:bg-slate-50 transition-all border border-slate-100 uppercase tracking-widest">
                                    XEM ĐÁP ÁN?
                                </button>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Answer Panel (Revealed after check or give up) --}}
                    @if($showAnswer)
                    <div class="mt-16 pt-16 border-t border-slate-100 space-y-8 animate-in fade-in slide-in-from-bottom-10 duration-1000">
                        <div class="text-center">
                            <h4 class="text-6xl font-black text-indigo-600 tracking-tighter uppercase">{{ $currentProgress->vocabulary->word }}</h4>
                            <div class="flex items-center justify-center gap-4 mt-4">
                                <p class="text-xl font-black text-slate-400">/{{ $currentProgress->vocabulary->pronunciation }}/</p>
                                <p class="text-2xl font-black text-slate-900 border-l-2 border-slate-200 pl-4">{{ $currentProgress->vocabulary->meaning }}</p>
                            </div>
                        </div>

                        {{-- SRS Ratings --}}
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 max-w-3xl mx-auto">
                            @foreach(['again' => 'RED', 'hard' => 'AMBER', 'good' => 'EMERALD', 'easy' => 'BLUE'] as $rating => $color)
                            @php
                            $colorMap = [
                            'RED' => 'bg-red-50 hover:bg-red-600 border-red-100 text-red-400',
                            'AMBER' => 'bg-amber-50 hover:bg-amber-600 border-amber-100 text-amber-400',
                            'EMERALD' => 'bg-emerald-50 hover:bg-emerald-600 border-emerald-100 text-emerald-400',
                            'BLUE' => 'bg-blue-50 hover:bg-blue-600 border-blue-100 text-blue-400'
                            ];
                            @endphp
                            <button wire:click="submitRating('{{ $rating }}')"
                                class="group flex flex-col items-center py-6 rounded-[32px] transition-all border shadow-lg shadow-black/5 {{ $colorMap[$color] }} hover:text-white">
                                <span class="text-2xl mb-1 group-hover:scale-125 transition-transform">
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
        </div>
        @endif
    </div>

    {{-- GSAP Load --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
</div>