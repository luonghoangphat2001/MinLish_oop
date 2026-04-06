<div class="max-w-2xl mx-auto p-4 sm:p-6">
    @if($isFinished)
        <div class="bg-white rounded-2xl shadow-xl p-8 text-center space-y-8 border border-gray-100">
            <div>
                <h2 class="text-3xl font-extrabold text-gray-800">Hoàn thành phiên học! 🎉</h2>
                <p class="text-gray-500 mt-2">Tuyệt vời! Bạn đã hoàn thành mục tiêu học tập.</p>
            </div>

            <div class="grid grid-cols-2 gap-4 text-left">
                <div class="bg-blue-50/50 p-5 rounded-xl border border-blue-100">
                    <p class="text-sm font-medium text-gray-500 mb-1">Số từ đã học</p>
                    <p class="text-3xl font-bold text-blue-600">{{ count($queueIds) }} <span class="text-lg font-medium text-blue-400">từ</span></p>
                </div>
                <div class="bg-emerald-50/50 p-5 rounded-xl border border-emerald-100">
                    <p class="text-sm font-medium text-gray-500 mb-1">Thời gian học</p>
                    <p class="text-3xl font-bold text-emerald-600">
                        {{ floor((time() - $sessionStartTime) / 60) }}<span class="text-lg font-medium text-emerald-400">p</span> 
                        {{ (time() - $sessionStartTime) % 60 }}<span class="text-lg font-medium text-emerald-400">s</span>
                    </p>
                </div>
            </div>

            <div class="bg-gray-50 p-5 rounded-xl border border-gray-200">
                <h3 class="text-sm font-semibold mb-3 text-gray-600 text-left uppercase tracking-wider">Phân bổ đánh giá</h3>
                <div class="flex justify-between space-x-2">
                    <div class="flex-1 bg-red-100 py-3 rounded-lg text-red-700 font-bold">Lại: {{ $ratingStats['again'] }}</div>
                    <div class="flex-1 bg-orange-100 py-3 rounded-lg text-orange-700 font-bold">Khó: {{ $ratingStats['hard'] }}</div>
                    <div class="flex-1 bg-blue-100 py-3 rounded-lg text-blue-700 font-bold">Tốt: {{ $ratingStats['good'] }}</div>
                    <div class="flex-1 bg-green-100 py-3 rounded-lg text-green-700 font-bold">Dễ: {{ $ratingStats['easy'] }}</div>
                </div>
            </div>

            <div class="inline-flex items-center space-x-2 bg-gradient-to-r from-amber-100 to-yellow-100 text-amber-800 px-6 py-2 rounded-full font-bold shadow-sm border border-amber-200">
                <span>🔥 Streak: Đang cập nhật (T22)</span>
            </div>

            <div class="flex flex-col sm:flex-row justify-center gap-4 pt-4">
                <button wire:click="learnMore" class="px-8 py-3 bg-indigo-600 text-white font-semibold rounded-xl hover:bg-indigo-700 transition shadow-lg shadow-indigo-200 w-full sm:w-auto">
                    Học thêm
                </button>
                <a href="{{ route('dashboard') ?? '/' }}" class="px-8 py-3 bg-white text-gray-700 font-semibold rounded-xl border border-gray-300 hover:bg-gray-50 transition text-center w-full sm:w-auto">
                    Xong hôm nay
                </a>
            </div>
        </div>
    @else
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-xl font-bold text-gray-800">MinLish Learning</h1>
            <div class="text-sm font-semibold text-indigo-600 bg-indigo-50 px-4 py-1 rounded-full">
                Từ {{ $currentIndex + 1 }} / {{ count($queueIds) }}
            </div>
        </div>

        @if($this->currentWord)
            <div x-data="{ flipped: false }" class="space-y-8">
                <div 
                    @click="flipped = !flipped" 
                    class="relative w-full h-96 cursor-pointer"
                    style="perspective: 1000px;"
                >
                    <div 
                        class="absolute inset-0 bg-white rounded-3xl shadow-lg border border-gray-100 flex flex-col items-center justify-center transition-all duration-300"
                        x-show="!flipped"
                        x-transition:enter="transition ease-out duration-300 transform"
                        x-transition:enter-start="opacity-0 translate-y-4"
                        x-transition:enter-end="opacity-100 translate-y-0"
                    >
                        <h2 class="text-6xl font-bold text-gray-800 tracking-tight">{{ $this->currentWord->word }}</h2>
                        <span class="absolute bottom-6 text-gray-400 text-sm animate-pulse">Chạm để xem nghĩa</span>
                    </div>

                    <div 
                        class="absolute inset-0 bg-indigo-50 rounded-3xl shadow-lg border-2 border-indigo-100 flex flex-col items-center justify-center p-8 transition-all duration-300 text-center"
                        x-show="flipped"
                        style="display: none;"
                        x-transition:enter="transition ease-out duration-300 transform"
                        x-transition:enter-start="opacity-0 -translate-y-4"
                        x-transition:enter-end="opacity-100 translate-y-0"
                    >
                        <h3 class="text-4xl font-bold text-indigo-900 mb-4">{{ $this->currentWord->meaning ?? 'Nghĩa của từ' }}</h3>
                        
                        @if($this->currentWord->pronunciation)
                            <p class="text-lg text-indigo-500 font-mono mb-6">/{{ $this->currentWord->pronunciation }}/</p>
                        @endif
                        
                        @if($this->currentWord->example)
                            <p class="text-gray-600 italic text-lg bg-white/60 p-4 rounded-xl border border-indigo-50">
                                "{{ $this->currentWord->example }}"
                            </p>
                        @endif
                    </div>
                </div>

                <div 
                    class="grid grid-cols-2 sm:grid-cols-4 gap-3" 
                    x-show="flipped" 
                    style="display: none;"
                    x-transition:enter="transition ease-out duration-500 delay-150"
                    x-transition:enter-start="opacity-0 translate-y-2"
                    x-transition:enter-end="opacity-100 translate-y-0"
                >
                    <button @click="flipped = false; $wire.submitRating('again')" class="py-4 bg-red-50 text-red-700 border border-red-200 rounded-2xl font-bold hover:bg-red-100 transition shadow-sm">
                        Lại (Again)
                    </button>
                    <button @click="flipped = false; $wire.submitRating('hard')" class="py-4 bg-orange-50 text-orange-700 border border-orange-200 rounded-2xl font-bold hover:bg-orange-100 transition shadow-sm">
                        Khó (Hard)
                    </button>
                    <button @click="flipped = false; $wire.submitRating('good')" class="py-4 bg-blue-50 text-blue-700 border border-blue-200 rounded-2xl font-bold hover:bg-blue-100 transition shadow-sm">
                        Tốt (Good)
                    </button>
                    <button @click="flipped = false; $wire.submitRating('easy')" class="py-4 bg-green-50 text-green-700 border border-green-200 rounded-2xl font-bold hover:bg-green-100 transition shadow-sm">
                        Dễ (Easy)
                    </button>
                </div>
            </div>
        @else
            <div class="text-center p-8 text-gray-500 bg-white rounded-2xl shadow">
                Không tìm thấy từ vựng nào trong danh sách.
            </div>
        @endif
    @endif
</div>