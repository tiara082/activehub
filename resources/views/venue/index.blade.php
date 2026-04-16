<!DOCTYPE html>
<html lang="id">
<head>
    <title>Cari Lapangan Olahraga</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

<div class="container mx-auto px-4 py-8">
    
    <!-- Header -->
    <div class="bg-green-900 text-center mb-10 py-10 rounded-xl">
        <h1 class="text-3xl font-bold text-white mb-3">PILIH LAPANGANMU, ATUR PERMAINANMU</h1>
        <button class="bg-yellow-500 text-black px-6 py-2 rounded-lg hover:bg-yellow-600 transition">
            Daftarkan Lapangan Anda
        </button>
    </div>

    <!-- Filter Section - Ukuran lebih kecil -->
    <div class="bg-white rounded-xl shadow-md p-4 mb-8">
        <div class="grid grid-cols-1 md:grid-cols-5 gap-2">
            <div>
                <input type="text" placeholder="Cari Lapangan" 
                       class="w-full border border-gray-300 rounded-lg px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
            </div>
            <div>
                <input type="text" placeholder="Cari Kota" 
                       class="w-full border border-gray-300 rounded-lg px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
            </div>
            <div>
                <select class="w-full border border-gray-300 rounded-lg px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
                    <option value="">Cari Olahraga</option>
                    <option value="Futsal">Futsal</option>
                    <option value="Basket">Basket</option>
                    <option value="Badminton">Badminton</option>
                    <option value="Tenis">Tenis</option>
                    <option value="Padel">Padel</option>
                    <option value="Mini Soccer">Mini Soccer</option>
                </select>
            </div>
            
            <div>
                <select class="w-full border border-gray-300 rounded-lg px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
                    <option value="">Urutkan</option>
                    <option value="price_asc">Harga Terendah</option>
                    <option value="price_desc">Harga Tertinggi</option>
                    <option value="rating_desc">Rating Tertinggi</option>
                    <option value="distance_asc">Jarak Terdekat</option>
                </select>
            </div>
            <div>
                <button class="w-full bg-green-900 text-white px-3 py-1.5 text-sm rounded-lg hover:bg-green-700 transition">
                    Cari
                </button>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        
        @foreach($venues as $venue)
        @php
            $prices = [];
            if(isset($venue->fields)) {
                foreach($venue->fields as $field) {
                    $prices[] = $field->price_per_hour;
                }
            } else {
                // Fallback untuk data dummy awal
                if($venue->id == 1) $prices = [100000, 100000, 150000];
                if($venue->id == 2) $prices = [200000, 180000, 250000, 250000];
            }
            $minPrice = !empty($prices) ? min($prices) : 0;
            $maxPrice = !empty($prices) ? max($prices) : 0;
            
            // Kumpulkan sport types
            $sports = [];
            if(isset($venue->fields)) {
                foreach($venue->fields as $field) {
                    $sports[] = $field->sport_type;
                }
            } else {
                if($venue->id == 1) $sports = ['Futsal', 'Mini Soccer'];
                if($venue->id == 2) $sports = ['Futsal', 'Mini Soccer'];
            }
            $sports = array_unique($sports);
        @endphp
        <a href="/venues/{{ $venue->id }}" class="block group cursor-pointer">
            <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                <div class="bg-green-800 h-48 flex items-center justify-center relative">
                    <i class="fas fa-futbol text-white text-6xl group-hover:scale-110 transition-transform duration-300"></i>
                    <span class="absolute top-3 right-3 bg-white/90 backdrop-blur-sm text-green-700 text-xs font-bold px-2 py-1 rounded-full">
                        {{ $venue->fields_count ?? count($venue->fields ?? []) }} Lapangan
                    </span>
                </div>
                <div class="p-5">
                    <h3 class="text-xl font-bold text-gray-800 mb-2 group-hover:text-green-600 transition-colors">{{ $venue->name }}</h3>
                    <div class="flex items-center gap-2 mb-3">
                        <span class="text-green-600 font-bold">Rp {{ number_format($minPrice, 0, ',', '.') }} - Rp {{ number_format($maxPrice, 0, ',', '.') }}</span>
                        <span class="text-gray-400">/jam</span>
                    </div>
                    <p class="text-gray-600 text-sm mb-3">
                        <i class="fas fa-map-marker-alt text-green-500 mr-1"></i> {{ $venue->location }}
                    </p>
                    <div class="flex flex-wrap gap-2 mb-4">
                        @foreach($sports as $sport)
                        <span class="bg-gray-100 text-gray-700 text-xs px-2 py-1 rounded-full">{{ $sport }}</span>
                        @endforeach
                    </div>
                </div>
            </div>
        </a>
        @endforeach

    </div>
</div>

</body>
</html>