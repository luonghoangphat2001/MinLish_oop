<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MinLish — Học tiếng Anh hiệu quả</title>
    <meta name="description" content="MinLish giúp bạn học từ vựng tiếng Anh hiệu quả với phương pháp SRS (Spaced Repetition System). Học thông minh, nhớ lâu hơn.">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased font-sans gradient-bg min-h-screen overflow-x-hidden">

    {{-- NAVBAR --}}
    <nav aria-label="Primary" class="fixed top-4 left-0 right-0 z-50 px-4">
        <div class="glass rounded-2xl px-6 py-3 flex items-center justify-between max-w-7xl mx-auto">
        {{-- Logo --}}
        <a href="/" class="flex items-center gap-2 cursor-pointer">
            <div class="w-8 h-8 rounded-lg bg-indigo-600 flex items-center justify-center">
                <svg class="w-5 h-5 text-white" aria-hidden="true" focusable="false" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
            </div>
            <span class="text-xl font-bold text-indigo-900 font-display">MinLish</span>
        </a>

        {{-- Nav links (desktop) --}}
        <div class="hidden md:flex items-center gap-6">
            <a href="#features" class="text-indigo-700 hover:text-indigo-900 font-medium transition-colors duration-200 cursor-pointer">Tính năng</a>
            <a href="#how-it-works" class="text-indigo-700 hover:text-indigo-900 font-medium transition-colors duration-200 cursor-pointer">Cách học</a>
            <a href="#testimonials" class="text-indigo-700 hover:text-indigo-900 font-medium transition-colors duration-200 cursor-pointer">Đánh giá</a>
        </div>

        {{-- CTA buttons --}}
        <div class="flex items-center gap-3">
            @if (Route::has('login'))
                @auth
                    <a href="{{ route('dashboard') }}" class="text-indigo-600 hover:text-indigo-800 font-semibold transition-colors duration-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500 focus-visible:ring-offset-2 rounded">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="text-indigo-600 hover:text-indigo-800 font-semibold transition-colors duration-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500 focus-visible:ring-offset-2 rounded">Đăng nhập</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-4 py-2 rounded-xl transition-colors duration-200 cursor-pointer focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500 focus-visible:ring-offset-2">
                            Bắt đầu miễn phí
                        </a>
                    @endif
                @endauth
            @endif
        </div>
        </div>
    </nav>

    {{-- TODO: Add mobile navigation menu (requires Alpine.js or JS) --}}

    {{-- HERO SECTION --}}
    <section class="relative min-h-screen flex items-center pt-28 pb-16 px-4 overflow-hidden">
        {{-- Background decorative blobs --}}
        <div class="absolute top-20 -left-32 w-96 h-96 bg-indigo-400/20 rounded-full blur-3xl pointer-events-none" aria-hidden="true"></div>
        <div class="absolute bottom-20 -right-32 w-96 h-96 bg-purple-400/20 rounded-full blur-3xl pointer-events-none" aria-hidden="true"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-blue-300/10 rounded-full blur-3xl pointer-events-none" aria-hidden="true"></div>

        <div class="relative max-w-7xl mx-auto w-full grid lg:grid-cols-2 gap-12 items-center">
            {{-- Left: Text content --}}
            <div class="space-y-8">
                {{-- Badge --}}
                <div class="inline-flex items-center gap-2 glass px-4 py-2 rounded-full">
                    <span class="w-2 h-2 bg-green-500 rounded-full" aria-hidden="true"></span>
                    <span class="text-sm font-semibold text-indigo-700">Phương pháp SRS đã được kiểm chứng</span>
                </div>

                {{-- Headline --}}
                <h1 class="text-5xl lg:text-6xl font-bold leading-tight font-display">
                    Học tiếng Anh<br>
                    <span class="text-gradient">hiệu quả hơn</span><br>
                    mỗi ngày
                </h1>

                {{-- Subtext --}}
                <p class="text-lg text-indigo-700 leading-relaxed max-w-lg">
                    MinLish sử dụng thuật toán <strong>Spaced Repetition</strong> giúp bạn ghi nhớ từ vựng lâu dài hơn 3x. Học đúng lúc, nhớ mãi mãi.
                </p>

                {{-- CTA buttons --}}
                <div class="flex flex-wrap gap-4">
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}"
                           class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white font-bold px-8 py-4 rounded-2xl text-lg transition-colors duration-200 shadow-lg shadow-indigo-500/30 focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500 focus-visible:ring-offset-2">
                            <svg class="w-5 h-5" aria-hidden="true" focusable="false" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                            Bắt đầu miễn phí
                        </a>
                    @endif
                    <a href="#how-it-works"
                       class="inline-flex items-center gap-2 glass hover:bg-white/80 text-indigo-700 font-bold px-8 py-4 rounded-2xl text-lg transition-colors duration-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500 focus-visible:ring-offset-2">
                        <svg class="w-5 h-5" aria-hidden="true" focusable="false" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Xem cách học
                    </a>
                </div>

                {{-- Trust signals --}}
                <div class="flex items-center gap-4 pt-4">
                    <div class="flex -space-x-2" aria-hidden="true">
                        @foreach(['bg-indigo-400', 'bg-purple-400', 'bg-blue-400', 'bg-green-400'] as $color)
                        <div class="w-9 h-9 rounded-full {{ $color }} border-2 border-white flex items-center justify-center">
                            <svg class="w-4 h-4 text-white" aria-hidden="true" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8v2.4h19.2v-2.4c0-3.2-6.4-4.8-9.6-4.8z"/>
                            </svg>
                        </div>
                        @endforeach
                    </div>
                    <p class="text-sm text-indigo-600 font-medium">
                        <strong class="text-indigo-900">2,000+</strong> học viên đang học cùng MinLish
                    </p>
                </div>
            </div>

            {{-- Right: Vocabulary preview card --}}
            <div class="relative hidden lg:block">
                {{-- Main card --}}
                <div class="glass rounded-3xl p-6 max-w-sm mx-auto">
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-sm font-semibold text-indigo-700">Từ vựng hôm nay</span>
                        <span class="text-xs bg-green-100 text-green-700 px-2 py-1 rounded-full font-medium">12 từ</span>
                    </div>
                    <div class="space-y-3">
                        @foreach([
                            ['word' => 'Perseverance', 'meaning' => 'Sự kiên trì', 'level' => 4, 'color' => 'green'],
                            ['word' => 'Eloquent', 'meaning' => 'Hùng hồn, lưu loát', 'level' => 3, 'color' => 'blue'],
                            ['word' => 'Meticulous', 'meaning' => 'Tỉ mỉ, cẩn thận', 'level' => 2, 'color' => 'yellow'],
                        ] as $item)
                        <div class="flex items-center justify-between bg-white/60 rounded-xl px-4 py-3">
                            <div>
                                <p class="font-bold text-indigo-900 text-sm">{{ $item['word'] }}</p>
                                <p class="text-xs text-indigo-500">{{ $item['meaning'] }}</p>
                            </div>
                            <div class="flex gap-1" aria-hidden="true">
                                @for($i = 1; $i <= 5; $i++)
                                <div class="w-2 h-2 rounded-full {{ $i <= $item['level'] ? 'bg-'.$item['color'].'-400' : 'bg-gray-200' }}"></div>
                                @endfor
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="mt-4 pt-4 border-t border-indigo-100">
                        <div class="flex items-center justify-between">
                            <span class="text-xs text-indigo-500">Tiến độ hôm nay</span>
                            <span class="text-xs font-bold text-indigo-700">8/12 từ</span>
                        </div>
                        <div class="mt-2 bg-indigo-100 rounded-full h-2" role="progressbar" aria-valuenow="66" aria-valuemin="0" aria-valuemax="100" aria-label="Tiến độ hôm nay 66%">
                            <div class="bg-indigo-500 h-2 rounded-full" style="width: 66%"></div>
                        </div>
                    </div>
                </div>

                {{-- Floating retention stat card --}}
                <div class="absolute -bottom-6 -left-6 glass rounded-2xl px-4 py-3 flex items-center gap-3" aria-hidden="true">
                    <div class="w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-indigo-500">Tỷ lệ ghi nhớ</p>
                        <p class="text-lg font-bold text-indigo-900">94%</p>
                    </div>
                </div>

                {{-- Floating streak card --}}
                <div class="absolute -top-4 -right-4 glass rounded-2xl px-4 py-3 flex items-center gap-2" aria-hidden="true">
                    <svg class="w-6 h-6 text-orange-500" aria-hidden="true" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M13.5 0.67s.74 2.65.74 4.8c0 2.06-1.35 3.73-3.41 3.73-2.07 0-3.63-1.67-3.63-3.73l.03-.36C5.21 7.51 4 10.62 4 14c0 4.42 3.58 8 8 8s8-3.58 8-8C20 8.61 17.41 3.8 13.5 0.67zM11.71 19c-1.78 0-3.22-1.4-3.22-3.14 0-1.62 1.05-2.76 2.81-3.12 1.77-.36 3.6-1.21 4.62-2.58.39 1.29.59 2.65.59 4.04 0 2.65-2.15 4.8-4.8 4.8z"/>
                    </svg>
                    <div>
                        <p class="text-xs text-indigo-500">Streak</p>
                        <p class="text-sm font-bold text-indigo-900">15 ngày</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

</body>
</html>
