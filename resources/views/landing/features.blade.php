<section class="bg-white py-20 px-6">
    <div class="max-w-5xl mx-auto">

        <h2 class="text-center mb-12"
            style="font-family:'Bebas Neue',sans-serif;font-size:clamp(2.2rem,7vw,3.8rem);color:#1c3a0c;">
            Our Features
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

            {{-- BOOKING LAPANGAN --}}
            <a href="{{ route('venues.index') }}"
               class="block group relative overflow-hidden rounded-xl h-[380px] cursor-pointer
                      hover:ring-1 hover:ring-[#c8e63a]/40 transition">

                <img src="https://images.unsplash.com/photo-1554068865-24cecd4e34b8?w=700&q=80"
                     class="w-full h-full object-cover transition duration-500 group-hover:scale-105">

                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent 
                            opacity-0 group-hover:opacity-100 transition duration-500"></div>

                <div class="absolute inset-0 flex flex-col justify-end p-6">

                    <div class="transform translate-y-6 opacity-0 
                                group-hover:translate-y-0 group-hover:opacity-100
                                transition duration-500">

                        <div class="w-11 h-11 bg-yellow-300 rounded-full flex items-center justify-center mb-4
                                    transition duration-300 group-hover:scale-110 group-hover:rotate-6">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-[#1c3a0c]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <rect x="3" y="4" width="18" height="18" rx="2"/>
                                <line x1="16" y1="2" x2="16" y2="6"/>
                                <line x1="8" y1="2" x2="8" y2="6"/>
                                <line x1="3" y1="10" x2="21" y2="10"/>
                            </svg>
                        </div>

                        <div class="max-w-xs">
                            <h3 class="text-white text-2xl tracking-tight"
                                style="font-family:'Bebas Neue',sans-serif;">
                                Booking Lapangan
                            </h3>

                            <p class="text-white/70 text-sm mt-2 leading-relaxed">
                                Pilih jadwal, cek ketersediaan, dan booking lapangan tanpa ribet.
                            </p>

                            <div class="w-0 h-[2px] bg-yellow-300 mt-4 
                                        transition-all duration-500 delay-300
                                        group-hover:w-16"></div>
                        </div>

                    </div>

                </div>
            </a>

            {{-- PUBLIC MATCH --}}
            <a href="{{ route('matches.index') }}"
               class="block group relative overflow-hidden rounded-xl h-[380px] cursor-pointer
                      hover:ring-1 hover:ring-[#c8e63a]/40 transition">

                <img src="https://images.unsplash.com/photo-1626224583764-f87db24ac4ea?w=700&q=80"
                     class="w-full h-full object-cover transition duration-500 group-hover:scale-105">

                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent 
                            opacity-0 group-hover:opacity-100 transition duration-500"></div>

                <div class="absolute inset-0 flex flex-col justify-end p-6">

                    <div class="transform translate-y-6 opacity-0 
                                group-hover:translate-y-0 group-hover:opacity-100
                                transition duration-500">

                        <div class="w-11 h-11 bg-yellow-300 rounded-full flex items-center justify-center mb-4
                                    transition duration-300 group-hover:scale-110 group-hover:rotate-6">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-[#1c3a0c]" fill="none"
                                 viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <circle cx="9" cy="7" r="4"/>
                                <path d="M17 11c2 0 4 2 4 4v1H13v-1c0-2 2-4 4-4z"/>
                                <path d="M9 11c-2 0-6 2-6 4v1h6"/>
                            </svg>
                        </div>

                        <div class="max-w-xs">
                            <h3 class="text-white text-2xl tracking-tight"
                                style="font-family:'Bebas Neue',sans-serif;">
                                Public Match
                            </h3>

                            <p class="text-white/70 text-sm mt-2 leading-relaxed">
                                Temukan match terbuka dan gabung main bareng pemain lain.
                            </p>

                            <div class="w-0 h-[2px] bg-yellow-300 mt-4 
                                        transition-all duration-500 group-hover:w-16"></div>
                        </div>

                    </div>

                </div>
            </a>

        </div>
    </div>
</section>