<!DOCTYPE html>
<html lang="id">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
            <div class="flex items-center gap-2 mb-5">
                <i class="fas fa-clock text-green-600 text-sm"></i>
                <span class="text-gray-500 text-sm">07:00 – 22:00</span>
            </div>

            <!-- TWO COLUMN LAYOUT -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

                <!-- KIRI: Deskripsi + Aturan -->
                <div>
                    <div class="mb-5">
                        <h2 class="text-lg font-bold text-gray-800 mb-2">Deskripsi</h2>
                        <p class="text-gray-600 leading-relaxed text-sm">
                            {{ $venue->description ?? 'Deskripsi venue belum tersedia.' }}
                        </p>
                    </div>
                    <hr class="border-gray-200 mb-5">
                    <div>
                        <h2 class="text-lg font-bold text-gray-800 mb-2">Aturan Venue</h2>
                        <ul class="text-gray-600 text-sm space-y-1.5">
                            <li class="flex items-start gap-2"><span class="text-green-600 font-bold">1.</span> Gunakan sepatu olahraga khusus tennis</li>
                            <li class="flex items-start gap-2"><span class="text-green-600 font-bold">2.</span> Dilarang membawa minuman keras, narkoba</li>
                            <li class="flex items-start gap-2"><span class="text-green-600 font-bold">3.</span> Lapangan buka mulai pukul 06.00–22.00...</li>
                        </ul>
                        <button class="text-green-600 text-sm font-semibold mt-2 hover:text-green-700">Baca Selengkapnya →</button>
                    </div>
                </div>

                <!-- KANAN: Fasilitas + Map -->
                <div>
                    <div class="mb-5">
                        <h2 class="text-lg font-bold text-gray-800 mb-3">Fasilitas</h2>
                        <div class="grid grid-cols-2 gap-y-2 gap-x-4">
                            <div class="flex items-center gap-2 text-sm text-gray-600">
                                <i class="fas fa-motorcycle text-[#1b3a1b] w-4 text-center text-sm"></i> Parkir Motor
                            </div>
                            <div class="flex items-center gap-2 text-sm text-gray-600">
                                <i class="fas fa-shower text-[#1b3a1b] w-4 text-center text-sm"></i> Shower
                            </div>
                            <div class="flex items-center gap-2 text-sm text-gray-600">
                                <i class="fas fa-car text-[#1b3a1b] w-4 text-center text-sm"></i> Parkir Mobil
                            </div>
                            <div class="flex items-center gap-2 text-sm text-gray-600">
                                <i class="fas fa-toilet text-[#1b3a1b] w-4 text-center text-sm"></i> Toilet
                            </div>
                            <div class="flex items-center gap-2 text-sm text-gray-600">
                                <i class="fas fa-utensils text-[#1b3a1b] w-4 text-center text-sm"></i> Kantin
                            </div>
                            <div class="flex items-center gap-2 text-sm text-gray-600">
                                <i class="fas fa-mosque text-[#1b3a1b] w-4 text-center text-sm"></i> Mushola
                            </div>
                        </div>
                    </div>
                    <!-- Map -->
                    <div class="rounded-xl overflow-hidden border border-gray-200 h-44 bg-gray-100 flex items-center justify-center">
                        <div class="text-center text-gray-400">
                            <i class="fas fa-map-marker-alt text-2xl mb-1 block text-[#1b3a1b]"></i>
                            <p class="text-sm">Peta Lokasi</p>
                            <p class="text-xs">{{ $venue->location ?? 'Malang, Jawa Timur' }}</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Pilih Lapangan Section -->
    <div class="bg-white rounded-xl overflow-hidden mb-8">
        <div class="p-6">
            <h2 class="text-xl font-bold text-gray-800 mb-5">Pilih Lapangan</h2>

            <!-- Tanggal Filter -->
            <div class="mb-6">
                <div class="flex items-center justify-between flex-wrap gap-3">
                    <div class="flex gap-2 flex-wrap ">
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
                            <a href="?date={{ $dateStr }}" class="day-btn px-5 py-2.5 rounded-lg border text-sm text-center {{ $isActive ? 'active border-green-500 bg-white text-[#1c3a0c] shadow-sm' : 'bg-gray-100 text-gray-600 hover:bg-gray-200 border-transparent' }}">
                                {{ $d->translatedFormat('l') }}<br>
                                <span class="text-xs font-normal">{{ $d->translatedFormat('d M') }}</span>
                            </a>
                        @endfor
                    </div>
                    <div class="flex gap-2">
                        <button class="px-4 py-2 rounded-lg text-sm border border-gray-300 text-gray-600 hover:bg-gray-50">
                            <i class="fas fa-filter mr-1"></i> Filter Waktu
                        </button>
                        <button class="px-4 py-2 rounded-lg text-sm border border-gray-300 text-gray-600 hover:bg-gray-50">
                            <i class="fas fa-calendar-alt mr-1"></i> Cari
                        </button>
                    </div>
                </div>
            </div>

            <!-- Daftar Lapangan -->
            <div class="space-y-4">
                @foreach($venue->fields as $idx => $field)
                <!-- Lapangan {{ $idx + 1 }} -->
                <div class="border border-gray-200 rounded-xl overflow-hidden">
                    <div class="flex items-center gap-4 p-4 cursor-pointer hover:bg-gray-50 transition" onclick="toggleField('field{{ $field->id }}', this)">
                        <!-- Thumbnail -->
                        <div class="w-28 h-20 bg-green-800 rounded-lg flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-running text-white text-3xl"></i>
                        </div>
                        <!-- Info -->
                        <div class="flex-1">
                            <h3 class="text-lg font-bold text-gray-800 mb-1">{{ $field->name }}</h3>
                            <div class="flex items-center gap-3 text-sm text-gray-500 mb-2">
                                <span class="flex items-center gap-1"><i class="fas fa-futbol text-gray-400 text-xs"></i> {{ $field->sport_type }}</span>
                                <span class="flex items-center gap-1"><i class="fas fa-expand-arrows-alt text-gray-400 text-xs"></i> {{ $field->is_indoor ? 'Indoor' : 'Outdoor' }}</span>
                            </div>
                            <button class="bg-yellow-500 text-white text-xs font-semibold px-4 py-1.5 rounded-full flex items-center gap-1">
                                {{ count($field->timeSlots) }} Jadwal Tersedia <i class="fas fa-chevron-{{ $idx === 0 ? 'up' : 'down' }} text-xs" id="arrow-field{{ $field->id }}"></i>
                            </button>
                        </div>
                    </div>
                    <!-- Jadwal Grid -->
                    <div id="field{{ $field->id }}" class="field-schedules {{ $idx === 0 ? 'open' : '' }} grid-cols-2 md:grid-cols-4 gap-3 px-4 pb-4 border-t border-gray-100 pt-4" style="display: {{ $idx === 0 ? 'grid' : 'none' }}">
                        @forelse($field->timeSlots as $slot)
                        @php
                            $st = \Carbon\Carbon::parse($slot->start_time);
                            $et = \Carbon\Carbon::parse($slot->end_time);
                            $dur = $st->diffInMinutes($et);
                        @endphp
                        <div class="schedule-card border border-gray-200 rounded-xl p-3 text-center cursor-pointer hover:border-green-400" onclick="selectSchedule(this)">
                            <p class="text-xs text-gray-400 mb-0.5">{{ $dur }} menit</p>
                            <p class="text-sm font-bold text-gray-800">{{ $st->format('H:i') }} - {{ $et->format('H:i') }}</p>
                            <p class="text-xs text-gray-500 mt-0.5">Rp {{ number_format($field->price_per_hour, 0, ',', '.') }}</p>
                        </div>
                        @empty
                        <div class="col-span-full text-center py-4 text-gray-500 text-sm">Tidak ada jadwal tersedia di tanggal ini.</div>
                        @endforelse
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

</div>

<script>
    function toggleField(id, header) {
        const panel = document.getElementById(id);
        const arrowId = 'arrow-' + id;
        const arrow = document.getElementById(arrowId);
        const isOpen = panel.classList.contains('open');
        if (isOpen) {
            panel.classList.remove('open');
            panel.style.display = 'none';
            if (arrow) { arrow.classList.remove('fa-chevron-up'); arrow.classList.add('fa-chevron-down'); }
        } else {
            panel.classList.add('open');
            panel.style.display = 'grid';
            if (arrow) { arrow.classList.remove('fa-chevron-down'); arrow.classList.add('fa-chevron-up'); }
        }
    }

    function selectSchedule(card) {
        const parent = card.closest('.field-schedules');
        parent.querySelectorAll('.schedule-card').forEach(c => {
            c.classList.remove('selected', 'border-green-500', 'bg-green-50');
            c.classList.add('border-gray-200');
        });
        card.classList.add('selected', 'border-green-500', 'bg-green-50');
        card.classList.remove('border-gray-200');
    }
</script>

</body>
</html>