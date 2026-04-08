<div class="space-y-6">
    {{-- Header Panel --}}
    <div class="flex flex-col md:flex-row items-center justify-between gap-6 bg-white rounded-[32px] border border-slate-100 p-8 shadow-sm">
        <div class="flex items-center gap-6">
            <div class="w-16 h-16 rounded-2xl bg-indigo-50 flex items-center justify-center text-indigo-600 shadow-inner">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
            </div>
            <div>
                <h2 class="text-[18px] font-black text-slate-900 tracking-tight uppercase leading-tight">{{ $set->name }}</h2>
                <div class="flex items-center gap-2 mt-1">
                    <span class="text-[10px] font-black text-indigo-500 uppercase tracking-widest bg-indigo-50 px-3 py-0.5 rounded-full border border-indigo-100">{{ $set->vocabularies_count }} TỪ VỰNG</span>
                </div>
            </div>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('vocabulary.sets') }}" class="inline-flex items-center gap-2 px-6 py-3 text-[12px] font-black text-slate-500 bg-slate-50 rounded-xl hover:bg-slate-100 transition-colors uppercase tracking-widest">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M7 16l-4-4m0 0l4-4m-4 4h18"/>
                </svg>
                QUAY LẠI
            </a>
            <a href="{{ route('learning.flashcards', $set) }}" class="px-8 py-3 text-[12px] font-black text-white bg-indigo-600 rounded-xl hover:bg-indigo-700 transition-all shadow-lg active:scale-95 uppercase">
                HỌC FLASHCARD
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Form Panel --}}
        <div class="lg:col-span-1">
            <div class="bg-white rounded-[32px] border border-slate-100 p-8 shadow-sm">
                <h3 class="text-[18px] font-black text-slate-900 uppercase tracking-tight mb-6">
                    {{ $editingId ? 'CẬP NHẬT TỪ' : 'THÊM TỪ MỚI' }}
                </h3>

                <form wire:submit.prevent="saveWord" class="space-y-4">
                    <div class="space-y-1">
                        <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest">Từ vựng</label>
                        <input wire:model.defer="word" type="text" class="w-full px-5 py-3 text-[14px] font-bold border border-slate-50 rounded-xl bg-slate-50/50 focus:border-indigo-400 outline-none transition-all">
                    </div>
                    <div class="space-y-1">
                        <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest">Nghĩa</label>
                        <input wire:model.defer="meaning" type="text" class="w-full px-5 py-3 text-[14px] font-bold border border-slate-50 rounded-xl bg-slate-50/50 focus:border-indigo-400 outline-none transition-all">
                    </div>
                    <button type="submit" class="w-full py-4 text-[12px] font-black text-white bg-indigo-600 rounded-xl hover:bg-indigo-700 transition-all uppercase tracking-widest">
                        {{ $editingId ? 'CẬP NHẬT' : 'THÊM TỪ' }}
                    </button>
                </form>
            </div>
        </div>

        {{-- List Panel --}}
        <div class="lg:col-span-2">
            <div class="bg-white rounded-[32px] border border-slate-100 p-8 shadow-sm">
                <h3 class="text-[18px] font-black text-slate-900 uppercase tracking-tight mb-6">DANH SÁCH TỪ VỰNG</h3>
                <div class="overflow-hidden border border-slate-50 rounded-2xl">
                    <table class="min-w-full divide-y divide-slate-50">
                        <thead class="bg-slate-50/50">
                            <tr>
                                <th class="px-6 py-4 text-left text-[11px] font-black text-slate-400 uppercase tracking-widest">Từ vựng</th>
                                <th class="px-6 py-4 text-left text-[11px] font-black text-slate-400 uppercase tracking-widest">Nghĩa</th>
                                <th class="px-6 py-4 text-right text-[11px] font-black text-slate-400 uppercase tracking-widest">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50 text-[14px]">
                            @foreach ($words as $item)
                                <tr class="hover:bg-slate-50 transition-colors">
                                    <td class="px-6 py-5 font-black text-slate-900 uppercase tracking-tight">{{ $item->word }}</td>
                                    <td class="px-6 py-5 font-black text-slate-600">{{ $item->meaning }}</td>
                                    <td class="px-6 py-5 text-right">
                                        <button wire:click="editWord({{ $item->id }})" class="p-2 text-indigo-600 hover:bg-indigo-50 rounded-lg">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
