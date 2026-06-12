{{-- resources/views/public-match/index.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Public Match</title>
    @if (app()->environment('production'))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script src="https://cdn.tailwindcss.com"></script>
    @endif
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"/>

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Anton&family=Bebas+Neue&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin=""/>

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
            ISI SLOT DAN MULAI PERMAINAN
        </h1>

        @auth
            @if(auth()->user()->role === 'user')
                @if($hasBooking ?? false)
                    <a href="{{ route('matches.create') }}"
                       class="inline-block bg-yellow-400 hover:bg-yellow-500
                               text-black font-bold px-12 py-4 rounded-xl transition">
                        Buat Permainan
                    </a>
                @else
                    <button onclick="document.getElementById('bookingRequiredModal').classList.remove('hidden')"
                            class="inline-block bg-yellow-400 hover:bg-yellow-500
                                   text-black font-bold px-12 py-4 rounded-xl transition cursor-pointer border-0">
                        Buat Permainan
                    </button>
                @endif
            @else
                <a href="{{ route('matches.create') }}"
                   class="inline-block bg-yellow-400 hover:bg-yellow-500
                           text-black font-bold px-12 py-4 rounded-xl transition">
                    Buat Permainan
                </a>
            @endif
        @else
            <a href="{{ route('login') }}"
               class="inline-block bg-yellow-400 hover:bg-yellow-500
                       text-black font-bold px-12 py-4 rounded-xl transition">
                Buat Permainan
            </a>
        @endauth
    </section>

    {{-- ===== MODAL: BOOKING REQUIRED ===== --}}
    <div id="bookingRequiredModal"
         class="hidden fixed inset-0 z-50 flex items-center justify-center p-4"
         onclick="if(event.target===this) this.classList.add('hidden')">

        {{-- Backdrop --}}
        <div class="absolute inset-0 bg-black/50 backdrop-blur-sm"></div>

        {{-- Card --}}
        <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-md overflow-hidden"
             style="animation: modalIn .25s cubic-bezier(.34,1.56,.64,1) both;">

            {{-- Top accent bar --}}
            <div class="h-1.5 w-full bg-gradient-to-r from-[#1b3a1b] via-yellow-400 to-[#1b3a1b]"></div>

            {{-- Body --}}
            <div class="px-8 pt-8 pb-6">

                {{-- Icon --}}
                <div class="w-14 h-14 rounded-xl bg-[#1b3a1b]/8 border border-[#1b3a1b]/15 flex items-center justify-center mb-5">
                    <svg class="w-7 h-7 text-[#1b3a1b]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                              d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>

                <h2 class="text-xl font-bold text-gray-900 mb-2 leading-snug">
                    Booking Lapangan Terlebih Dahulu
                </h2>

                <p class="text-sm text-gray-500 leading-relaxed mb-1">
                    Untuk membuat pertandingan terbuka, kamu perlu memiliki
                    <span class="font-semibold text-gray-700">booking lapangan yang aktif</span>
                    terlebih dahulu.
                </p>

                <p class="text-sm text-gray-500 leading-relaxed">
                    Pilih lapangan, tentukan jadwal, lalu buat permainanmu dan undang pemain lain untuk bergabung.
                </p>

            </div>

            {{-- Steps --}}
            <div class="mx-8 mb-6 rounded-xl border border-gray-100 bg-gray-50 divide-y divide-gray-100">

                <div class="flex items-center gap-4 px-5 py-3.5">
                    <div class="w-6 h-6 rounded-full bg-[#1b3a1b] flex items-center justify-center flex-shrink-0">
                        <span class="text-white text-[10px] font-bold">1</span>
                    </div>
                    <p class="text-sm text-gray-700">Cari dan booking lapangan yang tersedia</p>
                </div>

                <div class="flex items-center gap-4 px-5 py-3.5">
                    <div class="w-6 h-6 rounded-full bg-[#1b3a1b] flex items-center justify-center flex-shrink-0">
                        <span class="text-white text-[10px] font-bold">2</span>
                    </div>
                    <p class="text-sm text-gray-700">Buka permainan terbuka dari dashboard kamu</p>
                </div>

                <div class="flex items-center gap-4 px-5 py-3.5">
                    <div class="w-6 h-6 rounded-full bg-yellow-400 flex items-center justify-center flex-shrink-0">
                        <span class="text-black text-[10px] font-bold">3</span>
                    </div>
                    <p class="text-sm text-gray-700">Undang pemain dan mulai pertandingan</p>
                </div>

            </div>

            {{-- Actions --}}
            <div class="px-8 pb-8 flex flex-col gap-3">

                <a href="{{ route('venues.index') }}"
                   class="w-full bg-[#1b3a1b] hover:bg-[#2a5a2a] text-white font-semibold
                          py-3.5 rounded-xl text-sm text-center transition-colors">
                    Cari Lapangan Sekarang
                </a>

                <button onclick="document.getElementById('bookingRequiredModal').classList.add('hidden')"
                        class="w-full bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold
                               py-3.5 rounded-xl text-sm transition-colors border-0 cursor-pointer">
                    Kembali
                </button>

            </div>

        </div>
    </div>

    <style>
        @keyframes modalIn {
            from { opacity: 0; transform: scale(.92) translateY(12px); }
            to   { opacity: 1; transform: scale(1) translateY(0); }
        }
    </style>

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
                <input type="text" name="q" x-model="q" @input.debounce.800ms="autoSubmit()" placeholder="Cari Permainan"
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
        
        <!-- MAP CONTAINER -->
        <div class="relative w-full h-[400px] mb-8 rounded-2xl overflow-hidden shadow-sm border border-gray-200">
            <div id="match-map" class="w-full h-full z-0 relative" style="z-index: 0;"></div>
            <!-- Overlay for Location Warning -->
            <div id="location-warning" class="absolute top-4 left-1/2 -translate-x-1/2 bg-yellow-500 text-black px-4 py-2 rounded-xl text-sm font-bold shadow-md hidden items-center gap-2" style="z-index: 1000;">
                <i class="fas fa-exclamation-circle"></i>
                Beri akses lokasi agar kamu bisa melihat jarak dari posisimu!
                <button onclick="this.parentElement.style.display='none'" class="ml-2 text-black/70 hover:text-black"><i class="fas fa-times"></i></button>
            </div>
        </div>

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
                        <img src="{{ $match->photo_url ?? $match->booking->field->venue->photo_url ?? 'https://images.unsplash.com/photo-1575361204480-aadea25e6e68?w=600&q=80' }}"
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

                    @auth
                        @if($match->creator_id === auth()->id())
                            <div class="bg-blue-50 text-blue-700 text-xs font-semibold py-2.5 px-4 text-center border-t border-blue-100">
                                <i class="fas fa-user-shield mr-1"></i> Kamu adalah Pembuat Match
                            </div>
                        @elseif($match->participants->where('id', auth()->id())->count() > 0)
                            <div class="bg-green-50 text-green-700 text-xs font-semibold py-2.5 px-4 text-center border-t border-green-100">
                                <i class="fas fa-check-circle mr-1"></i> Kamu sudah bergabung (Lihat Detail)
                            </div>
                        @else
                            <div class="bg-gray-50 text-gray-500 text-xs font-semibold py-2.5 px-4 text-center border-t border-gray-100 group-hover:bg-green-50 group-hover:text-green-700 transition duration-200">
                                Lihat Detail Match
                            </div>
                        @endif
                    @else
                        <div class="bg-gray-50 text-gray-500 text-xs font-semibold py-2.5 px-4 text-center border-t border-gray-100 group-hover:bg-green-50 group-hover:text-green-700 transition duration-200">
                            Lihat Detail Match
                        </div>
                    @endauth
                </a>
                @empty
                <div class="col-span-full text-center text-gray-500 py-10">
                    Belum ada public match yang tersedia.
                </div>
                @endforelse
            </div>
        </div>
    </section>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>
<style>
    /* Custom Leaflet Popup Styling */
    .leaflet-popup-content-wrapper {
        border-radius: 8px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        padding: 0;
        overflow: hidden;
    }
    .leaflet-popup-content {
        margin: 0;
        width: 220px !important;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }
    .leaflet-popup-close-button {
        color: #999 !important;
        padding: 6px 6px 0 0 !important;
    }
    .leaflet-popup-close-button:hover {
        color: #333 !important;
    }
</style>
<script>
    const matchesData = [
        @foreach($matches as $match)
        {
            id: {{ $match->id }},
            title: "{!! addslashes($match->title) !!}",
            venue_name: "{!! addslashes($match->booking->field->venue->name ?? 'Venue') !!}",
            lat: {{ $match->booking->field->venue->latitude ?? 'null' }},
            lon: {{ $match->booking->field->venue->longitude ?? 'null' }},
            price: {{ $match->price_per_person }},
            url: "{{ route('matches.show', $match->id) }}"
        },
        @endforeach
    ].filter(m => m.lat !== null && m.lon !== null);

    // Haversine formula
    function getDistance(lat1, lon1, lat2, lon2) {
        const R = 6371; 
        const dLat = (lat2 - lat1) * Math.PI / 180;
        const dLon = (lon2 - lon1) * Math.PI / 180;
        const a = 
            Math.sin(dLat/2) * Math.sin(dLat/2) +
            Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) * 
            Math.sin(dLon/2) * Math.sin(dLon/2);
        const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a)); 
        return R * c; 
    }

    function createMatchPopupHTML(m, distanceKm = null) {
        let priceText = "Gratis";
        if (m.price > 0) {
            priceText = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0 }).format(m.price);
        }
        
        let distanceHtml = '<div></div>';
        if (distanceKm !== null) {
            distanceHtml = `<div class="text-[11px] font-semibold text-green-700 bg-green-50 px-2 py-1 rounded inline-flex items-center gap-1 border border-green-100"><i class="fas fa-location-arrow"></i> ${distanceKm.toFixed(1)} km</div>`;
        }

        return `
            <div style="cursor: pointer; padding: 16px;" onclick="window.location.href='${m.url}'" class="group">
                <h4 class="font-bold text-gray-900 text-sm mb-0.5 pr-4 leading-tight group-hover:text-[#1b3a1b] transition-colors line-clamp-1">${m.title}</h4>
                <p class="text-[11px] text-gray-500 mb-2 line-clamp-1">${m.venue_name}</p>
                <p class="text-xs text-gray-600 mb-3">Biaya: <span class="font-bold text-[#1b3a1b]">${priceText}</span></p>
                <div class="flex items-center justify-between mt-1">
                    ${distanceHtml}
                    <div class="bg-gray-50 group-hover:bg-green-100 w-6 h-6 rounded-full flex items-center justify-center transition-colors">
                        <i class="fas fa-chevron-right text-[10px] text-gray-400 group-hover:text-[#1b3a1b]"></i>
                    </div>
                </div>
            </div>
        `;
    }

    document.addEventListener("DOMContentLoaded", function() {
        const map = L.map('match-map').setView([-7.9839, 112.6214], 13);

        L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        const bounds = L.latLngBounds();
        let hasValidMarkers = false;
        const markersList = [];
        const addedCoords = {};
        
        matchesData.forEach(m => {
            let lat = m.lat;
            let lon = m.lon;
            
            const coordKey = `${lat}-${lon}`;
            if (addedCoords[coordKey]) {
                addedCoords[coordKey]++;
                lat += (Math.random() - 0.5) * 0.0005;
                lon += (Math.random() - 0.5) * 0.0005;
            } else {
                addedCoords[coordKey] = 1;
            }

            const marker = L.marker([lat, lon]).addTo(map);
            marker.bindPopup(createMatchPopupHTML(m, null));
            bounds.extend([lat, lon]);
            hasValidMarkers = true;
            markersList.push({ data: m, marker: marker });
        });

        if ("geolocation" in navigator) {
            navigator.geolocation.getCurrentPosition((position) => {
                const userLat = position.coords.latitude;
                const userLon = position.coords.longitude;
                
                const userIcon = L.divIcon({
                    className: 'custom-user-marker',
                    html: `<div style="background-color: #3b82f6; width: 16px; height: 16px; border-radius: 50%; border: 3px solid white; box-shadow: 0 0 6px rgba(0,0,0,0.5);"></div>`,
                    iconSize: [16, 16],
                    iconAnchor: [8, 8]
                });

                L.marker([userLat, userLon], {icon: userIcon})
                    .addTo(map)
                    .bindPopup('<strong class="font-sans text-sm text-blue-600">Lokasi Anda</strong>');

                // Update popup dengan jarak
                markersList.forEach(item => {
                    const dist = getDistance(userLat, userLon, item.data.lat, item.data.lon);
                    item.marker.setPopupContent(createMatchPopupHTML(item.data, dist));
                });
                
                // Langsung fokus ke sekitar lokasi user
                map.setView([userLat, userLon], 13);

            }, (error) => {
                const warn = document.getElementById('location-warning');
                warn.classList.remove('hidden');
                warn.classList.add('flex');
                if (hasValidMarkers) {
                    map.fitBounds(bounds, { padding: [30, 30], maxZoom: 13 });
                }
            });
        } else {
            if (hasValidMarkers) {
                map.fitBounds(bounds, { padding: [30, 30], maxZoom: 13 });
            }
        }
    });
</script>

</body>
</html>