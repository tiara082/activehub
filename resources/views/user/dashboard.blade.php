@extends('partials.app')

@section('title', 'Dashboard Pengguna')

@section('content')

<div class="space-y-6">

    {{-- HEADER BANNER --}}
    <div class="bg-gradient-to-r from-[#0b3d0b] via-[#124d12] to-[#1b5e1b] rounded-3xl p-6 text-white relative overflow-hidden shadow-lg border border-green-800/20">
        <div class="absolute -right-10 -top-10 w-40 h-40 bg-white/5 rounded-full blur-2xl"></div>
        <div class="absolute -right-2 -bottom-12 w-36 h-36 bg-yellow-400/10 rounded-full blur-xl"></div>
        
        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <p class="text-yellow-300 text-xs font-extrabold tracking-widest uppercase mb-1">DASHBOARD AKTIVITAS</p>
                <h2 class="text-2xl font-black tracking-tight flex items-center gap-2">
                    Halo, {{ auth()->user()->name }}! <span class="animate-bounce">👋</span>
                </h2>
                <p class="text-sm text-green-100/90 mt-1 font-medium">
                    Selamat datang di ActiveHub. Siap berolahraga hari ini?
                </p>
            </div>
            
            <div class="flex items-center gap-3">
                <a href="{{ route('venues.index') }}" class="px-5 py-2.5 bg-yellow-400 hover:bg-yellow-500 text-gray-950 text-xs font-bold rounded-xl shadow-md transition-all duration-300 hover:scale-105">
                    Pesan Lapangan
                </a>
            </div>
        </div>
    </div>

    {{-- GRID --}}
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

        {{-- ================= LEFT ================= --}}
        <div class="lg:col-span-2 space-y-6">

            {{-- STATS --}}
            <div class="grid grid-cols-2 gap-4">

                {{-- TOTAL PESANAN --}}
                <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-[0_8px_30px_rgba(0,0,0,0.02)] flex justify-between items-center hover:shadow-[0_12px_30px_rgba(11,61,11,0.06)] hover:-translate-y-0.5 transition-all duration-300 group">

                    <div>
                        <p class="text-xs font-extrabold text-gray-400 uppercase tracking-wider group-hover:text-green-700 transition-colors">
                            Total Pesanan
                        </p>

                        <p class="text-2xl font-black text-gray-800 mt-1 font-mono">
                            {{ $totalBooking }}
                        </p>
                    </div>

                    <div class="w-12 h-12 rounded-xl bg-green-50 text-green-600 flex items-center justify-center group-hover:bg-green-700 group-hover:text-white transition-all duration-300 shadow-sm">
                        <i class="fas fa-calendar-check text-lg"></i>
                    </div>

                </div>

                {{-- PERMAINAN PUBLIK --}}
                <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-[0_8px_30px_rgba(0,0,0,0.02)] flex justify-between items-center hover:shadow-[0_12px_30px_rgba(11,61,11,0.06)] hover:-translate-y-0.5 transition-all duration-300 group">

                    <div>
                        <p class="text-xs font-extrabold text-gray-400 uppercase tracking-wider group-hover:text-green-700 transition-colors">
                            Total Permainan
                        </p>

                        <p class="text-2xl font-black text-gray-800 mt-1 font-mono">
                            {{ $matchBooking }}
                        </p>
                    </div>

                    <div class="w-12 h-12 rounded-xl bg-green-50 text-green-600 flex items-center justify-center group-hover:bg-green-700 group-hover:text-white transition-all duration-300 shadow-sm">
                        <i class="fas fa-users text-lg"></i>
                    </div>

                </div>

            </div>

            {{-- CHART --}}
            <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-[0_8px_30px_rgba(0,0,0,0.02)]">

                <div class="flex justify-between mb-4">

                    <div>
                        <h3 class="font-bold text-gray-800 text-sm tracking-wide flex items-center gap-2">
                            <span class="w-1.5 h-4 bg-green-700 rounded-full"></span>
                            Aktivitas Pengguna
                        </h3>

                        <p class="text-xs text-gray-400 mt-1">
                            Statistik aktivitas bulanan
                        </p>
                    </div>

                </div>

                <div class="h-56 sm:h-72">
                    <canvas id="bookingChart"></canvas>
                </div>

            </div>

        </div>

        {{-- ================= RIGHT ================= --}}
        <div class="space-y-6">

            {{-- ===== AKSI CEPAT ===== --}}
            <div class="bg-white rounded-2xl border border-gray-100 p-5 shadow-[0_8px_30px_rgba(0,0,0,0.02)]">

                <h3 class="font-bold text-gray-800 text-sm tracking-wide mb-5 flex items-center gap-2">
                    <span class="w-1.5 h-4 bg-green-700 rounded-full"></span>
                    Aksi Cepat
                </h3>

                <div class="grid grid-cols-3 gap-4 text-center">

                    {{-- CARI LAPANGAN --}}
                    <a href="{{ route('venues.index') }}"
                       class="flex flex-col items-center gap-2 group">

                        <div class="w-12 h-12 rounded-2xl bg-[#0b3d0b]
                                    flex items-center justify-center
                                    group-hover:scale-105 group-hover:shadow-lg group-hover:shadow-green-900/10 transition-all duration-300">

                            <i class="fas fa-search text-white"></i>

                        </div>

                        <p class="text-xs font-semibold text-gray-600 group-hover:text-green-800 transition-colors">
                            Temukan Lapangan
                        </p>

                    </a>

                    {{-- CARI PERMAINAN --}}
                    <a href="{{ route('matches.index') }}"
                       class="flex flex-col items-center gap-2 group">

                        <div class="w-12 h-12 rounded-2xl bg-[#0b3d0b]
                                    flex items-center justify-center
                                    group-hover:scale-105 group-hover:shadow-lg group-hover:shadow-green-900/10 transition-all duration-300">

                            <i class="fas fa-users text-white"></i>

                        </div>

                        <p class="text-xs font-semibold text-gray-600 group-hover:text-green-800 transition-colors">
                            Cari Permainan
                        </p>

                    </a>

                    {{-- BUAT PERMAINAN --}}
                    <a href="{{ $hasBooking
                                ? route('matches.create')
                                : route('venues.index') }}"
                       class="flex flex-col items-center gap-2 group">

                        <div class="w-12 h-12 rounded-2xl
                                    {{ $hasBooking ? 'bg-yellow-500' : 'bg-gray-300' }}
                                    flex items-center justify-center
                                    group-hover:scale-105 group-hover:shadow-lg transition-all duration-300">

                            <i class="fas fa-plus text-white"></i>

                        </div>

                        <div class="text-center">

                            <p class="text-xs font-semibold text-gray-600 group-hover:text-yellow-600 transition-colors">
                                Buat Permainan
                            </p>

                            @if(!$hasBooking)
                            <p class="text-[9px] text-gray-400 mt-1 leading-tight font-medium">
                                Pesan lapangan dahulu
                            </p>
                            @endif

                        </div>

                    </a>

                </div>

            </div>

            {{-- ===== AKTIVITAS TERDEKAT ===== --}}
            <div class="bg-white rounded-2xl border border-gray-100 p-5 shadow-[0_8px_30px_rgba(0,0,0,0.02)]">

                <h3 class="font-bold text-gray-800 text-sm tracking-wide mb-4 flex items-center gap-2">
                    <span class="w-1.5 h-4 bg-green-700 rounded-full"></span>
                    Aktivitas Terdekat
                </h3>

                <div class="space-y-4">

                    {{-- PESANAN --}}
                    @if($nearestBooking)
                    <div class="border-l-4 border-green-700 rounded-r-2xl border-y border-r border-gray-100 p-4 bg-white hover:bg-green-50/20 transition-all duration-300 shadow-[0_4px_20px_rgba(0,0,0,0.01)] hover:shadow-[0_8px_30px_rgba(0,0,0,0.04)]">

                        <div class="flex justify-between items-start mb-1">

                            <p class="text-[9px] font-extrabold text-green-700 uppercase tracking-widest">
                                Pesanan Terdekat
                            </p>

                            @php
                                $status = $nearestBooking->status;
                                $statusLabel = 'Terjadwal';
                                $statusColor = 'bg-blue-50 text-blue-600';

                                if($status == 'confirmed' || $status == 'paid') {
                                    $statusLabel = 'Dikonfirmasi';
                                    $statusColor = 'bg-green-50 text-green-600';
                                }
                            @endphp

                            <span class="text-[9px] font-bold px-2.5 py-0.5 rounded-full {{ $statusColor }}">
                                {{ $statusLabel }}
                            </span>

                        </div>

                        <p class="text-sm font-bold text-gray-800 mt-1">
                            {{ $nearestBooking->field->venue->name ?? 'Venue' }}
                        </p>

                        <p class="text-xs text-gray-500 font-medium">
                            {{ $nearestBooking->field->name ?? 'Lapangan' }}
                        </p>

                        <div class="mt-3 space-y-1">
                            <p class="text-[11px] text-gray-500 flex items-center gap-1.5 font-medium">
                                <i class="far fa-calendar text-green-700"></i>

                                {{ $nearestBooking->timeSlot && $nearestBooking->timeSlot->date
                                    ? $nearestBooking->timeSlot->date->format('d M Y')
                                    : '-' }}
                            </p>

                            <p class="text-[11px] text-gray-500 flex items-center gap-1.5 font-medium">
                                <i class="far fa-clock text-green-700"></i>

                                {{ $nearestBooking->timeSlot
                                    ? date('H:i', strtotime($nearestBooking->timeSlot->start_time))
                                    : '-' }}

                                -

                                {{ $nearestBooking->timeSlot
                                    ? date('H:i', strtotime($nearestBooking->timeSlot->end_time))
                                    : '-' }} WIB
                            </p>
                        </div>

                    </div>
                    @endif

                    {{-- PERMAINAN --}}
                    @if($nearestMatch)
                    <div class="border-l-4 border-blue-600 rounded-r-2xl border-y border-r border-gray-100 p-4 bg-white hover:bg-blue-50/20 transition-all duration-300 shadow-[0_4px_20px_rgba(0,0,0,0.01)] hover:shadow-[0_8px_30px_rgba(0,0,0,0.04)]">

                        <div class="flex justify-between items-start mb-1">

                            <p class="text-[9px] font-extrabold text-blue-600 uppercase tracking-widest">
                                Permainan Terdekat
                            </p>

                            <span class="text-[9px] font-bold px-2.5 py-0.5 rounded-full bg-blue-50 text-blue-600">
                                Bergabung
                            </span>

                        </div>

                        <p class="text-sm font-bold text-gray-800 mt-1">
                            {{ $nearestMatch->field->venue->name ?? 'Venue' }}
                        </p>

                        <p class="text-xs text-gray-500 font-medium">
                            {{ $nearestMatch->field->name ?? 'Lapangan' }}
                        </p>

                        <div class="mt-3 space-y-1">
                            <p class="text-[11px] text-gray-500 flex items-center gap-1.5 font-medium">
                                <i class="far fa-calendar text-blue-600"></i>

                                {{ $nearestMatch->timeSlot && $nearestMatch->timeSlot->date
                                    ? $nearestMatch->timeSlot->date->format('d M Y')
                                    : '-' }}
                            </p>

                            <p class="text-[11px] text-gray-500 flex items-center gap-1.5 font-medium">
                                <i class="far fa-clock text-blue-600"></i>

                                {{ $nearestMatch->timeSlot
                                    ? date('H:i', strtotime($nearestMatch->timeSlot->start_time))
                                    : '-' }}

                                -

                                {{ $nearestMatch->timeSlot
                                    ? date('H:i', strtotime($nearestMatch->timeSlot->end_time))
                                    : '-' }} WIB
                            </p>
                        </div>

                    </div>
                    @endif

                    {{-- EMPTY --}}
                    @if(!$nearestBooking && !$nearestMatch)
                    <div class="text-center text-sm text-gray-400 py-6 font-medium">
                        Belum ada aktivitas terdekat
                    </div>
                    @endif

                </div>

            </div>

        </div>

    </div>

