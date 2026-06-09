<footer class="bg-[#0b3d0b] px-6 pt-16 pb-8 border-t border-yellow-300/10">

    <div class="max-w-5xl mx-auto">

        <div class="grid md:grid-cols-3 gap-10 mb-12">

            <div>
                <h2 style="font-family:'Bebas Neue',sans-serif;"
                    class="text-yellow-300 text-3xl uppercase tracking-wide">
                    ActiveHub
                </h2>

                <p class="text-yellow-300/60 text-sm mt-4 leading-relaxed max-w-xs">
                    Platform pemesanan lapangan dan cari teman main dengan mudah, cepat, dan tanpa ribet.
                </p>
            </div>

            <!-- NAV -->
            <div class="md:col-span-2 grid grid-cols-2 gap-8 text-sm">

                <!-- COLUMN 1 -->
                <div>
                    <p class="text-yellow-300/40 uppercase mb-3 text-xs">Jelajahi</p>

                    <div class="flex flex-col gap-2">
                        <a href="{{ route('fields.index') }}" class="text-yellow-300/70 hover:text-yellow-300 transition">
                            Cari Lapangan
                        </a>
                        <a href="{{ route('matches.index') }}" class="text-yellow-300/70 hover:text-yellow-300 transition">
                            Permainan Terbuka
                        </a>
                        <a href="{{ route('fields.index') }}" class="text-yellow-300/70 hover:text-yellow-300 transition">
                            Permainan Saya
                        </a>
                    </div>
                </div>

                <!-- COLUMN 2 -->
                <div>
                    <p class="text-yellow-300/40 uppercase mb-3 text-xs">Akun</p>

                    <div class="flex flex-col gap-2">
                        <a href="{{ route('login') }}" class="text-yellow-300/70 hover:text-yellow-300 transition">
                            Masuk
                        </a>
                        <a href="{{ route('register') }}" class="text-yellow-300/70 hover:text-yellow-300 transition">
                            Daftar
                        </a>
                        <a href="{{ auth()->check() ? route('owner.dashboard') : route('login') }}" class="text-yellow-300/70 hover:text-yellow-300 transition">
                            Dashboard Pemilik
                        </a>
                    </div>
                </div>

            </div>

        </div>

        <!-- DIVIDER -->
        <div class="border-t border-yellow-300/10 pt-6 flex flex-col md:flex-row justify-between items-center gap-4">

            <!-- COPYRIGHT -->
            <p class="text-yellow-300/40 text-xs">
                © 2026 ActiveHub. Hak cipta dilindungi.
            </p>

            <!-- MINI CTA -->
            <div class="flex items-center gap-3 text-xs text-yellow-300/60">
                <span>Mulai sekarang</span>
                <a href="{{ auth()->check() ? route('user.dashboard') : route('register') }}"
                   class="px-3 py-1 rounded-md bg-yellow-300 text-[#1c3a0c] font-semibold hover:bg-yellow-200 transition">
                    Daftar Gratis
                </a>
            </div>

        </div>

    </div>

</footer>

<!-- FONT -->
<link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">