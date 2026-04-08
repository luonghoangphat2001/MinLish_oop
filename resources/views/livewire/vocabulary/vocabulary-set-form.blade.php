<div>
    @if($showModal)
    {{-- Backdrop --}}
    <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
        <div class="absolute inset-0 bg-slate-900/50 backdrop-blur-sm" wire:click="closeModal"></div>

        {{-- Modal --}}
        <div class="relative z-10 w-full max-w-lg bg-white rounded-[24px] shadow-2xl overflow-hidden">
            <form wire:submit.prevent="save">
                {{-- Header --}}
                <div class="flex items-center justify-between px-6 py-5 border-b border-slate-100">
                    <h3 class="text-[18px] font-bold text-slate-900 uppercase tracking-tight">
                        {{ $setId ? 'CẬP NHẬT BỘ TỪ' : 'TẠO BỘ TỪ MỚI' }}
                    </h3>
                    <button type="button" wire:click="closeModal"
                        class="p-2 rounded-xl text-slate-400 hover:text-slate-600 hover:bg-slate-100 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                {{-- Body --}}
                <div class="px-6 py-5 space-y-4">
                    <div>
                        <label for="name" class="block text-[11px] font-medium text-slate-500 uppercase tracking-widest mb-2">
                            TÊN BỘ TỪ VỰNG <span class="text-red-500">*</span>
                        </label>
                        <input type="text" wire:model="name" id="name"
                            class="w-full px-5 py-3 text-[14px] font-medium border border-slate-50 rounded-xl bg-slate-50/50 focus:border-indigo-400 focus:ring-4 focus:ring-indigo-500/5 outline-none transition-all"
                            placeholder="Ví dụ: TOEIC VOCABULARY SET 1">
                        @error('name') <p class="mt-1.5 text-[11px] font-medium text-red-500 uppercase tracking-tight">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="description" class="block text-[11px] font-medium text-slate-500 uppercase tracking-widest mb-2">MÔ TẢ</label>
                        <textarea wire:model="description" id="description" rows="3"
                            class="w-full px-5 py-3 text-[14px] font-medium border border-slate-50 rounded-xl bg-slate-50/50 focus:border-indigo-400 focus:ring-4 focus:ring-indigo-500/5 outline-none transition-all resize-none"
                            placeholder="Mô tả ngắn về bộ từ này..."></textarea>
                        @error('description') <p class="mt-1.5 text-[11px] font-medium text-red-500 uppercase tracking-tight">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="tags" class="block text-[11px] font-medium text-slate-500 uppercase tracking-widest mb-2">TAGS (PHÂN CÁCH BẰNG DẤU PHẨY)</label>
                        <input type="text" wire:model="tags" id="tags"
                            placeholder="toeic, ielts, basic..."
                            class="w-full px-5 py-3 text-[14px] font-medium border border-slate-50 rounded-xl bg-slate-50/50 focus:border-indigo-400 focus:ring-4 focus:ring-indigo-500/5 outline-none transition-all">
                        @error('tags') <p class="mt-1.5 text-[11px] font-medium text-red-500 uppercase tracking-tight">{{ $message }}</p> @enderror
                    </div>

                    <label class="flex items-center gap-3 p-4 bg-slate-50 rounded-xl border border-slate-100 cursor-pointer hover:bg-indigo-50 hover:border-indigo-200 transition-colors">
                        <input id="is_public" type="checkbox" wire:model="is_public"
                            class="w-4 h-4 text-indigo-600 rounded focus:ring-indigo-400 border-slate-300">
                        <div>
                            <span class="text-[13px] font-medium text-slate-800 uppercase tracking-tight">CÔNG KHAI</span>
                            <p class="text-[10px] font-medium text-slate-400 uppercase tracking-widest mt-0.5">MỌI NGƯỜI CÓ THỂ TÌM VÀ XEM BỘ TỪ NÀY</p>
                        </div>
                    </label>
                </div>

                {{-- Footer --}}
                <div class="flex items-center justify-end gap-3 px-6 py-4 bg-slate-50 border-t border-slate-100">
                    <button type="button" wire:click="closeModal"
                        class="px-6 py-3 text-[12px] font-medium text-slate-600 border border-slate-200 rounded-xl hover:bg-white transition-colors uppercase tracking-widest">
                        HỦY
                    </button>
                    <button type="submit"
                        class="px-6 py-3 text-[12px] font-medium text-white bg-indigo-600 rounded-xl hover:bg-indigo-700 transition-all shadow-xl shadow-indigo-600/20 active:scale-95 uppercase tracking-widest">
                        LƯU THAY ĐỔI
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif
</div>
