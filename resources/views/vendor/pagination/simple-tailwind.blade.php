@if ($paginator->hasPages())
<nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="flex items-center justify-between gap-4 py-4">
    {{-- Previous Page Link --}}
    @if ($paginator->onFirstPage())
    <span class="inline-flex items-center px-6 py-3.5 text-[12px] font-black text-slate-300 bg-white border border-slate-50 rounded-2xl cursor-not-allowed uppercase tracking-widest shadow-sm">
        ← {!! __('pagination.previous') !!}
    </span>
    @else
    <a href="{{ $paginator->previousPageUrl() }}" rel="prev" wire:click.prevent="previousPage"
        class="inline-flex items-center px-6 py-3.5 text-[12px] font-black text-indigo-900/70 bg-white/80 border border-white/60 rounded-2xl hover:bg-indigo-600 hover:text-white transition-all duration-300 shadow-xl shadow-indigo-100/50 active:scale-95 uppercase tracking-widest">
        ← {!! __('pagination.previous') !!}
    </a>
    @endif

    {{-- Next Page Link --}}
    @if ($paginator->hasMorePages())
    <a href="{{ $paginator->nextPageUrl() }}" rel="next" wire:click.prevent="nextPage"
        class="inline-flex items-center px-6 py-3.5 text-[12px] font-black text-indigo-900/70 bg-white/80 border border-white/60 rounded-2xl hover:bg-indigo-600 hover:text-white transition-all duration-300 shadow-xl shadow-indigo-100/50 active:scale-95 uppercase tracking-widest">
        {!! __('pagination.next') !!} →
    </a>
    @else
    <span class="inline-flex items-center px-6 py-3.5 text-[12px] font-black text-slate-300 bg-white border border-slate-50 rounded-2xl cursor-not-allowed uppercase tracking-widest shadow-sm">
        {!! __('pagination.next') !!} →
    </span>
    @endif
</nav>
@endif