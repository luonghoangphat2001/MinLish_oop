<div class="max-w-xl mx-auto py-8">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Hồ sơ của tôi</h2>

    @if (session()->has('message'))
        <div class="mb-4 p-3 bg-green-100 text-green-800 rounded-lg text-sm">
            {{ session('message') }}
        </div>
    @endif

    <form wire:submit.prevent="save" class="space-y-5 bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Họ và tên</label>
            <input wire:model.defer="name" type="text"
                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm"
                placeholder="Nguyen Van A">
            @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Trình độ hiện tại</label>
            <select wire:model.defer="level"
                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                @foreach (['A1', 'A2', 'B1', 'B2', 'C1', 'C2'] as $lvl)
                    <option value="{{ $lvl }}">{{ $lvl }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Mục tiêu học</label>
            <input wire:model.defer="goal" type="text"
                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm"
                placeholder="IELTS, Giao tiếp, Business...">
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Từ mới / ngày</label>
                <input wire:model.defer="new_words" type="number" min="1" max="100"
                    class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                @error('new_words') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Từ ôn / ngày</label>
                <input wire:model.defer="review_words" type="number" min="1" max="200"
                    class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">
            </div>
        </div>

        <button type="submit"
            class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2.5 px-4 rounded-lg transition-colors duration-200 cursor-pointer">
            Lưu hồ sơ
        </button>
    </form>
</div>
