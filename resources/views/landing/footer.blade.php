<footer class="bg-[#0b3d0b] px-6 pt-16 pb-8 border-t border-[#c8e63a]/10">

    <div class="max-w-5xl mx-auto">

        <div class="grid md:grid-cols-3 gap-10 mb-12">

            <div>
                <h2 style="font-family:'Bebas Neue',sans-serif;"
                    class="text-[#c8e63a] text-3xl uppercase tracking-wide">
                    ActiveHub
                </h2>

                <p class="text-[#c8e63a]/60 text-sm mt-4 leading-relaxed max-w-xs">
                    Platform booking lapangan dan cari teman main dengan mudah, cepat, dan tanpa ribet.
                </p>
            </div>

            <!-- NAV -->
            <div class="md:col-span-2 grid grid-cols-2 gap-8 text-sm">

                <!-- COLUMN 1 -->
                <div>
                    <p class="text-[#c8e63a]/40 uppercase mb-3 text-xs">Explore</p>

                    <div class="flex flex-col gap-2">
                        <a href="{{ route('fields.index') }}" class="text-[#c8e63a]/70 hover:text-[#c8e63a] transition">
                            Cari Lapangan
                        </a>
                        <a href="{{ route('matches.index') }}" class="text-[#c8e63a]/70 hover:text-[#c8e63a] transition">
                            Public Match
                        </a>
                        <a href="{{ route('fields.index') }}" class="text-[#c8e63a]/70 hover:text-[#c8e63a] transition">
                            Match Saya
                        </a>
                    </div>
                </div>

                <!-- COLUMN 2 -->
                <div>
                    <p class="text-[#c8e63a]/40 uppercase mb-3 text-xs">Account</p>

                    <div class="flex flex-col gap-2">
                        <a href="{{ route('home') }}" class="text-[#c8e63a]/70 hover:text-[#c8e63a] transition">
                            Masuk
                        </a>
                        <a href="{{ route('home') }}" class="text-[#c8e63a]/70 hover:text-[#c8e63a] transition">
                            Daftar
                        </a>
                        <a href="{{ route('fields.index') }}" class="text-[#c8e63a]/70 hover:text-[#c8e63a] transition">
                            Dashboard Pemilik
                        </a>
                    </div>
                </div>

            </div>

        </div>

        <!-- DIVIDER -->
        <div class="border-t border-[#c8e63a]/10 pt-6 flex flex-col md:flex-row justify-between items-center gap-4">

            <!-- COPYRIGHT -->
            <p class="text-[#c8e63a]/40 text-xs">
                © 2026 ActiveHub. All rights reserved.
            </p>

            <!-- MINI CTA -->
            <div class="flex items-center gap-3 text-xs text-[#c8e63a]/60">
                <span>Mulai sekarang</span>
                <a href="{{ route('home') }}"
                   class="px-3 py-1 rounded-md bg-[#c8e63a] text-[#1c3a0c] font-semibold hover:bg-[#d9f24a] transition">
                    Daftar Gratis
                </a>
            </div>

        </div>

    </div>

</footer>

<!-- FONT -->
<link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">