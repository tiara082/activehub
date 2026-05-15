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
                    <hr class="border-gray-200 mb-5">
                    <div>
                        <h2 class="text-lg font-bold text-gray-800 mb-2">Jenis Olahraga</h2>
                        <div class="flex gap-2 flex-wrap">
                            @if(is_array($venue->sport_type))
                                @foreach($venue->sport_type as $sport)
                                    <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-medium">{{ $sport }}</span>
                                @endforeach
                            @elseif($venue->sport_type)
                                <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-medium">{{ $venue->sport_type }}</span>
                            @endif
                        </div>
                    </div>
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
