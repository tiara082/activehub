@extends('partials.app')

@section('title', 'Dashboard User')

@section('content')

@php

use App\Models\Booking;

$user = auth()->user();


// ===== STATS =====
$stats = [
    [
        'label' => 'Total Booking',
        'value' => Booking::where('user_id', $user->id)->count(),
        'icon'  => 'calendar-check',
        'color' => 'green'
    ],
    [
        'label' => 'Total Match',
        'value' => 8,
        'icon'  => 'users',
        'color' => 'blue'
    ],
];


// ===== CHART DATA DUMMY =====
$chartData = [
    ['month'=>'Jan','booking'=>4,'joined'=>2,'created'=>1],
    ['month'=>'Feb','booking'=>8,'joined'=>5,'created'=>2],
    ['month'=>'Mar','booking'=>6,'joined'=>4,'created'=>1],
    ['month'=>'Apr','booking'=>10,'joined'=>7,'created'=>3],
    ['month'=>'Mei','booking'=>7,'joined'=>5,'created'=>2],
    ['month'=>'Jun','booking'=>12,'joined'=>9,'created'=>4],
];

$maxChart = collect($chartData)->max('booking');


// ===== QUICK ACTION =====
$hasBooking = Booking::where('user_id', auth()->id())->exists();

@endphp


