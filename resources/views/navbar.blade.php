<nav class="fixed top-0 left-0 right-0 z-50 px-6 py-4 flex items-center justify-between
            bg-[#0b3d0b] shadow-sm">

    {{-- LOGO --}}
    <a href="/" class="font-display text-2xl font-black text-yellow-300 tracking-tight">
        ActiveHub
    </a>

    {{-- DESKTOP MENU --}}
    <div class="hidden md:flex items-center gap-6">

        {{-- Public Match --}}
        <a href="{{ route('matches.index') }}"
           class="text-white/80 text-sm font-medium hover:text-white transition-colors">
            Public Match
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
            {{-- USER MENU DROPDOWN --}}
            <div class="relative group">
                <button class="text-white/80 hover:text-white transition-colors flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                         stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M4.5 20.25a8.25 8.25 0 0115 0"/>
                    </svg>
                    <span class="text-sm font-medium hidden sm:inline">{{ Auth::user()->name }}</span>
                </button>

                {{-- DROPDOWN MENU --}}
                <div class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg opacity-0 invisible 
                            group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                    <div class="px-4 py-3 border-b border-gray-200">
                        <p class="text-sm font-semibold text-gray-800">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-gray-500">{{ Auth::user()->email }}</p>
                    </div>

                    <a href="{{ route('profile') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                        Profile
                    </a>

                    @if(Auth::user()->role === 'owner')
                        <a href="{{ route('owner.venue') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            Owner Dashboard
                        </a>
                    @endif

                    @if(Auth::user()->role === 'user')
                        <a href="{{ route('user.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            User Dashboard
                        </a>
                    @endif

                    @if(Auth::user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            Admin Dashboard
                        </a>
                    @endif

                    <div class="border-t border-gray-200">
                        <a href="{{ route('logout') }}" class="block px-4 py-2 text-sm text-red-600 hover:bg-gray-100 font-medium">
                            Logout
                        </a>
                    </div>
                </div>
            </div>
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