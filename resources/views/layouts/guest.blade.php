<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'MinLish') }}</title>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-slate-800 antialiased h-full">
        <div class="min-h-screen flex flex-col sm:justify-center items-center py-12 px-6
                    bg-gradient-to-br from-indigo-600 via-indigo-700 to-violet-800">

            {{-- Brand logo --}}
            <div class="mb-10 text-center">
                <a href="/" wire:navigate class="flex items-center gap-4 justify-center">
                    <div class="w-16 h-16 rounded-[24px] bg-white flex items-center justify-center shadow-2xl border-4 border-white/20 active:scale-95 transition-transform">
                        <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                    <div class="text-left">
                        <h1 class="text-4xl font-black text-white tracking-tighter uppercase leading-none">MinLish</h1>
                        <p class="text-[10px] font-black text-indigo-200 tracking-[0.2em] uppercase mt-1">Learning Ecosystem</p>
                    </div>
                </a>
            </div>

            {{-- Card --}}
            <div class="w-full sm:max-w-md bg-white rounded-[40px] shadow-2xl border border-white/10 p-10 relative overflow-hidden">
                {{-- Trang trí --}}
                <div class="absolute -top-12 -right-12 w-32 h-32 bg-indigo-50 rounded-full opacity-50"></div>
                <div class="absolute -bottom-12 -left-12 w-24 h-24 bg-violet-50 rounded-full opacity-50"></div>

                <div class="relative z-10">
                    {{ $slot }}
                </div>
            </div>

            {{-- Footer --}}
            <div class="mt-8 text-indigo-200 text-sm font-bold uppercase tracking-widest opacity-60">
                &copy; {{ date('Y') }} MinLish Team. All rights reserved.
            </div>
        </div>
    </body>
</html>
