@extends('partials.app')

@section('title', 'Pendapatan')
@section('page-title', 'Pendapatan')
@section('page-subtitle', 'Rekap pendapatan dan penarikan dana')
@section('cta-label', 'Tarik Dana')
@section('cta-href', '#')

@section('content')

<div class="grid xl:grid-cols-3 gap-5 mb-5">

    {{-- SALDO CARD --}}
    <div class="bg-[#1b3a1b] rounded-2xl p-6 relative overflow-hidden flex flex-col justify-between">
        <div class="absolute right-0 top-0 w-48 h-48 rounded-full bg-white/[0.04] -translate-y-1/3 translate-x-1/4"></div>
        <div class="absolute left-0 bottom-0 w-32 h-32 rounded-full bg-yellow-300/5 translate-y-1/2 -translate-x-1/4"></div>

        <div class="relative">
            <p class="text-white/40 text-xs uppercase tracking-widest mb-2">Total Pendapatan</p>
            <p class="font-mono text-3xl font-semibold text-yellow-300 leading-none">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>

        </div>

        <div class="relative mt-8">
            <div class="h-px bg-white/10 mb-5"></div>
            <div class="flex justify-between text-center">
                <div>
                    <p class="font-mono text-lg font-semibold text-white">Rp {{ number_format($thisMonthRevenue / 1000000, 1) }}M</p>
                    <p class="text-white/30 text-[11px] mt-0.5">Bulan Ini</p>
                </div>
                <div>
                    <p class="font-mono text-lg font-semibold text-white">Rp {{ number_format($lastMonthRevenue / 1000000, 1) }}M</p>
                    <p class="text-white/30 text-[11px] mt-0.5">Bulan Lalu</p>
                </div>
                <div>
                    <p class="font-mono text-lg font-semibold text-green-400">{{ $growth >= 0 ? '+' : '' }}{{ number_format($growth, 1) }}%</p>
                    <p class="text-white/30 text-[11px] mt-0.5">Pertumbuhan</p>
                </div>
            </div>
        </div>
    </div>

    {{-- BAR CHART --}}
    <div class="lg:col-span-2 bg-white rounded-2xl border border-gray-100 p-5">

        <div class="flex items-center justify-between mb-6">
            <div>
                <p class="font-semibold text-gray-800 text-sm">Pendapatan Bulanan</p>
                <p class="text-xs text-gray-400 mt-0.5">Riwayat 7 bulan terakhir (Juta Rp)</p>
            </div>
            <span class="bg-green-50 text-green-700 text-[10px] font-semibold px-3 py-1 rounded-full">
                {{ \Carbon\Carbon::now()->translatedFormat('M Y') }}
            </span>
        </div>

        <div class="flex gap-3 h-32">
            @foreach($bars as $bar)
            <div class="flex-1 flex flex-col items-center gap-2 group cursor-pointer h-full">

                <span class="font-mono text-[10px] opacity-0 group-hover:opacity-100 transition
                             {{ !empty($bar['current']) ? 'text-green-600 font-medium' : 'text-gray-400' }}">
                    {{ $bar['val'] }}M
                </span>

                {{-- BAR WRAPPER --}}
                <div class="w-full flex-1 flex items-end">
                    <div class="w-full rounded-t-xl transition-all duration-300 group-hover:scale-y-105 origin-bottom"
                        @style([
                            "height:" . max($bar['pct'], 10) . "%",
                            "background:" . (!empty($bar['current']) ? '#0b3d0b' : '#bbf7d0')
                        ])>
                    </div>
                </div>

                <span class="text-[10px]
                             {{ !empty($bar['current']) ? 'text-[#0b3d0b] font-semibold' : 'text-gray-400' }}">
                    {{ $bar['month'] }}
                </span>

            </div>
            @endforeach
        </div>

    </div>

</div>


