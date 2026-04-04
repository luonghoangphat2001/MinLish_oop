<div>
    @if (session()->has('message'))
        <div class="mb-4 rounded-md bg-green-50 px-3 py-2 text-sm text-green-700">
            {{ session('message') }}
        </div>
    @endif

    <div class="mb-6 flex flex-col items-center justify-between gap-4 sm:flex-row">
        <h3 class="text-lg font-bold text-gray-800">Danh sach bo tu vung</h3>
        <div class="flex gap-2">
            <button wire:click="createStarterSets" class="rounded-lg bg-emerald-600 px-4 py-2 text-sm font-medium text-white transition hover:bg-emerald-700">
                Tao bo mau nhanh
            </button>
            <button wire:click="$dispatch('open-form')" class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white transition hover:bg-indigo-700">
                + Tao bo tu moi
            </button>
        </div>
    </div>

    <div class="mb-6 grid grid-cols-1 gap-4 sm:grid-cols-2">
        <div>
            <label class="mb-1 block text-sm font-medium text-gray-700">Tim kiem</label>
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Nhap ten bo tu..." class="w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
        </div>
        <div>
            <label class="mb-1 block text-sm font-medium text-gray-700">Loc theo tag</label>
            <input type="text" wire:model.live.debounce.300ms="tagFilter" placeholder="Vi du: toeic, ielts..." class="w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6 md:grid-cols-2 xl:grid-cols-3">
        @forelse ($sets as $set)
            <div class="flex flex-col rounded-xl border bg-white p-5 shadow-sm transition hover:shadow-md">
                <div class="mb-2 flex items-start justify-between">
                    <h4 class="text-lg font-bold text-gray-900">{{ $set->name }}</h4>
                    <div class="flex items-center gap-2">
                        @if($set->is_public)
                            <span class="rounded-full bg-green-100 px-2 py-1 text-xs font-semibold text-green-700">Cong khai</span>
                        @else
                            <span class="rounded-full bg-gray-100 px-2 py-1 text-xs font-semibold text-gray-600">Rieng tu</span>
                        @endif
                    </div>
                </div>

                <p class="mb-4 line-clamp-2 text-sm text-gray-500">{{ $set->description ?? 'Khong co mo ta.' }}</p>

                <div class="mb-4 flex items-center gap-4 text-sm text-gray-600">
                    <span class="flex items-center gap-1">
                        <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                        {{ $set->vocabularies_count }} tu
                    </span>
                </div>

                @if($set->tags)
                    <div class="mb-4 flex flex-wrap gap-1">
                        @foreach($set->tags as $tag)
                            <span class="rounded-md bg-indigo-50 px-2 py-0.5 text-xs text-indigo-600">#{{ $tag }}</span>
                        @endforeach
                    </div>
                @endif

                <div class="mt-auto flex justify-end gap-2 border-t pt-3">
                    <a href="{{ route('vocabulary.words', $set) }}" class="px-2 py-1 text-sm font-medium text-slate-600 hover:text-slate-900">Quan ly tu</a>
                    <a href="{{ route('learning.flashcards', $set) }}" class="px-2 py-1 text-sm font-medium text-emerald-600 hover:text-emerald-900">Hoc</a>
                    <button wire:click="$dispatch('open-form', { id: {{ $set->id }} })" class="px-2 py-1 text-sm font-medium text-indigo-600 hover:text-indigo-900">Sua</button>
                    <button x-data x-on:click="if(confirm('Ban co chac chan muon xoa bo tu nay?')) $wire.deleteSet({{ $set->id }})" class="px-2 py-1 text-sm font-medium text-red-600 hover:text-red-900">Xoa</button>
                </div>
            </div>
        @empty
            <div class="col-span-full py-12 text-center text-gray-500">
                Chua co bo tu vung nao. Hay tao moi hoac bam "Tao bo mau nhanh".
            </div>
        @endforelse
    </div>

    <div class="mt-6">
        {{ $sets->links() }}
    </div>

    <livewire:vocabulary.vocabulary-set-form />
</div>