<div class="space-y-6">

    {{-- ================= HEADER ================= --}}
    <div>

        <h2 class="text-xl font-semibold text-gray-900">
            Halo, {{ auth()->user()->name }} 👋
        </h2>

        <p class="text-sm text-gray-500 mt-1">
            Selamat datang di ActiveHub, semoga harimu menyenangkan!
        </p>

    </div>



    {{-- ================= MAIN GRID ================= --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">



        {{-- ================= LEFT SIDE ================= --}}
        <div class="lg:col-span-2 space-y-6">


            {{-- ===== STATS ===== --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                @foreach($stats as $s)

                <div class="bg-white border border-gray-100 rounded-2xl p-5 flex items-center justify-between shadow-sm">

                    {{-- TEXT --}}
                    <div>

                        <p class="text-xs text-gray-500">
                            {{ $s['label'] }}
                        </p>

                        <p class="text-2xl font-bold text-gray-900 mt-1">
                            {{ $s['value'] }}
                        </p>

                    </div>


                    {{-- ICON --}}
                    <div class="w-12 h-12 rounded-xl bg-{{ $s['color'] }}-100 flex items-center justify-center">

                        <i class="fas fa-{{ $s['icon'] }} text-{{ $s['color'] }}-600"></i>

                    </div>

                </div>

                @endforeach

            </div>



            {{-- ===== CHART ===== --}}
<div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm">

    {{-- HEADER --}}
    <div class="mb-6">

        <h3 class="text-base font-semibold text-gray-800">
            Aktivitas User
        </h3>

        <p class="text-sm text-gray-400">
            Statistik 6 bulan terakhir
        </p>

    </div>


    {{-- CHART --}}
    <div class="relative h-80 pl-8">

        {{-- GRID + LABEL --}}
        <div class="absolute inset-0 flex flex-col justify-between pl-8">

            @foreach([12,9,6,3,0] as $line)

            <div class="relative border-t border-dashed border-gray-200 h-full">

                {{-- ANGKA --}}
                <span class="absolute -left-7 -top-3 text-[11px] text-gray-400">
                    {{ $line }}
                </span>

            </div>

            @endforeach

        </div>



        {{-- BAR AREA --}}
        <div class="absolute inset-0 flex items-end justify-between px-10 pb-6">

            @foreach($chartData as $data)

            @php
                $height = ($data['booking'] / $maxChart) * 220;
            @endphp

            <div class="flex flex-col items-center justify-end h-full relative group">

                {{-- TOOLTIP --}}
                <div class="absolute bottom-full mb-2
                            left-1/2 -translate-x-1/2
                            hidden group-hover:block
                            bg-gray-900 text-white
                            text-xs rounded-lg
                            px-3 py-2 shadow-lg
                            whitespace-nowrap z-20">

                    <p>Total Booking : {{ $data['booking'] }}</p>
                    <p>Match Diikuti : {{ $data['joined'] }}</p>
                    <p>Match Dibuat : {{ $data['created'] }}</p>

                </div>



                {{-- BAR --}}
                <div class="w-20 bg-green-700 hover:bg-green-800
                            rounded-t-xl transition-all duration-300"
                     style="height: {{ $height }}px">

                </div>



                {{-- MONTH --}}
                <p class="text-xs text-gray-500 mt-3">
                    {{ $data['month'] }}
                </p>

            </div>

            @endforeach

        </div>

    </div>

</div>

        </div>
        {{-- END LEFT SIDE --}}





        {{-- ================= RIGHT SIDE ================= --}}
        <div class="space-y-6">



            {{-- ===== QUICK ACTION ===== --}}
            <div class="bg-white rounded-2xl border border-gray-100 p-5 shadow-sm">

                <h3 class="font-semibold text-gray-800 mb-5">
                    Quick Action
                </h3>


                <div class="grid grid-cols-3 gap-4 text-center">


                    {{-- Cari --}}
                    <a href="{{ route('venues.index') }}"
                       class="flex flex-col items-center gap-2 group">

                        <div class="w-12 h-12 rounded-xl bg-green-700
                                    flex items-center justify-center
                                    group-hover:scale-105 transition">

                            <i class="fas fa-search text-white"></i>

                        </div>

                        <p class="text-xs text-gray-600">
                            Cari Lapangan
                        </p>

                    </a>



                    {{-- Join --}}
                    <a href="{{ route('matches.index') }}"
                       class="flex flex-col items-center gap-2 group">

                        <div class="w-12 h-12 rounded-xl bg-blue-500
                                    flex items-center justify-center
                                    group-hover:scale-105 transition">

                            <i class="fas fa-users text-white"></i>

                        </div>

                        <p class="text-xs text-gray-600">
                            Join Match
                        </p>

                    </a>



                    {{-- Buat Match --}}
                    <a href="{{ $hasBooking
                                ? route('matches.create')
                                : route('venues.index') }}"
                       class="flex flex-col items-center gap-2 group">

                        <div class="w-12 h-12 rounded-xl
                                    {{ $hasBooking ? 'bg-yellow-500' : 'bg-gray-400' }}
                                    flex items-center justify-center
                                    group-hover:scale-105 transition">

                            <i class="fas fa-plus text-white"></i>

                        </div>

                        <div class="text-center">

                            <p class="text-xs text-gray-600">
                                Buat Match
                            </p>

                            @if(!$hasBooking)

                            <p class="text-[10px] text-gray-400 mt-1 leading-tight">
                                Booking lapangan dulu
                            </p>

                            @endif

                        </div>

                    </a>

                </div>

            </div>

            {{-- ===== AKTIVITAS TERDEKAT ===== --}}
            <div class="bg-white rounded-2xl border border-gray-100 p-5 shadow-sm">

                <h3 class="font-semibold text-gray-800 mb-4">
                    Aktivitas Terdekat
                </h3>


                <div class="space-y-3">


                    {{-- BOOKING --}}
                    <div class="border border-gray-100 rounded-xl p-3">

                        <p class="text-xs text-green-600 mb-1">
                            Booking Terdekat
                        </p>

                        <p class="text-sm font-medium text-gray-800">
                            Active Arena
                        </p>

                        <p class="text-xs text-gray-500">
                            Lapangan Futsal A
                        </p>

                        <p class="text-xs text-gray-400 mt-1">
                            Sabtu, 25 Mei • 19:00
                        </p>

                    </div>



                    {{-- MATCH --}}
                    <div class="border border-gray-100 rounded-xl p-3">

                        <p class="text-xs text-red-500 mb-1">
                            Match Terdekat
                        </p>

                        <p class="text-sm font-medium text-gray-800">
                            Fun Match Weekend
                        </p>

                        <p class="text-xs text-gray-500">
                            Futsal • 7 vs 7
                        </p>

                        <p class="text-xs text-gray-400 mt-1">
                            Minggu, 26 Mei • 16:00
                        </p>

                    </div>

                </div>

            </div>

        </div>
        {{-- END RIGHT SIDE --}}

    </div>
    {{-- END MAIN GRID --}}

</div>



{{-- FONT AWESOME --}}
@push('styles')

<link rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

@endpush

@endsection