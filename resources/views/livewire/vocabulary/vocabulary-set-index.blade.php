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
                        {{ $set->vocabularies_count }} từ
                    </span>
                </div>

                @if($set->tags)
                    <div class="flex flex-wrap gap-1 mb-4">
                        @foreach($set->tags as $tag)
                            <span class="px-2 py-0.5 bg-indigo-50 text-indigo-600 text-xs rounded-md">#{{ $tag }}</span>
                        @endforeach
                    </div>
                @endif

                <div class="flex justify-end gap-2 border-t pt-3 mt-auto">
                    <button wire:click="$dispatch('open-form', { id: {{ $set->id }} })" class="text-sm text-indigo-600 hover:text-indigo-900 font-medium px-2 py-1">Sửa</button>
                    <!-- x-confirm via Alpine -->
                    <button x-data x-on:click="if(confirm('Bạn có chắc chắn muốn xóa bộ từ này?')) $wire.deleteSet({{ $set->id }})" class="text-sm text-red-600 hover:text-red-900 font-medium px-2 py-1">Xóa</button>
                </div>
            </div>
        @empty
            <div class="col-span-full py-12 text-center text-gray-500">
                Chưa có bộ từ vựng nào. Hãy tạo mới ngay!
            </div>
        @endforelse
    </div>

    <div class="mt-6">
        {{ $sets->links() }}
    </div>

    <!-- Modal Form -->
    <livewire:vocabulary.vocabulary-set-form />
</div>
