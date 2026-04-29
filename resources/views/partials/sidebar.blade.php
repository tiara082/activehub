<aside class="w-52 bg-white border-r border-gray-200 min-h-screen fixed top-0 left-0 z-50 flex flex-col">

    {{-- HEADER --}}
    <div class="px-4 pt-6 pb-4 space-y-5">

        {{-- LOGO (lebih niat & proper hierarchy) --}}
        <div class="px-1">
            <h1 style="font-family:'Bebas Neue',sans-serif;"
                class="text-[#0b3d0b] text-2xl tracking-wide leading-none">
                ACTIVE<span class="text-black">HUB</span>
            </h1>
        </div>

        {{-- PROFILE (lebih modern & clean) --}}
        <div class="flex items-center gap-3 px-3 py-2.5 rounded-xl 
                    border border-gray-100 bg-white shadow-sm">

            {{-- Avatar --}}
            <div class="w-9 h-9 rounded-lg bg-gradient-to-br from-[#0b3d0b] to-[#145214]
                        flex items-center justify-center text-white font-semibold text-xs">
                RA
            </div>

            {{-- Info --}}
            <div class="leading-tight flex-1">
                <p class="text-[13px] text-gray-900 font-semibold">
                    Rizal Ahmad
                </p>
                <p class="text-[11px] text-gray-400">
                    Owner
                </p>
            </div>

            {{-- Optional dot (status subtle premium touch) --}}
            <div class="w-2 h-2 rounded-full bg-green-500"></div>

        </div>

    </div>

    {{-- NAV --}}
    <nav class="flex-1 px-2 py-3 space-y-1 border-t border-gray-100">

        <a href="{{ route('owner.venue') }}"
           class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-[13px] transition
           {{ request()->routeIs('owner.venue')
                ? 'bg-[#0b3d0b]/5 text-[#0b3d0b] font-medium'
                : 'text-gray-500 hover:text-gray-900 hover:bg-gray-100' }}">

            <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-width="2" d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/>
            </svg>

            <span>My Venue</span>
        </a>

        <a href="{{ route('owner.bookings') }}"
           class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-[13px] transition
           {{ request()->routeIs('owner.bookings')
                ? 'bg-[#0b3d0b]/5 text-[#0b3d0b] font-medium'
                : 'text-gray-500 hover:text-gray-900 hover:bg-gray-100' }}">

            <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <rect x="3" y="4" width="18" height="18" rx="2" stroke-width="2"/>
                <path stroke-width="2" d="M16 2v4M8 2v4M3 10h18"/>
            </svg>

            <span>Booking</span>
        </a>

        <a href="{{ route('owner.calendar') }}"
           class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-[13px] transition
           {{ request()->routeIs('owner.calendar')
                ? 'bg-[#0b3d0b]/5 text-[#0b3d0b] font-medium'
                : 'text-gray-500 hover:text-gray-900 hover:bg-gray-100' }}">

            <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <circle cx="12" cy="12" r="9" stroke-width="2"/>
                <path stroke-width="2" d="M12 7v5l3 3"/>
            </svg>

            <span>Calendar</span>
        </a>

        <a href="{{ route('owner.earnings') }}"
           class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-[13px] transition
           {{ request()->routeIs('owner.earnings')
                ? 'bg-[#0b3d0b]/5 text-[#0b3d0b] font-medium'
                : 'text-gray-500 hover:text-gray-900 hover:bg-gray-100' }}">

            <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-width="2" d="M12 1v22M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6"/>
            </svg>

            <span>Earnings</span>
        </a>

    </nav>

    {{-- BOTTOM --}}
    <div class="px-2 py-3 border-t border-gray-100 space-y-1">

        <a href="/"
           class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-[13px] text-gray-500 hover:text-gray-900 hover:bg-gray-100 transition">
            <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-width="2" d="M3 12l9-9 9 9M4 10v10h16V10"/>
            </svg>
            <span>Beranda</span>
        </a>

        <a href="#"
           class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-[13px] text-red-500 hover:bg-red-50 transition">
            <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7"/>
                <path stroke-width="2" d="M7 20H5a2 2 0 01-2-2V6a2 2 0 012-2h2"/>
            </svg>
            <span>Logout</span>
        </a>

    </div>

</aside>