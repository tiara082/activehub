@extends('partials.app')

@section('title', 'Profile User')

@section('content')

@php
    $user = auth()->user();

    // ================= FILTER STATE =================
    $bookingActive = request('booking', 'all');
    $matchActive   = request('match', 'all');

    // ================= DUMMY DATA =================
    $bookings = [
        ['name'=>'Active Arena','status'=>'upcoming'],
        ['name'=>'Sport Center','status'=>'completed'],
        ['name'=>'Victory Futsal','status'=>'cancelled'],
    ];

    $matches = [
        ['name'=>'Fun Match Weekend','status'=>'host'],
        ['name'=>'Badminton Morning','status'=>'joined'],
        ['name'=>'Night Futsal','status'=>'joined'],
    ];

    // ================= FILTER =================
    $filteredBookings = collect($bookings)->filter(function($b) use ($bookingActive){
        return $bookingActive === 'all' || $b['status'] === $bookingActive;
    });

    $filteredMatches = collect($matches)->filter(function($m) use ($matchActive){
        return $matchActive === 'all' || $m['status'] === $matchActive;
    });
@endphp

<div class="space-y-6">

    {{-- ================= PROFILE HEADER ================= --}}
    <div class="bg-white rounded-2xl border border-gray-100 p-6 flex items-center justify-between">

        <div class="flex items-center gap-4">

            <div class="w-16 h-16 rounded-full bg-gradient-to-br from-[#0b3d0b] to-[#145214]
                        flex items-center justify-center text-white text-xl font-semibold">
                {{ strtoupper(substr($user->name,0,2)) }}
            </div>

            <div>
                <h2 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                    {{ $user->name }}
                    <span class="text-xs bg-blue-100 text-blue-700 px-2 py-1 rounded-full">
                        {{ ucfirst($user->role) }}
                    </span>
                </h2>

                <div class="text-sm text-gray-500 mt-1 space-y-1">
                    <p><i class="fas fa-envelope mr-1"></i> {{ $user->email }}</p>
                    <p><i class="fas fa-phone mr-1"></i> {{ $user->phone }}</p>
                </div>
            </div>

        </div>

        <div class="relative group">
                    <button class="w-9 h-9 rounded-lg bg-gray-100 hover:bg-gray-200 flex items-center justify-center transition">
                        <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                d="M12 20h9" />
                            <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                d="M16.5 3.5a2.121 2.121 0 113 3L7 19l-4 1 1-4 12.5-12.5z" />
                        </svg>
                    </button>

                    <span class="absolute right-0 top-full mt-2 text-xs bg-gray-900 text-white px-2 py-1 rounded 
                                 opacity-0 group-hover:opacity-100 transition whitespace-nowrap">
                        Edit Profile
                    </span>
                </div>

    </div>


    {{-- ================= STATS ================= --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">

        @php
        $stats = [
            ['label'=>'Total Booking','value'=>'12','icon'=>'calendar-check','color'=>'green'],
            ['label'=>'Match Diikuti','value'=>'5','icon'=>'users','color'=>'blue'],
            ['label'=>'Match Dibuat','value'=>'2','icon'=>'trophy','color'=>'yellow'],
            ['label'=>'Total Pengeluaran','value'=>'Rp 1.250.000','icon'=>'wallet','color'=>'red'],
        ];
        @endphp

        @foreach($stats as $s)
        <div class="bg-white border border-gray-100 rounded-xl p-5 flex items-center justify-between">
            
            <div>
                <p class="text-sm text-gray-500">{{ $s['label'] }}</p>
                <p class="text-xl font-semibold text-gray-900 mt-1">
                    {{ $s['value'] }}
                </p>
            </div>

            <div class="w-10 h-10 rounded-lg bg-{{ $s['color'] }}-50 flex items-center justify-center">
                <i class="fas fa-{{ $s['icon'] }} text-{{ $s['color'] }}-600"></i>
            </div>

        </div>
        @endforeach

    </div>


    {{-- ================= RIWAYAT ================= --}}
    <div class="grid md:grid-cols-2 gap-6">

        {{-- ================= BOOKING ================= --}}
        <div class="bg-white rounded-2xl border border-gray-100 p-5">

            <p class="font-semibold text-gray-800 mb-3">Booking Saya</p>

            {{-- FILTER --}}
            <div class="flex gap-2 p-1 bg-gray-100 rounded-xl mb-4 text-xs">

                @foreach(['all'=>'Semua','upcoming'=>'Upcoming','completed'=>'Completed','cancelled'=>'Canceled'] as $key => $label)
                <a href="?booking={{ $key }}&match={{ $matchActive }}"
                   class="px-3 py-1 rounded-lg
                   {{ $bookingActive === $key ? 'bg-white text-[#0b3d0b] shadow-sm' : 'text-gray-500' }}">
                    {{ $label }}
                </a>
                @endforeach

            </div>

            {{-- LIST --}}
            <div class="space-y-3 text-sm">

                @forelse($filteredBookings as $b)
                <div class="flex justify-between">
                    <span>{{ $b['name'] }}</span>

                    <span class="
                        {{ $b['status']=='upcoming' ? 'text-green-600' : '' }}
                        {{ $b['status']=='completed' ? 'text-blue-500' : '' }}
                        {{ $b['status']=='cancelled' ? 'text-red-500' : '' }}
                    ">
                        {{ ucfirst($b['status']) }}
                    </span>
                </div>
                @empty
                <p class="text-gray-400 text-center">Tidak ada data</p>
                @endforelse

            </div>

        </div>


        {{-- ================= MATCH ================= --}}
        <div class="bg-white rounded-2xl border border-gray-100 p-5">

            <p class="font-semibold text-gray-800 mb-3">Match Saya</p>

            {{-- FILTER --}}
            <div class="flex gap-2 p-1 bg-gray-100 rounded-xl mb-4 text-xs">

                @foreach(['all'=>'Semua','joined'=>'Joined','host'=>'Host'] as $key => $label)
                <a href="?booking={{ $bookingActive }}&match={{ $key }}"
                   class="px-3 py-1 rounded-lg
                   {{ $matchActive === $key ? 'bg-white text-[#0b3d0b] shadow-sm' : 'text-gray-500' }}">
                    {{ $label }}
                </a>
                @endforeach

            </div>

            {{-- LIST --}}
            <div class="space-y-3 text-sm">

                @forelse($filteredMatches as $m)
                <div class="flex justify-between">
                    <span>{{ $m['name'] }}</span>

                    <span class="
                        {{ $m['status']=='host' ? 'text-yellow-600' : 'text-blue-500' }}
                    ">
                        {{ ucfirst($m['status']) }}
                    </span>
                </div>
                @empty
                <p class="text-gray-400 text-center">Tidak ada data</p>
                @endforelse

            </div>

        </div>

    </div>


    {{-- ================= PASSWORD ================= --}}
    <div class="bg-white rounded-2xl border border-gray-100 p-5 space-y-4">

        <h3 class="font-semibold text-gray-800">Ganti Password</h3>

        <div class="grid md:grid-cols-3 gap-4">

            <input type="password" placeholder="Password Lama"
                class="border border-gray-200 rounded-lg px-4 py-2 text-sm">

            <input type="password" placeholder="Password Baru"
                class="border border-gray-200 rounded-lg px-4 py-2 text-sm">

            <input type="password" placeholder="Konfirmasi Password Baru"
                class="border border-gray-200 rounded-lg px-4 py-2 text-sm">

        </div>

        <div class="text-right">
            <button class="px-4 py-2 bg-green-600 text-white text-sm rounded-lg">
                Simpan Password
            </button>
        </div>

    </div>


    {{-- ================= LOGOUT ================= --}}
    <div class="bg-white rounded-2xl border border-gray-100 p-5 flex items-center justify-between">

        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-lg bg-red-50 flex items-center justify-center">
                <i class="fas fa-sign-out-alt text-red-500"></i>
            </div>
            <div>
                <p class="font-medium text-gray-800">Logout</p>
                <p class="text-sm text-gray-500">Keluar dari akun ActiveHub Anda</p>
            </div>
        </div>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="px-4 py-2 text-sm text-red-600 border border-red-200 rounded-lg hover:bg-red-50">
                Logout
            </button>
        </form>

    </div>

</div>

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@endpush

@endsection