@extends('partials.app')

@section('title', 'Dashboard User')

@section('content')

<div class="space-y-6">

    {{-- HEADER --}}
    <div>
        <h2 class="text-lg font-semibold text-gray-900">
            Halo, {{ auth()->user()->name }} 👋
        </h2>
        <p class="text-sm text-gray-500">
            Selamat datang di ActiveHub
        </p>
    </div>

    {{-- GRID --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- ================= LEFT ================= --}}
        <div class="lg:col-span-2 space-y-6">

            {{-- STATS --}}
            <div class="grid grid-cols-2 gap-4">

                <div class="bg-gray-100 p-5 rounded-xl flex justify-between">
                    <div>
                        <p class="text-xs text-gray-500">Total Booking</p>
                        <p class="text-lg font-semibold">{{ $totalBooking }}</p>
                    </div>
                </div>

                <div class="bg-gray-100 p-5 rounded-xl flex justify-between">
                    <div>
                        <p class="text-xs text-gray-500">Match Booking</p>
                        <p class="text-lg font-semibold">{{ $matchBooking }}</p>
                    </div>
                </div>

            </div>

            {{-- CHART --}}
            <div class="bg-white rounded-2xl border p-6 shadow-sm">

                <div class="flex justify-between mb-4">
                    <h3 class="font-semibold text-gray-800">
                        Aktivitas Booking
                    </h3>
                </div>

                <div class="h-64">
                    <canvas id="bookingChart"></canvas>
                </div>

            </div>

        </div>


        {{-- ================= RIGHT ================= --}}
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

                <div class="space-y-4">

                    {{-- BOOKING --}}
                    @if($nearestBooking)
                    <div class="border border-gray-100 rounded-xl p-3 bg-white hover:bg-gray-50 transition shadow-sm">
                        <div class="flex justify-between items-start mb-1">
                            <p class="text-[10px] font-bold text-green-600 uppercase tracking-wider">Booking Terdekat</p>
                            @php
                                $status = $nearestBooking->status;
                                $statusLabel = 'Terjadwal';
                                $statusColor = 'bg-blue-50 text-blue-600';
                                if($status == 'confirmed' || $status == 'paid') {
                                    $statusLabel = 'Confirmed';
                                    $statusColor = 'bg-green-50 text-green-600';
                                }
                            @endphp
                            <span class="text-[10px] px-2 py-0.5 rounded-full {{ $statusColor }}">{{ $statusLabel }}</span>
                        </div>
                        <p class="text-sm font-semibold text-gray-800">{{ $nearestBooking->field->venue->name ?? 'Venue' }}</p>
                        <p class="text-xs text-gray-500">{{ $nearestBooking->field->name ?? 'Lapangan' }}</p>
                        <p class="text-[11px] text-gray-400 mt-2 flex items-center gap-1.5">
                            <i class="far fa-calendar text-gray-400"></i>
                            {{ $nearestBooking->timeSlot && $nearestBooking->timeSlot->date ? $nearestBooking->timeSlot->date->format('d M Y') : '-' }}
                        </p>
                        <p class="text-[11px] text-gray-400 mt-1 flex items-center gap-1.5">
                            <i class="far fa-clock text-gray-400"></i>
                            {{ $nearestBooking->timeSlot ? date('H:i', strtotime($nearestBooking->timeSlot->start_time)) : '-' }} - {{ $nearestBooking->timeSlot ? date('H:i', strtotime($nearestBooking->timeSlot->end_time)) : '-' }}
                        </p>
                    </div>
                    @endif

                    {{-- MATCH --}}
                    @if($nearestMatch)
                    <div class="border border-gray-100 rounded-xl p-3 bg-white hover:bg-gray-50 transition shadow-sm">
                        <div class="flex justify-between items-start mb-1">
                            <p class="text-[10px] font-bold text-blue-600 uppercase tracking-wider">Match Terdekat</p>
                            <span class="text-[10px] px-2 py-0.5 rounded-full bg-blue-50 text-blue-600">Joined</span>
                        </div>
                        <p class="text-sm font-semibold text-gray-800">{{ $nearestMatch->field->venue->name ?? 'Venue' }}</p>
                        <p class="text-xs text-gray-500">{{ $nearestMatch->field->name ?? 'Lapangan' }}</p>
                        <p class="text-[11px] text-gray-400 mt-2 flex items-center gap-1.5">
                            <i class="far fa-calendar text-gray-400"></i>
                            {{ $nearestMatch->timeSlot && $nearestMatch->timeSlot->date ? $nearestMatch->timeSlot->date->format('d M Y') : '-' }}
                        </p>
                        <p class="text-[11px] text-gray-400 mt-1 flex items-center gap-1.5">
                            <i class="far fa-clock text-gray-400"></i>
                            {{ $nearestMatch->timeSlot ? date('H:i', strtotime($nearestMatch->timeSlot->start_time)) : '-' }} - {{ $nearestMatch->timeSlot ? date('H:i', strtotime($nearestMatch->timeSlot->end_time)) : '-' }}
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

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
const ctx = document.getElementById('bookingChart').getContext('2d');

const descriptions = [
    "Awal bulan sepi",
    "Mulai naik",
    "Stabil",
    "Aktif",
    "Naik",
    "Puncak"
];

new Chart(ctx, {
    type: 'bar',
    data: {
        labels: @json($months),
        datasets: [
            {
                label: 'Pending',
                data: @json($pendingData),
                backgroundColor: '#bbf7d0'
            },
            {
                label: 'Confirmed',
                data: @json($confirmedData),
                backgroundColor: '#4ade80'
            },
            {
                label: 'Completed',
                data: @json($completedData),
                backgroundColor: '#166534'
            }
        ]
    },
    options: {
        responsive: true,
        scales: {
            x: { stacked: true },
            y: { stacked: true }
        },
        plugins: {
            tooltip: {
                callbacks: {
                    afterBody: function(context) {
                        return descriptions[context[0].dataIndex];
                    }
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