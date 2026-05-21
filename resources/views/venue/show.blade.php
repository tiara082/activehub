<!DOCTYPE html>
<html lang="id">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $venue->name }} - Detail Lapangan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"/>
</head>
<body class="bg-gray-100 min-h-screen">

<div class="px-10 py-8">

    <!-- Back Button -->
    <a href="/venues" class="inline-flex items-center text-[#1b3a1b] hover:text-[#2a5a2a] mb-6">
        <i class="fas fa-arrow-left mr-2"></i> Kembali
    </a>

    <!-- Venue Header -->
    <div class="bg-white rounded-xl overflow-hidden mb-8">
        <div class="relative h-64 bg-gradient-to-r bg-[#1b3a1b] flex items-center justify-center">
            <i class="text-white text-8xl"></i>
        </div>
        <div class="p-6">
            <h1 class="text-3xl font-bold text-gray-800 mb-1">{{ $venue->name }}</h1>
            <p class="text-gray-500 text-sm mb-1">
                <i class="fas fa-map-marker-alt mr-1"></i> {{ $venue->location ?? 'Malang' }}
            </p>
            <div class="flex items-center gap-2 mb-5">
                <i class="fas fa-clock text-green-600 text-sm"></i>
                <span class="text-gray-500 text-sm">{{ \Carbon\Carbon::parse($venue->open_time)->format('H:i') }} – {{ \Carbon\Carbon::parse($venue->close_time)->format('H:i') }}</span>
            </div>

            <!-- TWO COLUMN LAYOUT -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

                <!-- KIRI: Deskripsi -->
                <div>
                    <div class="mb-5">
                        <h2 class="text-lg font-bold text-gray-800 mb-2">Deskripsi</h2>
                        <p class="text-gray-600 leading-relaxed text-sm">
                            {{ $venue->description ?? 'Deskripsi venue belum tersedia.' }}
                        </p>
                    </div>

                    @if($venue->rules)
                    <hr class="border-gray-200 mb-5">
                    <div class="mb-5">
                        <h2 class="text-lg font-bold text-gray-800 mb-2">Peraturan</h2>
                        <div class="text-gray-600 leading-relaxed text-sm whitespace-pre-line">{{ $venue->rules }}</div>
                    </div>
                    @endif


                </div>

                <!-- KANAN: Fasilitas + Map -->
                <div>
                    <div class="mb-5">
                        <h2 class="text-lg font-bold text-gray-800 mb-3">Fasilitas</h2>
                        <div class="grid grid-cols-2 gap-y-2 gap-x-4">
                            @if(is_array($venue->facilities))
                                @foreach($venue->facilities as $fac)
                                <div class="flex items-center gap-2 text-sm text-gray-600">
                                    <i class="fas fa-check-circle text-[#1b3a1b] w-4 text-center text-sm"></i> {{ $fac }}
                                </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                    <!-- Map -->
                    <div class="rounded-xl overflow-hidden border border-gray-200 h-44 bg-gray-100 flex items-center justify-center relative">
                        @if($venue->latitude && $venue->longitude)
                            <iframe width="100%" height="100%" frameborder="0" style="border:0; position:absolute; top:0; left:0;"
                                src="https://maps.google.com/maps?q={{ $venue->latitude }},{{ $venue->longitude }}&z=15&output=embed"
                                allowfullscreen>
                            </iframe>
                        @else
                            <div class="text-center text-gray-400">
                                <i class="fas fa-map-marker-alt text-2xl mb-1 block text-[#1b3a1b]"></i>
                                <p class="text-sm">Peta Lokasi</p>
                                <p class="text-xs">{{ $venue->location ?? 'Malang, Jawa Timur' }}</p>
                            </div>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Pilih Lapangan Section -->
    <div class="bg-white rounded-xl overflow-hidden mb-8">
        <div class="p-6">
            <h2 class="text-xl font-bold text-gray-800 mb-5">Pilih Lapangan & Jadwal</h2>

            @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-4">
                {{ session('success') }}
            </div>
            @endif

            @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-4">
                {{ $errors->first() }}
            </div>
            @endif

            <!-- Tanggal Filter -->
            <div class="mb-6">
                <div class="flex items-center justify-between flex-wrap gap-3">
                    <div class="flex gap-2 flex-wrap">
                        @php
                            use Carbon\Carbon;
                            $today = Carbon::today();
                            $selectedDate = request('date', $today->format('Y-m-d'));
                        @endphp
                        @for($i=0; $i<7; $i++)
                            @php
                                $d = $today->copy()->addDays($i);
                                $dateStr = $d->format('Y-m-d');
                                $isActive = $dateStr === $selectedDate;
                            @endphp
                            <a href="?date={{ $dateStr }}" class="px-5 py-2.5 rounded-lg border text-sm text-center {{ $isActive ? 'border-green-500 bg-white text-[#1c3a0c] shadow-sm' : 'bg-gray-100 text-gray-600 hover:bg-gray-200 border-transparent' }}">
                                {{ $d->translatedFormat('l') }}<br>
                                <span class="text-xs font-normal">{{ $d->translatedFormat('d M') }}</span>
                            </a>
                        @endfor
                    </div>
                </div>
            </div>

            <!-- Daftar Lapangan -->
            <div class="space-y-4">
                @foreach($venue->fields as $idx => $field)
                <div class="border border-gray-200 rounded-xl overflow-hidden">
                    <div class="flex items-center gap-4 p-4 cursor-pointer hover:bg-gray-50 transition" onclick="toggleField('field{{ $field->id }}', this)">
                        <div class="w-28 h-20 bg-green-800 rounded-lg flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-running text-white text-3xl"></i>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-lg font-bold text-gray-800 mb-1">{{ $field->name }}</h3>
                            <div class="flex items-center gap-3 text-sm text-gray-500 mb-2">
                                <span class="flex items-center gap-1"><i class="fas fa-futbol text-gray-400 text-xs"></i> {{ $field->sport_type }}</span>
                                <span class="flex items-center gap-1"><i class="fas fa-expand-arrows-alt text-gray-400 text-xs"></i> {{ $field->is_indoor ? 'Indoor' : 'Outdoor' }}</span>
                                <span class="flex items-center gap-1"><i class="fas fa-users text-gray-400 text-xs"></i> {{ $field->capacity }} orang</span>
                            </div>
                            <span class="bg-yellow-500 text-white text-xs font-semibold px-4 py-1.5 rounded-full inline-flex items-center gap-1">
                                {{ $field->timeSlots->count() }} Jadwal Tersedia <i class="fas fa-chevron-{{ $idx === 0 ? 'up' : 'down' }} text-xs" id="arrow-field{{ $field->id }}"></i>
                            </span>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-bold text-green-700">Rp {{ number_format($field->price_per_hour, 0, ',', '.') }}</p>
                            <p class="text-xs text-gray-400">/ jam</p>
                        </div>
                    </div>

                    <!-- Jadwal Grid -->
                    <div id="field{{ $field->id }}" class="field-schedules grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-3 px-4 pb-4 border-t border-gray-100 pt-4" style="display: {{ $idx === 0 ? 'grid' : 'none' }}">
                        @forelse($field->timeSlots->sortBy('start_time') as $slot)
                        @php
                            $st = Carbon::parse($slot->start_time);
                            $et = Carbon::parse($slot->end_time);
                        @endphp
                        <div class="schedule-card border border-gray-200 rounded-xl p-3 text-center cursor-pointer hover:border-green-400 transition"
                             data-slot-id="{{ $slot->id }}"
                             data-field="{{ $field->name }}"
                             data-sport="{{ $field->sport_type }}"
                             data-time="{{ $st->format('H:i') }}-{{ $et->format('H:i') }}"
                             data-price="{{ $field->price_per_hour }}"
                             onclick="selectSchedule(this)">
                            <p class="text-sm font-bold text-gray-800">{{ $st->format('H:i') }} - {{ $et->format('H:i') }}</p>
                            <p class="text-xs text-gray-500 mt-1">Rp {{ number_format($field->price_per_hour, 0, ',', '.') }}</p>
                        </div>
                        @empty
                        <div class="col-span-full text-center py-4 text-gray-500 text-sm">Tidak ada jadwal tersedia di tanggal ini.</div>
                        @endforelse
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Tombol Booking (muncul setelah pilih jadwal) -->
            <div id="bookingBar" class="hidden mt-6 bg-green-50 border border-green-200 rounded-xl p-4 flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Dipilih:</p>
                    <p class="font-bold text-gray-800" id="selectedInfo">-</p>
                </div>
                <form method="POST" action="{{ route('venues.book') }}">
                    @csrf
                    <input type="hidden" name="time_slot_id" id="selectedSlotId">
                    <button type="submit"
                        class="bg-[#123012] text-white px-6 py-3 rounded-lg font-semibold text-sm shadow-sm hover:shadow-md hover:scale-[1.01] transition">
                        Booking & Buat Match →
                    </button>
                </form>
            </div>

        </div>
    </div>

    <!-- ULASAN SECTION (DUMMY DATA) -->
    <div class="bg-white rounded-xl p-6 mb-8 shadow-sm border border-gray-100">
        
        <!-- Header -->
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center gap-2">
                <div class="w-6 h-6 rounded-full bg-red-100 flex items-center justify-center">
                    <i class="fas fa-play text-red-600 text-[10px] ml-0.5"></i>
                </div>
                <h2 class="text-xl font-bold text-gray-800">Ulasan</h2>
            </div>
            <button onclick="document.getElementById('allReviewsModal').classList.remove('hidden')" class="text-red-700 font-semibold text-sm hover:underline">Lihat semua ulasan</button>
        </div>

        <!-- Rating Summary -->
        <div class="flex items-end gap-3 mb-8">
            <div class="flex items-baseline">
                <span class="text-4xl font-extrabold text-gray-900 leading-none">4.8</span>
                <span class="text-gray-400 text-lg ml-1 font-medium">/5</span>
            </div>
            <div class="flex gap-1 text-yellow-400 text-xl mb-1">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star-half-alt"></i>
            </div>
            <div class="text-gray-400 text-sm mb-1.5 ml-2 font-medium">
                59 rating • 14 ulasan
            </div>
        </div>

        <!-- Category Progress Bars -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
            <!-- Kebersihan -->
            <div>
                <div class="flex justify-between items-center mb-1.5">
                    <span class="text-sm font-semibold text-gray-700">Kebersihan</span>
                    <span class="text-sm font-bold text-gray-700">4.93</span>
                </div>
                <div class="w-full bg-gray-200 h-1.5 rounded-full overflow-hidden">
                    <div class="bg-red-800 h-1.5 rounded-full" style="width: 98%"></div>
                </div>
            </div>
            
            <!-- Kondisi Lapangan -->
            <div>
                <div class="flex justify-between items-center mb-1.5">
                    <span class="text-sm font-semibold text-gray-700">Kondisi Lapangan</span>
                    <span class="text-sm font-bold text-gray-700">4.69</span>
                </div>
                <div class="w-full bg-gray-200 h-1.5 rounded-full overflow-hidden">
                    <div class="bg-red-800 h-1.5 rounded-full" style="width: 94%"></div>
                </div>
            </div>

            <!-- Komunikasi -->
            <div>
                <div class="flex justify-between items-center mb-1.5">
                    <span class="text-sm font-semibold text-gray-700">Komunikasi</span>
                    <span class="text-sm font-bold text-gray-700">4.81</span>
                </div>
                <div class="w-full bg-gray-200 h-1.5 rounded-full overflow-hidden">
                    <div class="bg-red-800 h-1.5 rounded-full" style="width: 96%"></div>
                </div>
            </div>
        </div>

        <!-- Review Cards Container (Horizontal Scroll) -->
        <div class="relative group">
            
            <!-- Left/Right Nav Buttons -->
            <button onclick="document.getElementById('reviewsContainer').scrollBy({left: -1098, behavior: 'smooth'})" class="absolute -left-4 top-1/2 -translate-y-1/2 w-8 h-8 bg-white border border-gray-200 rounded-full shadow-sm flex items-center justify-center z-10 text-gray-500 hover:text-gray-800 hover:bg-gray-50 opacity-0 group-hover:opacity-100 transition-opacity">
                <i class="fas fa-chevron-left text-xs"></i>
            </button>
            <button onclick="document.getElementById('reviewsContainer').scrollBy({left: 1098, behavior: 'smooth'})" class="absolute -right-4 top-1/2 -translate-y-1/2 w-8 h-8 bg-white border border-gray-200 rounded-full shadow-sm flex items-center justify-center z-10 text-gray-500 hover:text-gray-800 hover:bg-gray-50 opacity-0 group-hover:opacity-100 transition-opacity">
                <i class="fas fa-chevron-right text-xs"></i>
            </button>

            <div id="reviewsContainer" class="flex overflow-x-auto gap-4 pb-4 snap-x snap-mandatory hide-scrollbar" style="scrollbar-width: none;">
                <style>.hide-scrollbar::-webkit-scrollbar { display: none; }</style>

                <!-- Card 1 -->
                <div class="snap-start shrink-0 w-[350px] border border-gray-200 rounded-xl p-5 bg-white">
                    <div class="flex justify-between items-start mb-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-pink-400 text-white font-bold flex items-center justify-center text-sm">
                                AA
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-800 text-sm leading-tight">Ade Aria</h3>
                                <p class="text-[11px] text-gray-400">Diulas: 15 April 2026</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-1 border border-gray-200 px-2 py-0.5 rounded text-xs font-bold text-gray-700">
                            <i class="fas fa-star text-yellow-400 text-[10px]"></i> 5.0
                        </div>
                    </div>
                    <p class="text-sm text-gray-700 mb-2 leading-relaxed">
                        netnya mulai bolong2 di bagian tengah, kalo ujan deres bgt ada bocor sedikit di bagian kiri lapangan. mohon diperbaiki <a href="#" class="text-red-700 font-semibold hover:underline">Selengkapnya</a>
                    </p>
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mt-4">PADEL</p>
                </div>

                <!-- Card 2 -->
                <div class="snap-start shrink-0 w-[350px] border border-gray-200 rounded-xl p-5 bg-white">
                    <div class="flex justify-between items-start mb-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-purple-400 text-white font-bold flex items-center justify-center text-sm">
                                SW
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-800 text-sm leading-tight">Satya Windy</h3>
                                <p class="text-[11px] text-gray-400">Diulas: 15 April 2026</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-1 border border-gray-200 px-2 py-0.5 rounded text-xs font-bold text-gray-700">
                            <i class="fas fa-star text-yellow-400 text-[10px]"></i> 4.3
                        </div>
                    </div>
                    <p class="text-sm text-gray-700 mb-2 leading-relaxed">
                        kipasnya kurang naik jadi panas banget nyelekep dan ada pembangunan bau cat banget
                    </p>
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mt-4">PADEL</p>
                </div>
                
                <!-- Card 3 -->
                <div class="snap-start shrink-0 w-[350px] border border-gray-200 rounded-xl p-5 bg-white">
                    <div class="flex justify-between items-start mb-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-blue-500 text-white font-bold flex items-center justify-center text-sm">
                                BR
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-800 text-sm leading-tight">Budi Raharjo</h3>
                                <p class="text-[11px] text-gray-400">Diulas: 10 April 2026</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-1 border border-gray-200 px-2 py-0.5 rounded text-xs font-bold text-gray-700">
                            <i class="fas fa-star text-yellow-400 text-[10px]"></i> 4.8
                        </div>
                    </div>
                    <p class="text-sm text-gray-700 mb-2 leading-relaxed">
                        Tempatnya bersih, parkir luas, dan rumput sintetisnya masih sangat empuk. Recomended banget buat main malam karena lampunya terang!
                    </p>
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mt-4">MINI SOCCER</p>
                </div>

                <!-- Card 4 -->
                <div class="snap-start shrink-0 w-[350px] border border-gray-200 rounded-xl p-5 bg-white">
                    <div class="flex justify-between items-start mb-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-green-500 text-white font-bold flex items-center justify-center text-sm">
                                DF
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-800 text-sm leading-tight">Dinda Fauziah</h3>
                                <p class="text-[11px] text-gray-400">Diulas: 2 April 2026</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-1 border border-gray-200 px-2 py-0.5 rounded text-xs font-bold text-gray-700">
                            <i class="fas fa-star text-yellow-400 text-[10px]"></i> 5.0
                        </div>
                    </div>
                    <p class="text-sm text-gray-700 mb-2 leading-relaxed">
                        Sering main di sini sama teman kantor. Lapangannya terawat dan penjaganya ramah banget. Kamar mandinya juga lumayan bersih.
                    </p>
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mt-4">BASKET</p>
                </div>

                <!-- Card 5 -->
                <div class="snap-start shrink-0 w-[350px] border border-gray-200 rounded-xl p-5 bg-white">
                    <div class="flex justify-between items-start mb-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-orange-400 text-white font-bold flex items-center justify-center text-sm">
                                RA
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-800 text-sm leading-tight">Rizky Aditya</h3>
                                <p class="text-[11px] text-gray-400">Diulas: 28 Maret 2026</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-1 border border-gray-200 px-2 py-0.5 rounded text-xs font-bold text-gray-700">
                            <i class="fas fa-star text-yellow-400 text-[10px]"></i> 4.5
                        </div>
                    </div>
                    <p class="text-sm text-gray-700 mb-2 leading-relaxed">
                        Akses ke lokasi gampang banget karena di pinggir jalan raya. Cuma sayangnya ruang gantinya agak sempit pas lagi rame.
                    </p>
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mt-4">FUTSAL</p>
                </div>
                
                <!-- Card 6 -->
                <div class="snap-start shrink-0 w-[350px] border border-gray-200 rounded-xl p-5 bg-white">
                    <div class="flex justify-between items-start mb-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-teal-500 text-white font-bold flex items-center justify-center text-sm">
                                TS
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-800 text-sm leading-tight">Tania Safitri</h3>
                                <p class="text-[11px] text-gray-400">Diulas: 20 Maret 2026</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-1 border border-gray-200 px-2 py-0.5 rounded text-xs font-bold text-gray-700">
                            <i class="fas fa-star text-yellow-400 text-[10px]"></i> 4.9
                        </div>
                    </div>
                    <p class="text-sm text-gray-700 mb-2 leading-relaxed">
                        Fasilitas air minum gratisnya ngebantu banget! Harga sewa sepadan dengan kualitas lapangan yang didapatkan. Mantap.
                    </p>
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mt-4">BADMINTON</p>
                </div>
                
                <!-- Card 7 -->
                <div class="snap-start shrink-0 w-[350px] border border-gray-200 rounded-xl p-5 bg-white">
                    <div class="flex justify-between items-start mb-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-red-400 text-white font-bold flex items-center justify-center text-sm">
                                MK
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-800 text-sm leading-tight">Muhammad Kevin</h3>
                                <p class="text-[11px] text-gray-400">Diulas: 15 Maret 2026</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-1 border border-gray-200 px-2 py-0.5 rounded text-xs font-bold text-gray-700">
                            <i class="fas fa-star text-yellow-400 text-[10px]"></i> 4.2
                        </div>
                    </div>
                    <p class="text-sm text-gray-700 mb-2 leading-relaxed">
                        Suka banget main voli di sini. Bola yang disewakan masih baru dan jaringnya kencang. Pasti balik lagi minggu depan.
                    </p>
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mt-4">VOLI</p>
                </div>
                
                <!-- Card 8 -->
                <div class="snap-start shrink-0 w-[350px] border border-gray-200 rounded-xl p-5 bg-white">
                    <div class="flex justify-between items-start mb-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-indigo-500 text-white font-bold flex items-center justify-center text-sm">
                                LN
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-800 text-sm leading-tight">Lutfi Nugroho</h3>
                                <p class="text-[11px] text-gray-400">Diulas: 10 Maret 2026</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-1 border border-gray-200 px-2 py-0.5 rounded text-xs font-bold text-gray-700">
                            <i class="fas fa-star text-yellow-400 text-[10px]"></i> 4.7
                        </div>
                    </div>
                    <p class="text-sm text-gray-700 mb-2 leading-relaxed">
                        Lapangan tenisnya standar nasional, pantulan bola sangat konsisten. Pengelola juga fast response saat ditanya jadwal kosong.
                    </p>
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mt-4">TENIS</p>
                </div>

            </div>
        </div>

    </div>

