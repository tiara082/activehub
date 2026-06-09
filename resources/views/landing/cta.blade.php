<section 
    class="bg-[#0b3d0b] py-20 px-6"
    x-data="{ tab: 'pemilik' }"
>
    <div class="max-w-5xl mx-auto">

        <div class="flex justify-start mb-12">
            <div class="relative grid grid-cols-2 bg-[#1c3a0c]/40 p-1 rounded-xl w-[260px]">

                <div 
                    class="absolute top-1 bottom-1 w-1/2 bg-yellow-300 rounded-lg transition-all duration-300"
                    :class="tab === 'pemilik' ? 'translate-x-0' : 'translate-x-full'"
                ></div>

                <button 
                    @click="tab = 'pemilik'"
                    class="relative z-10 py-2 text-sm font-semibold uppercase transition text-center"
                    :class="tab === 'pemilik' ? 'text-[#1c3a0c]' : 'text-yellow-300/70'"
                >
                    Pemilik
                </button>

                <button 
                    @click="tab = 'penyewa'"
                    class="relative z-10 py-2 text-sm font-semibold uppercase transition text-center"
                    :class="tab === 'penyewa' ? 'text-[#1c3a0c]' : 'text-yellow-300/70'"
                >
                    Penyewa
                </button>

            </div>
        </div>

        <div class="grid md:grid-cols-2 gap-10 items-end">

            <div>

                <div 
                    x-show="tab === 'pemilik'" 
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-2"
                    x-transition:enter-end="opacity-100 translate-y-0"
                >
                    <h1 style="font-family:'Bebas Neue',sans-serif;"
                        class="text-yellow-300 uppercase leading-[0.9]">

                        <span class="block whitespace-nowrap text-[clamp(1.8rem,5vw,3.8rem)]">
                            Kelola Lapangan Lebih Praktis
                        </span>

                        <span class="block whitespace-nowrap text-[clamp(1.8rem,5vw,3.8rem)]">
                            Dan Menguntungkan
                        </span>

                    </h1>

                    <p class="text-yellow-300/60 mt-5 max-w-md text-sm leading-relaxed">
                        Digitalkan sistem reservasi lapangan Anda. Pantau pendapatan secara <i>real-time</i>,
                        atur jadwal otomatis, dan jangkau lebih banyak komunitas olahraga di sekitarmu.
                    </p>
                </div>

                <div 
                    x-show="tab === 'penyewa'" 
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-2"
                    x-transition:enter-end="opacity-100 translate-y-0"
                >
                    <h1 style="font-family:'Bebas Neue',sans-serif;"
                        class="text-yellow-300 uppercase leading-[0.9]">

                        <span class="block whitespace-nowrap text-[clamp(1.8rem,5vw,3.8rem)]">
                            Cari Lawan Main
                        </span>

                        <span class="block whitespace-nowrap text-[clamp(1.8rem,5vw,3.8rem)]">
                            Atau Pesan Lapangan
                        </span>

                    </h1>

                    <p class="text-yellow-300/60 mt-5 max-w-md text-sm leading-relaxed">
                        Gak perlu ribet <i>chat admin</i>. Pilih lapangan favoritmu, gabung permainan terbuka yang tersedia,
                        dan bayar instan tanpa drama. Olahraga jadi makin gampang!
                    </p>
                </div>

            </div>

            <div class="flex justify-end">

                <a href="{{ auth()->check() ? route('user.dashboard') : route('login') }}"
                   class="group flex items-end gap-2 text-yellow-300">

                    <!-- TEXT -->
                    <div style="font-family:'Bebas Neue',sans-serif;"
                         class="leading-none text-right">
                        <div class="text-4xl md:text-6xl transition group-hover:translate-x-1">
                            PELAJARI 
                        </div>
                        <div class="text-4xl md:text-6xl transition group-hover:translate-x-1">
                            LEBIH LANJUT
                        </div>
                    </div>

                    <!-- ARROW -->
                    <svg width="50" height="50" viewBox="0 0 24 24" fill="none"
                         class="rotate-[45deg] transition group-hover:translate-x-2 group-hover:-translate-y-2">
                        <path d="M4 12h12M10 6l6 6-6 6" 
                              stroke="#fde047" 
                              stroke-width="2"/>
                    </svg>

                </a>

            </div>

        </div>

    </div>
</section>

<link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
<script src="//unpkg.com/alpinejs" defer></script>