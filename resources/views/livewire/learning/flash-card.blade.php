<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-xl font-semibold text-gray-800">Flashcard: {{ $set->name }}</h2>
                <p class="text-sm text-gray-500">Space: lat the | 1:again 2:hard 3:good 4:easy</p>
            </div>
            <a href="{{ route('vocabulary.words', $set) }}"
                class="rounded-md border px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">
                Quan ly tu cua bo nay
            </a>
        </div>
    </x-slot>

    <div x-data
        x-on:keydown.window.space.prevent="$wire.flipCard()"
        x-on:keydown.window.1.prevent="$wire.submitRating('again')"
        x-on:keydown.window.2.prevent="$wire.submitRating('hard')"
        x-on:keydown.window.3.prevent="$wire.submitRating('good')"
        x-on:keydown.window.4.prevent="$wire.submitRating('easy')"
        class="mx-auto max-w-3xl">

        @if ($total === 0)
            <div class="rounded-xl border border-dashed border-gray-300 bg-white p-10 text-center shadow-sm">
                <p class="text-gray-600">Bo tu nay chua co du lieu hoc. Hay them tu truoc khi bat dau.</p>
                <a href="{{ route('vocabulary.words', $set) }}"
                    class="mt-3 inline-flex rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700">
                    Them tu ngay
                </a>
            </div>
        @elseif ($completed)
            <div class="rounded-xl border bg-white p-8 text-center shadow-sm">
                <h3 class="text-2xl font-bold text-gray-900">Hoan thanh phien hoc</h3>
                <p class="mt-2 text-gray-600">Ban da hoc {{ $total }} tu trong bo nay.</p>
                <div class="mx-auto mt-5 grid max-w-md grid-cols-2 gap-3 text-sm">
                    <div class="rounded-md bg-red-50 p-3 text-red-700">Again: {{ $ratingSummary['again'] }}</div>
                    <div class="rounded-md bg-amber-50 p-3 text-amber-700">Hard: {{ $ratingSummary['hard'] }}</div>
                    <div class="rounded-md bg-emerald-50 p-3 text-emerald-700">Good: {{ $ratingSummary['good'] }}</div>
                    <div class="rounded-md bg-blue-50 p-3 text-blue-700">Easy: {{ $ratingSummary['easy'] }}</div>
                </div>
                <div class="mt-6 flex justify-center gap-2">
                    <button wire:click="restartSession"
                        class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700">
                        Hoc lai bo nay
                    </button>
                    <a href="{{ route('dashboard') }}"
                        class="rounded-md border px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-50">
                        Ve dashboard
                    </a>
                </div>
            </div>
        @elseif ($currentProgress)
            <div class="mb-4 flex items-center justify-between text-sm text-gray-600">
                <span>Tu {{ $currentIndex + 1 }}/{{ $total }}</span>
                <span>Trang thai: <strong class="uppercase">{{ $currentProgress->status }}</strong></span>
            </div>

            <div class="rounded-2xl border bg-white p-8 shadow-sm">
                <div class="text-center">
                    <p class="text-3xl font-bold text-gray-900">{{ $currentProgress->vocabulary->word }}</p>
                    <p class="mt-1 text-sm text-gray-500">{{ $currentProgress->vocabulary->pronunciation ?: 'No pronunciation' }}</p>
                </div>

                @if ($showBack)
                    <div class="mt-6 rounded-xl bg-gray-50 p-5">
                        <p class="text-lg font-semibold text-indigo-700">{{ $currentProgress->vocabulary->meaning }}</p>
                        @if ($currentProgress->vocabulary->example)
                            <p class="mt-2 text-sm text-gray-600">Example: {{ $currentProgress->vocabulary->example }}</p>
                        @endif
                        @if ($currentProgress->vocabulary->collocation)
                            <p class="mt-1 text-sm text-gray-600">Collocation: {{ $currentProgress->vocabulary->collocation }}</p>
                        @endif
                        @if ($currentProgress->vocabulary->note)
                            <p class="mt-1 text-sm text-gray-600">Note: {{ $currentProgress->vocabulary->note }}</p>
                        @endif
                    </div>
                @endif

                <div class="mt-6">
                    <button wire:click="flipCard"
                        class="w-full rounded-md border px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-50">
                        {{ $showBack ? 'An mat sau' : 'Lat the' }}
                    </button>
                </div>

                <div class="mt-4 grid grid-cols-2 gap-2 sm:grid-cols-4">
                    <button wire:click="submitRating('again')" class="rounded-md bg-red-500 px-3 py-2 text-sm font-semibold text-white hover:bg-red-600">1 Again</button>
                    <button wire:click="submitRating('hard')" class="rounded-md bg-amber-500 px-3 py-2 text-sm font-semibold text-white hover:bg-amber-600">2 Hard</button>
                    <button wire:click="submitRating('good')" class="rounded-md bg-emerald-500 px-3 py-2 text-sm font-semibold text-white hover:bg-emerald-600">3 Good</button>
                    <button wire:click="submitRating('easy')" class="rounded-md bg-blue-500 px-3 py-2 text-sm font-semibold text-white hover:bg-blue-600">4 Easy</button>
                </div>
            </div>
        @endif
    </div>
</x-app-layout>

