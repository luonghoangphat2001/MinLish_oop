<div class="max-w-xl mx-auto py-6 px-4 sm:px-0">

    <h2 class="text-[18px] font-black text-slate-900 uppercase tracking-tight mb-6">HỒ SƠ CỦA TÔI</h2>

    @if (session()->has('message'))
        <div class="mb-5 flex items-center gap-3 rounded-[20px] bg-emerald-50 border border-emerald-100 px-5 py-4 shadow-sm">
            <div class="w-8 h-8 rounded-xl bg-emerald-500 flex items-center justify-center text-white shadow-lg shadow-emerald-200 flex-shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
            <p class="text-[13px] font-black text-emerald-900 uppercase tracking-tight">{{ session('message') }}</p>
        </div>
    @endif

    <form wire:submit.prevent="save" class="bg-white rounded-[24px] border border-slate-100 shadow-sm divide-y divide-slate-50">

        {{-- Basic info --}}
        <div class="px-6 py-6 space-y-4">
            <h3 class="text-[10px] font-black uppercase tracking-widest text-slate-400">THÔNG TIN CƠ BẢN</h3>

            <div>
                <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-2">HỌ VÀ TÊN</label>
                <input wire:model.defer="name" type="text" placeholder="Nguyen Van A"
                    class="w-full px-5 py-3 text-[14px] font-black border border-slate-50 rounded-xl bg-slate-50/50 focus:border-indigo-400 focus:ring-4 focus:ring-indigo-500/5 outline-none transition-all">
                @error('name') <p class="mt-1.5 text-[11px] font-black text-red-500 uppercase tracking-tight">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-2">TRÌNH ĐỘ HIỆN TẠI</label>
                <select wire:model.defer="level"
                    class="w-full px-5 py-3 text-[14px] font-black border border-slate-50 rounded-xl bg-slate-50/50 focus:border-indigo-400 focus:ring-4 focus:ring-indigo-500/5 outline-none transition-all">
                    @foreach (['A1', 'A2', 'B1', 'B2', 'C1', 'C2'] as $lvl)
                        <option value="{{ $lvl }}">{{ $lvl }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-2">MỤC TIÊU HỌC</label>
                <input wire:model.defer="goal" type="text" placeholder="IELTS, Giao tiếp, Business..."
                    class="w-full px-5 py-3 text-[14px] font-black border border-slate-50 rounded-xl bg-slate-50/50 focus:border-indigo-400 focus:ring-4 focus:ring-indigo-500/5 outline-none transition-all">
            </div>
        </div>

        {{-- Daily goal --}}
        <div class="px-6 py-6 space-y-4">
            <h3 class="text-[10px] font-black uppercase tracking-widest text-slate-400">MỤC TIÊU HÀNG NGÀY</h3>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-2">TỪ MỚI / NGÀY</label>
                    <input wire:model.defer="new_words" type="number" min="1" max="100"
                        class="w-full px-5 py-3 text-[14px] font-black border border-slate-50 rounded-xl bg-slate-50/50 focus:border-indigo-400 focus:ring-4 focus:ring-indigo-500/5 outline-none transition-all">
                    @error('new_words') <p class="mt-1.5 text-[11px] font-black text-red-500 uppercase tracking-tight">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-2">TỪ ÔN / NGÀY</label>
                    <input wire:model.defer="review_words" type="number" min="1" max="200"
                        class="w-full px-5 py-3 text-[14px] font-black border border-slate-50 rounded-xl bg-slate-50/50 focus:border-indigo-400 focus:ring-4 focus:ring-indigo-500/5 outline-none transition-all">
                </div>
            </div>
        </div>

        {{-- Submit --}}
        <div class="px-6 py-5">
            <button type="submit"
                class="w-full py-4 text-[12px] font-black text-white bg-indigo-600 hover:bg-indigo-700 rounded-xl transition-all shadow-xl shadow-indigo-600/20 active:scale-95 uppercase tracking-widest cursor-pointer">
                LƯU HỒ SƠ
            </button>
        </div>
    </form>
</div>
