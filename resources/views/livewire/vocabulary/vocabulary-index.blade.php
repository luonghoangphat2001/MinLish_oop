<div class="space-y-6">
    {{-- Header Panel --}}
    <div class="flex flex-col md:flex-row items-center justify-between gap-6 bg-white rounded-[32px] border border-slate-100 p-8 shadow-sm">
        <div class="flex items-center gap-6">
            <div class="w-16 h-16 rounded-2xl bg-indigo-50 flex items-center justify-center text-indigo-600 shadow-inner">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
            </div>
            <div>
                <h2 class="text-[18px] font-black text-slate-900 tracking-tight uppercase leading-tight">{{ $set->name }}</h2>
                <div class="flex items-center gap-2 mt-1">
                    <span class="text-[10px] font-black text-indigo-500 uppercase tracking-widest bg-indigo-50 px-3 py-0.5 rounded-full border border-indigo-100">{{ $set->vocabularies_count }} TỪ VỰNG</span>
                </div>
            </div>
        </div>
        <div class="flex flex-wrap items-center gap-4">
            {{-- BACK BUTTON --}}
            <a href="{{ route('vocabulary.sets') }}" 
               class="inline-flex items-center gap-2 px-6 py-4 rounded-2xl text-[11px] font-black text-slate-500 bg-slate-50 hover:bg-slate-100 transition-all duration-300 uppercase tracking-widest border border-slate-100 active:scale-95">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M7 16l-4-4m0 0l4-4m-4 4h18" />
                </svg>
                QUAY LẠI
            </a>

            <div class="h-8 w-[1px] bg-slate-100 hidden sm:block"></div>

            {{-- TOOL BUTTONS --}}
            <div class="flex items-center gap-2">
                <button wire:click="export" 
                        class="inline-flex items-center gap-2 px-6 py-4 rounded-2xl text-[11px] font-black text-emerald-700 bg-emerald-50 hover:bg-emerald-100 transition-all duration-300 uppercase tracking-widest border border-emerald-100 active:scale-95">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10l-5.5 5.5m0 0L12 21l5.5-5.5m-5.5 5.5V8a1 1 0 012 0v8.5" />
                    </svg>
                    EXPORT
                </button>

                <div class="relative">
                    <input type="file" wire:model="importFile" accept=".xlsx,.xls,.csv" class="hidden" id="import-file">
                    <label for="import-file" 
                           class="inline-flex items-center gap-2 px-6 py-4 rounded-2xl text-[11px] font-black text-amber-700 bg-amber-50 hover:bg-amber-100 transition-all duration-300 uppercase tracking-widest border border-amber-100 cursor-pointer active:scale-95">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                        </svg>
                        IMPORT
                    </label>
                </div>

                <button wire:click="downloadTemplate" 
                        class="p-4 rounded-2xl text-slate-400 bg-slate-50 hover:bg-slate-100 hover:text-slate-600 transition-all duration-300 border border-slate-100 active:scale-95"
                        title="Tải Template">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                    </svg>
                </button>
            </div>

            <div class="h-8 w-[1px] bg-slate-100 hidden sm:block"></div>

            {{-- PRIMARY ACTION --}}
            <a href="{{ route('learning.flashcards', $set) }}" 
               class="inline-flex items-center gap-3 px-8 py-4 rounded-2xl text-[11px] font-black text-white bg-indigo-600 hover:bg-indigo-700 transition-all duration-300 shadow-xl shadow-indigo-600/20 active:scale-95 uppercase tracking-widest">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
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
                        <td class="px-6 py-5">
                            <div class="flex items-center justify-end gap-2">
                                <button wire:click="editWord({{ $item->id }})" class="p-2 text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors" title="Sửa">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </button>

                                <button wire:click="deleteWord({{ $item->id }})" 
                                        wire:confirm="Bạn có chắc chắn muốn xóa từ vựng này không?" 
                                        class="p-2 text-rose-600 hover:bg-rose-50 rounded-lg transition-colors" title="Xóa">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Phân trang --}}
        @if ($words->hasPages())
            <div class="mt-8">
                {{ $words->links() }}
            </div>
        @endif
    </div>
</div>
    </div>
</div>