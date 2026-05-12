<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ActiveHub - Cari Lapangan Olahraga</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Anton&family=Bebas+Neue&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .font-anton { font-family: 'Anton', sans-serif; }
        .font-display { font-family: 'Bebas Neue', sans-serif; }
    </style>
    <script src="//unpkg.com/alpinejs" defer></script>
</head>
<body class="bg-gray-100 min-h-screen">

@include('navbar')

<!-- ===================== HERO SECTION ===================== -->
<section class="bg-[#1b3a1b] w-full px-6 pt-28 pb-16 text-center mt-16">
    <h1 class="font-anton text-white text-4xl md:text-5xl uppercase tracking-wide leading-tight mb-6">
        PILIH LAPANGANMU, ATUR PERMAINANMU
    </h1>
    <button class="inline-block bg-yellow-400 hover:bg-yellow-500 text-black font-bold px-12 py-4 rounded-xl transition">
        Daftarkan Lapangan Anda
    </button>
</section>

<!-- ===================== SEARCH BAR ===================== -->
<section class="max-w-5xl mx-auto px-4 mt-8 mb-6">
    <div class="flex flex-col md:flex-row gap-3 items-stretch md:items-center">

        <div class="relative flex-1">
            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M21 21l-4.3-4.3m1.8-5.2a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </span>
            <input type="text" placeholder="Cari Lapangan"
                   class="w-full bg-white border border-gray-200 rounded-xl pl-10 pr-4 py-3
                          text-sm text-gray-700 placeholder-gray-400
                          focus:outline-none focus:ring-2 focus:ring-[#1b3a1b]" />
        </div>

        <div class="relative flex-1">
            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M21 21l-4.3-4.3m1.8-5.2a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </span>
            <input type="text" placeholder="Cari Kota"
                   class="w-full bg-white border border-gray-200 rounded-xl pl-10 pr-4 py-3
                          text-sm text-gray-700 placeholder-gray-400
                          focus:outline-none focus:ring-2 focus:ring-[#1b3a1b]" />
        </div>

        <div class="relative flex-1">
            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 21a9 9 0 100-18 9 9 0 000 18z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M3.6 9h16.8M3.6 15h16.8M12 3a15 15 0 010 18"/>
                </svg>
            </span>
            <input type="text" placeholder="Cari Olahraga"
                   class="w-full bg-white border border-gray-200 rounded-xl pl-10 pr-4 py-3
                          text-sm text-gray-700 placeholder-gray-400
                          focus:outline-none focus:ring-2 focus:ring-[#1b3a1b]" />
        </div>

        <div class="relative flex-1">
            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 22s7-4.5 7-12a7 7 0 10-14 0c0 7.5 7 12 7 12z"/>
                    <circle cx="12" cy="10" r="2.5" stroke-width="2"/>
                </svg>
            </span>
            <input type="text" placeholder="Cari Kota"
                   class="w-full bg-white border border-gray-200 rounded-xl pl-10 pr-4 py-3
                          text-sm text-gray-700 placeholder-gray-400
                          focus:outline-none focus:ring-2 focus:ring-[#1b3a1b]" />
        </div>

        <button class="bg-[#1b3a1b] hover:bg-[#2a5a2a] text-white p-3 rounded-xl
                       transition-colors flex items-center justify-center">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M4 6h16M7 12h10M10 18h4"/>
            </svg>
        </button>

        <button class="bg-[#1b3a1b] hover:bg-[#2a5a2a] text-white font-semibold
                       px-7 py-3 rounded-xl transition-colors">
            Cari
        </button>

    </div>
</section>

<!-- ===================== VENUE CARDS ===================== -->
<section class="max-w-5xl mx-auto px-4 pb-16">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
        
        @foreach($venues as $venue)
        @php
            $prices = [];
            foreach($venue->fields as $field) {
                $prices[] = $field->price_per_hour;
            }
            $minPrice = count($prices) > 0 ? min($prices) : 0;
            $maxPrice = count($prices) > 0 ? max($prices) : 0;
            
            $sports = [];
            foreach($venue->fields as $field) {
                $sports[] = $field->sport_type;
            }
            $sports = array_unique($sports);
            $mainSport = count($sports) > 0 ? $sports[0] : 'Olahraga';
            
            $bgImages = [
                1 => 'https://images.unsplash.com/photo-1522778119026-d647f0598c20?w=600&q=80',
                2 => 'https://images.unsplash.com/photo-1579952363873-27f3bade9f55?w=600&q=80',
                3 => 'https://images.unsplash.com/photo-1508098682722-e99c43a406b2?w=600&q=80',
                4 => 'https://images.unsplash.com/photo-1599058917765-a3bce0adee7a?w=600&q=80',
            ];
            $bgImage = $bgImages[$venue->id] ?? 'https://images.unsplash.com/photo-1522778119026-d647f0598c20?w=600&q=80';
        @endphp
        
        <a href="/venues/{{ $venue->id }}" class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition-shadow duration-200 block group">
            <div class="relative">
                <img src="{{ $bgImage }}" class="w-full h-44 object-cover group-hover:scale-[1.02] transition-transform duration-300" />
                
                <div class="absolute top-3 right-3 bg-white/90 backdrop-blur-sm rounded-full px-3 py-1 flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <!-- Outer field -->
                        <rect x="3" y="5" width="18" height="14" rx="1" stroke-width="1.8"/>
                        <!-- Center line -->
                        <line x1="12" y1="5" x2="12" y2="19" stroke-width="1.8"/>
                        <!-- Center circle -->
                        <circle cx="12" cy="12" r="2" stroke-width="1.8"/>
                        <!-- Goal left -->
                        <line x1="3" y1="9" x2="3" y2="15" stroke-width="1.8"/>
                        <!-- Goal right -->
                        <line x1="21" y1="9" x2="21" y2="15" stroke-width="1.8"/>
                    </svg>
                                        
                    <span class="text-sm font-semibold text-gray-800">{{ $venue->fields_count ?? count($venue->fields ?? []) }} Lapangan</span>
                </div>
            </div>

            <div class="p-4">
                <p class="font-anton text-xl uppercase tracking-tight mb-0.5 text-gray-900">
                    {{ $venue->name }}
                </p>
                <p class="font-bold text-gray-800 text-sm mb-3">
                    {{ count($sports) > 0 ? implode(', ', $sports) : 'Olahraga' }}
                </p>

                <div class="space-y-1 text-xs text-gray-500">
                    <div class="flex items-center gap-2">
                        <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                  d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span>Buka 07:00 - 22:00</span>
                    </div>

                    <div class="flex items-center gap-2">
                        <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                  d="M12 2C8.686 2 6 4.686 6 8c0 5.25 6 13 6 13s6-7.75
                                     6-13c0-3.314-2.686-6-6-6z"/>
                            <circle cx="12" cy="8" r="2" stroke-width="1.8"/>
                        </svg>
                        <span class="truncate">{{ $venue->location }}</span>
                    </div>

                    <div class="flex items-center gap-2">
                        <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                  d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3
                                     0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                        </svg>
                        <span class="font-bold text-gray-700">Rp {{ number_format($minPrice, 0, ',', '.') }} - Rp {{ number_format($maxPrice, 0, ',', '.') }}/jam</span>
                    </div>
                </div>
            </div>
        </a>
        @endforeach

    </div>
</section>

</body>
</html>