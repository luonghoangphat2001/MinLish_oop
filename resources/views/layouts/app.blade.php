<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'MinLish') }} — Học từ vựng</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body class="font-sans antialiased bg-slate-50 text-slate-800" x-data="{ mobileSidebarOpen: false }">

    <div class="min-h-screen flex relative">
        {{-- Mobile Sidebar Overlay --}}
        <div x-show="mobileSidebarOpen" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="mobileSidebarOpen = false"
             class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-40 lg:hidden"></div>

        {{-- Sidebar --}}
        <aside :class="mobileSidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
               class="fixed inset-y-0 left-0 w-80 bg-white flex flex-col z-50 transform transition-transform duration-300 lg:relative lg:w-80 lg:z-auto shadow-xl lg:shadow-none border-r border-slate-100">
            
            <div class="px-8 py-8 border-b border-slate-50 flex items-center justify-between">
                <a href="{{ route('dashboard') }}" wire:navigate class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-indigo-600 flex items-center justify-center shadow-lg shadow-indigo-200">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <div>
                        <span class="text-[20px] font-black text-slate-900 tracking-tight uppercase leading-none block">MinLish</span>
                        <span class="block text-[10px] text-slate-400 font-black uppercase tracking-widest mt-1 tracking-tighter">Ecosystem</span>
                    </div>
                </a>
                <button @click="mobileSidebarOpen = false" class="lg:hidden p-2 text-slate-400 hover:text-indigo-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </div>

            <nav class="flex-1 px-4 py-8 space-y-2 overflow-y-auto">
                @php
                $navLinks = [
                    ['route' => 'dashboard','label' => 'Bảng điều khiển','icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />'],
                    ['route' => 'vocabulary.sets','label' => 'Quản lý bộ từ','icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />'],
                    ['route' => 'learning.daily-quiz','label' => 'Daily Quiz','icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 10h.01M12 10h.01M16 10h.01M9 16h6M7 4h10a3 3 0 013 3v10a3 3 0 01-3 3H7a3 3 0 01-3-3V7a3 3 0 013-3z" />'],
                    ['route' => 'profile','label' => 'Hồ sơ cá nhân','icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />'],
                ];
                @endphp

                @foreach($navLinks as $link)
                    @php $active = request()->routeIs($link['route']); @endphp
                    <a href="{{ route($link['route']) }}" wire:navigate @click="mobileSidebarOpen = false"
                       class="flex items-center gap-4 px-6 py-4 rounded-[16px] text-[14px] font-black transition-all {{ $active ? 'bg-indigo-600 text-white shadow-xl shadow-indigo-600/20' : 'text-slate-500 hover:bg-slate-50 hover:text-indigo-700' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor">{!! $link['icon'] !!}</svg>
                        <span class="tracking-widest uppercase">{{ $link['label'] }}</span>
                    </a>
                @endforeach
            </nav>

            <div class="px-4 py-8 border-t border-slate-100">
                <div class="flex items-center gap-4 px-4 py-4 rounded-[20px] bg-slate-50 border border-slate-100">
                    <div class="w-10 h-10 rounded-xl bg-indigo-600 flex items-center justify-center text-white font-black shadow-sm">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <div class="flex-1 overflow-hidden">
                        <p class="text-[13px] font-black uppercase truncate">{{ auth()->user()->name }}</p>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="text-[10px] text-slate-400 hover:text-red-500 font-black uppercase tracking-widest">Đăng xuất</button>
                        </form>
                    </div>
                </div>
            </div>
        </aside>

        {{-- Main Content --}}
        <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
            <header class="sticky top-0 z-30 bg-white/80 backdrop-blur-md border-b border-slate-100 px-4 sm:px-8 py-4">
                <div class="flex items-center justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <button @click="mobileSidebarOpen = true" class="lg:hidden p-2 -ml-2 text-slate-500 hover:text-indigo-600">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" /></svg>
                        </button>
                        <span class="lg:hidden font-black text-indigo-600 text-xl uppercase tracking-tighter">MinLish</span>
                        <h2 class="hidden lg:block text-[11px] font-black text-slate-400 uppercase tracking-[0.2em]">@yield('title', 'Hệ sinh thái học tập')</h2>
                    </div>

                    <div class="flex items-center gap-3">
                        <button @click="$dispatch('open-search-modal')"
                            class="group flex items-center justify-center sm:justify-start gap-3 p-2.5 sm:px-4 sm:py-3 rounded-xl bg-slate-50 hover:bg-white border border-slate-100 hover:border-indigo-100 transition-all duration-300">
                            <span class="text-indigo-500">🔍</span>
                            <span class="hidden sm:inline text-[13px] font-black text-slate-400 group-hover:text-indigo-600 uppercase tracking-tight">Tìm kiếm...</span>
                        </button>

                        <livewire:dashboard.notification-bell />
                    </div>
                </div>
            </header>

            <main class="flex-1 overflow-y-auto p-4 sm:p-8">
                {{ $slot }}
            </main>
        </div>
    </div>

    <livewire:global-search />

</body>

</html>