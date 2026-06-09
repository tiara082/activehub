<section class="bg-white py-20 px-6">
    <div class="max-w-5xl mx-auto">

        <div class="relative overflow-hidden rounded-2xl md:min-h-[440px] flex flex-col md:block bg-[#0f2305]">

            <!-- IMAGE WRAPPER -->
            <div class="relative h-64 md:h-auto md:absolute md:inset-0 w-full shrink-0">
                <img src="https://images.unsplash.com/photo-1546519638-68e109498ffc?w=1400&q=80"
                     class="w-full h-full object-cover object-center md:object-right md:scale-x-[-1]">
                     
                <!-- OVERLAY (MOBILE) -->
                <div class="absolute inset-0 bg-gradient-to-t from-[#0f2305] via-[#0f2305]/40 to-transparent md:hidden"></div>
            </div>

            <!-- OVERLAY (DESKTOP) -->
            <div class="hidden md:block absolute inset-0 bg-gradient-to-r from-[#0f2305]/95 via-[#0f2305]/70 to-transparent"></div>

            <!-- CONTENT -->
            <div class="relative z-10 p-6 md:p-8 max-w-lg -mt-8 md:mt-0">

                <h2 style="font-family:'Bebas Neue',sans-serif;font-size:clamp(2.5rem,7vw,4rem);color:white;">
                    Kenapa ActiveHub?
                </h2>

                <div class="mt-8 space-y-5">

                    <!-- ITEM -->
                    <div class="accordion-item border-b border-white/20 pb-4">

                        <button class="accordion-btn w-full flex items-start gap-3 text-left">

                            <!-- ICON -->
                            <div class="icon w-9 h-9 bg-yellow-300 rounded-full flex items-center justify-center shrink-0 transition">
                                <svg class="w-4 h-4 text-[#1c3a0c]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <rect x="3" y="4" width="18" height="18" rx="2"/>
                                    <line x1="8" y1="2" x2="8" y2="6"/>
                                    <line x1="16" y1="2" x2="16" y2="6"/>
                                </svg>
                            </div>

                            <div class="flex-1">
                                <p class="title text-white font-semibold transition">
                                    Pemesanan real-time tanpa ribet
                                </p>

                                <!-- DESC -->
                                <div class="accordion-content overflow-hidden max-h-0 opacity-0 transition-all duration-500">
                                    <p class="text-white/60 text-sm mt-2 leading-relaxed">
                                        Cek jadwal langsung dan pesan dalam hitungan detik tanpa perlu konfirmasi manual.
                                    </p>
                                </div>
                            </div>

                            <!-- INDICATOR -->
                            <div class="indicator w-[2px] h-0 bg-yellow-300 transition-all duration-500"></div>

                        </button>
                    </div>

                    <!-- ITEM -->
                    <div class="accordion-item border-b border-white/20 pb-4">

                        <button class="accordion-btn w-full flex items-start gap-3 text-left">

                            <div class="icon w-9 h-9 bg-yellow-300 rounded-full flex items-center justify-center shrink-0 transition">
                                <svg class="w-4 h-4 text-[#1c3a0c]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path d="M12 21s6-5.5 6-10a6 6 0 1 0-12 0c0 4.5 6 10 6 10z"/>
                                    <circle cx="12" cy="11" r="2"/>
                                </svg>
                            </div>

                            <div class="flex-1">
                                <p class="title text-white font-semibold transition">
                                    Temukan lapangan terdekat
                                </p>

                                <div class="accordion-content overflow-hidden max-h-0 opacity-0 transition-all duration-500">
                                    <p class="text-white/60 text-sm mt-2 leading-relaxed">
                                        Jelajahi berbagai tempat di sekitarmu dengan informasi lengkap dan akurat.
                                    </p>
                                </div>
                            </div>

                            <div class="indicator w-[2px] h-0 bg-yellow-300 transition-all duration-500"></div>

                        </button>
                    </div>

                    <!-- ITEM -->
                    <div class="accordion-item">

                        <button class="accordion-btn w-full flex items-start gap-3 text-left">

                            <div class="icon w-9 h-9 bg-yellow-300 rounded-full flex items-center justify-center shrink-0 transition">
                                <svg class="w-4 h-4 text-[#1c3a0c]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <circle cx="9" cy="7" r="4"/>
                                    <path d="M17 11c2 0 4 2 4 4v1H13"/>
                                    <path d="M9 11c-2 0-6 2-6 4v1h6"/>
                                </svg>
                            </div>

                            <div class="flex-1">
                                <p class="title text-white font-semibold transition">
                                    Main tanpa harus punya tim
                                </p>

                                <div class="accordion-content overflow-hidden max-h-0 opacity-0 transition-all duration-500">
                                    <p class="text-white/60 text-sm mt-2 leading-relaxed">
                                        Gabung permainan terbuka dan temukan teman bermain kapan saja.
                                    </p>
                                </div>
                            </div>

                            <div class="indicator w-[2px] h-0 bg-yellow-300 transition-all duration-500"></div>

                        </button>
                    </div>

                </div>

            </div>
        </div>

    </div>
</section>

<script>
    const items = document.querySelectorAll('.accordion-item');

    function closeAll() {
        items.forEach(item => {
            item.querySelector('.accordion-content').style.maxHeight = '0px';
            item.querySelector('.accordion-content').style.opacity = '0';
            item.querySelector('.indicator').style.height = '0px';
            item.querySelector('.icon').classList.remove('scale-110');
        });
    }

    items.forEach((item, index) => {
        const btn = item.querySelector('.accordion-btn');
        const content = item.querySelector('.accordion-content');
        const indicator = item.querySelector('.indicator');
        const icon = item.querySelector('.icon');

        btn.addEventListener('click', () => {
            const isOpen = content.style.maxHeight !== '0px';

            closeAll();

            if (!isOpen) {
                content.style.maxHeight = content.scrollHeight + 'px';
                content.style.opacity = '1';
                indicator.style.height = content.scrollHeight + 'px';
                icon.classList.add('scale-110');
            }
        });

        if (index === 0) {
            content.style.maxHeight = content.scrollHeight + 'px';
            content.style.opacity = '1';
            indicator.style.height = content.scrollHeight + 'px';
            icon.classList.add('scale-110');
        }
    });
</script>