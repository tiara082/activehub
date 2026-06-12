@php
    $user = auth()->user();
    $role = $user->role;
    $activeVenueName = null;
    if ($role === 'owner') {
        $venues = $user->venues()->get();
        $activeVenueId = session('active_venue_id');
        $venue = $activeVenueId ? ($venues->where('id', $activeVenueId)->first() ?? $venues->first()) : $venues->first();
        if ($venue) {
            $activeVenueName = $venue->name;
        }
    }
@endphp

{{-- ===== MOBILE TOPBAR ===== --}}
<div class="fixed top-0 left-0 right-0 z-40 flex items-center justify-between px-4 py-3 bg-[#0b3d0b] border-b border-white/10 lg:hidden">
    <a href="/" class="flex items-center gap-2">
        <img src="{{ asset('assets/logo yellow.png') }}" alt="ActiveHub" class="h-6 w-auto">
        <span class="font-display text-lg font-black text-yellow-300 tracking-tight leading-none">ActiveHub</span>
    </a>
    <button id="sidebar-toggle" class="p-2 rounded-lg text-white/70 hover:bg-white/10 transition" aria-label="Buka menu">
        <svg id="icon-open" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-width="2" stroke-linecap="round" d="M4 6h16M4 12h16M4 18h16"/>
        </svg>
        <svg id="icon-close" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-width="2" stroke-linecap="round" d="M6 18L18 6M6 6l12 12"/>
        </svg>
    </button>
</div>

{{-- ===== OVERLAY ===== --}}
<div id="sidebar-overlay" class="fixed inset-0 z-40 bg-black/40 backdrop-blur-sm hidden lg:hidden"></div>

