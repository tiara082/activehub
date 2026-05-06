{{-- resources/views/owner/pages/bookings.blade.php --}}
@extends('partials.app')

@section('title', 'Booking Management')
@section('page-title', 'Booking Management')
@section('page-subtitle', 'Kelola semua reservasi lapangan Anda')
@section('cta-label', 'Booking Manual')
@section('cta-href', '#')

@section('content')

@php
use Carbon\Carbon;
$todayLabel = Carbon::now()->translatedFormat('d M Y');
$statusStyle = [
    'Selesai' => 'bg-green-50 text-green-700',
    'Berlangsung' => 'bg-yellow-50 text-yellow-700',
    'Terjadwal' => 'bg-blue-50 text-blue-700',
    'Dibatalkan' => 'bg-gray-50 text-gray-500',
    'Pending' => 'bg-orange-50 text-orange-600',
];
@endphp

<div class="grid grid-cols-1 lg:grid-cols-3 gap-4 mb-8">

    {{-- GRAFIK 6 BULAN --}}
    <div class="lg:col-span-2 bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
        <div class="flex items-center justify-between mb-5">
            <div>
                <p class="text-sm font-semibold text-gray-800">Tren Booking</p>
                <p class="text-xs text-gray-400">6 bulan terakhir</p>
            </div>
            <span class="text-[11px] text-gray-400 font-medium">Jumlah booking</span>
        </div>

        <div class="flex items-end gap-3 h-36" id="booking-chart">
            @foreach($monthlyStats as $idx => $stat)
            @php
                $maxVal = collect($monthlyStats)->max('total') ?: 1;
                $heightPct = round(($stat['total'] / $maxVal) * 100);
                $isLast = $idx === (is_array($monthlyStats) ? count($monthlyStats) : $monthlyStats->count()) - 1;
            @endphp
            <div class="flex-1 flex flex-col items-center gap-1 group relative">
                {{-- Tooltip --}}
                <div class="absolute bottom-full mb-2 left-1/2 -translate-x-1/2
                            bg-[#1b3a1b] text-white text-[10px] font-semibold
                            px-2 py-1 rounded-lg whitespace-nowrap
                            opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none z-10">
                    {{ $stat['total'] }} booking
                    <br><span class="font-normal opacity-70">{{ $stat['selesai'] }} selesai · {{ $stat['dibatalkan'] }} batal</span>
                </div>

                {{-- Bar --}}
                <div class="w-full rounded-t-lg transition-all duration-500 ease-out"
                     style="height: {{ $heightPct }}%;
                            background: {{ $isLast ? '#1b3a1b' : '#e5ede5' }};
                            min-height: 6px;">
                </div>

                {{-- Label --}}
                <span class="text-[11px] font-medium {{ $isLast ? 'text-[#1b3a1b]' : 'text-gray-400' }}">
                    {{ $stat['label'] }}
                </span>
            </div>
            @endforeach
        </div>
    </div>


    {{-- RINGKASAN BULANAN --}}
    <div class="flex flex-col gap-4">

        {{-- Bulan ini --}}
        <div class="bg-[#1b3a1b] rounded-2xl p-5 text-white flex-1">
            <p class="text-xs font-medium opacity-60 mb-1">Bulan Ini</p>
            <p class="text-3xl font-bold tracking-tight">{{ $currentMonthStat['total'] }}</p>
            <p class="text-xs opacity-60 mb-3">total booking</p>

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
                <span class="text-[11px] opacity-50">vs bulan lalu</span>
            </div>
        </div>

        {{-- History 3 bulan --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 flex-1">
            <p class="text-xs font-semibold text-gray-800 mb-3">Riwayat Bulanan</p>
            <div class="space-y-3">
                @foreach(collect($monthlyStats)->slice(-4, 3) as $hist)
                @php
                    $maxHist = collect($monthlyStats)->max('total') ?: 1;
                    $barW    = round(($hist['total'] / $maxHist) * 100);
                @endphp
                <div>
                    <div class="flex justify-between items-center mb-1">
                        <span class="text-xs text-gray-500">{{ $hist['label'] }}</span>
                        <span class="text-xs font-semibold text-gray-700">{{ $hist['total'] }}</span>
                    </div>
                    <div class="h-1.5 bg-gray-100 rounded-full overflow-hidden">
                        <div class="h-full bg-[#1b3a1b]/30 rounded-full"
                             style="width: {{ $barW }}%"></div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

    </div>
</div>

{{-- STATUS FILTER --}}
<div class="mb-6">
    <div class="flex gap-2 p-1 bg-gray-100 rounded-2xl overflow-x-auto no-scrollbar">

        @foreach($tabs as $tab)
            @php $isActive = $active === $tab['key']; @endphp

            <a href="{{ request()->fullUrlWithQuery(['status' => $tab['key']]) }}"
               class="relative flex items-center gap-2 whitespace-nowrap px-4 py-2 rounded-xl
               transition-all duration-200 ease-out
               {{ $isActive
                    ? 'bg-white shadow-sm text-[#1b3a1b]'
                    : 'text-gray-500 hover:text-gray-800 hover:bg-white/60'
               }}">

                <span class="text-sm font-medium">{{ $tab['label'] }}</span>

                <span class="text-[11px] font-semibold px-2 py-[2px] rounded-full
                    {{ $isActive
                        ? 'bg-[#1b3a1b]/10 text-[#1b3a1b]'
                        : 'bg-gray-200 text-gray-500'
                    }}">
                    {{ $tab['count'] }}
                </span>

                @if($isActive)
                    <span class="absolute inset-0 rounded-xl ring-1 ring-[#1b3a1b]/10"></span>
                @endif

            </a>
        @endforeach

    </div>
</div>


{{-- SEARCH --}}
<form method="GET" action="{{ route('owner.bookings') }}" class="flex flex-col md:flex-row gap-3 mb-6" id="filterForm">
    <input type="hidden" name="status" value="{{ $active }}">

    <div class="flex-1 relative">
        <input type="text" name="search" value="{{ request('search') }}"
            placeholder="Cari nama atau nomor HP..."
            class="w-full bg-white border border-gray-200 rounded-2xl px-4 py-3 pl-10 text-sm
                   focus:ring-2 focus:ring-[#1b3a1b] outline-none" onchange="document.getElementById('filterForm').submit()">

        <svg class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"
             fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-width="2" d="M21 21l-4.3-4.3m1.8-5.2a7 7 0 11-14 0 7 7 0 0114 0z"/>
        </svg>
    </div>

    <div class="relative w-full md:w-60">
        <select name="field_id" onchange="document.getElementById('filterForm').submit()" class="w-full appearance-none bg-white border border-gray-200 rounded-2xl px-4 py-3 pr-10 text-sm
                       focus:ring-2 focus:ring-[#1b3a1b] outline-none hover:border-gray-300 transition">

            <option value="">Semua Lapangan</option>
            @if($venue && $venue->fields)
                @foreach($venue->fields as $field)
                    <option value="{{ $field->id }}" {{ request('field_id') == $field->id ? 'selected' : '' }}>{{ $field->name }}</option>
                @endforeach
            @endif

        </select>

        <div class="absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-gray-400">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-width="2" d="M6 9l6 6 6-6"/>
            </svg>
        </div>
    </div>

    <input type="date" name="date" value="{{ request('date') }}" onchange="document.getElementById('filterForm').submit()"
        class="bg-white border border-gray-200 rounded-2xl px-4 py-3 text-sm">
</form>


{{-- TABLE CARD --}}
<div class="bg-white rounded-2xl border border-gray-100 overflow-hidden shadow-sm">

    {{-- HEADER --}}
    <div class="flex items-center justify-between px-6 py-5 border-b border-gray-100">
        <div>
            <p class="text-sm font-semibold text-gray-800">Booking Overview</p>
            <p class="text-xs text-gray-400">{{ $todayLabel }}</p>
        </div>

        <button class="px-4 py-2 text-sm rounded-xl border border-gray-200 hover:border-[#1b3a1b] hover:text-[#1b3a1b] transition">
            Export
        </button>
    </div>


    {{-- TABLE --}}
    <div class="overflow-x-auto">
        <table class="w-full text-sm">

            <thead class="text-[11px] text-gray-400 uppercase tracking-wider">
                <tr>
                    <th class="px-6 py-4 text-left">Pemesan</th>
                    <th class="px-6 py-4 text-left">Lapangan</th>
                    <th class="px-6 py-4 text-left">Waktu</th>
                    <th class="px-6 py-4 text-left">Durasi</th>
                    <th class="px-6 py-4 text-left">Total</th>
                    <th class="px-6 py-4 text-left">Status</th>
                    <th class="px-6 py-4 text-right">Aksi</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-50">

                @forelse($bookings as $b)
                <tr class="hover:bg-gray-50 transition">

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
                        <span class="px-3 py-1 rounded-full text-xs font-medium
                            {{ $statusStyle[$b['status']] ?? 'bg-gray-50 text-gray-600' }}">
                            {{ $b['status'] }}
                        </span>
                    </td>

                    <td class="px-6 py-4 text-right">
                        <div class="flex justify-end gap-2">

                            {{-- VIEW --}}
                            <button class="w-9 h-9 inline-flex items-center justify-center rounded-xl
                                           hover:bg-gray-100 transition text-gray-500">
                                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <path stroke-width="2"
                                          d="M2.458 12C3.732 7.943 7.523 5 12 5
                                             c4.477 0 8.268 2.943 9.542 7
                                             C20.268 16.057 16.477 19 12 19
                                             c-4.477 0-8.268-2.943-9.542-7z"/>
                                    <circle cx="12" cy="12" r="3" stroke-width="2"/>
                                </svg>
                            </button>

                            {{-- EDIT --}}
                            <button class="w-9 h-9 inline-flex items-center justify-center rounded-xl
                                           hover:bg-gray-100 transition text-gray-500">
                                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <path stroke-width="2"
                                          d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07
                                             a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685
                                             a4.5 4.5 0 011.13-1.897l8.932-8.931z"/>
                                    <path stroke-width="2" d="M19.5 7.125L16.875 4.5"/>
                                </svg>
                            </button>

                        </div>
                    </td>

                </tr>

                @empty
                <tr>
                    <td colspan="7" class="text-center py-16 text-gray-400">
                        Belum ada booking
                    </td>
                </tr>
                @endforelse

            </tbody>
        </table>
    </div>

</div>

@endsection