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

        {{-- EDIT --}}
        <button
            class="inline-flex items-center gap-2
                   px-4 py-2 rounded-xl
                   bg-[#0b3d0b] hover:bg-[#145214]
                   text-white text-sm font-medium transition">

            <i class="fas fa-pen text-xs"></i>
            Edit Profile

        </button>

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

    {{-- ===== VENUE LIST ===== --}}
<div class="bg-white rounded-2xl border border-gray-100 p-5">

    {{-- HEADER --}}
    <div class="flex items-center justify-between mb-5">

        <div>
            <h3 class="font-semibold text-gray-900 flex items-center gap-2">
                <i class="fas fa-map-marker-alt text-green-600 text-sm"></i>
                Venue & Lapangan
            </h3>

            <p class="text-sm text-gray-500 mt-1">
                Daftar venue yang Anda miliki
            </p>
        </div>

        {{-- TAMBAH VENUE --}}
        <button
            class="inline-flex items-center gap-2
                   px-4 py-2 rounded-xl
                   bg-[#0b3d0b] hover:bg-[#145214]
                   text-white text-sm font-medium transition">

            <i class="fas fa-plus text-xs"></i>
            Tambah Venue

        </button>

    </div>

    @php
    $venues = [
        [
            'name'=>'Active Arena',
            'fields'=>['Lapangan A','Lapangan B','Lapangan Basket'],
        ],
        [
            'name'=>'Sport Center',
            'fields'=>['Badminton 1','Tennis Court'],
        ],
        [
            'name'=>'Victory Futsal',
            'fields'=>['Lapangan Utama'],
        ],
    ];
    @endphp

    {{-- LIST --}}
    <div class="space-y-3">

        @foreach($venues as $v)

        <div class="border border-gray-100 rounded-xl p-4 hover:bg-gray-50 transition">

            {{-- TOP --}}
            <div class="flex items-center justify-between">

                <div>

                    {{-- VENUE --}}
                    <p class="font-medium text-gray-900 flex items-center gap-2">
                        {{ $v['name'] }}
                    </p>

                    <p class="text-xs text-gray-500 mt-1">
                        {{ count($v['fields']) }} Lapangan
                    </p>

                </div>

                {{-- ACTION --}}
                <button
                    class="w-8 h-8 rounded-lg
                           hover:bg-gray-100
                           text-gray-400 hover:text-gray-700
                           transition">

                    <i class="fas fa-chevron-right text-xs"></i>

                </button>

            </div>

            {{-- FIELD --}}
            <div class="flex flex-wrap gap-2 mt-4">

                @foreach($v['fields'] as $field)

                <div
                    class="inline-flex items-center gap-2
                           px-3 py-1.5 rounded-lg
                           bg-gray-100 text-gray-700 text-xs">

                    <i class="fas fa-futbol text-green-700 text-[10px]"></i>

                    {{ $field }}

                </div>

                @endforeach

            </div>

        </div>

        @endforeach

    </div>

</div>

    {{-- ================= CHANGE PASSWORD ================= --}}
    <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">

        {{-- HEADER --}}
        <div class="px-6 py-5 border-b border-gray-100">

            <div class="flex items-center gap-3">

                <div class="w-11 h-11 rounded-xl
                            bg-yellow-50
                            flex items-center justify-center">

                    <i class="fas fa-lock text-yellow-500"></i>

                </div>

                <div>

                    <h3 class="font-semibold text-gray-900">
                        Ganti Password
                    </h3>

                    <p class="text-sm text-gray-500">
                        Pastikan password baru lebih aman dan mudah diingat
                    </p>

                </div>

            </div>

        </div>

        {{-- FORM --}}
        <div class="p-6">

            <div class="grid md:grid-cols-3 gap-4">

                {{-- OLD --}}
                <div>

                    <label class="text-sm font-medium text-gray-700 mb-2 block">
                        Password Lama
                    </label>

                    <div class="relative">

                        <input
                            type="password"
                            placeholder="••••••••"
                            class="w-full border border-gray-200
                                   rounded-xl px-4 py-3 text-sm
                                   focus:outline-none
                                   focus:ring-2 focus:ring-[#0b3d0b]/20
                                   focus:border-[#0b3d0b]">

                    </div>

                </div>

                {{-- NEW --}}
                <div>

                    <label class="text-sm font-medium text-gray-700 mb-2 block">
                        Password Baru
                    </label>

                    <input
                        type="password"
                        placeholder="••••••••"
                        class="w-full border border-gray-200
                               rounded-xl px-4 py-3 text-sm
                               focus:outline-none
                               focus:ring-2 focus:ring-[#0b3d0b]/20
                               focus:border-[#0b3d0b]">

                </div>

                {{-- CONFIRM --}}
                <div>

                    <label class="text-sm font-medium text-gray-700 mb-2 block">
                        Konfirmasi Password
                    </label>

                    <input
                        type="password"
                        placeholder="••••••••"
                        class="w-full border border-gray-200
                               rounded-xl px-4 py-3 text-sm
                               focus:outline-none
                               focus:ring-2 focus:ring-[#0b3d0b]/20
                               focus:border-[#0b3d0b]">

                </div>

            </div>

            {{-- BUTTON --}}
            <div class="flex justify-end mt-6">

                <button
            class="inline-flex items-center gap-2
                   px-4 py-2 rounded-xl
                   bg-[#0b3d0b] hover:bg-[#145214]
                   text-white text-sm font-medium transition">
            Simpan Password

        </button>
                

            </div>

        </div>

    </div>


     {{-- ===== LOGOUT ===== --}}
<a href="{{ route('logout') }}"
   class="bg-white rounded-2xl border border-gray-100 p-5
          flex items-center justify-between">

    <div class="flex items-center gap-3">

        {{-- ICON --}}
        <div class="w-11 h-11 rounded-xl
                    bg-red-50
                    flex items-center justify-center hover:bg-red-100 transition group">

            <i class="fas fa-sign-out-alt text-red-500"></i>

        </div>

        {{-- TEXT --}}
        <div>

            <p class="font-medium text-gray-800 group-hover:text-red-600 transition">
                Logout
            </p>

            <p class="text-sm text-gray-500">
                Keluar dari akun ActiveHub Anda
            </p>

        </div>

    </div>

</a>

{{-- Tambahan CSS untuk Font Awesome --}}
@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@endpush

@endsection