<div class="space-y-8">
    {{-- Tin nhắn thông báo --}}
    @if (session()->has('message'))
        <div class="flex items-center gap-4 rounded-3xl bg-emerald-50 border border-emerald-100 px-6 py-5 shadow-sm">
            <div class="w-10 h-10 rounded-2xl bg-emerald-500 flex items-center justify-center text-white shadow-lg shadow-emerald-200">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
            <p class="text-[14px] font-bold text-emerald-900 leading-tight uppercase tracking-tight">{{ session('message') }}</p>
        </div>
    @endif

    {{-- Tiêu đề & Toolbar --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
        <div>
            <h3 class="text-[18px] font-black text-slate-900 tracking-tight uppercase">QUẢN LÝ BỘ TỪ VỰNG</h3>
            <p class="text-slate-400 font-black mt-1 uppercase text-[10px] tracking-widest">KHO TỪ VỰNG CỦA BẠN</p>
        </div>
        <div class="flex flex-wrap items-center gap-3">
            <button wire:click="createStarterSets"
                class="inline-flex items-center gap-2 px-6 py-3.5 rounded-2xl text-[12px] font-black text-emerald-700 bg-emerald-50 border border-emerald-100 hover:bg-emerald-100 transition-all duration-300 uppercase tracking-widest">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                Tạo bộ mẫu
            </button>
            <button wire:click="$dispatch('open-form')"
                class="inline-flex items-center gap-2 px-8 py-3.5 rounded-2xl text-[12px] font-black text-white bg-indigo-600 hover:bg-indigo-700 transition-all duration-300 shadow-xl shadow-indigo-600/20 active:scale-95 uppercase tracking-widest">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                TẠO BỘ TỪ MỚI
            </button>
        </div>
    </div>

    {{-- Tìm kiếm --}}
    <div class="bg-white rounded-[24px] border border-slate-100 p-6 shadow-sm">
        <div class="relative w-full">
            <svg class="absolute left-6 top-1/2 -translate-y-1/2 w-5 h-5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0"/>
            </svg>
            <input type="text" wire:model.live.debounce.300ms="search"
                placeholder="TÌM KIẾM BỘ TỪ..."
                class="w-full pl-16 pr-6 py-4 text-[14px] font-black border border-slate-50 rounded-2xl focus:border-indigo-400 focus:ring-4 focus:ring-indigo-500/5 bg-slate-50/50 transition-all uppercase tracking-tight">
        </div>
    </div>

    {{-- Lưới thẻ bộ từ --}}
    <div class="grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-3">
        @forelse ($sets as $set)
            <div class="group flex flex-col bg-white rounded-[32px] border border-slate-50 p-8 shadow-sm hover:shadow-2xl hover:shadow-indigo-500/10 hover:-translate-y-2 transition-all duration-500">
                
                <div class="flex items-start justify-between mb-8">
                    <div class="w-16 h-16 rounded-2xl bg-indigo-50 flex items-center justify-center text-indigo-600 shadow-inner group-hover:scale-110 transition-transform duration-500">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                    </div>
                </div>

                <div class="mb-4">
                    <h4 class="text-[18px] font-black text-slate-900 leading-tight group-hover:text-indigo-600 transition-colors uppercase tracking-tight">{{ $set->name }}</h4>
                    <p class="text-[12px] font-bold text-slate-400 mt-2 line-clamp-2 leading-relaxed">"{{ $set->description ?? 'Chưa cập nhật mô tả.' }}"</p>
                </div>

                <div class="flex items-center gap-4 mb-6 mt-auto">
                    <div class="flex items-center gap-2 text-indigo-600 font-black text-[11px] uppercase tracking-widest">
                        {{ $set->vocabularies_count }} TỪ VỰNG
                    </div>
                    <div class="h-1.5 flex-1 bg-slate-100 rounded-full overflow-hidden shadow-inner">
                        <div class="h-full bg-indigo-600 rounded-full w-0 transition-all duration-700 shadow-lg shadow-indigo-400/20"></div>
                    </div>
                </div>

                {{-- Thao tác --}}
                <div class="flex flex-col gap-2 pt-6 border-t border-slate-50">
                    <div class="flex gap-2">
                        <a href="{{ route('learning.flashcards', $set) }}" class="flex-1 py-4 bg-indigo-600 text-white rounded-2xl font-black text-[11px] text-center uppercase tracking-widest hover:bg-indigo-700 transition-all shadow-xl shadow-indigo-600/20 active:scale-95">
                            BẮT ĐẦU HỌC
                        </a>
                        <button wire:click="$dispatch('open-form', { id: {{ $set->id }} })" class="p-4 bg-indigo-50 text-indigo-600 rounded-2xl hover:bg-indigo-100 transition-colors active:scale-95 border border-indigo-100">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        </button>
                    </div>
                    <a href="{{ route('vocabulary.words', $set) }}" class="w-full py-3.5 bg-slate-50 text-slate-500 rounded-2xl font-black text-[11px] text-center uppercase tracking-widest hover:bg-slate-100 transition-colors border border-slate-100">
                        Quản lý từ
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-full py-24 text-center opacity-50">
                <p class="text-[18px] font-black text-slate-900 uppercase tracking-tight">KHO TRỐNG</p>
            </div>
        @endforelse
    </div>

    {{-- Phân trang --}}
    @if($sets->hasPages())
        <div class="mt-8">
            {{ $sets->links() }}
        </div>
    @endif

    <livewire:vocabulary.vocabulary-set-form />
</div>
