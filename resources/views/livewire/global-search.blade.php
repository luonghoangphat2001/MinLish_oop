<div
    x-data="{ open: @entangle('showResults') }"
    x-show="open"

    x-transition:enter="transition ease-out duration-200"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"

    x-transition:leave="transition ease-in duration-150"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"

    @keydown.window.escape="$wire.closeSearch()"
    @keydown.window.ctrl.k.prevent="open = true"
    @keydown.window.meta.k.prevent="open = true"
    @open-search-modal.window="open = true"
    @click.away="$wire.closeSearch()"

    x-effect="if(open) { $nextTick(() => $refs.searchInput.focus()) }"

    class="fixed inset-0 bg-black/20 backdrop-blur-sm z-50 flex items-center justify-center p-4">

    <div
        class="bg-white rounded-3xl shadow-2xl w-full max-w-md max-h-[80vh] overflow-hidden border border-slate-100"
        @click.stop>

        {{-- HEADER --}}
        <div class="sticky top-0 bg-white z-10 border-b border-slate-100 px-6 py-4">
            <div class="relative flex items-center gap-3">
                <div class="relative flex-1">
                    <svg class="absolute left-5 top-1/2 -translate-y-1/2 w-5 h-5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0"/>
                    </svg>
                    <input
                        wire:model.live.debounce.300ms="query"
                        x-ref="searchInput"
                        type="text"
                        placeholder="TÌM TỪ VỰNG..."
                        class="w-full pl-14 pr-4 py-4 text-[14px] font-black border border-slate-50 rounded-2xl focus:border-indigo-400 focus:ring-4 focus:ring-indigo-500/5 bg-slate-50/50 transition-all uppercase tracking-tight outline-none"
                        autocomplete="off">
                </div>

                <button
                    wire:click="closeSearch"
                    class="p-3 bg-slate-50 text-slate-400 hover:text-rose-500 hover:bg-rose-50 rounded-2xl transition-all duration-300">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>

        {{-- LOADING --}}
        <div wire:loading class="px-6 py-4 text-sm text-slate-400">
            Đang tìm...
        </div>

        {{-- RESULTS --}}
        <div class="max-h-96 overflow-y-auto" wire:loading.remove>

            @forelse($results as $result)

            <a href="#"
                wire:click="goToResult({{ $result['id'] }})"
                class="block px-6 py-4 border-b hover:bg-indigo-50">

                <div class="flex items-start gap-3">

                    <div class="w-10 h-10 bg-indigo-100 rounded-xl flex items-center justify-center">
                        <span class="text-xs font-bold text-indigo-700">
                            {{ Str::limit($result['word'], 3, '') }}
                        </span>
                    </div>

                    <div class="flex-1">
                        <p class="font-bold">{{ $result['word'] }}</p>
                        <p class="text-sm text-slate-500">{{ $result['meaning'] }}</p>
                    </div>

                </div>

            </a>

            @empty

            @if(strlen($query) >= 2)
            <div class="px-6 py-10 text-center text-slate-400">
                Không tìm thấy kết quả
            </div>
            @endif

            @endforelse

        </div>

    </div>
</div>