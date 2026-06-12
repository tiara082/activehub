@extends('partials.app')

@section('title', 'Dashboard Pengguna')

@section('content')

<div class="space-y-6">

    {{-- HEADER --}}
    <div>
        <h2 class="text-lg font-semibold text-gray-900">
            Halo, {{ auth()->user()->name }}
        </h2>

        <p class="text-sm text-gray-500">
            Selamat datang di ActiveHub
        </p>
    </div>

    {{-- GRID --}}
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

        {{-- ================= LEFT ================= --}}
        <div class="lg:col-span-2 space-y-6">

            {{-- STATS --}}
            <div class="grid grid-cols-2 gap-4">

                {{-- TOTAL PESANAN --}}
                <div class="bg-gray-100 p-5 rounded-xl flex justify-between items-center">

                    <div>
                        <p class="text-xs text-gray-500">
                            Total Pesanan
                        </p>

                        <p class="text-lg font-semibold text-gray-800">
                            {{ $totalBooking }}
                        </p>
                    </div>

                    <div class="w-12 h-12 rounded-xl bg-green-100 flex items-center justify-center">
                        <i class="fas fa-calendar-check text-green-700"></i>
                    </div>

                </div>

                {{-- PERMAINAN PUBLIK --}}
                <div class="bg-gray-100 p-5 rounded-xl flex justify-between items-center">

                    <div>
                        <p class="text-xs text-gray-500">
                            Total Permainan
                        </p>

                        <p class="text-lg font-semibold text-gray-800">
                            {{ $matchBooking }}
                        </p>
                    </div>

                    <div class="w-12 h-12 rounded-xl bg-blue-100 flex items-center justify-center">
                        <i class="fas fa-users text-blue-700"></i>
                    </div>

                </div>

            </div>

            {{-- CHART --}}
            <div class="bg-white rounded-2xl border p-6 shadow-sm">

                <div class="flex justify-between mb-4">

                    <div>
                        <h3 class="font-semibold text-gray-800">
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
            <div class="bg-white rounded-2xl border border-gray-100 p-5 shadow-sm">

                <h3 class="font-semibold text-gray-800 mb-5">
                    Aksi Cepat
                </h3>

                <div class="grid grid-cols-3 gap-4 text-center">

                    {{-- CARI LAPANGAN --}}
                    <a href="{{ route('venues.index') }}"
                       class="flex flex-col items-center gap-2 group">

                        <div class="w-12 h-12 rounded-xl bg-green-700
                                    flex items-center justify-center
                                    group-hover:scale-105 transition">

                            <i class="fas fa-search text-white"></i>

                        </div>

                        <p class="text-xs text-gray-600">
                            Temukan Lapangan
                        </p>

                    </a>

                    {{-- CARI PERMAINAN --}}
                    <a href="{{ route('matches.index') }}"
                       class="flex flex-col items-center gap-2 group">

                        <div class="w-12 h-12 rounded-xl bg-blue-500
                                    flex items-center justify-center
                                    group-hover:scale-105 transition">

                            <i class="fas fa-users text-white"></i>

                        </div>

                        <p class="text-xs text-gray-600">
                            Cari Permainan
                        </p>

                    </a>

                    {{-- BUAT PERMAINAN --}}
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
                                Buat Permainan
                            </p>

                            @if(!$hasBooking)
                            <p class="text-[10px] text-gray-400 mt-1 leading-tight">
                                Pesan lapangan terlebih dahulu
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

                <div class="space-y-4">

                    {{-- PESANAN --}}
                    @if($nearestBooking)
                    <div class="border border-gray-100 rounded-xl p-3 bg-white hover:bg-gray-50 transition shadow-sm">

                        <div class="flex justify-between items-start mb-1">

                            <p class="text-[10px] font-bold text-green-600 uppercase tracking-wider">
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

                            <span class="text-[10px] px-2 py-0.5 rounded-full {{ $statusColor }}">
                                {{ $statusLabel }}
                            </span>

                        </div>

                        <p class="text-sm font-semibold text-gray-800">
                            {{ $nearestBooking->field->venue->name ?? 'Venue' }}
                        </p>

                        <p class="text-xs text-gray-500">
                            {{ $nearestBooking->field->name ?? 'Lapangan' }}
                        </p>

                        <p class="text-[11px] text-gray-400 mt-2 flex items-center gap-1.5">
                            <i class="far fa-calendar text-gray-400"></i>

                            {{ $nearestBooking->timeSlot && $nearestBooking->timeSlot->date
                                ? $nearestBooking->timeSlot->date->format('d M Y')
                                : '-' }}
                        </p>

                        <p class="text-[11px] text-gray-400 mt-1 flex items-center gap-1.5">
                            <i class="far fa-clock text-gray-400"></i>

                            {{ $nearestBooking->timeSlot
                                ? date('H:i', strtotime($nearestBooking->timeSlot->start_time))
                                : '-' }}

                            -

                            {{ $nearestBooking->timeSlot
                                ? date('H:i', strtotime($nearestBooking->timeSlot->end_time))
                                : '-' }}
                        </p>

                    </div>
                    @endif

                    {{-- PERMAINAN --}}
                    @if($nearestMatch)
                    <div class="border border-gray-100 rounded-xl p-3 bg-white hover:bg-gray-50 transition shadow-sm">

                        <div class="flex justify-between items-start mb-1">

                            <p class="text-[10px] font-bold text-blue-600 uppercase tracking-wider">
                                Permainan Terdekat
                            </p>

                            <span class="text-[10px] px-2 py-0.5 rounded-full bg-blue-50 text-blue-600">
                                Bergabung
                            </span>

                        </div>

                        <p class="text-sm font-semibold text-gray-800">
                            {{ $nearestMatch->field->venue->name ?? 'Venue' }}
                        </p>

                        <p class="text-xs text-gray-500">
                            {{ $nearestMatch->field->name ?? 'Lapangan' }}
                        </p>

                        <p class="text-[11px] text-gray-400 mt-2 flex items-center gap-1.5">
                            <i class="far fa-calendar text-gray-400"></i>

                            {{ $nearestMatch->timeSlot && $nearestMatch->timeSlot->date
                                ? $nearestMatch->timeSlot->date->format('d M Y')
                                : '-' }}
                        </p>

                        <p class="text-[11px] text-gray-400 mt-1 flex items-center gap-1.5">
                            <i class="far fa-clock text-gray-400"></i>

                            {{ $nearestMatch->timeSlot
                                ? date('H:i', strtotime($nearestMatch->timeSlot->start_time))
                                : '-' }}

                            -

                            {{ $nearestMatch->timeSlot
                                ? date('H:i', strtotime($nearestMatch->timeSlot->end_time))
                                : '-' }}
                        </p>

                    </div>
                    @endif

                    {{-- EMPTY --}}
                    @if(!$nearestBooking && !$nearestMatch)
                    <div class="text-center text-sm text-gray-400 py-6">
                        Belum ada aktivitas
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