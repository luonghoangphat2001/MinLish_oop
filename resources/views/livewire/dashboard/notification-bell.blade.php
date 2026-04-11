<div x-data="{ open: false }" class="relative perspective-1000">
    {{-- Bell Icon --}}
    <button @click="open = !open; if(open) $wire.$refresh()"
        class="relative p-2.5 rounded-2xl bg-white border border-slate-100 minlish-floating hover:shadow-xl hover:-translate-y-1 hover:bg-slate-50 transition-all duration-300 group focus:outline-none focus:ring-4 focus:ring-indigo-500/5">
        <svg class="w-6 h-6 text-slate-500 group-hover:text-indigo-600 group-hover:rotate-12 transition-all duration-300"
            fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
        </svg>

        @if($unreadCount > 0)
        <span class="absolute top-2 right-2 flex h-3 w-3">
            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-rose-400 opacity-75"></span>
            <span class="relative inline-flex rounded-full h-3 w-3 bg-rose-500 border-2 border-white shadow-sm"></span>
        </span>
        @endif
    </button>

    {{-- Dropdown Menu (Minlish Style) --}}
    <div x-show="open"
        @click.away="open = false"
        x-transition:enter="animate-notification-pop"
        class="absolute right-0 mt-6 w-[90vw] sm:w-[480px] glass-premium rounded-[40px] z-50 overflow-hidden ring-1 ring-black/5"
        style="display: none;">

        <div class="px-8 py-6 border-b border-white/20 flex items-center justify-between">
            <h3 class="text-[18px] font-black text-slate-900 uppercase tracking-tight">Thông báo của bạn</h3>
            @if($unreadCount > 0)
            <button wire:click="markAllAsRead" class="px-4 py-2 rounded-xl bg-indigo-600/10 text-[11px] font-black text-indigo-600 hover:bg-indigo-600 hover:text-white uppercase tracking-widest transition-all duration-300">
                Đã đọc hết
            </button>
            @endif
        </div>

        <div class="max-h-[500px] overflow-y-auto custom-scrollbar">
            @forelse($notifications as $index => $notification)
            <div class="px-8 py-6 border-b border-white/10 hover:bg-white/20 transition-all duration-300 relative group {{ $notification->read_at ? 'opacity-40' : '' }}"
                style="animation: notification-pop 0.4s cubic-bezier(0.34, 1.56, 0.64, 1) {{ $index * 0.05 }}s both;">
                <div class="flex gap-5 items-start">
                    <div class="flex-shrink-0 w-12 h-12 rounded-2xl {{ $notification->type === 'App\Notifications\InactivityGuiltTripNotification' ? 'bg-rose-500 shadow-rose-200' : 'bg-indigo-600 shadow-indigo-200' }} shadow-lg flex items-center justify-center text-white transform group-hover:scale-110 group-hover:rotate-6 transition-all duration-300">
                        @if($notification->type === 'App\Notifications\InactivityGuiltTripNotification')
                        <span class="text-xl">😢</span>
                        @else
                        <span class="text-xl">🔥</span>
                        @endif
                    </div>
                    <div class="flex-1">
                        <p class="text-[14px] font-extrabold text-slate-900 leading-tight group-hover:text-indigo-600 transition-colors">
                            {{ $notification->data['message'] ?? 'Bạn có thông báo mới' }}
                        </p>
                        <div class="flex items-center gap-2 mt-2">
                            <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">
                                {{ $notification->created_at->diffForHumans() }}
                            </span>
                            @unless($notification->read_at)
                            <span class="w-1 h-1 rounded-full bg-indigo-400"></span>
                            <span class="text-[10px] font-black text-indigo-400 uppercase tracking-widest">MỚI</span>
                            @endunless
                        </div>
                    </div>
                    @unless($notification->read_at)
                    <button wire:click="markAsRead('{{ $notification->id }}')"
                        class="w-10 h-10 rounded-2xl bg-white/40 border border-white/20 flex items-center justify-center text-slate-500 hover:text-emerald-500 hover:border-emerald-200 transition-all opacity-0 group-hover:opacity-100 shadow-sm hover:shadow-lg backdrop-blur-md">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                        </svg>
                    </button>
                    @endunless
                </div>
            </div>
            @empty
            <div class="px-8 py-16 text-center">
                <div class="w-20 h-20 bg-white/10 rounded-full flex items-center justify-center mx-auto mb-6 text-slate-300 shadow-inner backdrop-blur-sm">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                </div>
                <p class="text-[14px] font-black text-slate-500 uppercase tracking-[0.2em]">Tất cả đều ổn!</p>
                <p class="text-[11px] font-bold text-slate-400 mt-2 uppercase tracking-widest">Min đang mỉm cười với bạn đó.</p>
            </div>
            @endforelse
        </div>

        @if($notifications->count() > 0)
        <div class="p-6 bg-white/40 border-t border-white/20 text-center">
            <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 text-[12px] font-black text-slate-500 hover:text-indigo-600 uppercase tracking-[0.2em] transition-all group/link">
                LỊCH SỬ HOẠT ĐỘNG
                <svg class="w-4 h-4 transform group-hover/link:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                </svg>
            </a>
        </div>
        @endif
    </div>
</div>