@if ($paginator->hasPages())
<nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="flex items-center justify-center gap-6 py-12">

    {{-- Previous Page Link --}}
    @if ($paginator->onFirstPage())
    <span class="inline-flex items-center justify-center w-8 h-8 rounded-full text-indigo-200 bg-white/10 border border-white/20 cursor-not-allowed transition-all duration-500 shadow-sm backdrop-blur-md">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7" />
        </svg>
    </span>
    @else
    <a href="{{ $paginator->previousPageUrl() }}" rel="prev" wire:click.prevent="previousPage"
        class="inline-flex items-center justify-center w-8 h-8 rounded-full text-indigo-500 bg-white/60 border border-white/80 hover:bg-indigo-600 hover:text-white hover:scale-125 hover:-translate-y-2 hover:shadow-[0_20px_40px_rgba(79,70,229,0.3)] transition-all duration-500 backdrop-blur-md active:scale-95 group">
        <svg class="w-6 h-6 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7" />
        </svg>
    </a>
    @endif

    {{-- Pagination Elements --}}
    <div class="flex items-center gap-3 p-2 bg-white/20 backdrop-blur-2xl border border-white/30 rounded-[30px] shadow-[0_30px_60px_rgba(0,0,0,0.03)] hover:shadow-[0_40px_80px_rgba(0,0,0,0.05)] transition-all duration-700">
        @foreach ($elements as $element)
        {{-- "Three Dots" Separator --}}
        @if (is_string($element))
        <span class="inline-flex items-center justify-center w-6 h-6 text-indigo-300 font-black tracking-widest select-none cursor-default">{{ $element }}</span>
        @endif

        {{-- Array Of Links --}}
        @if (is_array($element))
        @foreach ($element as $page => $url)
        @if ($page == $paginator->currentPage())
        <span aria-current="page"
            class="inline-flex items-center justify-center w-8 h-8 rounded-full text-white font-black text-lg bg-indigo-600 shadow-[0_15px_30px_rgba(79,70,229,0.4)] ring-4 ring-indigo-600/10 cursor-default select-none transition-all duration-500">
            {{ $page }}
        </span>
        @else
        <a href="{{ $url }}" wire:click.prevent="gotoPage({{ $page }})"
            class="inline-flex items-center justify-center w-6 h-6 rounded-2xl text-indigo-900/40 font-black text-base hover:bg-white hover:text-indigo-600 hover:scale-110 hover:shadow-xl transition-all duration-300 active:scale-90">
            {{ $page }}
        </a>
        @endif
        @endforeach
        @endif
        @endforeach
    </div>

    {{-- Next Page Link --}}
    @if ($paginator->hasMorePages())
    <a href="{{ $paginator->nextPageUrl() }}" rel="next" wire:click.prevent="nextPage"
        class="inline-flex items-center justify-center w-8 h-8 rounded-full text-indigo-500 bg-white/60 border border-white/80 hover:bg-indigo-600 hover:text-white hover:scale-125 hover:-translate-y-2 hover:shadow-[0_20px_40px_rgba(79,70,229,0.3)] transition-all duration-500 backdrop-blur-md active:scale-95 group shadow-lg">
        <svg class="w-6 h-6 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7" />
        </svg>
    </a>
    @else
    <span class="inline-flex items-center justify-center w-8 h-8 rounded-full text-indigo-200 bg-white/10 border border-white/20 cursor-not-allowed transition-all duration-500 shadow-sm backdrop-blur-md">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7" />
        </svg>
    </span>
    @endif

</nav>
@endif