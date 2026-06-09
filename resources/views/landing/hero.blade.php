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
            Pemesanan lapangan, cari teman main, dan mulai olahraga
            tanpa ribet dalam satu platform.
        </p>
    </div>

    <div class="relative z-20 w-full max-w-4xl mt-16">

        <!-- MAIN BAR -->
        <form id="heroSearchForm" action="{{ route('venues.index') }}" method="GET"
              class="bg-white/95 backdrop-blur 
                    flex flex-col md:flex-row items-stretch 
                    rounded-xl shadow-xl overflow-visible
                    border border-white/20 relative z-10">
                    
            <input type="hidden" name="sport" id="input-sport" value="">

            <!-- AKTIVITAS -->
            <div class="group flex items-center gap-3 flex-1 px-5 py-4 cursor-pointer relative border-b border-gray-100 md:border-b-0">

                <div class="w-10 h-10 bg-[#FACC15] rounded-lg flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="#0b3d0b" stroke-width="2" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 3L4 14h7v7l9-11h-7z"/>
                    </svg>
                </div>

                <div>
                    <p class="font-semibold text-[#0b3d0b] text-sm">Aktivitas</p>
                    <p class="text-gray-400 text-xs" id="display-aktivitas">Sewa Lapangan</p>
                </div>

                <div class="absolute left-0 top-full h-3 w-full"></div>

                <!-- DROPDOWN -->
                <div class="absolute left-0 top-full mt-2 w-full md:w-[220px] 
                            bg-white rounded-xl shadow-lg border border-gray-100 
                            opacity-0 invisible translate-y-2
                            group-hover:opacity-100 group-hover:visible group-hover:translate-y-0
                            transition-all duration-200 ease-out
                            pointer-events-none group-hover:pointer-events-auto z-50">

                    <button type="button" onclick="setAktivitas('Permainan Terbuka', '{{ route('matches.index') }}')" class="w-full text-left px-4 py-3 hover:bg-[#FEF9C3]">Permainan Terbuka</button>
                    <button type="button" onclick="setAktivitas('Sewa Lapangan', '{{ route('venues.index') }}')" class="w-full text-left px-4 py-3 hover:bg-[#FEF9C3]">Sewa Lapangan</button>

                </div>

            </div>

            <div class="hidden md:block w-px bg-gray-200"></div>

            <!-- LOKASI -->
            <div class="flex items-center gap-3 flex-1 px-5 py-4 cursor-text relative border-b border-gray-100 md:border-b-0" onclick="document.getElementById('input-lokasi').focus()">
                <div class="w-10 h-10 bg-[#FACC15] rounded-lg flex items-center justify-center shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="#0b3d0b" stroke-width="2" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 20l-5.447-2.724A1 1 0 013 16.382V4.618a1 1 0 011.553-.832L9 6m0 14l6-3m-6 3V6m6 11l4.447 2.276A1 1 0 0021 18.382V6.618a1 1 0 00-.553-.894L15 3m0 14V3m0 0L9 6"/>
                    </svg>
                </div>

                <div class="flex-1 w-full relative">
                    <p class="font-semibold text-[#0b3d0b] text-sm">Lokasi</p>
                    <input type="text" name="city" id="input-lokasi"
                           placeholder="Semua kota" autocomplete="off"
                           class="w-full bg-transparent border-none p-0 focus:ring-0 text-xs text-gray-700 placeholder-gray-400 outline-none">
                           
                    <!-- AUTOCOMPLETE DROPDOWN -->
                    <div id="lokasi-dropdown" class="absolute left-0 top-full mt-3 w-full min-w-[250px] bg-white rounded-xl shadow-xl border border-gray-100 hidden z-50 overflow-hidden">
                        <div id="lokasi-loading" class="px-4 py-3 text-xs text-gray-500 hidden">Mencari...</div>
                        <ul id="lokasi-results" class="max-h-60 overflow-y-auto"></ul>
                    </div>
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
                    <p class="text-gray-400 text-xs" id="display-olahraga">Semua Olahraga</p>
                </div>

                <div class="absolute left-0 top-full h-3 w-full"></div>

                <!-- DROPDOWN -->
                <div class="absolute left-0 top-full mt-2 w-full md:w-[220px] 
                            bg-white rounded-xl shadow-lg border border-gray-100 
                            opacity-0 invisible translate-y-2
                            group-hover:opacity-100 group-hover:visible group-hover:translate-y-0
                            transition-all duration-200 ease-out
                            pointer-events-none group-hover:pointer-events-auto
                            max-h-60 overflow-y-auto z-50">

                    <button type="button" onclick="setOlahraga('')" class="w-full text-left px-4 py-3 hover:bg-[#FEF9C3]">Semua Olahraga</button>
                    <button type="button" onclick="setOlahraga('Futsal')" class="w-full text-left px-4 py-3 hover:bg-[#FEF9C3]">Futsal</button>
                    <button type="button" onclick="setOlahraga('Basket')" class="w-full text-left px-4 py-3 hover:bg-[#FEF9C3]">Basket</button>
                    <button type="button" onclick="setOlahraga('Bulu Tangkis')" class="w-full text-left px-4 py-3 hover:bg-[#FEF9C3]">Bulu Tangkis</button>
                    <button type="button" onclick="setOlahraga('Tennis')" class="w-full text-left px-4 py-3 hover:bg-[#FEF9C3]">Tennis</button>
                    <button type="button" onclick="setOlahraga('Voli')" class="w-full text-left px-4 py-3 hover:bg-[#FEF9C3]">Voli</button>
                    <button type="button" onclick="setOlahraga('Padel')" class="w-full text-left px-4 py-3 hover:bg-[#FEF9C3]">Padel</button>
                    <button type="button" onclick="setOlahraga('Kebugaran')" class="w-full text-left px-4 py-3 hover:bg-[#FEF9C3]">Kebugaran</button>

                </div>

            </div>

            <!-- BUTTON -->
            <button type="submit"
               class="bg-[#FACC15] text-[#0b3d0b] font-semibold text-sm 
                      flex items-center justify-center px-7 py-4 
                      rounded-b-xl md:rounded-r-xl md:rounded-bl-none
                      hover:bg-[#EAB308] transition-all hover:scale-[1.03]">
                Temukan →
            </button>

        </form>

    </div>

    <!-- SCROLL -->
    <div class="mt-16 md:mt-0 md:absolute md:bottom-6 flex flex-col items-center text-white/40 text-xs tracking-wider">
        <span>GULIR</span>
        <div class="w-px h-6 bg-white/30 mt-1 animate-pulse"></div>
    </div>

</section>

@push('scripts')
<script>
    function setAktivitas(name, url) {
        document.getElementById('display-aktivitas').innerText = name;
        document.getElementById('heroSearchForm').action = url;
    }

    function setOlahraga(name) {
        document.getElementById('display-olahraga').innerText = name || 'Semua Olahraga';
        document.getElementById('input-sport').value = name;
    }

    // AUTOCOMPLETE LOKASI (Nominatim API)
    let searchTimeout;
    const inputLokasi = document.getElementById('input-lokasi');
    const dropdownLokasi = document.getElementById('lokasi-dropdown');
    const resultsLokasi = document.getElementById('lokasi-results');
    const loadingLokasi = document.getElementById('lokasi-loading');

    inputLokasi.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        const query = this.value.trim();
        
        if (query.length < 3) {
            dropdownLokasi.classList.add('hidden');
            return;
        }

        dropdownLokasi.classList.remove('hidden');
        resultsLokasi.innerHTML = '';
        loadingLokasi.classList.remove('hidden');

        searchTimeout = setTimeout(() => {
            fetch(`https://photon.komoot.io/api/?q=${encodeURIComponent(query)}&limit=10`)
                .then(response => response.json())
                .then(data => {
                    loadingLokasi.classList.add('hidden');
                    resultsLokasi.innerHTML = '';
                    
                    const indonesianResults = data.features.filter(f => f.properties.country === 'Indonesia' || f.properties.countrycode === 'ID');

                    if (indonesianResults.length === 0) {
                        resultsLokasi.innerHTML = '<li class="px-4 py-3 text-xs text-gray-500">Lokasi tidak ditemukan</li>';
                        return;
                    }

                    indonesianResults.slice(0, 5).forEach(item => {
                        const props = item.properties;
                        const li = document.createElement('li');
                        li.className = 'px-4 py-3 text-sm hover:bg-[#FEF9C3] cursor-pointer border-b border-gray-50 last:border-0 truncate';
                        
                        const parts = [props.name, props.city, props.state].filter(Boolean);
                        const displayName = [...new Set(parts)].join(', ');
                        
                        li.textContent = displayName;
                        li.onclick = function() {
                            inputLokasi.value = displayName;
                            dropdownLokasi.classList.add('hidden');
                        };
                        resultsLokasi.appendChild(li);
                    });
                })
                .catch(error => {
                    loadingLokasi.classList.add('hidden');
                    resultsLokasi.innerHTML = '<li class="px-4 py-3 text-xs text-red-500">Gagal mencari lokasi</li>';
                });
        }, 500); // debounce 500ms
    });

    // Tutup dropdown jika klik di luar
    document.addEventListener('click', function(e) {
        if (!inputLokasi.contains(e.target) && !dropdownLokasi.contains(e.target)) {
            dropdownLokasi.classList.add('hidden');
        }
    });
</script>
@endpush