<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard hoc tap
            </h2>
            <a href="{{ route('vocabulary.sets') }}"
                class="inline-flex items-center rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700">
                Quan ly bo tu
            </a>
        </div>
    </x-slot>

    <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-4">
        <div class="rounded-xl border bg-white p-5 shadow-sm">
            <p class="text-sm text-gray-500">Tong so tu</p>
            <p class="mt-2 text-3xl font-bold text-gray-900">{{ $totalWords }}</p>
        </div>
        <div class="rounded-xl border bg-white p-5 shadow-sm">
            <p class="text-sm text-gray-500">Da hoc hom nay</p>
            <p class="mt-2 text-3xl font-bold text-gray-900">{{ $todayStudied }}</p>
        </div>
        <div class="rounded-xl border bg-white p-5 shadow-sm">
            <p class="text-sm text-gray-500">Can on tap ngay</p>
            <p class="mt-2 text-3xl font-bold text-amber-600">{{ $reviewDue }}</p>
        </div>
        <div class="rounded-xl border bg-white p-5 shadow-sm">
            <p class="text-sm text-gray-500">Streak hien tai</p>
            <p class="mt-2 text-3xl font-bold text-rose-600">{{ auth()->user()->streak_days ?? 0 }} ngay</p>
        </div>
    </div>

    <div class="mt-6 grid gap-6 lg:grid-cols-3">
        <div class="rounded-xl border bg-white p-5 shadow-sm lg:col-span-1">
            <h3 class="text-base font-semibold text-gray-900">Trang thai SRS</h3>
            <div class="mt-4 space-y-3 text-sm">
                <div class="flex items-center justify-between"><span class="text-gray-600">New</span><span class="font-semibold">{{ $statusCounts['new'] }}</span></div>
                <div class="flex items-center justify-between"><span class="text-gray-600">Learning</span><span class="font-semibold">{{ $statusCounts['learning'] }}</span></div>
                <div class="flex items-center justify-between"><span class="text-gray-600">Review</span><span class="font-semibold">{{ $statusCounts['review'] }}</span></div>
                <div class="flex items-center justify-between"><span class="text-gray-600">Mastered</span><span class="font-semibold">{{ $statusCounts['mastered'] }}</span></div>
            </div>
        </div>

        <div class="rounded-xl border bg-white p-5 shadow-sm lg:col-span-2">
            <div class="mb-4 flex items-center justify-between">
                <h3 class="text-base font-semibold text-gray-900">Bo tu gan day</h3>
                <span class="text-xs text-gray-500">Nhan vao bo tu de them tu hoac hoc flashcard</span>
            </div>

            @if ($recentSets->isEmpty())
                <div class="rounded-lg border border-dashed border-gray-300 p-6 text-center">
                    <p class="text-sm text-gray-600">Ban chua co bo tu nao. Tao bo tu mau o trang "Bo tu vung" de xem nhanh.</p>
                    <a href="{{ route('vocabulary.sets') }}"
                        class="mt-3 inline-flex items-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-medium text-white hover:bg-indigo-700">
                        Di toi trang bo tu
                    </a>
                </div>
            @else
                <div class="grid gap-3 md:grid-cols-2">
                    @foreach ($recentSets as $set)
                        <div class="rounded-lg border p-4">
                            <p class="font-semibold text-gray-900">{{ $set->name }}</p>
                            <p class="mt-1 text-xs text-gray-500">{{ $set->vocabularies_count }} tu</p>
                            <div class="mt-3 flex gap-2">
                                <a href="{{ route('vocabulary.words', $set) }}"
                                    class="rounded-md border px-3 py-1.5 text-xs font-medium text-gray-700 hover:bg-gray-50">
                                    Quan ly tu
                                </a>
                                <a href="{{ route('learning.flashcards', $set) }}"
                                    class="rounded-md bg-indigo-600 px-3 py-1.5 text-xs font-medium text-white hover:bg-indigo-700">
                                    Hoc flashcard
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-app-layout>

