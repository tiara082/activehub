<nav class="fixed top-0 left-0 right-0 z-50 px-6 py-4 flex items-center justify-between
            bg-[#0b3d0b] shadow-sm">

    {{-- LOGO --}}
    <a href="/" class="font-display text-2xl font-black text-yellow-300 tracking-tight">
        ActiveHub
    </a>

    {{-- DESKTOP MENU --}}
    <div class="hidden md:flex items-center gap-6">

        {{-- Beranda --}}
        <a href="{{ route('home') }}"
           class="text-white/80 text-sm font-medium hover:text-white transition-colors">
            Beranda
        </a>

        {{-- Public Match --}}
        <a href="{{ route('matches.index') }}"
           class="text-white/80 text-sm font-medium hover:text-white transition-colors">
            Pertandingan Terbuka
        </a>

        {{-- Cari Lapangan --}}
        <a href="{{ route('venues.index') }}"
           class="text-white/80 text-sm font-medium hover:text-white transition-colors">
            Cari Lapangan

        </a>

        {{-- CART ICON (NEW) --}}
        <a href="{{ route('cart.index') }}"
           class="relative text-white/80 hover:text-white transition-colors group">

            <svg class="w-5 h-5 group-hover:scale-110 transition-transform"
                 fill="none" stroke="currentColor" viewBox="0 0 24 24"
                 stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M2.25 3h1.386c.51 0 .955.343 1.086.833L5.25 6m0 0l1.5 7.5h11.81c.51 0 .955-.343 1.086-.833l1.364-5.454A1.125 1.125 0 0019.02 6H5.25z"/>
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M9 20.25a.75.75 0 100-1.5.75.75 0 000 1.5zM17.25 20.25a.75.75 0 100-1.5.75.75 0 000 1.5z"/>
            </svg>

            {{-- badge --}}
            <span class="absolute -top-2 -right-2 bg-yellow-300 text-[#0b3d0b] text-xs font-bold
                         w-5 h-5 flex items-center justify-center rounded-full">
                0
            </span>
        </a>

        {{-- PROFILE ICON (NEW) --}}
        @auth
            @php
                $dashboardUrl = '#';
                if(Auth::user()->role === 'owner') {
                    $dashboardUrl = route('owner.venue');
                } elseif(Auth::user()->role === 'admin') {
                    $dashboardUrl = route('admin.dashboard');
                } elseif(Auth::user()->role === 'user') {
                    $dashboardUrl = route('user.dashboard');
                }
            @endphp
            {{-- USER ICON LINK --}}
            <a href="{{ $dashboardUrl }}" class="text-white/80 hover:text-white transition-colors flex items-center">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                     stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M4.5 20.25a8.25 8.25 0 0115 0"/>
                </svg>
            </a>
        @else
            {{-- NOT LOGGED IN --}}
            <a href="{{ route('login') }}"
               class="text-white/80 hover:text-white transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                     stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M4.5 20.25a8.25 8.25 0 0115 0"/>
                </svg>
            </a>
        @endauth

    </div>

    {{-- MOBILE BUTTON --}}
    <button class="md:hidden text-white"
            x-data
            @click="$dispatch('toggle-nav')">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M4 6h16M4 12h16M4 18h16"/>
        </svg>
    </button>

</nav>