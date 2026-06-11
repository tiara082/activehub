{{-- resources/views/owner/pages/bookings.blade.php --}}
@extends('partials.app')

@section('title', 'Kelola Pemesanan')
@section('page-title', 'Kelola Pemesanan')
@section('page-subtitle', 'Kelola seluruh pemesanan lapangan Anda')
@section('cta-label', 'Tambah Pemesanan')
@section('cta-href', '#')

@section('content')

@push('styles')
<style>
    .booking-row {
        position: relative;
        transition: all 0.25s ease;
    }
    .booking-row::after {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 4px;
        background-color: #0b3d0b;
        opacity: 0;
        transition: opacity 0.25s ease;
    }
    .booking-row:hover::after {
        opacity: 1;
    }
    .booking-row:hover {
        background-color: rgba(11, 61, 11, 0.02) !important;
    }
</style>
@endpush

@php
use Carbon\Carbon;

$todayLabel = Carbon::now()->translatedFormat('d M Y');

$statusStyle = [
    'Selesai' => 'bg-green-50 text-green-700',
    'Berlangsung' => 'bg-yellow-50 text-yellow-700',
    'Terjadwal' => 'bg-blue-50 text-blue-700',
    'Dibatalkan' => 'bg-red-50 text-red-700',
    'Menunggu' => 'bg-orange-50 text-orange-600',
    'Diblokir' => 'bg-red-50 text-red-600',
];
@endphp

