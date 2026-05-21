{{-- resources/views/public-match/index.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Public Match</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"/>

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Anton&family=Bebas+Neue&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet" />

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .font-anton { font-family: 'Anton', sans-serif; }
        .font-display { font-family: 'Bebas Neue', sans-serif; }
    </style>
    <script src="//unpkg.com/alpinejs" defer></script>
</head>

<body class="bg-gray-100 min-h-screen">

    @include('navbar')

    {{-- ===== HERO ===== --}}
    <section class="bg-[#1b3a1b] w-full px-6 pt-28 pb-16 text-center mt-16">

        <h1 class="font-anton text-white text-4xl md:text-5xl uppercase tracking-wide leading-tight mb-6">
            ISI SLOT DAN MULAI PERTANDINGAN
        </h1>

        <a href="{{ route('matches.create') }}"
        class="inline-block bg-yellow-400 hover:bg-yellow-400
                text-black font-bold px-12 py-4 rounded-xl transition">
            Buat Public Match
        </a>
    </section>

    {{-- ===== SEARCH BAR ===== --}}
    <section class="max-w-5xl mx-auto px-4 mt-8 mb-6" x-data="searchFilter()">
        <form id="searchForm" method="GET" action="{{ route('matches.index') }}" class="flex flex-col md:flex-row gap-3 items-stretch md:items-center">

            <!-- q: Nama Lapangan -->
            <div class="relative flex-1">
                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M21 21l-4.3-4.3m1.8-5.2a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </span>
                <input type="text" name="q" x-model="q" @input.debounce.800ms="autoSubmit()" placeholder="Cari Pertandingan"
                   class="w-full bg-white border border-gray-200 rounded-xl pl-10 pr-4 py-3
                              text-sm text-gray-700 placeholder-gray-400
                              focus:outline-none focus:ring-2 focus:ring-[#1b3a1b]" />
            </div>

            <!-- sport: Jenis Olahraga -->
            <div class="relative flex-1" @click.away="sportOpen = false">
                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 21a9 9 0 100-18 9 9 0 000 18z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M3.6 9h16.8M3.6 15h16.8M12 3a15 15 0 010 18"/>
                    </svg>
                </span>
                <input type="hidden" name="sport" :value="sport">
                <button type="button" @click="sportOpen = !sportOpen"
                        class="w-full bg-white border border-gray-200 rounded-xl pl-10 pr-4 py-3 text-left
                               text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-[#1b3a1b] flex items-center justify-between">
                    <span x-text="sport ? sport : 'Semua Olahraga'" :class="{'text-gray-400': !sport}"></span>
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div x-show="sportOpen" x-transition style="display: none;"
                     class="absolute z-10 w-full mt-2 bg-white border border-gray-100 rounded-xl shadow-lg py-2">
                    <template x-for="s in sports" :key="s">
                        <button type="button" @click="sport = (s === 'Semua Olahraga' ? '' : s); sportOpen = false; autoSubmit()"
                                class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-green-50 hover:text-green-700 transition"
                                x-text="s"></button>
                    </template>
                </div>
            </div>

            <!-- city: Cari Kota Autocomplete -->
            <div class="relative flex-1" @click.away="cityOpen = false">
                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 22s7-4.5 7-12a7 7 0 10-14 0c0 7.5 7 12 7 12z"/>
                        <circle cx="12" cy="10" r="2.5" stroke-width="2"/>
                    </svg>
                </span>
                <input type="hidden" name="lat" :value="lat">
                <input type="hidden" name="lon" :value="lon">
                <input type="text" name="city" x-model="city" @input.debounce.800ms="searchCity(); autoSubmit()" @focus="cityOpen = true"
                       placeholder="Cari Lokasi" autocomplete="off"
                       class="w-full bg-white border border-gray-200 rounded-xl pl-10 pr-4 py-3
                              text-sm text-gray-700 placeholder-gray-400
                              focus:outline-none focus:ring-2 focus:ring-[#1b3a1b]" />
                
                <div x-show="cityOpen && citySuggestions.length > 0" x-transition style="display: none;"
                     class="absolute z-10 w-full mt-2 bg-white border border-gray-100 rounded-xl shadow-lg py-2 max-h-60 overflow-y-auto">
                    <template x-for="suggestion in citySuggestions" :key="suggestion.place_id">
                        <button type="button" @click="selectCity(suggestion); autoSubmit()"
                                class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-green-50 hover:text-green-700 transition">
                            <span x-text="suggestion.display_name" class="line-clamp-1"></span>
                        </button>
                    </template>
                </div>
            </div>

            <!-- sort: Filter Garis Tiga Dropdown -->
            <div class="relative" @click.away="sortOpen = false">
                <input type="hidden" name="sort" :value="sort">
                <button type="button" @click="sortOpen = !sortOpen"
                        class="bg-[#1b3a1b] hover:bg-[#2a5a2a] text-white p-3 rounded-xl h-full
                               transition-colors flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 6h16M7 12h10M10 18h4"/>
                    </svg>
                </button>
                <div x-show="sortOpen" x-transition style="display: none;"
                     class="absolute right-0 z-10 w-48 mt-2 bg-white border border-gray-100 rounded-xl shadow-lg py-2">
                    <button type="button" @click="sort = 'terdekat'; sortOpen = false; autoSubmit()" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-green-50 transition"
                            :class="{'font-bold text-[#1b3a1b] bg-green-50': sort === 'terdekat'}">
                        Paling Dekat
                    </button>
                    <button type="button" @click="sort = 'terlama'; sortOpen = false; autoSubmit()" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-green-50 transition"
                            :class="{'font-bold text-[#1b3a1b] bg-green-50': sort === 'terlama'}">
                        Paling Lama
                    </button>
                </div>
            </div>
        </form>
    </section>

    <script>
    function searchFilter() {
        return {
            q: "{{ request('q') }}",
            sportOpen: false,
            sport: "{{ request('sport') }}",
            sports: ['Semua Olahraga', 'Futsal', 'Mini Soccer', 'Badminton', 'Basket', 'Tenis', 'Voli'],
            
            cityOpen: false,
            city: "{{ request('city') }}",
            lat: "{{ request('lat') }}",
            lon: "{{ request('lon') }}",
            citySuggestions: [],
            
            sortOpen: false,
            sort: "{{ request('sort', 'terdekat') }}",

            init() {
                this.fetchNearby();
            },

            async fetchNearby() {
                const container = document.getElementById('nearby-container');
                
                if ("geolocation" in navigator) {
                    navigator.geolocation.getCurrentPosition(async (position) => {
                        const lat = position.coords.latitude;
                        const lon = position.coords.longitude;
                        try {
                            const res = await fetch(`/matches/nearby?lat=${lat}&lon=${lon}`);
                            const html = await res.text();
                            if(html.trim() !== '') {
                                container.innerHTML = html;
                            }
                        } catch (e) {
                            console.error('Error fetching nearby matches:', e);
                        }
                    }, (error) => {
                        console.warn('Geolocation blocked or failed:', error);
                        let reason = "Akses Lokasi Diblokir/Gagal.";
                        if(error.code === 1) reason = "Anda menolak akses lokasi.";
                        else if(error.code === 2) reason = "Lokasi tidak tersedia (Komputer tidak bisa mendeteksi GPS/WiFi).";
                        else if(error.code === 3) reason = "Waktu pencarian lokasi habis (Timeout).";

                        container.innerHTML = `
                            <div class="mb-10 p-4 bg-yellow-50 border border-yellow-200 rounded-xl flex items-center gap-3">
                                <i class="fas fa-exclamation-triangle text-yellow-500 text-xl"></i>
                                <div class="flex-1">
                                    <p class="text-sm text-yellow-800 font-bold">${reason}</p>
                                    <p class="text-xs text-yellow-700 mt-1">Pesan Sistem: ${error.message}</p>
                                </div>
                            </div>
                        `;
                    }, { timeout: 10000, maximumAge: 60000 });
                } else {
                    container.innerHTML = `
                        <div class="mb-10 p-4 bg-red-50 border border-red-200 rounded-xl flex items-center gap-3">
                            <i class="fas fa-times-circle text-red-500 text-xl"></i>
                            <p class="text-sm text-red-800">Browser Anda tidak mendukung fitur lokasi.</p>
                        </div>
                    `;
                }
            },

            async searchCity() {
                if (this.city.length < 3) {
                    this.citySuggestions = [];
                    this.lat = '';
                    this.lon = '';
                    return;
                }
                this.lat = '';
                this.lon = '';

                try {
                    const response = await fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${this.city}&countrycodes=id&limit=5`);
                    const data = await response.json();
                    this.citySuggestions = data;
                    this.cityOpen = true;
                } catch (error) {
                    console.error('Error fetching city:', error);
                }
            },

            selectCity(suggestion) {
                this.city = suggestion.display_name.split(',').slice(0, 3).join(',').trim();
                this.lat = suggestion.lat;
                this.lon = suggestion.lon;
                this.citySuggestions = [];
                this.cityOpen = false;
            },

            async autoSubmit() {
                const form = document.getElementById('searchForm');
                const url = new URL(form.action);
                const formData = new FormData(form);
                const searchParams = new URLSearchParams(formData);
                url.search = searchParams.toString();
                
                window.history.pushState({}, '', url);

                try {
                    const res = await fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } });
                    const html = await res.text();
                    
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');
                    
                    const newList = doc.getElementById('list-container');
                    if(newList) {
                        document.getElementById('list-container').innerHTML = newList.innerHTML;
                    }
                } catch (err) {
                    console.error('AJAX Filter error:', err);
                }
            }
        }
    }
    </script>

    <!-- ===================== PUBLIC MATCH LIST ===================== -->
    <section class="max-w-5xl mx-auto px-4 pb-16">
        <!-- Nearby Container -->
        <div id="nearby-container"></div>

        <div id="list-container">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                @forelse ($matches as $match)
                {{-- CARD --}}
                <a href="{{ route('matches.show', $match->id) }}"
                   class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-md
                          transition-shadow duration-200 block group">

                    <div class="relative">
                        <img src="{{ $match->booking->field->venue->photo_url ?? 'https://images.unsplash.com/photo-1575361204480-aadea25e6e68?w=600&q=80' }}"
                            class="w-full h-44 object-cover group-hover:scale-[1.02] transition-transform duration-300" />
                            
                        <div class="absolute top-3 left-3 bg-[#1b3a1b]/90 backdrop-blur-sm text-white rounded-full px-3 py-1 text-xs font-semibold">
                            {{ $match->booking->field->sport_type ?? 'Olahraga' }}
                        </div>

                        <div class="absolute top-3 right-3 bg-white/90 backdrop-blur-sm
                                    rounded-full px-3 py-1 flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M17 20h5v-2a4 4 0 00-4-4H6a4 4 0 00-4 4v2h5 M12 12a4 4 0 100-8 4 4 0 000 8z"/>
                            </svg>
                            <span class="text-sm font-semibold text-gray-800">{{ $match->participants->count() }}/{{ $match->total_players }}</span>
                        </div>
                    </div>

                    <div class="p-4">
                        <h2 class="font-bold text-lg text-gray-900 leading-tight mb-1 truncate">
                            {{ $match->title }}
                        </h2>
                        
                        <p class="text-sm font-semibold text-gray-600 mb-4 truncate border-b border-gray-100 pb-3">
                            {{ $match->booking->field->venue->name ?? 'Venue' }}
                        </p>

                        <div class="space-y-2 text-sm text-gray-500">
                            <div class="flex items-center gap-2">
                                <i class="far fa-calendar-alt w-4 text-center text-[#1b3a1b]"></i>
                                <span>{{ \Carbon\Carbon::parse($match->booking->timeSlot->date)->translatedFormat('d M Y') }}</span>
                            </div>

                            <div class="flex items-center gap-2">
                                <i class="far fa-clock w-4 text-center text-[#1b3a1b]"></i>
                                <span>{{ \Carbon\Carbon::parse($match->booking->timeSlot->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($match->booking->timeSlot->end_time)->format('H:i') }}</span>
                            </div>

                            <div class="flex items-center gap-2">
                                <i class="fas fa-map-marker-alt w-4 text-center text-[#1b3a1b]"></i>
                                <span class="truncate">{{ $match->booking->field->venue->city ?? 'Kota' }}</span>
                            </div>

                            <div class="flex items-center gap-2 mt-2 pt-2 border-t border-gray-100">
                                <i class="fas fa-wallet w-4 text-center text-green-600"></i>
                                <span class="font-semibold text-gray-900">
                                    @if($match->price_per_person > 0)
                                        Rp {{ number_format($match->price_per_person, 0, ',', '.') }}<span class="font-normal text-xs text-gray-500">/org</span>
                                    @else
                                        <span class="text-green-600">Gratis</span>
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>
                </a>
                @empty
                <div class="col-span-full text-center text-gray-500 py-10">
                    Belum ada public match yang tersedia.
                </div>
                @endforelse
            </div>
        </div>
    </section>

</body>
</html>