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
    <nav class="fixed top-4 left-4 right-4 z-50 glass rounded-2xl px-6 py-3 flex items-center justify-between max-w-7xl mx-auto">
        {{-- Logo --}}
        <a href="/" class="flex items-center gap-2 cursor-pointer">
            <div class="w-8 h-8 rounded-lg bg-indigo-600 flex items-center justify-center">
                <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
            </div>
            <span class="text-xl font-bold text-indigo-900" style="font-family: 'Baloo 2', cursive;">MinLish</span>
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
                    <a href="{{ url('/dashboard') }}" class="text-indigo-600 hover:text-indigo-800 font-semibold transition-colors duration-200 cursor-pointer">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="text-indigo-600 hover:text-indigo-800 font-semibold transition-colors duration-200 cursor-pointer">Đăng nhập</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-4 py-2 rounded-xl transition-colors duration-200 cursor-pointer focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500 focus-visible:ring-offset-2">
                            Bắt đầu miễn phí
                        </a>
                    @endif
                @endauth
            @endif
        </div>
    </nav>

    {{-- PAGE CONTENT ADDED IN TASKS 3-6 --}}

</body>
</html>