</div>

@endsection

{{-- ================= SCRIPT ================= --}}
@push('scripts')

{{-- Hidden Element to store Chart Data safely for JS --}}
<div id="dashboardChartData" class="hidden"
     data-months="{{ json_encode($months) }}"
     data-booking="{{ json_encode($bookingData) }}"
     data-joined="{{ json_encode($joinedMatchData) }}"
     data-created="{{ json_encode($createdMatchData) }}">
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const chartDataEl = document.getElementById('dashboardChartData');
const chartMonths = JSON.parse(chartDataEl.dataset.months);
const chartBooking = JSON.parse(chartDataEl.dataset.booking);
const chartJoined = JSON.parse(chartDataEl.dataset.joined);
const chartCreated = JSON.parse(chartDataEl.dataset.created);
const ctx = document.getElementById('bookingChart').getContext('2d');

new Chart(ctx, {
    type: 'bar',

    data: {
        labels: chartMonths,

        datasets: [

           {
                label: 'Total Pesanan',
                data: chartBooking,
                backgroundColor: '#C8E6C9',
                hoverBackgroundColor: '#C8E6C9',
                borderRadius: 4,
            },

            {
                label: 'Permainan Diikuti',
                data: chartJoined,
                backgroundColor: '#81C784',
                hoverBackgroundColor: '#81C784',
                borderRadius: 4,
            },

            {
                label: 'Permainan Dibuat',
                data: chartCreated,
                backgroundColor: '#2E7D32',
                hoverBackgroundColor: '#2E7D32',
                borderRadius: 4,
            }

        ]
    },

    options: {
        responsive: true,
        maintainAspectRatio: false,

        plugins: {

            legend: {
                position: 'top',

                labels: {
                    usePointStyle: false,
                    boxWidth: 40,
                    padding: 20
                }
            },

            tooltip: {
                backgroundColor: '#111827',
                padding: 12,
                cornerRadius: 10
            }
        },

        scales: {

            x: {
                stacked: true,

                grid: {
                    color: '#f3f4f6'
                }
            },

            y: {
                stacked: true,
                beginAtZero: true,

                ticks: {
                    stepSize: 2
                },

                grid: {
                    color: '#f3f4f6'
                }
            }

        }
    }
});
</script>
@endpush

{{-- FONT AWESOME --}}
@push('styles')
<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@endpush