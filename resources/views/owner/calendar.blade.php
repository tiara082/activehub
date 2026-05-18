{{-- resources/views/owner/pages/calendar.blade.php --}}
@extends('partials.app')

@section('title', 'Slot Kalender')
@section('page-title', 'Slot Kalender')
@section('page-subtitle', 'Atur ketersediaan dan blokir waktu lapangan')
@section('cta-label', 'Block Tanggal')
@section('cta-href', '#')

@section('content')

<div class="grid lg:grid-cols-5 gap-6">

    <div class="lg:col-span-2 bg-white rounded-2xl border border-gray-100 overflow-hidden shadow-sm">

        {{-- HEADER --}}
        <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100">

            {{-- LEFT INFO --}}
            <div>
                <p class="font-semibold text-gray-800 text-sm">{{ \Carbon\Carbon::parse($date)->translatedFormat('F Y') }}</p>
                <p class="text-xs text-gray-400">Klik tanggal untuk lihat slot</p>
            </div>

            {{-- RIGHT ACTION (POJOK) --}}
            <div class="flex items-center gap-2">
                <a href="{{ route('owner.calendar', ['month' => \Carbon\Carbon::parse($date)->subMonth()->format('m'), 'year' => \Carbon\Carbon::parse($date)->subMonth()->format('Y')]) }}" class="px-2 py-1 bg-gray-100 rounded hover:bg-gray-200">&lt;</a>
                <a href="{{ route('owner.calendar', ['month' => \Carbon\Carbon::parse($date)->addMonth()->format('m'), 'year' => \Carbon\Carbon::parse($date)->addMonth()->format('Y')]) }}" class="px-2 py-1 bg-gray-100 rounded hover:bg-gray-200">&gt;</a>
                
                <button onclick="openManageBlockModal()" class="px-3 py-1.5 text-[11px] rounded-xl bg-red-50 text-red-600 hover:bg-red-100 transition font-semibold">
                    Kelola Blokir
                </button>
            </div>

        </div>

        {{-- DAY LABELS --}}
        <div class="grid grid-cols-7 px-3 pt-3">
            @foreach(['Min','Sen','Sel','Rab','Kam','Jum','Sab'] as $d)
                <div class="text-center text-[10px] font-medium text-gray-400 py-1.5">
                    {{ $d }}
                </div>
            @endforeach
        </div>

        <div class="grid grid-cols-7 gap-1 px-3 pb-4">

            @foreach($days as $day)
            <a href="{{ $day['empty'] ? '#' : route('owner.calendar', ['date' => $day['date'], 'month' => \Carbon\Carbon::parse($date)->format('m'), 'year' => \Carbon\Carbon::parse($date)->format('Y')]) }}"
                class="aspect-square flex flex-col items-center justify-center rounded-xl text-[13px]
                       relative transition-all cursor-pointer
                       hover:scale-[1.02]
                       {{ $day['empty'] ? 'text-gray-300 cursor-default pointer-events-none' : 'hover:bg-gray-50 text-gray-700' }}
                       {{ $day['type'] === 'today' ? 'bg-[#1b3a1b] text-white font-bold' : '' }}
                       {{ $day['type'] === 'booked' ? 'bg-green-50 text-green-700' : '' }}
                       {{ $day['type'] === 'partial' ? 'bg-yellow-50 text-yellow-700' : '' }}
                ">
                {{ $day['n'] }}

                @if(in_array($day['type'],['booked','partial']))
                    <span class="absolute bottom-1 w-1 h-1 rounded-full
                                 {{ $day['type'] === 'booked' ? 'bg-green-500' : 'bg-yellow-500' }}"></span>
                @endif
            </a>
            @endforeach

        </div>

        {{-- LEGEND --}}
        <div class="flex items-center justify-between px-5 py-3 border-t border-gray-100 bg-gray-50/40">

            <div class="flex items-center gap-4 flex-wrap">

                <div class="flex items-center gap-1.5 text-[11px] text-gray-500">
                    <div class="w-2.5 h-2.5 rounded-full bg-[#1b3a1b]"></div>
                    Hari Ini
                </div>

                <div class="flex items-center gap-1.5 text-[11px] text-gray-500">
                    <div class="w-2.5 h-2.5 rounded-full bg-green-500"></div>
                    Penuh
                </div>

                <div class="flex items-center gap-1.5 text-[11px] text-gray-500">
                    <div class="w-2.5 h-2.5 rounded-full bg-yellow-400"></div>
                    Sebagian
                </div>

                <div class="flex items-center gap-1.5 text-[11px] text-gray-500">
                    <div class="w-2.5 h-2.5 rounded-full bg-gray-300"></div>
                    Kosong
                </div>

            </div>

        </div>

    </div>

    <div class="lg:col-span-3 bg-white rounded-2xl border border-gray-100 overflow-hidden shadow-sm">

        {{-- HEADER --}}
        <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100">

            <div>
                <p class="font-semibold text-gray-800 text-sm">Slot — {{ \Carbon\Carbon::parse($selectedDate)->translatedFormat('d F Y') }}</p>
                <p class="text-xs text-gray-400">Klik slot untuk blokir jam tertentu</p>
            </div>

            <button onclick="openAddBookingModal()" class="px-4 py-2 text-sm rounded-xl bg-[#0b3d0b] text-white hover:bg-[#163016] transition">
                + Tambah Booking
            </button>

        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">

                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100">
                        <th class="text-left text-[10px] text-gray-400 uppercase px-5 py-3 w-24">Waktu</th>
                        @if($venue && $venue->fields)
                            @foreach($venue->fields as $field)
                                <th class="text-center text-[10px] text-gray-400 uppercase px-2 py-3">
                                    {{ $field->name }}
                                </th>
                            @endforeach
                        @endif
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-50">

                    @php
                    $slotClass = [
                        'booked'  => 'bg-green-50 text-green-700 border border-green-100',
                        'free'    => 'bg-gray-50 text-gray-400 border border-gray-100 hover:bg-yellow-50 hover:text-yellow-700 hover:border-yellow-200 cursor-pointer',
                        'active'  => 'bg-yellow-100 text-yellow-700 border border-yellow-200',
                        'pending' => 'bg-orange-50 text-orange-600 border border-orange-100',
                        'blocked' => 'bg-red-50 text-red-400 border border-red-100',
                    ];

                    $slotLabel = [
                        'booked'  => 'Dipesan',
                        'free'    => 'Kosong',
                        'active'  => 'Sekarang',
                        'pending' => 'Pending',
                        'blocked' => 'Blokir',
                    ];
                    @endphp

                    @foreach($slots as $slot)
                    <tr class="hover:bg-gray-50/40 transition">

                        <td class="px-5 py-3.5 font-mono text-[12px] text-gray-500">
                            {{ $slot[0] }}
                        </td>

                        @for($i = 1; $i < count($slot); $i++)
                        <td class="px-2 py-3 text-center">
                            <span class="text-[11px] font-semibold px-3 py-1.5 rounded-lg inline-block transition
                                         {{ $slotClass[$slot[$i]] ?? $slotClass['free'] }}">
                                {{ $slotLabel[$slot[$i]] ?? 'Unknown' }}
                            </span>
                        </td>
                        @endfor

                    </tr>
                    @endforeach

                </tbody>

            </table>
        </div>

    </div>

