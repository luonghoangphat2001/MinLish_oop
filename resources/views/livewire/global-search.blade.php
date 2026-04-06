<div class="relative">
    <!-- Search Input -->
    <div class="relative">
        <input
            wire:model.live.debounce.300ms="query"
            type="text"
            placeholder="🔍 Tìm từ vựng... (Word/Meaning)"
            class="w-64 pl-10 pr-10 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200"
        >
        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
        </div>
        <button wire:click="$set('query', '')" type="button"
                class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <!-- Results Dropdown -->
    @if (count($results) > 0)
        <div class="absolute z-50 w-64 mt-1 bg-white border border-gray-200 rounded-xl shadow-lg max-h-80 overflow-auto">
            @foreach ($results as $index => $result)
                <a href="#" wire:click.prevent="selectResult({{ $index }})"
                   class="block px-4 py-3 hover:bg-indigo-50 border-b border-gray-100 last:border-b-0 transition-colors duration-150">
                    <div class="font-semibold text-indigo-900 truncate">{{ $result['word'] }}</div>
                    <div class="text-sm text-gray-600 truncate mt-1">{{ Str::limit($result['meaning'], 60) }}</div>
                    <div class="text-xs text-gray-400 mt-1">Bộ: {{ $result['set_name'] }}</div>
                </a>
            @endforeach
        </div>
    @elseif (strlen($query) >= 2)
        <div class="absolute z-50 w-64 mt-1 bg-white border border-gray-200 rounded-xl shadow-lg p-4">
            <p class="text-sm text-gray-500 text-center">Không tìm thấy từ nào 😔</p>
        </div>
    @endif
</div>

