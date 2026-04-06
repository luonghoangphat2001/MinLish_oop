<div>
    <div class="mb-6 flex flex-col gap-2 rounded-xl border bg-white p-5 shadow-sm sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-3xl font-semibold text-gray-800">Bộ từ: {{ $set->name }}</h2>
            <p class="text-sm text-gray-500">Tạo từ theo chủ đề, sửa nhanh và học ngay bằng flashcard.</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('vocabulary.sets') }}"
                class="rounded-md border px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">
                Quay lại bộ từ
            </a>
            <a href="{{ route('learning.flashcards', $set) }}"
                class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-medium text-white hover:bg-indigo-700">
                Học flashcard
            </a>
        </div>
    </div>

    <div class="grid gap-6 lg:grid-cols-3">
        <div class="rounded-xl border bg-white p-5 shadow-sm lg:col-span-1">
            <h3 class="text-base font-semibold text-gray-900">{{ $editingId ? 'Cập nhật từ' : 'Thêm từ mới' }}</h3>

            @if (session()->has('message'))
                <div class="mt-3 rounded-md bg-green-50 px-3 py-2 text-sm text-green-700">
                    {{ session('message') }}
                </div>
            @endif

            <form wire:submit.prevent="saveWord" class="mt-4 space-y-3">
                <div>
                    <label class="mb-1 block text-sm font-medium text-gray-700">Từ *</label>
                    <input wire:model.defer="word" type="text" class="w-full rounded-md border-gray-300 text-sm">
                    @error('word') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="mb-1 block text-sm font-medium text-gray-700">Nghĩa *</label>
                    <input wire:model.defer="meaning" type="text" class="w-full rounded-md border-gray-300 text-sm">
                    @error('meaning') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="mb-1 block text-sm font-medium text-gray-700">Phiên âm</label>
                    <input wire:model.defer="pronunciation" type="text" class="w-full rounded-md border-gray-300 text-sm">
                </div>
                <div>
                    <label class="mb-1 block text-sm font-medium text-gray-700">Ví dụ</label>
                    <textarea wire:model.defer="example" rows="2" class="w-full rounded-md border-gray-300 text-sm"></textarea>
                </div>
                <div>
                    <label class="mb-1 block text-sm font-medium text-gray-700">Cụm từ đi cùng</label>
                    <input wire:model.defer="collocation" type="text" class="w-full rounded-md border-gray-300 text-sm">
                </div>
                <div>
                    <label class="mb-1 block text-sm font-medium text-gray-700">Từ liên quan</label>
                    <input wire:model.defer="related_words" type="text" class="w-full rounded-md border-gray-300 text-sm">
                </div>
                <div>
                    <label class="mb-1 block text-sm font-medium text-gray-700">Ghi chú</label>
                    <textarea wire:model.defer="note" rows="2" class="w-full rounded-md border-gray-300 text-sm"></textarea>
                </div>

                <div class="flex gap-2">
                    <button type="submit" class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700">
                        {{ $editingId ? 'Lưu cập nhật' : 'Thêm từ' }}
                    </button>
                    @if ($editingId)
                        <button type="button" wire:click="cancelEdit" class="rounded-md border px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-50">
                            Hủy
                        </button>
                    @endif
                </div>
            </form>
        </div>

        <div class="rounded-xl border bg-white p-5 shadow-sm lg:col-span-2">
            <div class="mb-4 flex items-center justify-between gap-3">
                <h3 class="text-base font-semibold text-gray-900">Danh sách từ trong bộ</h3>
                <input wire:model.live.debounce.300ms="search" type="text" placeholder="Tìm word / meaning..."
                    class="w-full max-w-xs rounded-md border-gray-300 text-sm">
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-3 py-2 text-left font-semibold text-gray-600">Từ</th>
                            <th class="px-3 py-2 text-left font-semibold text-gray-600">Nghĩa</th>
                            <th class="px-3 py-2 text-left font-semibold text-gray-600">SRS</th>
                            <th class="px-3 py-2 text-left font-semibold text-gray-600">Ví dụ</th>
                            <th class="px-3 py-2 text-right font-semibold text-gray-600">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($words as $item)
                            @php
                                $status = optional($item->srsProgress->first())->status ?? 'new';
                                $statusLabel = match($status) {
                                    'learning' => 'Learning',
                                    'review' => 'Review',
                                    'mastered' => 'Mastered',
                                    default => 'New'
                                };
                                $statusClass = match($status) {
                                    'learning' => 'bg-amber-50 text-amber-700',
                                    'review' => 'bg-blue-50 text-blue-700',
                                    'mastered' => 'bg-emerald-50 text-emerald-700',
                                    default => 'bg-gray-100 text-gray-700'
                                };
                            @endphp
                            <tr>
                                <td class="px-3 py-2 font-medium text-gray-900">{{ $item->word }}</td>
                                <td class="px-3 py-2 text-gray-700">{{ $item->meaning }}</td>
                                <td class="px-3 py-2">
                                    <span class="rounded-full px-2 py-1 text-xs font-semibold {{ $statusClass }}">{{ $statusLabel }}</span>
                                </td>
                                <td class="px-3 py-2 text-gray-500">{{ $item->example ?: '-' }}</td>
                                <td class="px-3 py-2 text-right">
                                    <button wire:click="editWord({{ $item->id }})" class="mr-2 text-indigo-600 hover:text-indigo-800">Sửa</button>
                                    <button x-data
                                        x-on:click="if(confirm('Xóa từ này khỏi bộ?')) $wire.deleteWord({{ $item->id }})"
                                        class="text-red-600 hover:text-red-800">
                                        Xóa
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-3 py-6 text-center text-gray-500">Chưa có từ nào trong bộ này.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $words->links() }}
            </div>
        </div>
    </div>
</div>