</div>

{{-- MODAL ADD BOOKING (OFFLINE) --}}
<div id="addBookingModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/40 px-4">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-md p-6">
        <div class="flex items-center justify-between mb-5">
            <h3 class="font-semibold text-gray-900">Tambah Booking Offline</h3>
            <button onclick="closeAddBookingModal()" class="text-gray-400 hover:text-gray-600 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-width="2" stroke-linecap="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <form method="POST" action="{{ route('owner.calendar.booking') }}" class="space-y-4">
            @csrf
            <div>
                <label class="text-xs text-gray-500 mb-1 block">Tanggal</label>
                <input type="date" name="date" value="{{ \Carbon\Carbon::parse($selectedDate)->format('Y-m-d') }}" required
                    class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#0b3d0b]">
            </div>
            <div>
                <label class="text-xs text-gray-500 mb-1 block">Lapangan</label>
                <select name="field_id" required
                    class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#0b3d0b] bg-white">
                    <option value="">-- Pilih Lapangan --</option>
                    @if($venue && $venue->fields)
                        @foreach($venue->fields as $field)
                            <option value="{{ $field->id }}">{{ $field->name }}</option>
                        @endforeach
                    @endif
                </select>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="text-xs text-gray-500 mb-1 block">Jam Mulai</label>
                    <select name="start_time" id="start_time" required
                        class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#0b3d0b] bg-white">
                        @for($h = $startHour ?? 7; $h < ($endHour ?? 22); $h++)
                            <option value="{{ sprintf('%02d:00', $h) }}">{{ sprintf('%02d:00', $h) }}</option>
                        @endfor
                    </select>
                </div>
                <div>
                    <label class="text-xs text-gray-500 mb-1 block">Jam Selesai</label>
                    <select name="end_time" id="end_time" required
                        class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#0b3d0b] bg-white">
                        @for($h = ($startHour ?? 7) + 1; $h <= ($endHour ?? 22); $h++)
                            <option value="{{ sprintf('%02d:00', $h) }}">{{ sprintf('%02d:00', $h) }}</option>
                        @endfor
                    </select>
                </div>
            </div>
            <div class="flex gap-3 pt-4">
                <button type="button" onclick="closeAddBookingModal()"
                    class="flex-1 border border-gray-200 text-gray-600 text-sm font-medium py-2.5 rounded-xl hover:bg-gray-50 transition">
                    Batal
                </button>
                <button type="submit"
                    class="flex-1 bg-[#0b3d0b] hover:bg-[#163016] text-white text-sm font-medium py-2.5 rounded-xl transition">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

