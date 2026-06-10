{{-- resources/views/field-detail.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Field Detail</title>

    @if (app()->environment('production'))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script src="https://cdn.tailwindcss.com"></script>
    @endif

    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,400;0,9..40,500;0,9..40,700;1,9..40,400&family=Bebas+Neue&display=swap" rel="stylesheet">

    <style>
        .font-bebas { font-family: 'Bebas Neue', sans-serif; }
        body { font-family: 'DM Sans', sans-serif; }

        .line-clamp-3 {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        #dateContainer::-webkit-scrollbar { display: none; }
        #dateContainer { -ms-overflow-style: none; scrollbar-width: none; }

        .schedule-panel {
            display: none;
        }
        .schedule-panel.open {
            display: block;
            animation: slideDown .2s ease;
        }
        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-6px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* Available slot */
        .slot-available {
            background-color: #f3f4f6;
            cursor: pointer;
        }
        .slot-available:hover {
            background-color: #e5e7eb;
        }
        .slot-available.selected {
            background-color: #1c3a1c;
            color: white;
        }
        .slot-available.selected .slot-label,
        .slot-available.selected .slot-price {
            color: #a3c4a3;
        }

        /* Booked slot */
        .slot-booked {
            background-color: #4b5563;
            cursor: not-allowed;
        }
        .slot-booked .slot-label,
        .slot-booked .slot-time,
        .slot-booked .slot-price {
            color: #9ca3af;
        }

        .chevron { transition: transform .2s; }
        .chevron.up { transform: rotate(180deg); }
    </style>
</head>

<body class="bg-white text-gray-900">

<div class="max-w-5xl mx-auto pb-16 px-4 md:px-6">

    {{-- ================= PHOTO GRID --}}
    <div class="grid grid-cols-3 gap-2 h-[300px] md:h-[360px] mt-4">
        <div class="col-span-2 bg-gray-200 overflow-hidden rounded-xl">
            <img src="{{ $venue->photos[0] ?? 'https://placehold.co/800x400/cccccc/999999?text=Foto+Utama' }}"
                 class="w-full h-full object-cover">
        </div>
        <div class="grid grid-rows-2 gap-2">
            <div class="bg-gray-200 overflow-hidden rounded-xl">
                <img src="{{ $venue->photos[1] ?? 'https://placehold.co/400x200/cccccc/999999?text=Foto+2' }}"
                     class="w-full h-full object-cover">
            </div>
            <div class="relative bg-gray-200 overflow-hidden rounded-xl">
                <img src="{{ $venue->photos[2] ?? 'https://placehold.co/400x200/cccccc/999999?text=Foto+3' }}"
                     class="w-full h-full object-cover">
                <button class="absolute bottom-2 right-2 text-xs text-white bg-black/50 hover:bg-black/70 px-2 py-1 rounded transition">
                    Lihat semua foto
                </button>
            </div>
        </div>
    </div>

    {{-- ================= TITLE --}}
    <div class="mt-5">
        <h1 class="font-bebas text-4xl leading-tight tracking-wide">
            {{ strtoupper($venue->name ?? 'VENUE POLINEMA JOS') }}
        </h1>
        <p class="text-base font-semibold text-gray-800 mt-0.5">
            {{ $venue->open_time ?? '07:00' }} – {{ $venue->close_time ?? '22:00' }}
        </p>
    </div>

    {{-- ================= CONTENT --}}
    <div class="grid md:grid-cols-2 gap-10 mt-6">

        {{-- LEFT: Deskripsi + Aturan --}}
        <div>
            <h2 class="font-bold text-xl mb-2">Deskripsi</h2>

            @php
                $description = $venue->description ?? 'Samator Tennis Court merupakan lapangan tennis indoor tertutup dengan lantai khusus tenis yang mendukung pergerakan cepat dan aman. Area ini memiliki pencahayaan buatan yang stabil, dinding pelindung, serta ruang yang cukup luas untuk aktivitas bermain. Lapangan ini memungkinkan permainan tenis dilakukan kapan saja tanpa terpengaruh kondisi cuaca.';
            @endphp

            <div id="desc-text" class="text-sm text-gray-600 leading-relaxed line-clamp-3">
                {{ $description }}
            </div>
            <button onclick="toggleDesc()" id="desc-btn"
                class="text-sm text-red-500 mt-1 font-medium hover:underline">
                Baca Selengkapnya
            </button>

            <hr class="my-5 border-gray-200">

            <h2 class="font-bold text-xl mb-2">Aturan Venue</h2>

            @php
                $rules = $venue->rules ?? [
                    'Gunakan sepatu olahraga khusus tennis',
                    'Dilarang membawa minuman keras, narkoba',
                    'Lapangan buka mulai pukul 06.00–22.00',
                    'Tidak diperkenankan membawa makanan ke dalam lapangan',
                    'Jaga kebersihan lapangan dan fasilitas',
                ];
            @endphp

            <ol id="rules-list" class="text-sm text-gray-600 list-decimal ml-4 space-y-1">
                @foreach($rules as $i => $rule)
                    <li class="{{ $i >= 3 ? 'rule-extra hidden' : '' }}">{{ $rule }}</li>
                @endforeach
            </ol>
            <button onclick="toggleRules()" id="rules-btn"
                class="text-sm text-red-500 mt-2 font-medium hover:underline">
                Baca Selengkapnya
            </button>
        </div>

        {{-- RIGHT: Fasilitas + Maps --}}
        <div>
            <h2 class="font-bold text-xl mb-4">Fasilitas</h2>

            @php
                $facilities = $venue->facilities ?? [
                    ['icon' => 'motor',  'label' => 'Parkir Motor'],
                    ['icon' => 'shower', 'label' => 'Shower'],
                    ['icon' => 'mobil',  'label' => 'Parkir Mobil'],
                    ['icon' => 'toilet', 'label' => 'Toilet'],
                    ['icon' => 'kantin', 'label' => 'Kantin'],
                    ['icon' => 'musola', 'label' => 'Mushola'],
                ];
                $iconMap = [
                    'motor'  => '<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3c-1 0-2 .5-2.5 1.5L8 7H5a2 2 0 00-2 2v1h1.5a3.5 3.5 0 000 7H6a3.5 3.5 0 003.5-3.5V12h5v1.5A3.5 3.5 0 0018 17h1.5a3.5 3.5 0 000-7H18l-1.5-4A2.5 2.5 0 0014 5h-2z"/></svg>',
                    'mobil'  => '<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 17H7a2 2 0 01-2-2V9a2 2 0 012-2h10a2 2 0 012 2v6a2 2 0 01-2 2h-2m-6 0h6m-6 0v1m6-1v1M5 9l1-3h12l1 3"/><circle cx="9" cy="17" r="1" fill="currentColor"/><circle cx="15" cy="17" r="1" fill="currentColor"/></svg>',
                    'shower' => '<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4 12h16M4 12a8 8 0 0116 0M4 12V6a4 4 0 014-4h.5M15 16l-.5 2M12 16v2M9 16l.5 2"/></svg>',
                    'toilet' => '<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M8 21V10a4 4 0 018 0v11M8 21h8M5 10h14M12 3a2 2 0 100 4 2 2 0 000-4z"/></svg>',
                    'kantin' => '<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13l-1.5 7h13L17 13M9 20a1 1 0 100 2 1 1 0 000-2zm6 0a1 1 0 100 2 1 1 0 000-2z"/></svg>',
                    'musola' => '<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 2C8 2 5 5 5 9c0 5 7 13 7 13s7-8 7-13c0-4-3-7-7-7z"/><circle cx="12" cy="9" r="2.5" stroke="currentColor" stroke-width="1.5" fill="none"/></svg>',
                ];
            @endphp

            <div class="grid grid-cols-2 gap-x-6 gap-y-3">
                @foreach($facilities as $f)
                    @php
                        $fLabel = is_array($f) ? $f['label'] : $f;
                        $fKey   = is_array($f) ? ($f['icon'] ?? 'kantin') : 'kantin';
                    @endphp
                    <div class="flex items-center gap-2 text-sm text-gray-700">
                        <span class="text-gray-600 flex-shrink-0">
                            {!! $iconMap[$fKey] ?? $iconMap['kantin'] !!}
                        </span>
                        {{ $fLabel }}
                    </div>
                @endforeach
            </div>

            <div class="mt-5 h-44 bg-gray-100 rounded-xl overflow-hidden flex items-center justify-center text-gray-400 text-sm border border-gray-200 relative">
                @if(isset($venue->lat) && isset($venue->lng))
                    <iframe width="100%" height="100%" frameborder="0" style="border:0"
                        src="https://maps.google.com/maps?q={{ $venue->lat }},{{ $venue->lng }}&z=15&output=embed"
                        allowfullscreen>
                    </iframe>
                @else
                    <span>Maps</span>
                @endif
            </div>
        </div>

    </div>

    {{-- ================= PILIH LAPANGAN --}}
    <div class="mt-10">

        <h2 class="text-2xl font-bold mb-4">Pilih Lapangan</h2>

        {{-- DATE ROW --}}
        <div class="flex items-center gap-3 mb-6 flex-wrap md:flex-nowrap">

            <div id="dateContainer" class="flex gap-2 overflow-x-auto flex-1 min-w-0">
                @php
                    $dates = [
                        ['day'=>'Sen','date'=>'13 Apr'],
                        ['day'=>'Sel','date'=>'14 Apr'],
                        ['day'=>'Rab','date'=>'15 Apr'],
                        ['day'=>'Kam','date'=>'16 Apr'],
                        ['day'=>'Jum','date'=>'17 Apr'],
                        ['day'=>'Sab','date'=>'18 Apr'],
                        ['day'=>'Min','date'=>'19 Apr'],
                    ];
                @endphp

                @foreach($dates as $i => $d)
                <button onclick="selectDate(this)"
                    class="date-btn flex-shrink-0 min-w-[64px] border rounded-lg px-3 py-2 text-center transition
                    {{ $i==0 ? 'bg-green-50 border-[#1c3a1c] text-[#1c3a1c]' : 'border-gray-300 text-gray-700 hover:border-gray-400' }}">
                    <p class="text-xs font-normal">{{ $d['day'] }}</p>
                    <p class="font-semibold text-sm">{{ $d['date'] }}</p>
                </button>
                @endforeach
            </div>

            <div class="flex gap-2 flex-shrink-0">
                <button class="flex items-center gap-2 border border-gray-300 rounded-lg px-3 py-2 text-sm font-medium hover:bg-gray-50 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <rect x="3" y="4" width="18" height="18" rx="2" stroke="currentColor" stroke-width="1.5" fill="none"/>
                        <path stroke-linecap="round" d="M8 2v4M16 2v4M3 10h18"/>
                    </svg>
                </button>

                <button class="flex items-center gap-2 bg-[#1c3a1c] text-white rounded-lg px-4 py-2 text-sm font-medium hover:bg-[#2a5228] transition">
                    Filter Waktu
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>

                <button class="flex items-center gap-2 bg-[#1c3a1c] text-white rounded-lg px-4 py-2 text-sm font-medium hover:bg-[#2a5228] transition">
                    Cabor
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
            </div>

        </div>

        {{-- COURTS LIST --}}
        @php
            $courtsData = $courts ?? [];

            if(empty($courtsData)) {
                $courtsData = [
                    (object)[
                        'photo'     => null,
                        'type'      => 'Tennis',
                        'location'  => 'Outdoor',
                        'schedules' => [
                            (object)['start'=>'08:00','end'=>'09:00','price'=>100000,'duration'=>60,'is_booked'=>false],
                            (object)['start'=>'09:00','end'=>'10:00','price'=>100000,'duration'=>60,'is_booked'=>true],
                        ]
                    ],
                    (object)[
                        'photo'     => null,
                        'type'      => 'Tennis',
                        'location'  => 'Outdoor',
                        'schedules' => [
                            (object)['start'=>'08:00','end'=>'09:00','price'=>100000,'duration'=>60,'is_booked'=>false],
                            (object)['start'=>'09:00','end'=>'10:00','price'=>100000,'duration'=>60,'is_booked'=>false],
                            (object)['start'=>'10:00','end'=>'11:00','price'=>100000,'duration'=>60,'is_booked'=>true],
                            (object)['start'=>'11:00','end'=>'12:00','price'=>50000, 'duration'=>60,'is_booked'=>true],
                            (object)['start'=>'12:00','end'=>'13:00','price'=>50000, 'duration'=>60,'is_booked'=>false],
                            (object)['start'=>'13:00','end'=>'14:00','price'=>50000, 'duration'=>60,'is_booked'=>false],
                            (object)['start'=>'14:00','end'=>'15:00','price'=>50000, 'duration'=>60,'is_booked'=>true],
                            (object)['start'=>'15:00','end'=>'16:00','price'=>100000,'duration'=>60,'is_booked'=>false],
                            (object)['start'=>'16:00','end'=>'17:00','price'=>100000,'duration'=>60,'is_booked'=>false],
                            (object)['start'=>'17:00','end'=>'18:00','price'=>100000,'duration'=>60,'is_booked'=>true],
                            (object)['start'=>'18:00','end'=>'19:00','price'=>100000,'duration'=>60,'is_booked'=>false],
                            (object)['start'=>'19:00','end'=>'20:00','price'=>100000,'duration'=>60,'is_booked'=>false],
                        ]
                    ],
                ];
            }
        @endphp

        @foreach($courtsData as $idx => $court)
        @php
            $courtIdx   = $idx + 1;
            $jadwalId   = 'jadwal-' . $courtIdx;
            $btnId      = 'btn-' . $courtIdx;
            $schedules  = $court->schedules ?? [];
            $totalCount = count($schedules);
            // Count only available (non-booked) schedules for the label
            $availCount = 0;
            foreach($schedules as $s) { if(!($s->is_booked ?? false)) $availCount++; }
        @endphp

        <div class="mb-8">

            {{-- Court row: image left, info + toggle button right --}}
            <div class="flex gap-4 items-start">

                {{-- Court Image --}}
                <div class="w-40 h-28 flex-shrink-0 rounded-xl overflow-hidden bg-gray-200">
                    @if(!empty($court->photo))
                        <img src="{{ $court->photo }}" class="w-full h-full object-cover">
                    @else
                        {{-- Checkerboard placeholder --}}
                        <div class="w-full h-full" style="background-image: repeating-conic-gradient(#d1d5db 0% 25%, #e5e7eb 0% 50%); background-size: 20px 20px;"></div>
                    @endif
                </div>

                {{-- Court Info --}}
                <div class="flex-1">
                    <h3 class="font-bold text-lg">Lapangan {{ $courtIdx }}</h3>

                    <div class="flex flex-col gap-1 mt-1">
                        <div class="flex items-center gap-1.5 text-sm text-gray-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <circle cx="11" cy="11" r="6" stroke="currentColor" stroke-width="1.5" fill="none"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 16.5l4 4M8 8h6M11 5v12"/>
                            </svg>
                            {{ $court->type ?? 'Tennis' }}
                        </div>
                        <div class="flex items-center gap-1.5 text-sm text-gray-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <rect x="3" y="3" width="18" height="18" rx="2" stroke="currentColor" stroke-width="1.5" fill="none"/>
                                <path stroke-linecap="round" d="M3 9h18M9 3v18"/>
                            </svg>
                            {{ $court->location ?? 'Outdoor' }}
                        </div>
                    </div>

                    {{-- Dropdown toggle button --}}
                    <button id="{{ $btnId }}" onclick="toggleJadwal('{{ $jadwalId }}', '{{ $btnId }}')"
                        class="mt-3 bg-[#1c3a1c] text-white px-4 py-2 rounded-lg text-sm font-medium flex items-center gap-2 hover:bg-[#2a5228] transition">
                        <span>{{ $availCount ?: ($totalCount ?: 6) }} Jadwal Tersedia</span>
                        <svg class="chevron w-3.5 h-3.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                </div>
            </div>

            {{-- SCHEDULE PANEL
                 Offset left to align with the info column (image w-40 = 160px + gap-4 = 16px => ml-44) --}}
            <div id="{{ $jadwalId }}" class="schedule-panel mt-3 ml-44">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-3">

                    @forelse($schedules as $schedule)
                        @php $isBooked = $schedule->is_booked ?? false; @endphp

                        @if($isBooked)
                            {{-- Booked: grey, not clickable --}}
                            <div class="slot-booked rounded-xl p-3 text-center select-none">
                                <p class="slot-label text-xs mb-0.5">{{ $schedule->duration ?? 60 }} menit</p>
                                <p class="slot-time font-semibold text-sm">{{ $schedule->start }} - {{ $schedule->end }}</p>
                                <p class="slot-price text-xs mt-0.5">Rp {{ number_format($schedule->price, 0, ',', '.') }}</p>
                            </div>
                        @else
                            {{-- Available: clickable --}}
                            <button onclick="selectSlot(this)"
                                class="slot-available rounded-xl p-3 text-center transition">
                                <p class="slot-label text-xs text-gray-400 mb-0.5">{{ $schedule->duration ?? 60 }} menit</p>
                                <p class="slot-time font-semibold text-sm">{{ $schedule->start }} - {{ $schedule->end }}</p>
                                <p class="slot-price text-xs text-gray-500 mt-0.5">Rp {{ number_format($schedule->price, 0, ',', '.') }}</p>
                            </button>
                        @endif

                    @empty
                        {{-- Fallback dummy slots --}}
                        @for($s = 0; $s < 6; $s++)
                        <button onclick="selectSlot(this)" class="slot-available rounded-xl p-3 text-center transition">
                            <p class="slot-label text-xs text-gray-400 mb-0.5">60 menit</p>
                            <p class="slot-time font-semibold text-sm">08:00 - 09:00</p>
                            <p class="slot-price text-xs text-gray-500 mt-0.5">Rp 100.000</p>
                        </button>
                        @endfor
                    @endforelse

                </div>
            </div>

        </div>

        @if(!$loop->last)
            <hr class="border-gray-100 mb-8">
        @endif

        @endforeach

    </div>

</div>

<script>
function toggleDesc() {
    const el  = document.getElementById('desc-text');
    const btn = document.getElementById('desc-btn');
    const isClamp = el.classList.contains('line-clamp-3');
    el.classList.toggle('line-clamp-3', !isClamp);
    btn.textContent = isClamp ? 'Tutup' : 'Baca Selengkapnya';
}

function toggleRules() {
    const extras = document.querySelectorAll('.rule-extra');
    const btn    = document.getElementById('rules-btn');
    const hidden = extras[0]?.classList.contains('hidden');
    extras.forEach(el => el.classList.toggle('hidden', !hidden));
    btn.textContent = hidden ? 'Tutup' : 'Baca Selengkapnya';
}

function selectDate(el) {
    document.querySelectorAll('.date-btn').forEach(btn => {
        btn.classList.remove('bg-green-50', 'border-[#1c3a1c]', 'text-[#1c3a1c]');
        btn.classList.add('border-gray-300', 'text-gray-700');
    });
    el.classList.remove('border-gray-300', 'text-gray-700');
    el.classList.add('bg-green-50', 'border-[#1c3a1c]', 'text-[#1c3a1c]');
}

function toggleJadwal(panelId, btnId) {
    const panel   = document.getElementById(panelId);
    const btn     = document.getElementById(btnId);
    const chevron = btn.querySelector('.chevron');
    const isOpen  = panel.classList.contains('open');
    panel.classList.toggle('open', !isOpen);
    chevron.classList.toggle('up', !isOpen);
}

function selectSlot(el) {
    const panel = el.closest('.schedule-panel');
    panel.querySelectorAll('.slot-available').forEach(s => s.classList.remove('selected'));
    el.classList.add('selected');
}
</script>

</body>
</html>