{{-- resources/views/owner/pages/profile.blade.php --}}
@extends('partials.app')

@section('title', 'Profile Owner')

@section('content')
@php
    $user = auth()->user();
@endphp

<div class="space-y-6">

    {{-- ===== PROFILE HEADER ===== --}}
     <div class="bg-white rounded-2xl border border-gray-100 p-6 flex items-center justify-between">

        <div class="flex items-center gap-4">

            {{-- AVATAR --}}
            <div class="w-16 h-16 rounded-full bg-gradient-to-br from-[#0b3d0b] to-[#145214]
                        flex items-center justify-center text-white text-xl font-semibold">
                {{ strtoupper(substr($user->name,0,2)) }}
            </div>

            {{-- INFO --}}
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


    {{-- ===== STATS ===== --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">

        @php
        $stats = [
            ['label'=>'Jumlah Venue','value'=>'3','icon'=>'building','color'=>'blue'],
            ['label'=>'Jumlah Lapangan','value'=>'8','icon'=>'futbol','color'=>'green'],
            ['label'=>'Total Booking','value'=>'45','icon'=>'calendar-check','color'=>'orange'],
            ['label'=>'Total Revenue','value'=>'Rp 12.450.000','icon'=>'money-bill-wave','color'=>'yellow'],
        ];
        @endphp

        @foreach($stats as $s)
        <div class="bg-white border border-gray-100 rounded-xl p-5 flex items-center justify-between transition hover:bg-gray-50">
            
            <div>
                <p class="text-sm text-gray-500">{{ $s['label'] }}</p>
                <p class="text-xl font-semibold text-gray-900 mt-1">
                    {{ $s['value'] }}
                </p>
            </div>

            {{-- ICON --}}
            <div class="w-10 h-10 rounded-lg bg-{{ $s['color'] }}-50 flex items-center justify-center">
                <i class="fas fa-{{ $s['icon'] }} text-{{ $s['color'] }}-600 text-lg"></i>
            </div>

        </div>
        @endforeach

    </div>


    {{-- ===== DAFTAR VENUE DENGAN LIST LAPANGAN ===== --}}
    <div class="bg-white rounded-2xl border border-gray-100 p-5">

        <h3 class="font-semibold text-gray-800 mb-4 flex items-center gap-2">
            <i class="fas fa-map-marker-alt text-green-600"></i> Venue & Lapangan
        </h3>

        @php
        $venues = [
            [
                'name'=>'Active Arena',
                'fields'=>3,
                'field_list'=>['Lapangan Futsal A', 'Lapangan Futsal B', 'Lapangan Basket'],
                'sports'=>'Futsal, Basket'
            ],
            [
                'name'=>'Sport Center Jakarta',
                'fields'=>2,
                'field_list'=>['Lapangan Badminton 1', 'Lapangan Tenis'],
                'sports'=>'Badminton, Tenis'
            ],
            [
                'name'=>'Victory Futsal',
                'fields'=>1,
                'field_list'=>['Lapangan Futsal'],
                'sports'=>'Futsal'
            ],
        ];
        @endphp

        <div class="space-y-4">

            @foreach($venues as $v)
            <div class="rounded-xl border border-gray-100 hover:bg-gray-50 transition overflow-hidden">
                {{-- Header Venue --}}
                <div class="flex items-center justify-between p-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg bg-green-50 flex items-center justify-center">
                            <i class="fas fa-futbol text-green-600"></i>
                        </div>
                        <div>
                            <p class="font-medium text-gray-900">{{ $v['name'] }}</p>
                            <p class="text-sm text-gray-500">
                                <i class="fas fa-layer-group text-gray-400 mr-1"></i> {{ $v['fields'] }} Lapangan
                            </p>
                        </div>
                    </div>

                    <div class="flex items-center gap-3">
                        <span class="bg-gray-100 px-2 py-1 rounded-lg text-xs text-gray-600">
                            <i class="fas fa-futbol mr-1"></i> {{ $v['sports'] }}
                        </span>
                        <button class="text-gray-400 hover:text-green-600 transition">
                            <i class="fas fa-chevron-down text-sm"></i>
                        </button>
                    </div>
                </div>

                {{-- List Lapangan (ditampilkan langsung) --}}
                <div class="bg-gray-50 px-4 py-3 border-t border-gray-100">
                    <div class="flex flex-wrap items-center gap-2">
                        <span class="text-xs font-medium text-gray-500 mr-2">
                            <i class="fas fa-list-ul mr-1"></i> Daftar Lapangan:
                        </span>
                        @foreach($v['field_list'] as $field)
                            <span class="inline-flex items-center gap-1 px-2 py-1 bg-white rounded-md text-xs text-gray-700 border border-gray-200 shadow-sm">
                                <i class="fas fa-circle text-green-800 text-[10px]"></i> {{ $field }}
                            </span>
                        @endforeach
                    </div>
                </div>
            </div>
            @endforeach

        </div>

        <div class="mt-5 pt-4 border-t border-gray-100 flex justify-end">
            <button class="px-4 py-2 text-sm rounded-xl bg-[#0b3d0b] text-white hover:bg-[#163016] transition flex items-center gap-2">
                <i class="fas fa-plus-circle"></i> Tambah Venue
            </button>
        </div>

    </div>


    {{-- ===== GANTI PASSWORD ===== --}}
    <div class="bg-white rounded-2xl border border-gray-100 p-5 space-y-4">

        <h3 class="font-semibold text-gray-800 flex items-center gap-2">
            <i class="fas fa-lock text-green-600"></i> Ganti Password
        </h3>

        <div class="grid md:grid-cols-3 gap-4">

            <div class="relative">
                <i class="fas fa-key absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                <input type="password" placeholder="Password Lama"
                    class="w-full border border-gray-200 rounded-lg pl-10 pr-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
            </div>

            <div class="relative">
                <i class="fas fa-lock absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                <input type="password" placeholder="Password Baru"
                    class="w-full border border-gray-200 rounded-lg pl-10 pr-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
            </div>

            <div class="relative">
                <i class="fas fa-check-circle absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                <input type="password" placeholder="Konfirmasi Password Baru"
                    class="w-full border border-gray-200 rounded-lg pl-10 pr-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
            </div>

        </div>

        <div class="text-right">
            <button class="px-4 py-2 bg-green-600 text-white text-sm rounded-lg hover:bg-green-700 transition flex items-center gap-2 ml-auto">
                Simpan Password
            </button>
        </div>

    </div>


    {{-- ===== LOGOUT ===== --}}
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

        <button class="px-4 py-2 text-sm text-red-600 border border-red-200 rounded-lg hover:bg-red-50 flex items-center gap-2 transition">
            <i class="fas fa-sign-out-alt"></i> Logout
        </button>

    </div>

</div>

{{-- Tambahan CSS untuk Font Awesome --}}
@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@endpush

@endsection