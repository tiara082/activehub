<nav x-data="{ mobileNavOpen: false }" class="fixed top-0 left-0 right-0 z-50 px-6 py-4 flex items-center justify-between
            bg-[#0b3d0b] shadow-sm">

    {{-- LOGO --}}
    <a href="/" class="font-display text-2xl font-black text-yellow-300 tracking-tight">
        ActiveHub
    </a>

    {{-- DESKTOP MENU --}}
    <div class="hidden md:flex items-center gap-6">

        {{-- Beranda --}}
        <a href="{{ route('home') }}"
           class="text-white/80 text-sm font-medium hover:text-yellow-300 transition-colors relative group">
            Beranda
            <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-yellow-300 transition-all duration-300 group-hover:w-full"></span>
        </a>

        {{-- Public Match --}}
        <a href="{{ route('matches.index') }}"
           class="text-white/80 text-sm font-medium hover:text-yellow-300 transition-colors relative group">
            Permainan
            <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-yellow-300 transition-all duration-300 group-hover:w-full"></span>
        </a>

        {{-- Cari Lapangan --}}
        <a href="{{ route('venues.index') }}"
           class="text-white/80 text-sm font-medium hover:text-yellow-300 transition-colors relative group">
            Cari Venue
            <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-yellow-300 transition-all duration-300 group-hover:w-full"></span>
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
            @click="mobileNavOpen = !mobileNavOpen">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M4 6h16M4 12h16M4 18h16"/>
        </svg>
    </button>

    {{-- MOBILE MENU --}}
    <div x-show="mobileNavOpen" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-2"
         class="md:hidden absolute top-[68px] left-0 right-0 bg-[#0b3d0b] shadow-xl border-t border-white/10 z-40"
         style="display: none;">
        <div class="flex flex-col px-6 py-4 gap-4">
            <a href="{{ route('home') }}" class="text-white/80 font-medium hover:text-yellow-300">Beranda</a>
            <a href="{{ route('matches.index') }}" class="text-white/80 font-medium hover:text-yellow-300">Permainan</a>
            <a href="{{ route('venues.index') }}" class="text-white/80 font-medium hover:text-yellow-300">Cari Venue</a>
            
            <div class="h-px w-full bg-white/10 my-2"></div>
            
            @auth
                @php
                    $dashboardUrl = '#';
                    if(Auth::user()->role === 'owner') $dashboardUrl = route('owner.venue');
                    elseif(Auth::user()->role === 'admin') $dashboardUrl = route('admin.dashboard');
                    elseif(Auth::user()->role === 'user') $dashboardUrl = route('user.dashboard');
                @endphp
                <a href="{{ $dashboardUrl }}" class="text-white font-medium flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 20.25a8.25 8.25 0 0115 0"/>
                    </svg>
                    Dashboard
                </a>
            @else
                <a href="{{ route('login') }}" class="text-white font-medium hover:text-yellow-300 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 20.25a8.25 8.25 0 0115 0"/>
                    </svg>
                    Masuk
                </a>
            @endauth
        </div>
    </div>

</nav>