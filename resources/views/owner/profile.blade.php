{{-- resources/views/owner/pages/profile.blade.php --}}
@extends('partials.app')

@section('title', 'Profil Pemilik')

@section('content')

@php
    $user = auth()->user();
@endphp

<div class="space-y-8">

    {{-- ================= PROFILE HEADER ================= --}}
    <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm">

        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">

            {{-- LEFT --}}
            <div class="flex items-center gap-4">

                {{-- AVATAR --}}
                <div class="w-16 h-16 rounded-full
                            bg-gradient-to-br from-[#0b3d0b] to-[#145214]
                            flex items-center justify-center
                            text-white text-xl font-semibold shadow-sm">

                    {{ strtoupper(substr($user->name,0,2)) }}

                </div>

                {{-- INFO --}}
                <div>

                    <h2 class="text-xl font-semibold text-gray-900 flex items-center gap-2">

                        {{ $user->name }}

                        <span class="text-xs bg-blue-100 text-blue-700 px-2 py-1 rounded-full">
                            {{ ucfirst($user->role) }}
                        </span>

                    </h2>

                    <div class="text-sm text-gray-500 mt-2 space-y-1.5">

                        <p class="flex items-center gap-2">
                            <i class="fas fa-envelope text-gray-400"></i>
                            {{ $user->email }}
                        </p>

                        <p class="flex items-center gap-2">
                            <i class="fas fa-phone text-gray-400"></i>
                            {{ $user->phone }}
                        </p>

                    </div>

                </div>

            </div>

            {{-- BUTTON EDIT --}}
            <div class="flex lg:justify-end">

                <a href="{{ route('profile.edit') }}"
                   class="inline-flex items-center gap-2
                          px-5 py-2.5 rounded-xl
                          bg-[#0b3d0b] hover:bg-[#145214]
                          text-white text-sm font-medium transition">

                    <i class="fas fa-pen text-xs"></i>

                    Edit Profil

                </a>

            </div>

        </div>

    </div>


    {{-- ================= STATISTIK ================= --}}
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-5">

        @php
        $venuesData = $user->venues()->with('fields')->get();
        $venueCount = $venuesData->count();
        $fieldCount = $venuesData->sum(fn($v) => $v->fields->count());
        $fieldIds = $venuesData->flatMap->fields->pluck('id');
        
        $totalBookings = \App\Models\Booking::whereIn('field_id', $fieldIds)->count();
        $totalEarnings = \App\Models\Booking::whereIn('field_id', $fieldIds)
            ->whereIn('status', ['paid', 'completed', 'confirmed'])
            ->sum('total_price');

        $stats = [
            [
                'label' => 'Jumlah Venue',
                'value' => $venueCount,
                'icon'  => 'building',
                'color' => 'blue'
            ],
            [
                'label' => 'Jumlah Lapangan',
                'value' => $fieldCount,
                'icon'  => 'futbol',
                'color' => 'green'
            ],
            [
                'label' => 'Total Pemesanan',
                'value' => $totalBookings,
                'icon'  => 'calendar-check',
                'color' => 'orange'
            ],
            [
                'label' => 'Total Pendapatan',
                'value' => 'Rp ' . number_format($totalEarnings, 0, ',', '.'),
                'icon'  => 'money-bill-wave',
                'color' => 'yellow'
            ],
        ];
        @endphp

        @foreach($stats as $s)

        <div class="bg-white border border-gray-100 rounded-2xl p-5
                    flex items-center justify-between
                    shadow-sm hover:shadow-md transition">

            <div>

                <p class="text-sm text-gray-500">
                    {{ $s['label'] }}
                </p>

                <p class="text-2xl font-bold text-gray-900 mt-2">
                    {{ $s['value'] }}
                </p>

            </div>

            {{-- ICON --}}
            <div class="w-12 h-12 rounded-xl
                        bg-{{ $s['color'] }}-50
                        flex items-center justify-center">

                <i class="fas fa-{{ $s['icon'] }}
                          text-{{ $s['color'] }}-600 text-lg"></i>

            </div>

        </div>

        @endforeach

    </div>


    {{-- ================= DAFTAR VENUE ================= --}}
    <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm">

        {{-- HEADER --}}
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">

            <div>

                <h3 class="font-semibold text-gray-900 flex items-center gap-2 text-lg">

                    <i class="fas fa-map-marker-alt text-green-600 text-sm"></i>

                    Venue & Lapangan

                </h3>

                <p class="text-sm text-gray-500 mt-1">
                    Daftar venue dan lapangan yang Anda kelola
                </p>

            </div>

            {{-- BUTTON --}}
            <button
                class="inline-flex items-center gap-2
                       px-4 py-2.5 rounded-xl
                       bg-[#0b3d0b] hover:bg-[#145214]
                       text-white text-sm font-medium transition">

                <i class="fas fa-plus text-xs"></i>

                Tambah Venue

            </button>

        </div>

        {{-- LIST --}}
        <div class="space-y-4">

            @forelse($venuesData as $v)

            <div class="border border-gray-100 rounded-2xl p-5 hover:bg-gray-50 transition">

                {{-- TOP --}}
                <div class="flex items-start justify-between gap-4">

                    <div>

                        <p class="font-semibold text-gray-900 text-base">
                            {{ $v->name }}
                        </p>

                        <p class="text-sm text-gray-500 mt-1">
                            {{ $v->fields->count() }} Lapangan
                        </p>

                    </div>

                    {{-- ACTION --}}
                    <a href="{{ route('owner.venue') }}"
                        class="w-9 h-9 rounded-xl flex items-center justify-center
                               hover:bg-gray-100
                               text-gray-400 hover:text-gray-700
                               transition">

                        <i class="fas fa-chevron-right text-xs"></i>

                    </a>

                </div>

                {{-- FIELD --}}
                <div class="flex flex-wrap gap-2 mt-5">

                    @forelse($v->fields as $field)

                    <div
                        class="inline-flex items-center gap-2
                               px-3 py-2 rounded-xl
                               bg-gray-100 text-gray-700 text-xs">

                        <i class="fas fa-futbol text-green-700 text-[10px]"></i>

                        {{ $field->name }}

                    </div>

                    @empty
                    <p class="text-xs text-gray-400">Belum ada lapangan di venue ini.</p>
                    @endforelse

                </div>

            </div>

            @empty
            <div class="text-center py-8 text-gray-400 text-sm">
                Anda belum mendaftarkan venue apapun.
            </div>
            @endforelse

        </div>

    </div>


    {{-- ================= GANTI PASSWORD ================= --}}
    <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden shadow-sm">

        {{-- HEADER --}}
        <div class="px-6 py-5 border-b border-gray-100">

            <div class="flex items-center gap-4">

                <div class="w-12 h-12 rounded-xl
                            bg-yellow-50
                            flex items-center justify-center">

                    <i class="fas fa-lock text-yellow-500"></i>

                </div>

                <div>

                    <h3 class="font-semibold text-gray-900 text-lg">
                        Ubah Kata Sandi
                    </h3>

                    <p class="text-sm text-gray-500 mt-1">
                        Gunakan kata sandi yang aman dan mudah Anda ingat
                    </p>

                </div>

            </div>

        </div>

        {{-- FORM --}}
        <div class="p-6">

            <form action="{{ route('profile.password') }}" method="POST">

                @csrf
                @method('PUT')

                <div class="grid md:grid-cols-3 gap-5">

                    {{-- PASSWORD LAMA --}}
                    <div>

                        <label class="text-sm font-medium text-gray-700 mb-2 block">
                            Kata Sandi Lama
                        </label>

                        <input
                            type="password"
                            name="old_password"
                            placeholder="••••••••"
                            class="w-full border border-gray-200
                                   rounded-xl px-4 py-3 text-sm
                                   focus:outline-none
                                   focus:ring-2 focus:ring-[#0b3d0b]/20
                                   focus:border-[#0b3d0b]">

                    </div>

                    {{-- PASSWORD BARU --}}
                    <div>

                        <label class="text-sm font-medium text-gray-700 mb-2 block">
                            Kata Sandi Baru
                        </label>

                        <input
                            type="password"
                            name="new_password"
                            placeholder="••••••••"
                            class="w-full border border-gray-200
                                   rounded-xl px-4 py-3 text-sm
                                   focus:outline-none
                                   focus:ring-2 focus:ring-[#0b3d0b]/20
                                   focus:border-[#0b3d0b]">

                    </div>

                    {{-- KONFIRMASI --}}
                    <div>

                        <label class="text-sm font-medium text-gray-700 mb-2 block">
                            Konfirmasi Kata Sandi
                        </label>

                        <input
                            type="password"
                            name="new_password_confirmation"
                            placeholder="••••••••"
                            class="w-full border border-gray-200
                                   rounded-xl px-4 py-3 text-sm
                                   focus:outline-none
                                   focus:ring-2 focus:ring-[#0b3d0b]/20
                                   focus:border-[#0b3d0b]">

                    </div>

                </div>

                {{-- BUTTON --}}
                <div class="flex justify-end mt-7">

                    <button
                        type="submit"
                        class="inline-flex items-center gap-2
                               px-5 py-2.5 rounded-xl
                               bg-[#0b3d0b] hover:bg-[#145214]
                               text-white text-sm font-medium transition">

                        Simpan Perubahan

                    </button>

                </div>

            </form>

        </div>

    </div>


    {{-- ================= LOGOUT ================= --}}
    <a href="{{ route('logout') }}"
       class="bg-white rounded-2xl border border-gray-100 p-5
              flex items-center justify-between
              hover:border-red-100 hover:bg-red-50/30 transition">

        <div class="flex items-center gap-4">

            {{-- ICON --}}
            <div class="w-12 h-12 rounded-xl
                        bg-red-50
                        flex items-center justify-center">

                <i class="fas fa-sign-out-alt text-red-500"></i>

            </div>

            {{-- TEXT --}}
            <div>

                <p class="font-medium text-gray-800">
                    Keluar dari Akun
                </p>

                <p class="text-sm text-gray-500 mt-1">
                    Anda akan keluar dari akun ActiveHub
                </p>

            </div>

        </div>

        <i class="fas fa-chevron-right text-gray-300"></i>

    </a>

</div>


{{-- FONT AWESOME --}}
@push('styles')
<link rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@endpush

@endsection