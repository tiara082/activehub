<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $venue->name }} - Detail Lapangan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-100">

<div class="container mx-auto px-4 py-8">
    
    <!-- Back Button -->
    <a href="/venues" class="inline-flex items-center text-green-600 hover:text-green-700 mb-6">
        <i class="fas fa-arrow-left mr-2"></i> Kembali ke Daftar
    </a>

    <!-- Venue Header -->
    <div class="bg-white rounded-xl shadow-md overflow-hidden mb-8">
        <div class="relative h-64 bg-gradient-to-r from-green-400 to-blue-500 flex items-center justify-center">
            <i class="fas fa-futbol text-white text-8xl"></i>
        </div>
        <div class="p-6">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">{{ $venue->name }}</h1>
            <div class="flex items-center gap-4 mb-4">
                <span class="text-green-600 font-bold text-xl">Rp {{ number_format($venue->fields[0]->price_per_hour ?? 0, 0, ',', '.') }} - Rp {{ number_format(end($venue->fields)->price_per_hour ?? 0, 0, ',', '.') }}K</span>
                <span class="text-gray-400">/jam</span>
            </div>
            <p class="text-gray-600 mb-2">
                <i class="fas fa-map-marker-alt text-green-500 mr-2"></i> {{ $venue->location }}
            </p>
            <p class="text-gray-600">{{ $venue->description }}</p>
        </div>
    </div>

    <!-- Fields List -->
    <h2 class="text-2xl font-bold text-gray-800 mb-4">Daftar Lapangan</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @foreach($venue->fields as $field)
        <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition">
            <div class="p-5">
                <div class="flex justify-between items-start mb-3">
                    <h3 class="text-xl font-bold text-gray-800">{{ $field->name }}</h3>
                    <span class="bg-green-100 text-green-700 text-xs font-bold px-2 py-1 rounded-full">
                        {{ $field->is_indoor ? 'Indoor' : 'Outdoor' }}
                    </span>
                </div>
                <div class="space-y-2 mb-4">
                    <p class="text-gray-600">
                        <i class="fas fa-sport-icon text-green-500 mr-2"></i> 
                        Olahraga: {{ $field->sport_type }}
                    </p>
                    <p class="text-gray-600">
                        <i class="fas fa-tag text-green-500 mr-2"></i> 
                        Harga: <span class="font-bold text-green-600">Rp {{ number_format($field->price_per_hour, 0, ',', '.') }}</span>/jam
                    </p>
                    <p class="text-gray-600">
                        <i class="fas fa-users text-green-500 mr-2"></i> 
                        Kapasitas: {{ $field->capacity }} orang
                    </p>
                </div>
                <button class="w-full bg-green-600 text-white py-2 rounded-lg hover:bg-green-700 transition">
                    Booking Sekarang
                </button>
            </div>
        </div>
        @endforeach
    </div>
</div>

</body>
</html>