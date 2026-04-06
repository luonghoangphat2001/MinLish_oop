<<<<<<< HEAD
<div>
    <div class="flex flex-col sm:flex-row justify-between items-center mb-6 gap-4">
        <h3 class="text-lg font-bold text-gray-800">Danh sách Bộ từ vựng</h3>
        <button wire:click="$dispatch('open-form')" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition">
            + Tạo bộ từ mới
        </button>
    </div>

    <div class="mb-6 grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Tìm kiếm</label>
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Nhập tên bộ từ..." class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Lọc theo Tag</label>
            <input type="text" wire:model.live.debounce.300ms="tagFilter" placeholder="Ví dụ: toeic, ielts..." class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
        </div>
    </div>

    <!-- Danh sách -->
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
        @forelse ($sets as $set)
            <div class="bg-white border rounded-xl p-5 shadow-sm hover:shadow-md transition">
                <div class="flex justify-between items-start mb-2">
                    <h4 class="font-bold text-gray-900 text-lg">{{ $set->name }}</h4>
                    <div class="flex items-center gap-2">
                        @if($set->is_public)
                            <span class="px-2 py-1 text-xs font-semibold bg-green-100 text-green-700 rounded-full">Công khai</span>
                        @else
                            <span class="px-2 py-1 text-xs font-semibold bg-gray-100 text-gray-600 rounded-full">Riêng tư</span>
                        @endif
                    </div>
                </div>
                
                <p class="text-sm text-gray-500 mb-4 line-clamp-2">{{ $set->description ?? 'Không có mô tả.' }}</p>
                
                <div class="flex items-center gap-4 text-sm text-gray-600 mb-4">
                    <span class="flex items-center gap-1">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
=======
﻿<div>
    @if (session()->has('message'))
        <div class="mb-4 rounded-md bg-green-50 px-3 py-2 text-sm text-green-700">
            {{ session('message') }}
        </div>
    @endif

    <div class="mb-6 flex flex-col items-center justify-between gap-4 sm:flex-row">
        <h3 class="text-lg font-bold text-gray-800">Danh sách bộ từ vựng</h3>
        <div class="flex gap-2">
            <button wire:click="createStarterSets" class="rounded-lg bg-emerald-600 px-4 py-2 text-sm font-medium text-white transition hover:bg-emerald-700">
                Tạo bộ mẫu nhanh
            </button>
            <button wire:click="$dispatch('open-form')" class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white transition hover:bg-indigo-700">
                + Tạo bộ từ mới
            </button>
        </div>
    </div>

    <div class="mb-6 grid grid-cols-1 gap-4 sm:grid-cols-2">
        <div>
            <label class="mb-1 block text-sm font-medium text-gray-700">Tìm kiếm</label>
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Nhập tên bộ từ..." class="w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
        </div>
        <div>
            <label class="mb-1 block text-sm font-medium text-gray-700">Lọc theo tag</label>
            <input type="text" wire:model.live.debounce.300ms="tagFilter" placeholder="Ví dụ: toeic, ielts..." class="w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6 md:grid-cols-2 xl:grid-cols-3">
        @forelse ($sets as $set)
            <div class="flex flex-col rounded-xl border bg-white p-5 shadow-sm transition hover:shadow-md">
                <div class="mb-2 flex items-start justify-between">
                    <h4 class="text-lg font-bold text-gray-900">{{ $set->name }}</h4>
                    <div class="flex items-center gap-2">
                        @if($set->is_public)
                            <span class="rounded-full bg-green-100 px-2 py-1 text-xs font-semibold text-green-700">Công khai</span>
                        @else
                            <span class="rounded-full bg-gray-100 px-2 py-1 text-xs font-semibold text-gray-600">Riêng tư</span>
                        @endif
                    </div>
                </div>

                <p class="mb-4 line-clamp-2 text-sm text-gray-500">{{ $set->description ?? 'Không có mô tả.' }}</p>

                <div class="mb-4 flex items-center gap-4 text-sm text-gray-600">
                    <span class="flex items-center gap-1">
                        <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
>>>>>>> 7ef4268b3ffbd68cac2db2a0eb2de9478d18e60b
                        {{ $set->vocabularies_count }} từ
                    </span>
                </div>

                @if($set->tags)
<<<<<<< HEAD
                    <div class="flex flex-wrap gap-1 mb-4">
                        @foreach($set->tags as $tag)
                            <span class="px-2 py-0.5 bg-indigo-50 text-indigo-600 text-xs rounded-md">#{{ $tag }}</span>
=======
                    <div class="mb-4 flex flex-wrap gap-1">
                        @foreach($set->tags as $tag)
                            <span class="rounded-md bg-indigo-50 px-2 py-0.5 text-xs text-indigo-600">#{{ $tag }}</span>
>>>>>>> 7ef4268b3ffbd68cac2db2a0eb2de9478d18e60b
                        @endforeach
                    </div>
                @endif

<<<<<<< HEAD
                <div class="flex justify-end gap-2 border-t pt-3 mt-auto">
                    <button wire:click="$dispatch('open-form', { id: {{ $set->id }} })" class="text-sm text-indigo-600 hover:text-indigo-900 font-medium px-2 py-1">Sửa</button>
                    <!-- x-confirm via Alpine -->
                    <button x-data x-on:click="if(confirm('Bạn có chắc chắn muốn xóa bộ từ này?')) $wire.deleteSet({{ $set->id }})" class="text-sm text-red-600 hover:text-red-900 font-medium px-2 py-1">Xóa</button>
=======
                <div class="mt-auto flex justify-end gap-2 border-t pt-3">
                    <a href="{{ route('vocabulary.words', $set) }}" class="px-2 py-1 text-sm font-medium text-slate-600 hover:text-slate-900">Quản lý từ</a>
                    <a href="{{ route('learning.flashcards', $set) }}" class="px-2 py-1 text-sm font-medium text-emerald-600 hover:text-emerald-900">Học</a>
                    <button wire:click="$dispatch('open-form', { id: {{ $set->id }} })" class="px-2 py-1 text-sm font-medium text-indigo-600 hover:text-indigo-900">Sửa</button>
                    <button x-data x-on:click="if(confirm('Bạn có chắc chắn muốn xóa bộ từ này?')) $wire.deleteSet({{ $set->id }})" class="px-2 py-1 text-sm font-medium text-red-600 hover:text-red-900">Xóa</button>
>>>>>>> 7ef4268b3ffbd68cac2db2a0eb2de9478d18e60b
                </div>
            </div>
        @empty
            <div class="col-span-full py-12 text-center text-gray-500">
<<<<<<< HEAD
                Chưa có bộ từ vựng nào. Hãy tạo mới ngay!
=======
                Chưa có bộ từ vựng nào. Hãy tạo mới hoặc bấm "Tạo bộ mẫu nhanh".
>>>>>>> 7ef4268b3ffbd68cac2db2a0eb2de9478d18e60b
            </div>
        @endforelse
    </div>

    <div class="mt-6">
        {{ $sets->links() }}
    </div>

<<<<<<< HEAD
    <!-- Modal Form -->
=======
>>>>>>> 7ef4268b3ffbd68cac2db2a0eb2de9478d18e60b
    <livewire:vocabulary.vocabulary-set-form />
</div>
