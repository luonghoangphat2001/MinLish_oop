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
    @click.away="$wire.closeSearch()"

    class="fixed inset-0 bg-black/20 backdrop-blur-sm z-50 flex items-center justify-center p-4"
>

    <div 
        class="bg-white rounded-3xl shadow-2xl w-full max-w-md max-h-[80vh] overflow-hidden border border-slate-100"
        @click.stop
    >

        {{-- HEADER --}}
        <div class="sticky top-0 bg-white z-10 border-b border-slate-100 px-6 py-4">
            <div class="flex items-center gap-3">

                <input
                    wire:model.live.debounce.300ms="query"
                    type="text"
                    placeholder="Tìm từ vựng..."
                    class="flex-1 text-lg font-bold outline-none bg-transparent"
                    autocomplete="off">

                <button 
                    wire:click="closeSearch"
                    class="p-1.5 hover:bg-slate-100 rounded-xl"
                >
                    ✕
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
