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

    {{-- STATS SECTION --}}
    <section class="py-16 px-4">
        <div class="max-w-7xl mx-auto">
            <div class="glass rounded-3xl p-8 grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
                <div>
                    <p class="text-5xl font-bold text-gradient font-display">2,000+</p>
                    <p class="text-indigo-600 mt-2 font-medium">Học viên đang học</p>
                </div>
                <div class="md:border-x border-indigo-200">
                    <p class="text-5xl font-bold text-gradient font-display">10,000+</p>
                    <p class="text-indigo-600 mt-2 font-medium">Từ vựng trong hệ thống</p>
                </div>
                <div>
                    <p class="text-5xl font-bold text-gradient font-display">94%</p>
                    <p class="text-indigo-600 mt-2 font-medium">Tỷ lệ ghi nhớ dài hạn</p>
                </div>
            </div>
        </div>
    </section>

    {{-- FEATURES SECTION --}}
    <section id="features" class="py-20 px-4">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-16 space-y-4">
                <span class="text-sm font-bold text-indigo-500 uppercase tracking-widest">Tính năng nổi bật</span>
                <h2 class="text-4xl lg:text-5xl font-bold text-indigo-900 font-display">
                    Mọi thứ bạn cần để<br>
                    <span class="text-gradient">giỏi tiếng Anh</span>
                </h2>
                <p class="text-indigo-600 max-w-2xl mx-auto text-lg">
                    MinLish kết hợp khoa học ghi nhớ và trải nghiệm học tập thú vị để giúp bạn đạt kết quả tốt nhất.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach([
                    [
                        'title' => 'Spaced Repetition (SRS)',
                        'desc' => 'Thuật toán thông minh nhắc bạn ôn đúng lúc, đúng từ — giúp ghi nhớ lâu dài hơn 3 lần so với học thông thường.',
                        'color' => 'indigo',
                        'icon' => 'M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z',
                    ],
                    [
                        'title' => 'Bộ từ vựng cá nhân hoá',
                        'desc' => 'Tạo và quản lý bộ từ vựng theo chủ đề riêng. Nhập từ thủ công hoặc import từ file Excel.',
                        'color' => 'purple',
                        'icon' => 'M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10',
                    ],
                    [
                        'title' => 'Theo dõi tiến độ',
                        'desc' => 'Dashboard trực quan cho thấy số từ đã học, tỷ lệ nhớ, và streak hàng ngày. Nhìn thấy sự tiến bộ mỗi ngày.',
                        'color' => 'blue',
                        'icon' => 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z',
                    ],
                    [
                        'title' => 'Mục tiêu hàng ngày',
                        'desc' => 'Đặt mục tiêu học từng ngày. Nhắc nhở thông minh giúp bạn duy trì thói quen học đều đặn.',
                        'color' => 'green',
                        'icon' => 'M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z',
                    ],
                    [
                        'title' => 'Streak & Gamification',
                        'desc' => 'Duy trì streak liên tiếp để tạo động lực. Huy hiệu và phần thưởng khuyến khích bạn học đều mỗi ngày.',
                        'color' => 'orange',
                        'icon' => 'M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z M9.879 16.121A3 3 0 1012.015 11L11 14H9c0 .768.293 1.536.879 2.121z',
                    ],
                    [
                        'title' => 'Nhật ký học tập',
                        'desc' => 'Xem lại lịch sử học tập chi tiết. Phân tích điểm mạnh, yếu để tập trung vào những gì cần cải thiện.',
                        'color' => 'pink',
                        'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01',
                    ],
                ] as $feature)
                <div class="glass rounded-2xl p-6 hover:shadow-xl hover:-translate-y-1 transition-all duration-200 group">
                    <div class="w-12 h-12 rounded-xl bg-{{ $feature['color'] }}-100 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-200">
                        <svg class="w-6 h-6 text-{{ $feature['color'] }}-600" aria-hidden="true" focusable="false" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $feature['icon'] }}" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-indigo-900 mb-2 font-display">{{ $feature['title'] }}</h3>
                    <p class="text-indigo-600 text-sm leading-relaxed">{{ $feature['desc'] }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </section>

</body>
</html>