{{-- MODAL MANAGE BLOCK --}}
<div id="manageBlockModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/40 px-4">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-md p-6">
        <div class="flex items-center justify-between mb-5">
            <h3 class="font-semibold text-gray-900">Kelola Blokir Lapangan</h3>
            <button onclick="closeManageBlockModal()" class="text-gray-400 hover:text-gray-600 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-width="2" stroke-linecap="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <form method="POST" id="manageBlockForm" action="{{ route('owner.calendar.block') }}" class="space-y-4">
            @csrf
            <div>
                <label class="text-xs text-gray-500 mb-1 block">Tanggal</label>
                <input type="date" name="date" value="{{ \Carbon\Carbon::parse($selectedDate)->format('Y-m-d') }}" readonly
                    class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none bg-gray-50 text-gray-500">
            </div>
            
            <div>
                <label class="text-xs text-gray-500 mb-1 block">Pilih Lapangan</label>
                <select name="field_id" required
                    class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#0b3d0b] bg-white">
                    <option value="all">Semua Lapangan</option>
                    @if($venue && $venue->fields)
                        @foreach($venue->fields as $field)
                            <option value="{{ $field->id }}">{{ $field->name }}</option>
                        @endforeach
                    @endif
                </select>
            </div>

            <div>
                <label class="text-xs text-gray-500 mb-1 block">Aksi</label>
                <div class="flex items-center gap-4 mt-2">
                    <label class="flex items-center gap-2 text-sm cursor-pointer">
                        <input type="radio" name="action_type" value="block" checked class="text-[#0b3d0b] focus:ring-[#0b3d0b]" 
                            onchange="document.getElementById('manageBlockForm').action = '{{ route('owner.calendar.block') }}'">
                        <span>Blokir</span>
                    </label>
                    <label class="flex items-center gap-2 text-sm cursor-pointer">
                        <input type="radio" name="action_type" value="unblock" class="text-[#0b3d0b] focus:ring-[#0b3d0b]"
                            onchange="document.getElementById('manageBlockForm').action = '{{ route('owner.calendar.unblock') }}'">
                        <span>Buka Blokir</span>
                    </label>
                </div>
            </div>
            
            <div class="flex gap-3 pt-4">
                <button type="button" onclick="closeManageBlockModal()"
                    class="flex-1 border border-gray-200 text-gray-600 text-sm font-medium py-2.5 rounded-xl hover:bg-gray-50 transition">
                    Batal
                </button>
                <button type="submit"
                    class="flex-1 bg-red-600 hover:bg-red-700 text-white text-sm font-medium py-2.5 rounded-xl transition"
                    onclick="return confirm('Apakah Anda yakin ingin melakukan aksi ini pada tanggal dan lapangan yang dipilih?')">
                    Terapkan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openManageBlockModal() {
        document.getElementById('manageBlockModal').classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }
    function closeManageBlockModal() {
        document.getElementById('manageBlockModal').classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }

    function openAddBookingModal() {
        document.getElementById('addBookingModal').classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }
    function closeAddBookingModal() {
        document.getElementById('addBookingModal').classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }

    document.addEventListener('DOMContentLoaded', function() {
        const startSelect = document.getElementById('start_time');
        const endSelect = document.getElementById('end_time');

        if (startSelect && endSelect) {
            startSelect.addEventListener('change', function() {
                const startHour = parseInt(this.value.split(':')[0]);
                
                // Keep current selection if valid, otherwise update it
                const currentEndHour = parseInt(endSelect.value.split(':')[0]);
                
                // Hide options in end_time that are <= startHour
                Array.from(endSelect.options).forEach(option => {
                    const optHour = parseInt(option.value.split(':')[0]);
                    if (optHour <= startHour) {
                        option.disabled = true;
                        option.style.display = 'none';
                    } else {
                        option.disabled = false;
                        option.style.display = '';
                    }
                });

                // Auto select next hour if current end_time is invalid
                if (currentEndHour <= startHour) {
                    const nextValidHour = (startHour + 1).toString().padStart(2, '0') + ':00';
                    endSelect.value = nextValidHour;
                }
            });
            
            // Trigger initially
            startSelect.dispatchEvent(new Event('change'));
        }
    });
</script>

@endsection