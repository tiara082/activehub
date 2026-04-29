<section 
    class="relative overflow-hidden 
           bg-[#0b3d0b]
           min-h-screen flex flex-col items-center justify-center 
           px-6 pt-32 pb-16"
>

    <!-- BACKGROUND -->
    <div class="absolute -top-40 -left-40 w-[400px] h-[400px] bg-[#FACC15]/10 rounded-full blur-[120px]"></div>
    <div class="absolute bottom-0 right-0 w-[300px] h-[300px] bg-[#FACC15]/10 rounded-full blur-[100px]"></div>

    <!-- TITLE -->
    <div class="relative z-10 text-center max-w-3xl mx-auto">
        <h1 style="font-family:'Bebas Neue',sans-serif;"
            class="text-white uppercase leading-[0.85] tracking-tight
                   text-[clamp(5rem,17vw,12rem)] drop-shadow-md">
            ActiveHub
        </h1>

        <p class="text-white/70 text-sm md:text-base mt-4 tracking-wide max-w-md mx-auto leading-relaxed">
            Booking lapangan, cari teman main, dan mulai olahraga
            tanpa ribet dalam satu platform.
        </p>
    </div>

    <div class="relative z-20 w-full max-w-4xl mt-16">

        <!-- MAIN BAR -->
        <div class="bg-white/95 backdrop-blur 
                    flex flex-col md:flex-row items-stretch 
                    rounded-xl shadow-xl overflow-visible
                    border border-white/20 relative z-10">

            <!-- AKTIVITAS -->
            <div class="group flex items-center gap-3 flex-1 px-5 py-4 cursor-pointer relative">

                <div class="w-10 h-10 bg-[#FACC15] rounded-lg flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="#0b3d0b" stroke-width="2" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 3L4 14h7v7l9-11h-7z"/>
                    </svg>
                </div>

                <div>
                    <p class="font-semibold text-[#0b3d0b] text-sm">Aktivitas</p>
                    <p class="text-gray-400 text-xs">Pilih aktivitas</p>
                </div>

                <div class="absolute left-0 top-full h-3 w-full"></div>

                <!-- DROPDOWN -->
                <div class="absolute left-0 top-full mt-2 w-[220px] 
                            bg-white rounded-xl shadow-lg border border-gray-100 
                            opacity-0 invisible translate-y-2
                            group-hover:opacity-100 group-hover:visible group-hover:translate-y-0
                            transition-all duration-200 ease-out
                            pointer-events-none group-hover:pointer-events-auto z-50">

                    <button class="w-full text-left px-4 py-3 hover:bg-[#FEF9C3]">Public Match</button>
                    <button class="w-full text-left px-4 py-3 hover:bg-[#FEF9C3]">Sewa Lapangan</button>

                </div>

            </div>

            <div class="hidden md:block w-px bg-gray-200"></div>

            <!-- LOKASI -->
            <div class="flex items-center gap-3 flex-1 px-5 py-4">
                <div class="w-10 h-10 bg-[#FACC15] rounded-lg flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="#0b3d0b" stroke-width="2" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 20l-5.447-2.724A1 1 0 013 16.382V4.618a1 1 0 011.553-.832L9 6m0 14l6-3m-6 3V6m6 11l4.447 2.276A1 1 0 0021 18.382V6.618a1 1 0 00-.553-.894L15 3m0 14V3m0 0L9 6"/>
                    </svg>
                </div>

                <div>
                    <p class="font-semibold text-[#0b3d0b] text-sm">Lokasi</p>
                    <p class="text-gray-400 text-xs">Pilih kota</p>
                </div>
            </div>

            <div class="hidden md:block w-px bg-gray-200"></div>

            <!-- OLAHRAGA -->
            <div class="group flex items-center gap-3 flex-1 px-5 py-4 cursor-pointer relative">

                <div class="w-10 h-10 bg-[#FACC15] rounded-lg flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="#0b3d0b" stroke-width="2" class="w-5 h-5">
                        <circle cx="12" cy="12" r="9"/>
                        <path d="M3 12h18M12 3a15 15 0 010 18M12 3a15 15 0 000 18"/>
                    </svg>
                </div>

                <div>
                    <p class="font-semibold text-[#0b3d0b] text-sm">Olahraga</p>
                    <p class="text-gray-400 text-xs">Pilih olahraga</p>
                </div>

                <div class="absolute left-0 top-full h-3 w-full"></div>

                <!-- DROPDOWN -->
                <div class="absolute left-0 top-full mt-2 w-[220px] 
                            bg-white rounded-xl shadow-lg border border-gray-100 
                            opacity-0 invisible translate-y-2
                            group-hover:opacity-100 group-hover:visible group-hover:translate-y-0
                            transition-all duration-200 ease-out
                            pointer-events-none group-hover:pointer-events-auto
                            max-h-60 overflow-y-auto z-50">

                    <button class="w-full text-left px-4 py-3 hover:bg-[#FEF9C3]">Futsal</button>
                    <button class="w-full text-left px-4 py-3 hover:bg-[#FEF9C3]">Sepak Bola</button>
                    <button class="w-full text-left px-4 py-3 hover:bg-[#FEF9C3]">Badminton</button>
                    <button class="w-full text-left px-4 py-3 hover:bg-[#FEF9C3]">Basket</button>
                    <button class="w-full text-left px-4 py-3 hover:bg-[#FEF9C3]">Tenis</button>
                    <button class="w-full text-left px-4 py-3 hover:bg-[#FEF9C3]">Voli</button>
                    <button class="w-full text-left px-4 py-3 hover:bg-[#FEF9C3]">Mini Soccer</button>
                    <button class="w-full text-left px-4 py-3 hover:bg-[#FEF9C3]">Ping Pong</button>
                    <button class="w-full text-left px-4 py-3 hover:bg-[#FEF9C3]">Padel</button>
                    <button class="w-full text-left px-4 py-3 hover:bg-[#FEF9C3]">Baseball</button>

                </div>

            </div>

            <!-- BUTTON -->
            <a href="{{ route('fields.index') }}"
               class="bg-[#FACC15] text-[#0b3d0b] font-semibold text-sm 
                      flex items-center justify-center px-7 py-4 
                      rounded-r-xl 
                      hover:bg-[#EAB308] transition-all hover:scale-[1.03]">
                Temukan →
            </a>

        </div>

    </div>

    <!-- SCROLL -->
    <div class="absolute bottom-6 flex flex-col items-center text-white/40 text-xs tracking-wider">
        <span>SCROLL</span>
        <div class="w-px h-6 bg-white/30 mt-1 animate-pulse"></div>
    </div>

</section>