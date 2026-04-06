<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    @php
        $user = auth()->user();
        $goal = $user->dailyGoal;
        $sets = $user->vocabularySets()->withCount('vocabularies')->latest()->get();
        $totalWords = $sets->sum('vocabularies_count');
    @endphp

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border border-gray-100">
                    <p class="text-sm text-gray-500 mb-2">Mục tiêu hôm nay</p>
                    <p class="text-3xl font-semibold text-gray-900">
                        {{ $goal?->new_words_per_day ?? 10 }} <span class="text-base font-normal text-gray-600">từ mới</span>
                    </p>
                    <p class="text-3xl font-semibold text-gray-900 mt-2">
                        {{ $goal?->review_words_per_day ?? 20 }} <span class="text-base font-normal text-gray-600">từ ôn</span>
                    </p>
                    @php $profileUrl = \Illuminate\Support\Facades\Route::has('profile.edit') ? route('profile.edit') : (\Illuminate\Support\Facades\Route::has('profile') ? route('profile') : url('/profile')); @endphp
                    <a href="{{ $profileUrl }}" class="inline-block mt-4 text-sm font-medium text-indigo-600 hover:text-indigo-700">
                        {{ $goal ? __('Chỉnh sửa mục tiêu') : __('Đặt mục tiêu ngay') }}
                    </a>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border border-gray-100">
                    <p class="text-sm text-gray-500 mb-2">Bộ từ vựng</p>
                    <p class="text-3xl font-semibold text-gray-900">{{ $sets->count() }}</p>
                    <p class="text-sm text-gray-600 mt-1">{{ $totalWords }} từ đang có</p>
                    @php
                        $setsUrl = match (true) {
                            \Illuminate\Support\Facades\Route::has('vocabulary.sets.index') => route('vocabulary.sets.index'),
                            \Illuminate\Support\Facades\Route::has('vocabulary.sets') => route('vocabulary.sets'),
                            default => url('/vocabulary'),
                        };
                    @endphp
                    <a href="{{ $setsUrl }}" class="inline-block mt-4 text-sm font-medium text-indigo-600 hover:text-indigo-700">
                        Xem danh sách
                    </a>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border border-gray-100">
                    <p class="text-sm text-gray-500 mb-2">Tiến độ</p>
                    <p class="text-3xl font-semibold text-gray-900">{{ $user->total_learned_words ?? 0 }}</p>
                    <p class="text-sm text-gray-600 mt-1">từ đã học</p>
                    <p class="text-sm text-gray-500 mt-4">SRS sẽ cập nhật khi bạn bắt đầu học.</p>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-100">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-900">Bộ từ gần đây</h3>
                        @php
                            $setsUrl = match (true) {
                                \Illuminate\Support\Facades\Route::has('vocabulary.sets.index') => route('vocabulary.sets.index'),
                                \Illuminate\Support\Facades\Route::has('vocabulary.sets') => route('vocabulary.sets'),
                                default => url('/vocabulary'),
                            };
                        @endphp
                        <a href="{{ $setsUrl }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-700">
                            Quản lý bộ từ
                        </a>
                    </div>

                    @if ($sets->isEmpty())
                        <p class="text-sm text-gray-600">Chưa có bộ từ nào. Hãy tạo bộ đầu tiên để bắt đầu học.</p>
                    @else
                        <div class="space-y-3">
                            @foreach ($sets->take(5) as $set)
                                <div class="flex items-center justify-between border border-gray-100 rounded-lg px-4 py-3">
                                    <div>
                                        <p class="font-semibold text-gray-900">{{ $set->name }}</p>
                                        <p class="text-sm text-gray-600 line-clamp-2">{{ $set->description ?? 'Không có mô tả' }}</p>
                                    </div>
                                    <span class="text-sm font-medium text-gray-700">{{ $set->vocabularies_count }} từ</span>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
