<div>
    <div class="mb-6 flex flex-col gap-2 rounded-xl border bg-white p-5 shadow-sm sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-2xl font-semibold text-gray-800">Flashcard: {{ $set->name }}</h2>
            <p class="text-sm text-gray-500">Space: lật thẻ | 1: lại | 2: khó | 3: tốt | 4: dễ</p>
        </div>
        <a href="{{ route('vocabulary.words', $set) }}"
            class="rounded-md border px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">
            Quản lý từ của bộ này
        </a>
    </div>

    <div x-data="{ flipped: @entangle('showBack') }"
        x-on:keydown.window.space.prevent="$wire.flipCard()"
        x-on:keydown.window.1.prevent="$wire.submitRating('again')"
        x-on:keydown.window.2.prevent="$wire.submitRating('hard')"
        x-on:keydown.window.3.prevent="$wire.submitRating('good')"
        x-on:keydown.window.4.prevent="$wire.submitRating('easy')"
        class="mx-auto max-w-3xl">

        @if ($total === 0)
            <div class="rounded-xl border border-dashed border-gray-300 bg-white p-10 text-center shadow-sm">
                <p class="text-gray-600">Bộ từ này chưa có dữ liệu học. Hãy thêm từ trước khi bắt đầu.</p>
                <a href="{{ route('vocabulary.words', $set) }}"
                    class="mt-3 inline-flex rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700">
                    Thêm từ ngay
                </a>
            </div>
        @elseif ($completed)
            <div class="rounded-xl border bg-white p-8 text-center shadow-sm">
                <h3 class="text-2xl font-bold text-gray-900">Hoàn thành phiên học</h3>
                <p class="mt-2 text-gray-600">Bạn đã học {{ $total }} từ trong bộ này.</p>
                <div class="mx-auto mt-5 grid max-w-md grid-cols-2 gap-3 text-sm">
                    <div class="rounded-md bg-red-50 p-3 text-red-700">Lại: {{ $ratingSummary['again'] }}</div>
                    <div class="rounded-md bg-amber-50 p-3 text-amber-700">Khó: {{ $ratingSummary['hard'] }}</div>
                    <div class="rounded-md bg-emerald-50 p-3 text-emerald-700">Tốt: {{ $ratingSummary['good'] }}</div>
                    <div class="rounded-md bg-blue-50 p-3 text-blue-700">Dễ: {{ $ratingSummary['easy'] }}</div>
                </div>
                <div class="mt-6 flex justify-center gap-2">
                    <button wire:click="restartSession"
                        class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700">
                        Học lại bộ này
                    </button>
                    <a href="{{ route('dashboard') }}"
                        class="rounded-md border px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-50">
                        Về dashboard
                    </a>
                </div>
            </div>
        @elseif ($currentProgress)
            <div class="mb-4 flex items-center justify-between text-sm text-gray-600">
                <span>Từ {{ $currentIndex + 1 }}/{{ $total }}</span>
                <span>Trạng thái: <strong class="uppercase">{{ $currentProgress->status }}</strong></span>
            </div>

            <div class="rounded-2xl border bg-white p-8 shadow-sm">
                <div class="relative mx-auto h-[240px] w-full [perspective:1200px]">
                    <div class="relative h-full w-full transition-transform duration-500 [transform-style:preserve-3d]"
                         :class="flipped ? '[transform:rotateY(180deg)]' : ''">
                        <div class="absolute inset-0 rounded-xl border bg-white p-5 [backface-visibility:hidden]">
                            <div class="text-center pt-8">
                                <p class="text-3xl font-bold text-gray-900">{{ $currentProgress->vocabulary->word }}</p>
                                <p class="mt-1 text-sm text-gray-500">{{ $currentProgress->vocabulary->pronunciation ?: 'Chưa có phiên âm' }}</p>
                            </div>
                        </div>

                        <div class="absolute inset-0 rounded-xl border bg-gray-50 p-5 [backface-visibility:hidden] [transform:rotateY(180deg)]">
                            <p class="text-lg font-semibold text-indigo-700">{{ $currentProgress->vocabulary->meaning }}</p>
                            @if ($currentProgress->vocabulary->example)
                                <p class="mt-2 text-sm text-gray-600">Ví dụ: {{ $currentProgress->vocabulary->example }}</p>
                            @endif
                            @if ($currentProgress->vocabulary->collocation)
                                <p class="mt-1 text-sm text-gray-600">Cụm từ đi cùng: {{ $currentProgress->vocabulary->collocation }}</p>
                            @endif
                            @if ($currentProgress->vocabulary->note)
                                <p class="mt-1 text-sm text-gray-600">Ghi chú: {{ $currentProgress->vocabulary->note }}</p>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="mt-6">
                    <button wire:click="flipCard"
                        class="w-full rounded-md border px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-50">
                        {{ $showBack ? 'Ẩn mặt sau' : 'Lật thẻ' }}
                    </button>
                </div>

                <div class="mt-4 grid grid-cols-2 gap-3 sm:grid-cols-4 ">
                    <button wire:click="submitRating('again')"
                        class="inline-flex min-h-11 w-full items-center justify-center rounded-md bg-red-500 px-3 py-2 text-sm font-semibold text-white shadow hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-300">
                        1 · Lại
                    </button>
                    <button wire:click="submitRating('hard')"
                        class="inline-flex min-h-11 w-full items-center justify-center rounded-md bg-amber-500 px-3 py-2 text-sm font-semibold text-white shadow hover:bg-amber-600 focus:outline-none focus:ring-2 focus:ring-amber-300">
                        2 · Khó
                    </button>
                    <button wire:click="submitRating('good')"
                        class="inline-flex min-h-11 w-full items-center justify-center rounded-md bg-emerald-500 px-3 py-2 text-sm font-semibold text-white shadow hover:bg-emerald-600 focus:outline-none focus:ring-2 focus:ring-emerald-300">
                        3 · Tốt
                    </button>
                    <button wire:click="submitRating('easy')"
                        class="inline-flex min-h-11 w-full items-center justify-center rounded-md bg-blue-500 px-3 py-2 text-sm font-semibold text-white shadow hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-300">
                        4 · Dễ
                    </button>
                </div>
            </div>
        @endif
    </div>
</div>
