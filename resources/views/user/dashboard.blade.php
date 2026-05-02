@extends('partials.app')

@section('title', 'Dashboard User')

@section('content')

<div class="space-y-6">

{{-- ================= HEADER ================= --}}
<div>
    <h2 class="text-lg font-semibold text-gray-900">
        Halo, {{ auth()->user()->name }} 👋
    </h2>
    <p class="text-sm text-gray-500">
        Selamat datang di ActiveHub, semoga harimu menyenangkan!
    </p>
</div>


{{-- ================= MAIN GRID ================= --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- ================= LEFT SIDE ================= --}}
    <div class="lg:col-span-2 space-y-6">

        {{-- ===== STATS ===== --}}
<div class="grid grid-cols-3 gap-4">

    @php
    $stats = [
        ['label'=>'Total Booking','value'=>'12','icon'=>'calendar-check','color'=>'green'],
        ['label'=>'Match Booking','value'=>'7','icon'=>'users','color'=>'blue'],
        ['label'=>'Match Dibuat','value'=>'3','icon'=>'trophy','color'=>'yellow'],
    ];
    @endphp

    @foreach($stats as $s)
    <div class="bg-gray-100 rounded-xl p-5 flex items-center justify-between">

        {{-- TEXT --}}
        <div>
            <p class="text-xs text-gray-500">{{ $s['label'] }}</p>
            <p class="text-lg font-semibold text-gray-900 mt-1">
                {{ $s['value'] }}
            </p>
        </div>

        {{-- ICON --}}
        <div class="w-10 h-10 rounded-lg bg-{{ $s['color'] }}-100 flex items-center justify-center">
            <i class="fas fa-{{ $s['icon'] }} text-{{ $s['color'] }}-600"></i>
        </div>

    </div>
    @endforeach

</div>


        {{-- ===== CHART ===== --}}
        <div class="bg-white rounded-2xl border border-gray-100 p-6 h-75">

            <div class="mb-4">
                <p class="text-sm font-semibold text-gray-800">
                    Aktivitas Booking
                </p>
                <p class="text-xs text-gray-400">
                    6 bulan terakhir
                </p>
            </div>

            @php
            $chart = [5,8,6,10,7,12];
            $max = max($chart);
            @endphp

            <div class="flex items-end gap-3 h-60">
                @foreach($chart as $i => $val)
                @php
                    $h = ($val/$max)*100;
                @endphp

                <div class="flex-1 flex flex-col items-center gap-1">

                    <div class="w-full bg-gray-200 rounded-t-lg"
                         style="height: {{ $h }}%">
                    </div>

                    <span class="text-[10px] text-gray-400">
                        {{ ['Jan','Feb','Mar','Apr','Mei','Jun'][$i] }}
                    </span>

                </div>
                @endforeach
            </div>

        </div>

    </div>


    {{-- ================= RIGHT SIDE ================= --}}
    <div class="space-y-6">

        {{-- ===== QUICK ACTION ===== --}}
        <div class="bg-white rounded-2xl border border-gray-100 p-5">

            <h3 class="font-semibold text-gray-800 mb-4">
                Quick Action
            </h3>

            <div class="grid grid-cols-3 gap-4 text-center">

                {{-- Cari --}}
                <div class="flex flex-col items-center gap-2">
                    <div class="w-12 h-12 rounded-xl bg-green-800 flex items-center justify-center">
                        <i class="fas fa-search text-white"></i>
                    </div>
                    <p class="text-xs text-gray-600">Cari Lapangan</p>
                </div>

                {{-- Join --}}
                <div class="flex flex-col items-center gap-2">
                    <div class="w-12 h-12 rounded-xl bg-blue-500 flex items-center justify-center">
                        <i class="fas fa-users text-white"></i>
                    </div>
                    <p class="text-xs text-gray-600">Join Match</p>
                </div>

                {{-- Buat --}}
                <div class="flex flex-col items-center gap-2">
                    <div class="w-12 h-12 rounded-xl bg-yellow-500 flex items-center justify-center">
                        <i class="fas fa-plus text-white"></i>
                    </div>
                    <p class="text-xs text-gray-600">Buat Match</p>
                </div>

            </div>

        </div>


        {{-- ===== UPCOMING ===== --}}
        <div class="bg-white rounded-2xl border border-gray-100 p-5">

            <div class="flex justify-between mb-4">
                <h3 class="font-semibold text-gray-800">
                    Aktivitas Terdekat
                </h3>
                <a href="#" class="text-sm text-green-600 hover:underline">
                    Lihat semua
                </a>
            </div>

            <div class="space-y-3">

                {{-- Booking --}}
                <div class="border rounded-xl p-3">
                    <p class="text-xs text-green-600 mb-1">Booking Terdekat</p>
                    <p class="text-sm font-medium">Active Arena</p>
                    <p class="text-xs text-gray-500">Lapangan Futsal A</p>
                    <p class="text-xs text-gray-400 mt-1">
                        Sabtu, 25 Mei • 19:00
                    </p>
                </div>

                {{-- Match --}}
                <div class="border rounded-xl p-3">
                    <p class="text-xs text-red-500 mb-1">Match Terdekat</p>
                    <p class="text-sm font-medium">Fun Match Weekend</p>
                    <p class="text-xs text-gray-500">Futsal • 7 vs 7</p>
                    <p class="text-xs text-gray-400 mt-1">
                        Minggu, 26 Mei • 16:00
                    </p>
                </div>

            </div>

        </div>

    </div>

</div>

</div>


{{-- FONT AWESOME --}}
@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@endpush

@endsection