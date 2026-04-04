<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-xl font-semibold text-gray-800">Bo tu: {{ $set->name }}</h2>
                <p class="text-sm text-gray-500">Tao tu theo chu de, sua nhanh va hoc ngay bang flashcard.</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('vocabulary.sets') }}"
                    class="rounded-md border px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">
                    Quay lai bo tu
                </a>
                <a href="{{ route('learning.flashcards', $set) }}"
                    class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-medium text-white hover:bg-indigo-700">
                    Hoc flashcard
                </a>
            </div>
        </div>
    </x-slot>

    <div class="grid gap-6 lg:grid-cols-3">
        <div class="rounded-xl border bg-white p-5 shadow-sm lg:col-span-1">
            <h3 class="text-base font-semibold text-gray-900">{{ $editingId ? 'Cap nhat tu' : 'Them tu moi' }}</h3>

            @if (session()->has('message'))
                <div class="mt-3 rounded-md bg-green-50 px-3 py-2 text-sm text-green-700">
                    {{ session('message') }}
                </div>
            @endif

            <form wire:submit.prevent="saveWord" class="mt-4 space-y-3">
                <div>
                    <label class="mb-1 block text-sm font-medium text-gray-700">Word *</label>
                    <input wire:model.defer="word" type="text" class="w-full rounded-md border-gray-300 text-sm">
                    @error('word') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="mb-1 block text-sm font-medium text-gray-700">Meaning *</label>
                    <input wire:model.defer="meaning" type="text" class="w-full rounded-md border-gray-300 text-sm">
                    @error('meaning') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="mb-1 block text-sm font-medium text-gray-700">Pronunciation</label>
                    <input wire:model.defer="pronunciation" type="text" class="w-full rounded-md border-gray-300 text-sm">
                </div>
                <div>
                    <label class="mb-1 block text-sm font-medium text-gray-700">Example</label>
                    <textarea wire:model.defer="example" rows="2" class="w-full rounded-md border-gray-300 text-sm"></textarea>
                </div>
                <div>
                    <label class="mb-1 block text-sm font-medium text-gray-700">Collocation</label>
                    <input wire:model.defer="collocation" type="text" class="w-full rounded-md border-gray-300 text-sm">
                </div>
                <div>
                    <label class="mb-1 block text-sm font-medium text-gray-700">Related Words</label>
                    <input wire:model.defer="related_words" type="text" class="w-full rounded-md border-gray-300 text-sm">
                </div>
                <div>
                    <label class="mb-1 block text-sm font-medium text-gray-700">Note</label>
                    <textarea wire:model.defer="note" rows="2" class="w-full rounded-md border-gray-300 text-sm"></textarea>
                </div>

                <div class="flex gap-2">
                    <button type="submit" class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700">
                        {{ $editingId ? 'Luu cap nhat' : 'Them tu' }}
                    </button>
                    @if ($editingId)
                        <button type="button" wire:click="cancelEdit" class="rounded-md border px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-50">
                            Huy
                        </button>
                    @endif
                </div>
            </form>
        </div>

        <div class="rounded-xl border bg-white p-5 shadow-sm lg:col-span-2">
            <div class="mb-4 flex items-center justify-between gap-3">
                <h3 class="text-base font-semibold text-gray-900">Danh sach tu trong bo</h3>
                <input wire:model.live.debounce.300ms="search" type="text" placeholder="Tim word / meaning..."
                    class="w-full max-w-xs rounded-md border-gray-300 text-sm">
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-3 py-2 text-left font-semibold text-gray-600">Word</th>
                            <th class="px-3 py-2 text-left font-semibold text-gray-600">Meaning</th>
                            <th class="px-3 py-2 text-left font-semibold text-gray-600">Example</th>
                            <th class="px-3 py-2 text-right font-semibold text-gray-600">Thao tac</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($words as $item)
                            <tr>
                                <td class="px-3 py-2 font-medium text-gray-900">{{ $item->word }}</td>
                                <td class="px-3 py-2 text-gray-700">{{ $item->meaning }}</td>
                                <td class="px-3 py-2 text-gray-500">{{ $item->example ?: '-' }}</td>
                                <td class="px-3 py-2 text-right">
                                    <button wire:click="editWord({{ $item->id }})" class="mr-2 text-indigo-600 hover:text-indigo-800">Sua</button>
                                    <button x-data
                                        x-on:click="if(confirm('Xoa tu nay khoi bo?')) $wire.deleteWord({{ $item->id }})"
                                        class="text-red-600 hover:text-red-800">
                                        Xoa
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-3 py-6 text-center text-gray-500">Chua co tu nao trong bo nay.</td>
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
</x-app-layout>

