<div class="space-y-6">
    <div class="rounded-xl border bg-white p-5 shadow-sm">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-2xl font-semibold text-gray-800">Daily Quiz</h2>
                <p class="text-sm text-gray-500">Quiz trộn ngẫu nhiên từ nhiều bộ từ vựng của bạn.</p>
            </div>
            <a href="{{ route('dashboard') }}" class="rounded-md border px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">
                Về dashboard
            </a>
        </div>
    </div>

    <div class="rounded-xl border bg-white p-5 shadow-sm">
        <div class="mb-2 flex items-center justify-between text-sm">
            <span class="text-gray-600">Tiến độ: {{ min($currentIndex + 1, $total) }}/{{ $total }}</span>
            <span class="font-semibold text-gray-800">{{ $progressPercent }}%</span>
        </div>
        <div class="h-2.5 w-full rounded-full bg-gray-100">
            <div class="h-2.5 rounded-full bg-indigo-600 transition-all" style="width: {{ $progressPercent }}%"></div>
        </div>
    </div>

    @if ($total === 0)
        <div class="rounded-xl border border-dashed border-gray-300 bg-white p-8 text-center shadow-sm">
            <p class="text-gray-600">Bạn chưa có từ để tạo Daily Quiz. Hãy thêm từ vào bộ từ trước.</p>
            <a href="{{ route('vocabulary.sets') }}" class="mt-3 inline-flex rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700">
                Đi tới bộ từ
            </a>
        </div>
    @elseif ($completed)
        <div class="rounded-xl border bg-white p-8 shadow-sm">
            <h3 class="text-xl font-bold text-gray-900">Hoàn thành Daily Quiz</h3>
            <p class="mt-1 text-sm text-gray-600">Kết quả đã được tính vào hoạt động học hôm nay và streak của bạn.</p>

            <div class="mt-4 grid gap-3 sm:grid-cols-2">
                <div class="rounded-md bg-emerald-50 p-4">
                    <p class="text-sm text-emerald-700">Đúng</p>
                    <p class="text-2xl font-bold text-emerald-700">{{ $correctCount }}</p>
                </div>
                <div class="rounded-md bg-red-50 p-4">
                    <p class="text-sm text-red-700">Sai</p>
                    <p class="text-2xl font-bold text-red-700">{{ $wrongCount }}</p>
                </div>
            </div>

            <div class="mt-6 overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-3 py-2 text-left font-semibold text-gray-600">Từ</th>
                            <th class="px-3 py-2 text-left font-semibold text-gray-600">Bộ từ</th>
                            <th class="px-3 py-2 text-left font-semibold text-gray-600">Đáp án của bạn</th>
                            <th class="px-3 py-2 text-left font-semibold text-gray-600">Đáp án đúng</th>
                            <th class="px-3 py-2 text-left font-semibold text-gray-600">Kết quả</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach ($results as $item)
                            <tr>
                                <td class="px-3 py-2 font-medium text-gray-900">{{ $item['word'] }}</td>
                                <td class="px-3 py-2 text-gray-600">{{ $item['set'] }}</td>
                                <td class="px-3 py-2 text-gray-700">{{ $item['answer'] }}</td>
                                <td class="px-3 py-2 text-gray-700">{{ $item['meaning'] }}</td>
                                <td class="px-3 py-2">
                                    @if ($item['is_correct'])
                                        <span class="rounded-full bg-emerald-50 px-2 py-1 text-xs font-semibold text-emerald-700">Đúng</span>
                                    @else
                                        <span class="rounded-full bg-red-50 px-2 py-1 text-xs font-semibold text-red-700">Sai</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-5 flex flex-wrap gap-2">
                <button wire:click="restart" class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700">
                    Làm lại Daily Quiz
                </button>
                <a href="{{ route('vocabulary.sets') }}" class="rounded-md border px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-50">
                    Quản lý bộ từ
                </a>
            </div>
        </div>
    @else
        <div class="rounded-xl border bg-white p-8 shadow-sm">
            @php
                $word = $currentWord;
            @endphp

            @if ($word)
                <div class="mb-4 text-sm text-gray-600">
                    Bộ từ: <span class="font-semibold text-gray-800">{{ $word->set?->name }}</span>
                </div>

                <div class="rounded-lg border bg-gray-50 p-5 text-center">
                    <p class="text-xs uppercase tracking-wide text-gray-500">Từ cần dịch nghĩa</p>
                    <p class="mt-2 text-3xl font-bold text-gray-900">{{ $word->word }}</p>
                    @if ($word->pronunciation)
                        <p class="mt-1 text-sm text-gray-500">{{ $word->pronunciation }}</p>
                    @endif
                </div>

                <form wire:submit.prevent="submitAnswer" class="mt-5 space-y-3">
                    <label for="answer" class="block text-sm font-medium text-gray-700">Nhập đáp án của bạn</label>
                    <input
                        id="answer"
                        wire:model.defer="answer"
                        type="text"
                        placeholder="Ví dụ: nước"
                        class="w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        autocomplete="off"
                    >
                    @error('answer') <p class="text-xs text-red-600">{{ $message }}</p> @enderror

                    @if ($lastCorrect !== null)
                        @if ($lastCorrect)
                            <div class="rounded-md bg-emerald-50 px-3 py-2 text-sm text-emerald-700">Câu trước: Chính xác.</div>
                        @else
                            <div class="rounded-md bg-red-50 px-3 py-2 text-sm text-red-700">Câu trước: Chưa đúng, đã ghi nhận để luyện lại.</div>
                        @endif
                    @endif

                    <div class="flex gap-2">
                        <button type="submit" class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700">
                            Xác nhận
                        </button>
                    </div>
                </form>
            @endif
        </div>
    @endif
</div>
