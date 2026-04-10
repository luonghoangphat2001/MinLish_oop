<div class="max-w-4xl mx-auto space-y-8 pb-12">
    {{-- Header Section --}}
    <div class="bg-white rounded-3xl p-6 md:p-8 border border-slate-100 shadow-sm flex flex-col md:flex-row md:items-center md:justify-between gap-6">
        <div class="flex items-center gap-5">
            <div class="w-14 h-14 rounded-2xl bg-indigo-50 flex items-center justify-center text-indigo-600 shadow-inner">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
            </div>
            <div>
                <h2 class="text-lg font-bold text-slate-900 uppercase">DAILY QUIZ</h2>
                <p class="text-[12px] font-semibold text-slate-400 uppercase tracking-widest">Nhiệm vụ rèn luyện hàng ngày</p>
            </div>
        </div>

        <a href="{{ route('dashboard') }}"
            class="inline-flex items-center gap-2 px-6 py-3 rounded-xl text-xs font-bold text-slate-500 bg-slate-50 hover:bg-slate-100 transition-all uppercase tracking-widest border border-slate-100">
            VỀ DASHBOARD
        </a>
    </div>

    {{-- Progress Section --}}
    <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm">
        <div class="flex items-center justify-between mb-3">
            <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">TIẾN ĐỘ: {{ min($currentIndex + 1, $total) }} / {{ $total }}</span>
            <span class="text-sm font-bold text-indigo-600">{{ $progressPercent }}%</span>
        </div>
        <div class="w-full h-3 bg-slate-50 rounded-full overflow-hidden border border-slate-100 shadow-inner">
            <div class="h-full bg-indigo-600 transition-all duration-500" style="width: {{ $progressPercent }}%"></div>
        </div>
    </div>

    @if ($total === 0)
    <div class="bg-white border-2 border-dashed border-slate-200 rounded-3xl p-16 text-center">
        <p class="text-sm font-bold text-slate-400 uppercase mb-6">CHƯA CÓ TỪ VỰNG ĐỂ LUYỆN TẬP</p>
        <a href="{{ route('vocabulary.sets') }}" class="inline-flex items-center px-8 py-4 bg-indigo-600 text-white rounded-xl text-xs font-bold uppercase tracking-widest hover:bg-indigo-700 transition-all">
            ĐẾN KHO TỪ VỰNG
        </a>
    </div>
    @elseif ($completed)
    {{-- Results --}}
    <div class="space-y-8">
        <div class="bg-white rounded-3xl p-10 text-center border border-slate-100 shadow-sm">
            <h3 class="text-xl font-bold text-slate-900 uppercase mb-8">HOÀN THÀNH NHIỆM VỤ</h3>

            <div class="grid grid-cols-2 gap-4 max-w-sm mx-auto">
                <div class="p-6 rounded-2xl bg-emerald-50 border border-emerald-100">
                    <p class="text-xs font-bold text-emerald-600 uppercase mb-1">ĐÚNG</p>
                    <p class="text-3xl font-bold text-emerald-700">{{ $correctCount }}</p>
                </div>
                <div class="p-6 rounded-2xl bg-rose-50 border border-rose-100">
                    <p class="text-xs font-bold text-rose-600 uppercase mb-1">SAI</p>
                    <p class="text-3xl font-bold text-rose-700">{{ $wrongCount }}</p>
                </div>
            </div>

            <div class="mt-10 flex flex-wrap justify-center gap-4">
                <button wire:click="restart" class="px-8 py-4 bg-indigo-600 text-white rounded-xl text-xs font-bold uppercase tracking-widest hover:bg-indigo-700 transition-all">
                    LÀM LẠI QUIZ
                </button>
                <a href="{{ route('vocabulary.sets') }}" class="px-8 py-4 bg-white border border-slate-200 text-slate-600 rounded-xl text-xs font-bold uppercase tracking-widest hover:bg-slate-50 transition-all">
                    QUẢN LÝ BỘ TỪ
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($results as $item)
            <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm">
                <div class="flex justify-between items-start mb-4">
                    <span class="text-base font-bold text-slate-900 uppercase">{{ $item['word'] }}</span>
                    <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase {{ $item['is_correct'] ? 'bg-emerald-50 text-emerald-600 border border-emerald-100' : 'bg-rose-50 text-rose-600 border border-rose-100' }}">
                        {{ $item['is_correct'] ? 'ĐÚNG' : 'SAI' }}
                    </span>
                </div>
                <p class="text-sm text-slate-500 font-semibold mb-4">{{ $item['meaning'] }}</p>
                <div class="bg-slate-50 p-3 rounded-xl">
                    <span class="text-[10px] font-bold text-slate-400 uppercase block mb-1">BẠN ĐÃ NHẬP</span>
                    <p class="text-xs font-semibold text-slate-700 italic">"{{ $item['answer'] ?: '___' }}"</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @else
    {{-- Quiz Card --}}
    <div class="bg-white rounded-[32px] p-10 md:p-16 border border-slate-100 shadow-sm text-center">
        @php $word = $currentWord; @endphp
        @if ($word)
        <div class="mb-8">
            <span class="text-xs font-bold bg-indigo-50 text-indigo-600 px-4 py-1.5 rounded-full border border-indigo-100 uppercase tracking-widest">
                BỘ TỪ: {{ $word->set?->name }}
            </span>
        </div>

        <p class="text-xs font-bold text-slate-300 uppercase tracking-[0.3em] mb-4">YÊU CẦU DỊCH NGHĨA</p>
        <h1 class="text-3xl md:text-5xl font-bold text-slate-900 uppercase mb-4 tracking-tight">{{ $word->word }}</h1>
        @if ($word->pronunciation)
        <p class="text-lg font-semibold text-indigo-400 mb-10">{{ $word->pronunciation }}</p>
        @else
        <div class="h-10"></div>
        @endif

        <form wire:submit.prevent="submitAnswer" class="max-w-md mx-auto">
            <div class="relative mb-8">
                <input
                    id="answer"
                    wire:model.defer="answer"
                    type="text"
                    placeholder="Nhập nghĩa của từ..."
                    autofocus
                    class="w-full bg-slate-50 border-2 border-slate-100 rounded-2xl px-6 py-5 text-xl font-bold text-center text-slate-900 placeholder:text-slate-300 focus:bg-white focus:border-indigo-600 focus:ring-0 transition-all outline-none uppercase"
                    autocomplete="off">
                @error('answer') <p class="text-rose-500 text-xs font-semibold uppercase mt-2">{{ $message }}</p> @enderror
            </div>

            <button type="submit" class="w-full py-5 bg-indigo-600 text-white rounded-xl text-sm font-bold uppercase tracking-widest hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-600/20 active:scale-95">
                XÁC NHẬN
            </button>

            @if ($lastCorrect !== null)
            <div class="mt-8 flex justify-center">
                @if ($lastCorrect)
                <div class="px-6 py-3 bg-emerald-50 text-emerald-600 rounded-xl text-xs font-bold uppercase tracking-widest border border-emerald-100">
                    ✓ CHÍNH XÁC
                </div>
                @else
                <div class="px-6 py-3 bg-rose-50 text-rose-600 rounded-xl text-xs font-bold uppercase tracking-widest border border-rose-100">
                    ✗ CÂU TRƯỚC CHƯA ĐÚNG
                </div>
                @endif
            </div>
            @endif
        </form>
        @endif
    </div>
    @endif
</div>