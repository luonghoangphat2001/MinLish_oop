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

<body class="font-sans antialiased bg-[#EEF2FF] text-slate-800">

<div class="min-h-screen flex">

    {{-- SIDEBAR --}}
    <aside class="w-96 bg-white flex flex-col flex-shrink-0 hidden lg:flex shadow-sm border-r border-slate-100">

        <div class="px-6 py-6 border-b border-slate-50">

            {{-- 🔍 SEARCH BUTTON (FIX PR WARNING) --}}
            <div class="pb-4">
                <button 
                    wire:click="$set('showResults', true)"
                    class="w-full flex items-center gap-3 px-4 py-3 rounded-xl bg-indigo-50 hover:bg-indigo-100 text-indigo-700 text-sm font-bold transition"
                    aria-label="Open search"
                >
                    🔍 Tìm kiếm
                    <span class="ml-auto text-xs bg-white px-2 py-0.5 rounded border text-slate-400">
                        Ctrl K
                    </span>
                </button>
            </div>

            {{-- LOGO --}}
            <a href="{{ route('dashboard') }}" wire:navigate class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-indigo-600 flex items-center justify-center shadow-lg shadow-indigo-200">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                              d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                </div>
                <div>
                    <span class="text-xl font-black text-slate-900 tracking-tight uppercase">MinLish</span>
                    <span class="block text-[10px] text-slate-400 font-black uppercase tracking-widest">ECOSYSTEM</span>
                </div>
            </a>
        </div>

        {{-- NAV --}}
        <nav class="flex-1 px-4 py-8 space-y-2">
            @php
                $navLinks = [
                    ['route' => 'dashboard','label' => 'BẢNG ĐIỀU KHIỂN','icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>'],
                    ['route' => 'vocabulary.sets','label' => 'QUẢN LÝ BỘ TỪ','icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>'],
                    ['route' => 'profile','label' => 'HỒ SƠ CÁ NHÂN','icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>'],
                ];
            @endphp

            @foreach($navLinks as $link)
                @php $active = request()->routeIs($link['route']); @endphp
                <a href="{{ route($link['route']) }}" wire:navigate
                   class="flex items-center gap-4 px-5 py-4 rounded-2xl text-[13px] font-black transition-all
                   {{ $active ? 'bg-indigo-600 text-white shadow-xl shadow-indigo-200' : 'text-slate-500 hover:bg-indigo-50 hover:text-indigo-700' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor">{!! $link['icon'] !!}</svg>
                    <span class="tracking-widest">{{ $link['label'] }}</span>
                </a>
            @endforeach
        </nav>

        {{-- USER --}}
        <div class="px-4 py-6 border-t border-slate-100">
            <div class="flex items-center gap-4 px-4 py-4 rounded-3xl bg-slate-50 border">
                <div class="w-10 h-10 rounded-2xl bg-indigo-600 flex items-center justify-center text-white font-black">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <div class="flex-1">
                    <p class="text-sm font-black uppercase">{{ auth()->user()->name }}</p>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="text-xs text-slate-400 hover:text-red-500 uppercase">
                            Đăng xuất
                        </button>
                    </form>
                </div>
            </div>
        </div>

    </aside>

    {{-- MAIN --}}
    <div class="flex-1 flex flex-col">

        {{-- MOBILE HEADER --}}
        <header class="lg:hidden bg-white border-b px-6 py-4 flex justify-between">

            <span class="font-black">MinLish</span>

            {{-- 🔍 MOBILE SEARCH --}}
            <button 
                wire:click="$set('showResults', true)"
                class="px-3 py-2 bg-indigo-100 text-indigo-700 rounded"
                aria-label="Open search"
            >
                🔍
            </button>

        </header>

        {{-- CONTENT --}}
        <main class="flex-1 overflow-y-auto p-6">
            {{ $slot }}
        </main>

    </div>

</div>

{{-- GLOBAL SEARCH --}}
<livewire:global-search />

</body>
</html>