</div>

<!-- Modal Semua Ulasan -->
<div id="allReviewsModal" class="fixed inset-0 z-50 hidden bg-black/60 flex items-center justify-center p-4 backdrop-blur-sm">
    <div class="bg-white rounded-xl w-full max-w-3xl max-h-[90vh] flex flex-col shadow-2xl">
        <!-- Modal Header -->
        <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-gray-50/50 rounded-t-xl">
            <div>
                <h2 class="text-xl font-bold text-gray-800">Semua Ulasan</h2>
                <p class="text-sm text-gray-500 mt-1"><i class="fas fa-star text-yellow-400 mr-1"></i> 4.8 dari 14 ulasan</p>
            </div>
            <button onclick="document.getElementById('allReviewsModal').classList.add('hidden')" class="w-8 h-8 bg-white border border-gray-200 rounded-full flex items-center justify-center text-gray-500 hover:text-red-500 hover:border-red-200 hover:bg-red-50 transition-colors">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <!-- Modal Body (Scrollable List) -->
        <div class="p-6 overflow-y-auto flex-1 space-y-4 bg-gray-50">
            
            <!-- List Card 1 -->
            <div class="border border-gray-200 rounded-xl p-5 bg-white shadow-sm">
                <div class="flex justify-between items-start mb-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-pink-400 text-white font-bold flex items-center justify-center text-sm">
                            AA
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-800 text-sm leading-tight">Ade Aria</h3>
                            <p class="text-[11px] text-gray-400">Diulas: 15 April 2026</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-1 border border-gray-200 px-2 py-0.5 rounded text-xs font-bold text-gray-700 bg-gray-50">
                        <i class="fas fa-star text-yellow-400 text-[10px]"></i> 5.0
                    </div>
                </div>
                <p class="text-sm text-gray-700 mb-2 leading-relaxed">
                    netnya mulai bolong2 di bagian tengah, kalo ujan deres bgt ada bocor sedikit di bagian kiri lapangan. mohon diperbaiki <a href="#" class="text-red-700 font-semibold hover:underline">Selengkapnya</a>
                </p>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mt-4">PADEL</p>
            </div>

            <!-- List Card 2 -->
            <div class="border border-gray-200 rounded-xl p-5 bg-white shadow-sm">
                <div class="flex justify-between items-start mb-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-purple-400 text-white font-bold flex items-center justify-center text-sm">
                            SW
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-800 text-sm leading-tight">Satya Windy</h3>
                            <p class="text-[11px] text-gray-400">Diulas: 15 April 2026</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-1 border border-gray-200 px-2 py-0.5 rounded text-xs font-bold text-gray-700 bg-gray-50">
                        <i class="fas fa-star text-yellow-400 text-[10px]"></i> 4.3
                    </div>
                </div>
                <p class="text-sm text-gray-700 mb-2 leading-relaxed">
                    kipasnya kurang naik jadi panas banget nyelekep dan ada pembangunan bau cat banget
                </p>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mt-4">PADEL</p>
            </div>
            
            <!-- List Card 3 -->
            <div class="border border-gray-200 rounded-xl p-5 bg-white shadow-sm">
                <div class="flex justify-between items-start mb-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-blue-500 text-white font-bold flex items-center justify-center text-sm">
                            BR
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-800 text-sm leading-tight">Budi Raharjo</h3>
                            <p class="text-[11px] text-gray-400">Diulas: 10 April 2026</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-1 border border-gray-200 px-2 py-0.5 rounded text-xs font-bold text-gray-700 bg-gray-50">
                        <i class="fas fa-star text-yellow-400 text-[10px]"></i> 4.8
                    </div>
                </div>
                <p class="text-sm text-gray-700 mb-2 leading-relaxed">
                    Tempatnya bersih, parkir luas, dan rumput sintetisnya masih sangat empuk. Recomended banget buat main malam karena lampunya terang!
                </p>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mt-4">MINI SOCCER</p>
            </div>

            <!-- List Card 4 (Extra dummy) -->
            <div class="border border-gray-200 rounded-xl p-5 bg-white shadow-sm">
                <div class="flex justify-between items-start mb-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-green-500 text-white font-bold flex items-center justify-center text-sm">
                            DF
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-800 text-sm leading-tight">Dinda Fauziah</h3>
                            <p class="text-[11px] text-gray-400">Diulas: 2 April 2026</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-1 border border-gray-200 px-2 py-0.5 rounded text-xs font-bold text-gray-700 bg-gray-50">
                        <i class="fas fa-star text-yellow-400 text-[10px]"></i> 5.0
                    </div>
                </div>
                <p class="text-sm text-gray-700 mb-2 leading-relaxed">
                    Sering main di sini sama teman kantor. Lapangannya terawat dan penjaganya ramah banget. Kamar mandinya juga lumayan bersih.
                </p>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mt-4">BASKET</p>
            </div>

        </div>
    </div>
