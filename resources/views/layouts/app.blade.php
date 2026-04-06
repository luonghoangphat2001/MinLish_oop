<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-gray-50">
        <div class="min-h-screen flex">
            {{-- Sidebar --}}
            <aside class="w-64 bg-white border-r border-gray-200 flex flex-col flex-shrink-0 hidden lg:flex">
                {{-- Logo --}}
                <div class="px-6 py-5 border-b border-gray-100">
                    <a href="{{ route('dashboard') }}" wire:navigate class="flex items-center gap-2 mr-4">
                        <span class="text-xl font-bold text-indigo-600">MinLish</span>
                        <span class="text-xs text-gray-400 font-medium">Learn Vocab</span>
                    </a>
                    @livewire('global-search')
                </div>

                {{-- Nav --}}
                <nav class="flex-1 px-4 py-4 space-y-1">
                    <a href="{{ route('dashboard') }}" wire:navigate
                        class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                        Dashboard
                    </a>

                    <a href="{{ route('profile') }}" wire:navigate
                        class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        Hồ sơ
                    </a>

                    <a href="{{ route('vocabulary.sets') }}" wire:navigate
                        class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                        Bộ từ vựng
                    </a>
                </nav>

                {{-- User + Logout --}}
                <div class="px-4 py-4 border-t border-gray-100">
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600 truncate">{{ auth()->user()->name }}</span>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-xs text-gray-400 hover:text-red-500 transition-colors cursor-pointer">
                                Đăng xuất
                            </button>
                        </form>
                    </div>
                </div>
            </aside>

            {{-- Main content --}}
            <div class="flex-1 flex flex-col min-w-0">
                {{-- Top bar for mobile --}}
                <div class="lg:hidden bg-white border-b border-gray-200 px-4 py-3 flex items-center justify-between">
                    <span class="text-lg font-bold text-indigo-600">MinLish</span>
                    <livewire:layout.navigation />
                </div>

                {{-- Page Heading --}}
                @if (isset($header))
                    <header class="bg-white shadow-sm">
                        <div class="px-6 py-4">
                            {{ $header }}
                        </div>
                    </header>
                @endif

                {{-- Page Content --}}
                <main class="flex-1 p-6">
                    {{ $slot }}
                </main>
            </div>
        </div>
    </body>
</html>
