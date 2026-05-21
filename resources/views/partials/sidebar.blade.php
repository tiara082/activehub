@php
    $user = auth()->user();
    $role = $user->role;
@endphp

<aside class="w-52 bg-white border-r border-gray-200 min-h-screen fixed top-0 left-0 z-50 flex flex-col">

    {{-- HEADER --}}
    <div class="px-4 pt-6 pb-4 space-y-5">

        {{-- LOGO --}}
        <div class="px-1">
            <h1 style="font-family:'Bebas Neue',sans-serif;"
                class="text-[#0b3d0b] text-2xl tracking-wide leading-none">
                ACTIVE<span class="text-black">HUB</span>
            </h1>
        </div>

        {{-- USER INFO (CLICKABLE TO PROFILE) --}}
        <a href="{{ route($role === 'user' ? 'user.profile' : 'owner.profile') }}"
           class="flex items-center gap-3 px-3 py-2.5 rounded-xl border border-gray-100 bg-white shadow-sm hover:bg-gray-50 transition">

            <div class="w-9 h-9 rounded-lg bg-gradient-to-br from-[#0b3d0b] to-[#145214]
                        flex items-center justify-center text-white font-semibold text-xs">
                {{ strtoupper(substr($user->name, 0, 2)) }}
            </div>

            <div class="leading-tight flex-1">
                <p class="text-[13px] text-gray-900 font-semibold">
                    {{ $user->name }}
                </p>
                <p class="text-[11px] text-gray-400 capitalize">
                    {{ $role }}
                </p>
            </div>

            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    d="M9 5l7 7-7 7"/>
            </svg>

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
            <span>venue saya</span>
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