<aside id="sidebar" class="w-52 bg-white border-r border-gray-200 min-h-screen fixed top-0 left-0 z-50 flex flex-col
    -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out">

    {{-- HEADER --}}
    <div class="px-4 pt-6 pb-4 space-y-5">

        {{-- LOGO --}}
        <div class="px-1">
            <a href="/" class="flex items-center gap-2">
                <img src="{{ asset('assets/logo yellow.png') }}" alt="ActiveHub" class="h-7 w-auto">
                <span class="font-display text-xl font-black text-yellow-400 tracking-tight leading-none">ActiveHub</span>
            </a>
        </div>

        {{-- USER INFO (CLICKABLE TO PROFILE) --}}
        <a href="{{ route($role === 'user' ? 'user.profile' : 'owner.profile') }}"
           class="group flex items-center gap-3 px-3 py-3 rounded-2xl border border-gray-200 bg-white hover:border-[#1b3a1b]/30 shadow-[0_2px_10px_rgba(0,0,0,0.02)] hover:shadow-[0_4px_12px_rgba(27,58,27,0.08)] transition-all duration-300 cursor-pointer">

            <div class="w-10 h-10 flex-shrink-0 rounded-full bg-gradient-to-br from-[#0b3d0b] to-[#1a6e1a]
                        flex items-center justify-center text-white font-bold text-sm shadow-inner ring-2 ring-green-50">
                {{ strtoupper(substr($user->name, 0, 2)) }}
            </div>

            <div class="leading-tight flex-1 overflow-hidden">
                <p class="text-sm text-gray-900 font-bold truncate">
                    {{ $user->name }}
                </p>
                <p class="text-[11px] text-gray-500 mt-0.5 flex items-center">
                    <span class="capitalize font-medium text-gray-600">{{ $role }}</span>
                    @if($activeVenueName)
                        <span class="mx-1 text-gray-300">•</span>
                        <span class="text-[#0b3d0b] font-semibold truncate" title="{{ $activeVenueName }}">
                            {{ $activeVenueName }}
                        </span>
                    @endif
                </p>
            </div>

            <div class="flex-shrink-0 w-6 h-6 flex items-center justify-center rounded-full bg-gray-50 group-hover:bg-[#1b3a1b]/10 transition-colors">
                <svg class="w-3.5 h-3.5 text-gray-400 group-hover:text-[#1b3a1b] transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                </svg>
            </div>

        </a>

    </div>

    {{-- NAV --}}
    <nav class="flex-1 px-2 py-3 space-y-1 border-t border-gray-100">

        {{-- ================= USER ================= --}}
        @if($role === 'user')

        {{-- Dashboard --}}
        <a href="{{ route('user.dashboard') }}"
           class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-[13px] transition
           {{ request()->routeIs('user.dashboard') ? 'bg-[#0b3d0b]/5 text-[#0b3d0b] font-medium' : 'text-gray-500 hover:text-gray-900 hover:bg-gray-100' }}">
            <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-width="2" d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/>
            </svg>
            <span>Aktivitas</span>
        </a>


        {{-- Bookings --}}
        <a href="{{ route('user.bookings') }}"
           class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-[13px] transition
           {{ request()->routeIs('user.bookings') ? 'bg-[#0b3d0b]/5 text-[#0b3d0b] font-medium' : 'text-gray-500 hover:text-gray-900 hover:bg-gray-100' }}">
            <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <rect x="3" y="4" width="18" height="18" rx="2" stroke-width="2"/>
                <path stroke-width="2" d="M16 2v4M8 2v4M3 10h18"/>
            </svg>
            <span>Pemesanan</span>
        </a>

        {{-- Matches --}}
        <a href="{{ route('user.my-match') }}"
            class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-[13px] transition
            {{ request()->routeIs('user.my-match') ? 'bg-[#0b3d0b]/5 text-[#0b3d0b] font-medium' : 'text-gray-500 hover:text-gray-900 hover:bg-gray-100' }}">
                
            <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    d="M8 21h8M12 17v4M7 4h10v4a5 5 0 01-10 0V4z"/>
                <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    d="M5 6h2a3 3 0 01-3 3V6zM19 6h-2a3 3 0 003 3V6z"/>
            </svg>

            <span>Permainan</span>
        </a>

        @endif


        {{-- ================= OWNER ================= --}}
        @if($role === 'owner')

        <a href="{{ route('owner.venue') }}"
           class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-[13px] transition
           {{ request()->routeIs('owner.venue') ? 'bg-[#0b3d0b]/5 text-[#0b3d0b] font-medium' : 'text-gray-500 hover:text-gray-900 hover:bg-gray-100' }}">
            <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-width="2" d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/>
            </svg>
            <span>Venue Saya</span>
        </a>

        <a href="{{ route('owner.bookings') }}"
           class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-[13px] transition
           {{ request()->routeIs('owner.bookings') ? 'bg-[#0b3d0b]/5 text-[#0b3d0b] font-medium' : 'text-gray-500 hover:text-gray-900 hover:bg-gray-100' }}">
            <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <rect x="3" y="4" width="18" height="18" rx="2" stroke-width="2"/>
                <path stroke-width="2" d="M16 2v4M8 2v4M3 10h18"/>
            </svg>
            <span>Pemesanan</span>
        </a>

        <a href="{{ route('owner.calendar') }}"
           class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-[13px] transition
           {{ request()->routeIs('owner.calendar') ? 'bg-[#0b3d0b]/5 text-[#0b3d0b] font-medium' : 'text-gray-500 hover:text-gray-900 hover:bg-gray-100' }}">
            <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <circle cx="12" cy="12" r="9" stroke-width="2"/>
                <path stroke-width="2" d="M12 7v5l3 3"/>
            </svg>
            <span>Kalender</span>
        </a>

        <a href="{{ route('owner.earnings') }}"
           class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-[13px] transition
           {{ request()->routeIs('owner.earnings') ? 'bg-[#0b3d0b]/5 text-[#0b3d0b] font-medium' : 'text-gray-500 hover:text-gray-900 hover:bg-gray-100' }}">
            <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-width="2" d="M12 1v22M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6"/>
            </svg>
            <span>Pendapatan</span>
        </a>

        <a href="{{ route('owner.reviews') }}"
           class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-[13px] transition
           {{ request()->routeIs('owner.reviews') ? 'bg-[#0b3d0b]/5 text-[#0b3d0b] font-medium' : 'text-gray-500 hover:text-gray-900 hover:bg-gray-100' }}">
            <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
            </svg>
            <span>Ulasan</span>
        </a>

        @endif

    </nav>

    {{-- BOTTOM --}}
    <div class="px-2 py-3 border-t border-gray-100 space-y-1">

        <a href="/" class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-[13px] text-gray-500 hover:bg-gray-100">
            <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-width="2" d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/>
            </svg>
            <span>Beranda</span>
        </a>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="w-full flex items-center gap-2.5 px-3 py-2 rounded-lg text-[13px] text-red-500 hover:bg-red-50">
                <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                </svg>
                Keluar
            </button>
        </form>

    </div>

</aside>

<script>
(function() {
    const toggle   = document.getElementById('sidebar-toggle');
    const sidebar  = document.getElementById('sidebar');
    const overlay  = document.getElementById('sidebar-overlay');
    const iconOpen  = document.getElementById('icon-open');
    const iconClose = document.getElementById('icon-close');

    function openSidebar() {
        sidebar.classList.remove('-translate-x-full');
        overlay.classList.remove('hidden');
        iconOpen.classList.add('hidden');
        iconClose.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeSidebar() {
        sidebar.classList.add('-translate-x-full');
        overlay.classList.add('hidden');
        iconOpen.classList.remove('hidden');
        iconClose.classList.add('hidden');
        document.body.style.overflow = '';
    }

    toggle.addEventListener('click', function() {
        const isOpen = !sidebar.classList.contains('-translate-x-full');
        isOpen ? closeSidebar() : openSidebar();
    });

    overlay.addEventListener('click', closeSidebar);
})();
</script>