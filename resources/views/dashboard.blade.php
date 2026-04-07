<x-app-layout>
    <x-slot name="header">
        <h2 class="text-[18px] font-black text-slate-900 leading-tight uppercase tracking-tight">TRANG TỔNG QUAN</h2>
    </x-slot>

    @php
        $user = auth()->user();
        $goal = $user->dailyGoal;
        $sets = $user->vocabularySets()->withCount('vocabularies')->latest()->get();
    @endphp

    <div class="space-y-8">
        {{-- THỐNG KÊ NHANH --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white rounded-[24px] border border-slate-100 p-8 shadow-sm hover:shadow-xl transition-all duration-300">
                <div class="flex items-center gap-4 mb-6">
                    <div class="w-12 h-12 rounded-2xl bg-indigo-50 flex items-center justify-center text-indigo-600 shadow-inner">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0"/></svg>
                    </div>
                    <h3 class="text-[16px] font-black text-slate-800 uppercase tracking-tight">MỤC TIÊU HÀNG NGÀY</h3>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div class="bg-slate-50 rounded-2xl p-5 text-center">
                        <p class="text-3xl font-black text-slate-900">{{ $goal?->new_words_per_day ?? 10 }}</p>
                        <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mt-1">TỪ MỚI</p>
                    </div>
                    <div class="bg-slate-50 rounded-2xl p-5 text-center">
                        <p class="text-3xl font-black text-slate-900">{{ $goal?->review_words_per_day ?? 20 }}</p>
                        <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mt-1">ÔN TẬP</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-[24px] border border-slate-100 p-8 shadow-sm hover:shadow-xl transition-all duration-300">
                <div class="flex items-center gap-4 mb-6">
                    <div class="w-12 h-12 rounded-2xl bg-emerald-50 flex items-center justify-center text-emerald-600 shadow-inner">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                    </div>
                    <h3 class="text-[16px] font-black text-slate-800 uppercase tracking-tight">KHO BỘ TỪ</h3>
                </div>
                <div class="bg-slate-50 rounded-2xl p-7 text-center">
                    <p class="text-4xl font-black text-slate-900">{{ $sets->count() }}</p>
                    <p class="text-[9px] font-black text-slate-500 mt-1 uppercase tracking-widest">BỘ TỪ ĐANG LƯU</p>
                </div>
            </div>

            <div class="bg-white rounded-[24px] border border-slate-100 p-8 shadow-sm hover:shadow-xl transition-all duration-300">
                <div class="flex items-center gap-4 mb-6">
                    <div class="w-12 h-12 rounded-2xl bg-amber-50 flex items-center justify-center text-amber-600 shadow-inner">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    </div>
                    <h3 class="text-[16px] font-black text-slate-800 uppercase tracking-tight">TIẾN ĐỘ HỌC</h3>
                </div>
                <div class="bg-slate-50 rounded-2xl p-7 text-center">
                    <p class="text-4xl font-black text-slate-900">{{ $user->total_learned_words ?? 0 }}</p>
                    <p class="text-[9px] font-black text-slate-500 mt-1 uppercase tracking-widest">TỪ THÀNH THẠO</p>
                </div>
            </div>
        </div>

        {{-- KHU VỰC CHỦ CHỐT: QUẢN LÝ BỘ TỪ VỰNG --}}
        <div class="bg-white rounded-[32px] border-2 border-indigo-600/20 p-8 shadow-sm overflow-hidden relative">
            <div class="absolute top-0 right-0 p-8 opacity-5">
                <svg class="w-48 h-48" fill="currentColor" viewBox="0 0 24 24"><path d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
            </div>
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-8">
                    <div class="flex items-center gap-4">
                        <div class="w-2 h-10 bg-indigo-600 rounded-full"></div>
                        <h3 class="text-[20px] font-black text-slate-900 uppercase tracking-tight">BỘ TỪ GẦN ĐÂY</h3>
                    </div>
                    <a href="{{ route('vocabulary.sets') }}" class="inline-flex items-center gap-2 text-[11px] font-black text-indigo-600 hover:text-indigo-800 transition-colors uppercase tracking-widest underline underline-offset-8 decoration-2">
                        VÀO KHO TỪ VỰNG
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    @forelse ($sets->take(4) as $set)
                        <div class="group bg-slate-50/50 border border-slate-100 rounded-[24px] p-6 hover:bg-white hover:border-indigo-400 hover:shadow-2xl transition-all duration-300">
                            <div class="flex items-start justify-between mb-6">
                                <div class="flex items-center gap-6">
                                    <div class="w-16 h-16 rounded-2xl bg-white flex items-center justify-center text-indigo-600 shadow-sm border border-slate-100 group-hover:scale-110 transition-transform">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                                    </div>
                                    <div>
                                        <h4 class="text-[18px] font-black text-slate-900 uppercase tracking-tight">{{ $set->name }}</h4>
                                        <p class="text-[11px] font-bold text-slate-400 mt-1 uppercase tracking-widest">{{ $set->vocabularies_count }} TỪ VỰNG</p>
                                    </div>
                                </div>
                            </div>
                            <div class="relative w-full h-3 bg-slate-200 rounded-full overflow-hidden mb-6 shadow-inner">
                                <div class="absolute inset-y-0 left-0 bg-indigo-600 rounded-full shadow-lg" style="width: 0%"></div>
                            </div>
                            <a href="{{ route('learning.flashcards', $set) }}" class="w-full inline-flex justify-center py-4 bg-indigo-600 text-white rounded-xl font-black text-[11px] uppercase tracking-widest hover:bg-indigo-700 transition-all shadow-xl shadow-indigo-600/20 active:scale-95">
                                BẮT ĐẦU HỌC
                            </a>
                        </div>
                    @empty
                        <div class="col-span-full py-12 text-center opacity-30">
                            <p class="text-[14px] font-black uppercase tracking-widest">CHƯA CÓ BỘ TỪ NÀO</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- BẢNG PHÂN TÍCH --}}
        <div class="bg-white rounded-[32px] border border-slate-50 p-10 shadow-sm">
            <h3 class="text-[18px] font-black text-slate-900 uppercase tracking-tight mb-8">PHÂN TÍCH TIẾN ĐỘ</h3>
            <livewire:dashboard.activity-chart />
        </div>
    </div>
</x-app-layout>
