<div x-data="{ open: false, focusSearch: false }" class="relative">
    <!-- Search Trigger -->
    <button @click="open = true; focusSearch = true" class="p-2 text-gray-500 hover:text-gray-900 rounded-lg hover:bg-gray-100">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
        </svg>
    </button>

    <!-- Search Overlay -->
    <div x-show="open" x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         x-on:click.away="open = false" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">

        <!-- Backdrop -->
        <div x-show="open" x-transition.opacity class="fixed inset-0 bg-black bg-opacity-25" @click="open = false"></div>

        <!-- Panel -->
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="w-full max-w-2xl bg-white rounded-2xl shadow-2xl ring-1 ring-black ring-opacity-5 max-h-[90vh] overflow-y-auto">
                <!-- Header -->
                <div class="sticky top-0 z-10 bg-white border-b px-6 py-4">
                    <div class="flex items-center space-x-3">
                        <button wire:click="$emit('close-search')" class="p-1 hover:bg-gray-100 rounded-lg">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                        <div class="flex-1">
                            <input wire:model.live.debounce.300ms="search"
                                   x-ref="searchInput" x-on:focus="focusSearch = true"
                                   type="text"
                                   class="w-full px-4 py-2 border-0 focus:ring-2 focus:ring-blue-500 rounded-xl text-lg"
                                   placeholder="Tìm từ vựng, nghĩa, bộ từ..." autocomplete="off">
                        </div>
                    </div>
                </div>

                <!-- Results -->
                <div class="p-4 max-h-96 overflow-y-auto">
                    @if (count($results) === 0)
                        <div class="text-center py-12 text-gray-500">
                            <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                <path d="M34 40h10v-4a6 6 0 00-6-6h-5m-4 0h6a6 6 0 006-6V20a6 6 0 00-6-6h-5m-6 0v6a2 2 0 002 2h2a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2v-6m0 17.371h8.171A2 2 0 0022 20.828v-5.657a2 2 0 00-.828-1.621l-4.21-3.211a1 1 0 00-1.986 0l-4.21 3.211a2 2 0 00-.829 1.621v5.657a2 2 0 002.828 1.543zm7.513 2.175l-3.664 2.566a1 1 0 01-1.186 0L18.51 39.175a1 1 0 01-.372-1.119l2.92-7.939a1 1 0 01.899-.725h5.834a1 1 0 01.899.725l2.92 7.939a1 1 0 01-.371 1.12z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">Không tìm thấy</h3>
                            <p class="text-sm">Thử từ khóa khác hoặc thêm từ mới</p>
                        </div>
                    @else
                        <div class="space-y-2">
                            @foreach ($results as $result)
                                <a href="{{ $result['url'] }}" class="group block p-4 rounded-xl hover:bg-gray-50 transition-colors border border-transparent hover:border-gray-200">
                                    <div class="flex items-start space-x-3">
                                        <div class="flex-shrink-0 w-10 h-10 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center">
                                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <h4 class="text-lg font-semibold text-gray-900 group-hover:text-blue-600 truncate">{{ $result['word'] }}</h4>
                                            <p class="text-sm text-gray-600 mt-1 line-clamp-2">{{ $result['meaning'] }}</p>
                                            <p class="text-xs text-gray-500 mt-1 inline-flex items-center px-2 py-1 bg-gray-100 rounded-full">
                                                {{ $result['set'] }}
                                            </p>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