{{-- ===== BOTTOM ROW ===== --}}
<div class="grid xl:grid-cols-2 gap-5">

    {{-- RINCIAN PER LAPANGAN --}}
    <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
        <div class="px-5 py-4 border-b border-gray-100">
            <p class="font-semibold text-gray-800 text-sm">Rincian per Lapangan</p>
            <p class="text-xs text-gray-400 mt-0.5">{{ \Carbon\Carbon::now()->translatedFormat('F Y') }}</p>
        </div>

        <div class="px-5 py-3 divide-y divide-gray-50">

            @foreach($laps as $lap)
            @php
            $diff = $lap['total'] - $lap['prev'];
            $isUp = $diff >= 0;
            @endphp

            <div class="py-4">
                <div class="flex items-center justify-between mb-2">
                    <div>
                        <p class="font-medium text-gray-800 text-sm">{{ $lap['name'] }}</p>
                        <p class="text-[11px] text-gray-400">
                            {{ $lap['booking'] }} pemesanan • {{ $lap['jam'] }} jam
                        </p>

                        <p class="text-[11px] mt-1
                                  {{ $isUp ? 'text-green-600' : 'text-red-400' }}">
                            {{ $isUp ? '+' : '' }}Rp {{ number_format($diff/1000000,1) }}M dari bulan lalu
                        </p>
                    </div>

                    <p class="font-mono font-semibold text-green-700 text-sm">
                        Rp {{ number_format($lap['total']/1000000,1) }}M
                    </p>
                </div>

                <div class="w-full h-1.5 bg-gray-100 rounded-full overflow-hidden">
                    <div class="h-full bg-[#0b3d0b] rounded-full"
                        @style(["width: {$lap['pct']}%"])>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>


    {{-- RIWAYAT TRANSAKSI --}}
    <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
        <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100">
            <div>
                <p class="font-semibold text-gray-800 text-sm">Riwayat Transaksi</p>
                <p class="text-xs text-gray-400 mt-0.5">Terbaru</p>
            </div>
            <a href="{{ route('owner.bookings') }}" class="text-xs text-[#0b3d0b] font-semibold hover:underline">Lihat semua →</a>
        </div>

        <div class="divide-y divide-gray-50">

            @foreach($txns as $t)
            <div class="flex items-center gap-3 px-5 py-3.5 hover:bg-gray-50/40 transition-colors">

                <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0
            {{ $t['source'] === 'online'  ? 'bg-blue-50' : 'bg-amber-50' }}">

                    @if($t['source'] === 'online')
                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="w-5 h-5 text-blue-600"
                        viewBox="0 0 24 24"
                        fill="currentColor">
                        <path d="M3 6.75A2.25 2.25 0 015.25 4.5h13.5A2.25 2.25 0 0121 6.75v1.5H3v-1.5zM3 9.75h18v7.5A2.25 2.25 0 0118.75 19.5H5.25A2.25 2.25 0 013 17.25v-7.5zm3 4.5a.75.75 0 000 1.5h3a.75.75 0 000-1.5H6z" />
                    </svg>

                    @else
                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="w-5 h-5 text-amber-600"
                        viewBox="0 0 24 24"
                        fill="currentColor">
                        <path d="M2.25 6.75A2.25 2.25 0 014.5 4.5h15A2.25 2.25 0 0121.75 6.75v10.5A2.25 2.25 0 0119.5 19.5h-15A2.25 2.25 0 012.25 17.25V6.75zM6 9a3 3 0 100 6 3 3 0 000-6zm9 0h3v1.5h-3V9zm0 3h3v1.5h-3V12z" />
                    </svg>
                    @endif

                </div>

                {{-- TEXT --}}
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-800 truncate">{{ $t['name'] }}</p>

                    <p class="text-[11px] text-gray-400 flex items-center gap-2">
                        {{ $t['detail'] }} • {{ $t['date'] }}

                        {{-- LABEL --}}
                        <span class="px-2 py-0.5 rounded text-[10px] font-medium
                        {{ $t['source'] === 'online'
                            ? 'bg-blue-50 text-blue-600'
                            : 'bg-amber-50 text-amber-600' }}">
                            {{ $t['source'] === 'online' ? 'Online' : 'Offline' }}
                        </span>
                    </p>
                </div>

                {{-- ALL INCOME --}}
                <p class="font-mono font-semibold text-sm text-green-600 flex-shrink-0">
                    +{{ $t['amount'] }}
                </p>

            </div>
            @endforeach
        </div>
    </div>

</div>

@endsection