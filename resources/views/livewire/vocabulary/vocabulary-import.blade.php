<div>
    {{--
        T18: Vocabulary Import Modal Blade
        Responsive AlpineJS modal with Tailwind Glassmorphism.
        Features:
        - 3D backdrop + backdrop click/hide
        - File drag-drop zone
        - Progress bar (wire:loading)
        - Template download
        - Success/error states
        - Mobile-first responsive
    --}}
    <div x-data="{ open: false }" x-init="$wire.on('open-import-modal', () => open = true)">
        {{-- Modal trigger button in parent (VocabularyIndex) --}}

        <!-- Modal -->
        <div x-show="open"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             x-on:keydown.escape.window="open = false"
             class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">

            <!-- Backdrop -->
            <div x-show="open" x-transition:enter="ease-in-out duration-500"
                 x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                 x-transition:leave="ease-in-out duration-500" x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 x-on:click="open = false"
                 class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

            <!-- Modal panel -->
            <div class="fixed inset-0 pointer-events-none flex items-end sm:items-center justify-center p-4">
                <div x-show="open" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="pointer-events-auto w-full max-w-2xl transform transition-all sm:p-6 lg:p-8">
                    <div class="glass rounded-2xl bg-white p-6 shadow-xl ring-1 ring-black ring-opacity-5">
                        <div class="flex items-start justify-between">
                            <h2 class="text-lg font-bold text-gray-900" id="modal-title">
                                Import từ vựng từ Excel/CSV
                            </h2>
                            <div class="ml-4 flex items-center md:ml-6">
                                <button type="button" @click="open = false"
                                        class="rounded-md bg-white text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                    <span class="sr-only">Close panel</span>
                                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <div class="mt-6 space-y-6">
                            <!-- Download template -->
                            <div class="flex justify-center">
                                <button wire:click="downloadTemplate"
                                        class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10l-5.5 5.5m0 0L12 21l5.5-5.5m-5.5 5.5V8a1 1 0 012 0v8.5" />
                                    </svg>
                                    Tải template Excel
                                </button>
                            </div>

                            <!-- File upload -->
                            <div class="border-2 border-dashed border-gray-300 rounded-xl p-6 hover:border-indigo-400 transition-colors">
                                <div class="text-center">
                                    <div class="mx-auto h-12 w-12 text-gray-400 mb-4">
                                        <svg class="mx-auto h-12 w-12" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 20h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    </div>
                                    <div class="space-y-1 text-sm text-gray-600">
                                        <label for="file" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                            <span>Upload file</span>
                                            <input wire:model="file" id="file" type="file" class="sr-only" accept=".xlsx,.xls,.csv">
                                        </label>
                                        <p class="text-xs text-gray-500 mt-2">Excel/CSV lên đến 2MB</p>
                                    </div>
                                </div>
                            </div>

                            @if ($errors && count($errors) > 0)
                                <div class="bg-red-50 border border-red-200 rounded-xl p-4">
                                    <div class="flex">
                                        <div class="flex-shrink-0">
                                            <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <ul class="ml-3 list-disc list-inside text-sm text-red-700">
                                            @foreach ($errors as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            @endif

                            <!-- Progress -->
                            @if($isUploading)
                                <div class="bg-indigo-50 border border-indigo-200 rounded-xl p-4">
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm font-medium text-indigo-800">Đang import...</span>
                                        <span class="text-sm text-indigo-600">{{ $uploadProgress }}%</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2 mt-2">
                                        <div class="bg-indigo-600 h-2 rounded-full transition-all duration-300" style="width: {{ $uploadProgress }}%"></div>
                                    </div>
                                </div>
                            @endif

                            <!-- Results -->
                            @if($importedCount > 0)
                                <div class="bg-green-50 border border-green-200 rounded-xl p-4">
                                    <div class="text-center">
                                        <div class="mx-auto h-12 w-12 bg-green-100 rounded-full flex items-center justify-center mb-4">
                                            <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                            </svg>
                                        </div>
                                        <h3 class="text-lg font-semibold text-green-800 mb-2">Import thành công!</h3>
                                        <p class="text-green-700">Đã thêm <strong>{{ $importedCount }}</strong> từ vựng vào bộ từ.</p>
                                    </div>
                                </div>
                            @endif

                            <!-- Actions -->
                            <div class="flex space-x-3 pt-4">
                                <button wire:click="import" wire:loading.attr="disabled"
                                        class="flex-1 bg-indigo-600 border border-transparent rounded-md py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center">
                                    <svg wire:loading.remove class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                                    </svg>
                                    <span wire:loading.remove>Import file</span>
                                    <span wire:loading>Đang xử lý...</span>
                                </button>
                                <button type="button" @click="open = false"
                                        class="flex-1 bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Hủy
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