<div class="grid grid-cols-1 xl:grid-cols-3 gap-4 mb-6">

    {{-- GRAFIK 6 BULAN --}}
    <div class="lg:col-span-2 bg-white rounded-2xl border border-gray-100 shadow-sm p-6">

        <div class="flex items-center justify-between mb-5">

            <div>
                <p class="text-sm font-semibold text-gray-800">
                    Tren Pemesanan
                </p>

                <p class="text-xs text-gray-400">
                    6 bulan terakhir
                </p>
            </div>

            <span class="text-[11px] text-gray-400 font-medium">
                Jumlah pemesanan
            </span>

        </div>

        <div class="flex gap-3 h-36" id="booking-chart">

            @foreach($monthlyStats as $idx => $stat)

            @php
                $maxVal = collect($monthlyStats)->max('total') ?: 1;
                $heightPct = round(($stat['total'] / $maxVal) * 100);

                $isLast = $idx === (
                    is_array($monthlyStats)
                    ? count($monthlyStats)
                    : $monthlyStats->count()
                ) - 1;
            @endphp

            <div class="flex-1 flex flex-col items-center gap-1 group relative h-full">

                {{-- TOOLTIP --}}
                <div class="absolute bottom-full mb-2 left-1/2 -translate-x-1/2
                            bg-[#1b3a1b] text-white text-[10px] font-semibold
                            px-2 py-1 rounded-lg whitespace-nowrap
                            opacity-0 group-hover:opacity-100 transition-opacity
                            pointer-events-none z-10">

                    {{ $stat['total'] }} pemesanan

                    <br>

                    <span class="font-normal opacity-70">
                        {{ $stat['selesai'] }} selesai ·
                        {{ $stat['dibatalkan'] }} dibatalkan
                    </span>

                </div>

                {{-- BAR WRAPPER --}}
                <div class="w-full flex-1 flex items-end">
                    <div class="w-full rounded-t-lg transition-all duration-500 ease-out"
                         @style([
                             "height: {$heightPct}%",
                             "background: " . ($isLast ? '#0b3d0b' : '#bbf7d0'),
                             "min-height: 4px"
                         ])>
                    </div>
                </div>

                {{-- LABEL --}}
                <span class="text-[11px] font-medium
                    {{ $isLast ? 'text-[#0b3d0b]' : 'text-gray-400' }}">

                    {{ $stat['label'] }}

                </span>

            </div>

            @endforeach

        </div>

    </div>


    {{-- RINGKASAN BULANAN --}}
    <div class="flex flex-col gap-4">

        {{-- BULAN INI --}}
        <div class="bg-[#1b3a1b] rounded-2xl p-5 text-white flex-1">

            <p class="text-xs font-medium opacity-60 mb-1">
                Bulan Ini
            </p>

            <p class="text-3xl font-bold tracking-tight">
                {{ $currentMonthStat['total'] }}
            </p>

            <p class="text-xs opacity-60 mb-3">
                total pemesanan
            </p>

            <div class="flex items-center gap-1.5">

                @if($diffPct >= 0)

                    <span class="inline-flex items-center gap-1 text-[11px] font-semibold
                                 bg-white/15 text-white px-2 py-1 rounded-full">

                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-width="2.5" d="M5 15l7-7 7 7"/>
                        </svg>

                        +{{ $diffPct }}%

                    </span>

                @else

                    <span class="inline-flex items-center gap-1 text-[11px] font-semibold
                                 bg-white/15 text-white px-2 py-1 rounded-full">

                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-width="2.5" d="M19 9l-7 7-7-7"/>
                        </svg>

                        {{ $diffPct }}%

                    </span>

                @endif

                <span class="text-[11px] opacity-50">
                    vs bulan lalu
                </span>

            </div>

        </div>


        {{-- RIWAYAT BULANAN --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 flex-1">

            <p class="text-xs font-semibold text-gray-800 mb-3">
                Riwayat Bulanan
            </p>

            <div class="space-y-3">

                @foreach(collect($monthlyStats)->slice(-4, 3) as $hist)

                @php
                    $maxHist = collect($monthlyStats)->max('total') ?: 1;
                    $barW    = round(($hist['total'] / $maxHist) * 100);
                @endphp

                <div>

                    <div class="flex justify-between items-center mb-1">

                        <span class="text-xs text-gray-500">
                            {{ $hist['label'] }}
                        </span>

                        <span class="text-xs font-semibold text-gray-700">
                            {{ $hist['total'] }}
                        </span>

                    </div>

                    <div class="h-1.5 bg-gray-100 rounded-full overflow-hidden">

                        <div class="h-full bg-[#1b3a1b]/30 rounded-full"
                             @style(["width: {$barW}%"])>
                        </div>

                    </div>

                </div>

                @endforeach

            </div>

        </div>

    </div>

</div>


{{-- FILTER STATUS --}}
<div class="mb-6">

    <div class="flex gap-2 p-1 bg-gray-100 rounded-2xl overflow-x-auto no-scrollbar">

        @foreach($tabs as $tab)

        @php
            $isActive = $active === $tab['key'];
        @endphp

        <a href="{{ request()->fullUrlWithQuery(['status' => $tab['key']]) }}"
           class="relative flex items-center gap-2 whitespace-nowrap px-4 py-2 rounded-xl
           transition-all duration-200 ease-out
           {{ $isActive
                ? 'bg-[#0b3d0b] shadow-md text-white'
                : 'text-gray-500 hover:text-gray-800 hover:bg-white/60'
           }}">

            <span class="text-sm font-medium">
                {{ $tab['label'] }}
            </span>

            <span class="text-[11px] font-semibold px-2 py-[2px] rounded-full
                {{ $isActive
                    ? 'bg-white/20 text-white'
                    : 'bg-gray-200 text-gray-500'
                }}">

                {{ $tab['count'] }}

            </span>

            @if($isActive)
                <span class="absolute inset-0 rounded-xl ring-1 ring-[#0b3d0b]/10"></span>
            @endif

        </a>

        @endforeach

    </div>

</div>


{{-- PENCARIAN --}}
<form method="GET"
      action="{{ route('owner.bookings') }}"
      class="flex flex-col md:flex-row gap-3 mb-6"
      id="filterForm">

    <input type="hidden" name="status" value="{{ $active }}">

    {{-- SEARCH --}}
    <div class="flex-1 relative">

        <input
            type="text"
            name="search"
            value="{{ request('search') }}"
            placeholder="Cari nama atau nomor telepon..."
            class="w-full bg-white border border-gray-200 rounded-2xl
                   px-4 py-3 pl-10 text-sm
                   focus:ring-4 focus:ring-[#0b3d0b]/10 focus:border-[#0b3d0b] transition-all outline-none"
            onchange="document.getElementById('filterForm').submit()">

        <svg class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"
             fill="none"
             stroke="currentColor"
             viewBox="0 0 24 24">

            <path stroke-width="2"
                  d="M21 21l-4.3-4.3m1.8-5.2
                     a7 7 0 11-14 0
                     7 7 0 0114 0z"/>

        </svg>

    </div>


    {{-- FILTER LAPANGAN --}}
    <div class="relative w-full md:w-60">

        <select
            name="field_id"
            onchange="document.getElementById('filterForm').submit()"
            class="w-full appearance-none bg-white border border-gray-200
                   rounded-2xl px-4 py-3 pr-10 text-sm
                   focus:ring-4 focus:ring-[#0b3d0b]/10 focus:border-[#0b3d0b]
                   outline-none hover:border-[#0b3d0b] transition-all">

            <option value="">
                Semua Lapangan
            </option>

            @if($venue && $venue->fields)

                @foreach($venue->fields as $field)

                    <option value="{{ $field->id }}"
                        {{ request('field_id') == $field->id ? 'selected' : '' }}>

                        {{ $field->name }}

                    </option>

                @endforeach

            @endif

        </select>

        <div class="absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-gray-400">

            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-width="2" d="M6 9l6 6 6-6"/>
            </svg>

        </div>

    </div>


    {{-- FILTER TANGGAL --}}
    <input
        type="date"
        name="date"
        value="{{ request('date') }}"
        onchange="document.getElementById('filterForm').submit()"
        class="bg-white border border-gray-200 rounded-2xl px-4 py-3 text-sm focus:ring-4 focus:ring-[#0b3d0b]/10 focus:border-[#0b3d0b] outline-none transition-all">

</form>


{{-- TABLE --}}
<div class="bg-white rounded-2xl border border-gray-100 overflow-hidden shadow-sm">

    {{-- HEADER --}}
    <div class="flex items-center justify-between px-4 sm:px-6 py-4 sm:py-5 border-b border-gray-100">
        <div>
            <p class="text-sm font-semibold text-gray-800">Ringkasan Pemesanan</p>
            <p class="text-xs text-gray-400">{{ $todayLabel }}</p>
        </div>
        <a href="{{ route('owner.bookings.export', request()->all()) }}"
           class="px-3 sm:px-4 py-2 text-xs sm:text-sm rounded-xl border border-gray-200 inline-block
                  hover:border-[#1b3a1b] hover:text-[#1b3a1b] transition whitespace-nowrap">
            Ekspor
        </a>
    </div>

    {{-- DESKTOP TABLE --}}
    <div class="hidden md:block overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="text-[11px] text-gray-400 uppercase tracking-wider text-center">
                <tr>
                    <th class="px-6 py-4">Pemesan</th>
                    <th class="px-6 py-4">Lapangan</th>
                    <th class="px-6 py-4">Jadwal</th>
                    <th class="px-6 py-4">Durasi</th>
                    <th class="px-6 py-4">Total</th>
                    <th class="px-6 py-4">Status</th>
                    <th class="px-6 py-4">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50 text-center">
                @forelse($bookings as $b)
                <tr class="booking-row hover:bg-gray-50 transition">
                    <td class="px-6 py-4">
                        <p class="font-medium text-gray-800">{{ $b['name'] }}</p>
                        <p class="text-xs text-gray-400">{{ $b['phone'] }}</p>
                    </td>
                    <td class="px-6 py-4 text-gray-600">{{ $b['court'] }}</td>
                    <td class="px-6 py-4">
                        <p class="text-gray-700">{{ $b['date'] }}</p>
                        <p class="text-xs text-gray-400">{{ $b['time'] }}</p>
                    </td>
                    <td class="px-6 py-4 text-gray-600">{{ $b['dur'] }}</td>
                    <td class="px-6 py-4 font-medium text-gray-800">{{ $b['total'] }}</td>
                    <td class="px-6 py-4">
                        <span class="px-3 py-1 rounded-full text-xs font-medium {{ $statusStyle[$b['status']] ?? 'bg-gray-50 text-gray-600' }}">
                            {{ $b['status'] }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex justify-center gap-2">
                            <div id="booking-data-{{ $b['id'] }}" class="hidden"
                                data-id="#BKG-{{ str_pad($b['id'], 4, '0', STR_PAD_LEFT) }}"
                                data-name="{{ $b['name'] }}" data-phone="{{ $b['phone'] }}"
                                data-court="{{ $b['court'] }}" data-date="{{ $b['date'] }}"
                                data-time="{{ $b['time'] }}" data-dur="{{ $b['dur'] }}"
                                data-total="{{ $b['total'] }}" data-status="{{ $b['status'] }}"></div>
                            <button onclick="openDetailBookingModal({{ $b['id'] }})" class="w-9 h-9 inline-flex items-center justify-center rounded-xl hover:bg-gray-100 transition text-gray-500">
                                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <path stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7C20.268 16.057 16.477 19 12 19c-4.477 0-8.268-2.943-9.542-7z"/>
                                    <circle cx="12" cy="12" r="3" stroke-width="2"/>
                                </svg>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-center py-16 text-gray-400">Belum ada pemesanan</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- MOBILE CARD LIST --}}
    <div class="md:hidden divide-y divide-gray-50">
        @forelse($bookings as $b)
        <div class="p-4">
            <div id="booking-data-{{ $b['id'] }}" class="hidden"
                data-id="#BKG-{{ str_pad($b['id'], 4, '0', STR_PAD_LEFT) }}"
                data-name="{{ $b['name'] }}" data-phone="{{ $b['phone'] }}"
                data-court="{{ $b['court'] }}" data-date="{{ $b['date'] }}"
                data-time="{{ $b['time'] }}" data-dur="{{ $b['dur'] }}"
                data-total="{{ $b['total'] }}" data-status="{{ $b['status'] }}"></div>
            <div class="flex items-start justify-between mb-2">
                <div>
                    <p class="font-semibold text-gray-800 text-sm">{{ $b['name'] }}</p>
                    <p class="text-xs text-gray-400">{{ $b['phone'] }}</p>
                </div>
                <span class="px-2.5 py-1 rounded-full text-xs font-medium {{ $statusStyle[$b['status']] ?? 'bg-gray-50 text-gray-600' }}">
                    {{ $b['status'] }}
                </span>
            </div>
            <div class="grid grid-cols-2 gap-2 text-xs text-gray-500 mb-3">
                <div><span class="text-gray-400">Lapangan:</span> {{ $b['court'] }}</div>
                <div><span class="text-gray-400">Durasi:</span> {{ $b['dur'] }}</div>
                <div><span class="text-gray-400">Tanggal:</span> {{ $b['date'] }}</div>
                <div><span class="text-gray-400">Jam:</span> {{ $b['time'] }}</div>
            </div>
            <div class="flex items-center justify-between">
                <p class="text-sm font-semibold text-gray-800">{{ $b['total'] }}</p>
                <button onclick="openDetailBookingModal({{ $b['id'] }})" class="text-xs text-[#1b3a1b] font-medium px-3 py-1.5 rounded-lg bg-[#1b3a1b]/5 hover:bg-[#1b3a1b]/10 transition">
                    Lihat Detail
                </button>
            </div>
        </div>
        @empty
        <div class="text-center py-16 text-gray-400 text-sm">Belum ada pemesanan</div>
        @endforelse
    </div>

</div>

{{-- MODAL DETAIL BOOKING --}}
<div id="detailBookingModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/40 px-4 backdrop-blur-sm transition-opacity">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-md p-6 transform scale-95 transition-transform text-left">
        <div class="flex justify-between items-start border-b border-gray-100 pb-4 mb-4">
            <div>
                <h3 class="font-bold text-gray-900 text-lg">Detail Pemesanan</h3>
                <p id="detail-booking-id" class="text-xs text-gray-500 mt-1"></p>
            </div>
            <button type="button" onclick="closeDetailBookingModal()" class="text-gray-400 hover:text-gray-600 p-1">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        
        <div class="space-y-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Status</p>
                    <span id="detail-booking-status" class="px-3 py-1 rounded-full text-xs font-medium"></span>
                </div>
                <div class="text-right">
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Total Biaya</p>
                    <p id="detail-booking-total" class="font-bold text-[#1b3a1b] text-lg"></p>
                </div>
            </div>

            <div class="bg-gray-50 rounded-xl p-4 border border-gray-100 space-y-3">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-[10px] font-semibold text-gray-500 uppercase tracking-wider mb-1">Pemesan</p>
                        <p id="detail-booking-name" class="font-medium text-gray-900 text-sm"></p>
                    </div>
                    <div>
                        <p class="text-[10px] font-semibold text-gray-500 uppercase tracking-wider mb-1">Telepon</p>
                        <p id="detail-booking-phone" class="font-medium text-gray-900 text-sm"></p>
                    </div>
                </div>
            </div>

            <div class="bg-gray-50 rounded-xl p-4 border border-gray-100 space-y-3">
                <div>
                    <p class="text-[10px] font-semibold text-gray-500 uppercase tracking-wider mb-1">Lapangan</p>
                    <p id="detail-booking-court" class="font-medium text-gray-900 text-sm"></p>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-[10px] font-semibold text-gray-500 uppercase tracking-wider mb-1">Tanggal</p>
                        <p id="detail-booking-date" class="font-medium text-gray-900 text-sm"></p>
                    </div>
                    <div>
                        <p class="text-[10px] font-semibold text-gray-500 uppercase tracking-wider mb-1">Waktu & Durasi</p>
                        <p class="font-medium text-gray-900 text-sm"><span id="detail-booking-time"></span> (<span id="detail-booking-dur"></span>)</p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="mt-6 pt-4 border-t border-gray-100 text-right">
            <button type="button" onclick="closeDetailBookingModal()" class="bg-[#1b3a1b] text-white px-5 py-2.5 rounded-xl text-sm font-semibold hover:bg-[#285228] transition">
                Tutup
            </button>
        </div>
    </div>
</div>

<script>
    const statusStyles = {
        'Selesai': 'bg-green-50 text-green-700',
        'Berlangsung': 'bg-yellow-50 text-yellow-700',
        'Terjadwal': 'bg-blue-50 text-blue-700',
        'Dibatalkan': 'bg-red-50 text-red-700',
        'Menunggu': 'bg-orange-50 text-orange-600',
        'Diblokir': 'bg-red-50 text-red-600',
        'Blokir': 'bg-red-50 text-red-600'
    };

    function openDetailBookingModal(id) {
        const modal = document.getElementById('detailBookingModal');
        const data = document.getElementById('booking-data-' + id).dataset;

        document.getElementById('detail-booking-id').innerText = data.id;
        document.getElementById('detail-booking-name').innerText = data.name;
        document.getElementById('detail-booking-phone').innerText = data.phone;
        document.getElementById('detail-booking-court').innerText = data.court;
        document.getElementById('detail-booking-date').innerText = data.date;
        document.getElementById('detail-booking-time').innerText = data.time;
        document.getElementById('detail-booking-dur').innerText = data.dur;
        document.getElementById('detail-booking-total').innerText = data.total;
        
        const statusEl = document.getElementById('detail-booking-status');
        statusEl.innerText = data.status;
        statusEl.className = 'px-3 py-1 rounded-full text-xs font-medium ' + (statusStyles[data.status] || 'bg-gray-50 text-gray-600');

        modal.classList.remove('hidden');
        setTimeout(() => {
            modal.querySelector('div').classList.remove('scale-95');
            modal.querySelector('div').classList.add('scale-100');
        }, 10);
    }

    function closeDetailBookingModal() {
        const modal = document.getElementById('detailBookingModal');
        modal.querySelector('div').classList.remove('scale-100');
        modal.querySelector('div').classList.add('scale-95');
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 150);
    }

    document.getElementById('detailBookingModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeDetailBookingModal();
        }
    });
</script>

@endsection