</div>

<script>
    let selectedSlot = null;

    function toggleField(id, header) {
        const panel = document.getElementById(id);
        const arrowId = 'arrow-' + id;
        const arrow = document.getElementById(arrowId);
        const isOpen = panel.style.display === 'grid';

        if (isOpen) {
            panel.style.display = 'none';
            if (arrow) { arrow.classList.remove('fa-chevron-up'); arrow.classList.add('fa-chevron-down'); }
        } else {
            panel.style.display = 'grid';
            if (arrow) { arrow.classList.remove('fa-chevron-down'); arrow.classList.add('fa-chevron-up'); }
        }
    }

    function selectSchedule(card) {
        // Reset all cards
        document.querySelectorAll('.schedule-card').forEach(c => {
            c.classList.remove('border-green-500', 'bg-green-50', 'selected');
            c.classList.add('border-gray-200');
        });

        // Highlight selected
        card.classList.add('border-green-500', 'bg-green-50', 'selected');
        card.classList.remove('border-gray-200');

        // Store selection
        const slotId = card.dataset.slotId;
        const field = card.dataset.field;
        const sport = card.dataset.sport;
        const time = card.dataset.time;
        const price = parseInt(card.dataset.price);

        document.getElementById('selectedSlotId').value = slotId;
        document.getElementById('selectedInfo').innerHTML =
            `${field} — ${sport} — ${time} — Rp ${price.toLocaleString('id-ID')}`;

        document.getElementById('bookingBar').classList.remove('hidden');
    }
</script>

</body>
</html>
