<div x-data="{ open: @entangle('showResults') }"
     x-show="open"
     x-transition:enter="transition ease-out duration-200"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-150"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     @keydown.window.escape="$wire.closeSearch(); open = false"
     @click.away="$wire.closeSearch(); open = false"
     class="fixed inset-0 bg-black/20 backdrop-blur-sm z-50 flex items-center justify-center p-4"
     wire:click="$set('showResults', false)">

    <div class="bg-white rounded-3xl shadow-2xl w-full max-w-md max-h-[80vh] overflow-hidden border border-slate-100"
         @click.stop>

        {{-- Header --}}
        <div class="sticky top-0 bg-white z-10 border-b border-slate-100 px-6 py-4">
            <div class="flex items-center gap-3">
                <svg class="w-6 h-6 text-slate-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <input
                    wire:model.live.debounce.300ms="query"
                    type="text"
                    placeholder="Tìm từ vựng, bộ từ..."
                    class="flex-1 text-lg font-bold text-slate-800 outline-none bg-transparent"
                    autocomplete="off">
                <button wire:click="closeSearch" type="button" class="p-1.5 hover:bg-slate-100 rounded-xl text-slate-400 hover:text-slate-600 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>

        {{-- Results --}}
        <div class="max-h-96 overflow-y-auto">
            @forelse($results as $result)
                <a href="#" wire:click="goToResult({{ $result['id'] }})"
                   class="block px-6 py-4 border-b border-slate-50 hover:bg-indigo-50 transition-colors last:border-b-0">
                    <div class="flex items-start gap-3">
                        <div class="flex-shrink-0 mt-0.5 w-10 h-10 bg-indigo-100 rounded-xl flex items-center justify-center">
                            <span class="text-[10px] font-black text-indigo-700 uppercase tracking-widest">{{ Str::limit($result['word'], 3, '') }}</span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2 mb-1">
                                <h3 class="font-black text-slate-900 text-base truncate">{{ $result['word'] }}</h3>
                                <span class="px-2 py-0.5 bg-slate-100 text-[10px] font-black text-slate-600 rounded-full uppercase tracking-widest">Từ</span>
                            </div>
                            <p class="text-slate-600 text-sm leading-tight line-clamp-1">{{ $result['meaning'] }}</p>
                            <div class="flex items-center gap-2 mt-1.5">
                                <span class="text-xs text-slate-500 font-bold truncate">{{ $result['set'] }}</span>
                                @if($result['author'] !== 'Public')
                                    <span class="text-[10px] text-slate-400 font-black uppercase tracking-widest">bởi {{ $result['author'] }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </a>
            @empty
                @if(strlen($query) >= 2)
                    <div class="px-6 py-12 text-center">
                        <div class="w-20 h-20 mx-auto mb-4 bg-slate-100 rounded-2xl flex items-center justify-center">
                            <svg class="w-10 h-10 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                        <h3 class="font-black text-slate-900 text-lg mb-1">Không tìm thấy</h3>
                        <p class="text-slate-500 text-sm">Thử từ khóa khác hoặc tạo bộ từ mới</p>
                    </div>
                @endif
            @endforelse
        </div>
    </div>
</div>
