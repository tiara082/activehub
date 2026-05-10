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
        <div class="grid grid-cols-2 gap-4">

            @php
            $stats = [
                [
                    'label' => 'Total Booking',
                    'value' => $totalBooking,
                    'icon'  => 'calendar-check',
                    'color' => 'green'
                ],

                [
                    'label' => 'Match Booking',
                    'value' => $matchBooking,
                    'icon'  => 'users',
                    'color' => 'blue'
                ],
            ];
            @endphp

            @foreach($stats as $s)

            <div class="bg-gray-100 rounded-xl p-5 flex items-center justify-between">

                <div>

                    <p class="text-xs text-gray-500">
                        {{ $s['label'] }}
                    </p>

                    <p class="text-lg font-semibold text-gray-900 mt-1">
                        {{ $s['value'] }}
                    </p>

                </div>

                <div class="w-10 h-10 rounded-lg bg-{{ $s['color'] }}-100 flex items-center justify-center">

                    <i class="fas fa-{{ $s['icon'] }} text-{{ $s['color'] }}-600"></i>

                </div>

            </div>

            @endforeach

        </div>


        {{-- ===== CHART ===== --}}
        <div class="bg-white rounded-2xl border border-gray-100 p-6">

            <div class="mb-6">

                <p class="text-sm font-semibold text-gray-800">
                    Aktivitas Booking
                </p>

                <p class="text-xs text-gray-400">
                    6 bulan terakhir
                </p>

            </div>

            @php

            $deskripsi = [
                'Aktivitas booking bulan ini',
                'Jumlah booking meningkat',
                'Aktivitas cukup stabil',
                'Booking mengalami kenaikan',
                'Aktivitas pengguna aktif',
                'Booking tertinggi bulan ini'
            ];

            $max = max($chart) > 0 ? max($chart) : 1;

            @endphp

            <div class="flex items-end gap-4 h-64 border-b border-gray-100 pb-3">

                @foreach($chart as $i => $val)

                @php
                    $height = ($val / $max) * 180;
                @endphp

                <div class="flex-1 flex flex-col items-center gap-2 group relative">

                    {{-- TOOLTIP --}}
                    <div class="absolute -top-20 opacity-0 group-hover:opacity-100 transition duration-300 z-10">

                        <div class="bg-gray-900 text-white text-[11px] rounded-xl px-3 py-2 shadow-xl w-40 text-center">

                            <p class="font-semibold">
                                {{ $months[$i] }}
                            </p>

                            <p class="mt-1">
                                {{ $val }} Booking
                            </p>

                            <p class="text-gray-300 mt-1">
                                {{ $deskripsi[$i] }}
                            </p>

                        </div>

                    </div>

                    {{-- BATANG --}}
                    <div 
                        class="w-full rounded-t-2xl bg-gradient-to-t from-green-500 to-green-300 hover:scale-105 hover:from-green-600 hover:to-green-400 transition-all duration-300 shadow-md"
                        style="height: {{ $height }}px">
                    </div>

                    {{-- BULAN --}}
                    <span class="text-xs text-gray-400">
                        {{ $months[$i] }}
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
        <a href="{{ route('fields.index') }}"
        class="flex flex-col items-center gap-2 hover:scale-105 transition">

            <div class="w-12 h-12 rounded-xl bg-green-800 flex items-center justify-center">
                <i class="fas fa-search text-white"></i>
            </div>

            <p class="text-xs text-gray-600">
                Cari Lapangan
            </p>

        </a>

        {{-- Join --}}
        <a href="{{ route('matches.index') }}"
        class="flex flex-col items-center gap-2 hover:scale-105 transition">

            <div class="w-12 h-12 rounded-xl bg-blue-500 flex items-center justify-center">
                <i class="fas fa-users text-white"></i>
            </div>

            <p class="text-xs text-gray-600">
                Join Match
            </p>

        </a>

        {{-- Buat --}}
        <a href="{{ route('matches.create') }}"
        class="flex flex-col items-center gap-2 hover:scale-105 transition">

            <div class="w-12 h-12 rounded-xl bg-yellow-500 flex items-center justify-center">
                <i class="fas fa-plus text-white"></i>
            </div>

            <p class="text-xs text-gray-600">
                Buat Match
            </p>

        </a>

    </div>

</div>


        {{-- ===== UPCOMING ===== --}}
        <div class="bg-white rounded-2xl border border-gray-100 p-5">

            <div class="mb-4">

                <h3 class="font-semibold text-gray-800">
                    Aktivitas Terdekat
                </h3>

            </div>

            <div class="space-y-3">

                {{-- BOOKING --}}
                @if($nearestBooking)

                <div class="border rounded-xl p-3">

                    <p class="text-xs text-green-600 mb-1">
                        Booking Terdekat
                    </p>

                    <p class="text-sm font-medium">
                        {{ $nearestBooking->field->name ?? 'Lapangan' }}
                    </p>

                    <p class="text-xs text-gray-500">
                        {{ $nearestBooking->timeSlot->start_time ?? '-' }}
                    </p>

                    <p class="text-xs text-gray-400 mt-1">
                        Status: {{ ucfirst($nearestBooking->status) }}
                    </p>

                </div>

                @endif


                {{-- MATCH --}}
                @if($nearestMatch)

                <div class="border rounded-xl p-3">

                    <p class="text-xs text-red-500 mb-1">
                        Match Terdekat
                    </p>

                    <p class="text-sm font-medium">
                        Public Match
                    </p>

                    <p class="text-xs text-gray-500">
                        {{ $nearestMatch->field->name ?? 'Lapangan' }}
                    </p>

                    <p class="text-xs text-gray-400 mt-1">
                        Status: {{ ucfirst($nearestMatch->status) }}
                    </p>

                </div>

                @endif


                {{-- EMPTY --}}
                @if(!$nearestBooking && !$nearestMatch)

                <div class="text-center py-6 text-sm text-gray-400">
                    Belum ada aktivitas booking
                </div>

                @endif

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