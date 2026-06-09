@extends('partials.app')

@section('title', 'Profil Pengguna')

@section('content')

@php
    $user = auth()->user();

    $stats = [
        [
            'label' => 'Total Pemesanan',
            'value' => $user->bookings()->count(),
            'icon'  => 'calendar-check',
            'color' => 'green'
        ],
        [
            'label' => 'Permainan Diikuti',
            'value' => $user->joinedMatches()->count(),
            'icon'  => 'users',
            'color' => 'blue'
        ],
        [
            'label' => 'Permainan Dibuat',
            'value' => $user->createdMatches()->count(),
            'icon'  => 'trophy',
            'color' => 'yellow'
        ],
    ];
@endphp

<div class="space-y-6">

   {{-- ===== PROFIL ===== --}}
<div class="bg-white rounded-2xl border border-gray-100 p-6">

    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">

        {{-- LEFT --}}
        <div class="flex items-center gap-4">

            {{-- AVATAR --}}
            <div class="w-16 h-16 rounded-full
                        bg-gradient-to-br from-[#0b3d0b] to-[#145214]
                        flex items-center justify-center
                        text-white text-xl font-semibold">

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

                    <p>
                        <i class="fas fa-envelope mr-1"></i>
                        {{ $user->email }}
                    </p>

                    <p>
                        <i class="fas fa-phone mr-1"></i>
                        {{ $user->phone }}
                    </p>

                    <p>
                        <i class="fas fa-venus-mars mr-1"></i>
                        {{ $user->gender === 'female' ? 'Wanita (Female)' : 'Pria (Male)' }}
                    </p>
                </div>

            </div>

        </div>

        {{-- EDIT --}}
        <div class="flex lg:justify-end">

            <a href="{{ route('profile.edit') }}"
               class="inline-flex items-center gap-2
                      px-4 py-2 rounded-xl
                      bg-[#0b3d0b] hover:bg-[#145214]
                      text-white text-sm font-medium transition">

                <i class="fas fa-pen text-xs"></i>

                Edit Profil

            </a>

        </div>

    </div>

</div>

{{-- ================= STATISTIK ================= --}}
<div class="grid grid-cols-1 md:grid-cols-3 gap-6">

    @foreach($stats as $s)

    <div class="bg-white border border-gray-100 rounded-2xl p-5
                flex items-center justify-between">

        <div>

            <p class="text-sm text-gray-500">
                {{ $s['label'] }}
            </p>

            <p class="text-2xl font-bold text-gray-900 mt-1">
                {{ $s['value'] }}
            </p>

        </div>

        <div class="w-12 h-12 rounded-xl
                    bg-{{ $s['color'] }}-50
                    flex items-center justify-center">

            <i class="fas fa-{{ $s['icon'] }}
                      text-{{ $s['color'] }}-600 text-lg"></i>

        </div>

    </div>

    @endforeach

</div>

{{-- ================= GANTI PASSWORD ================= --}}
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
                    Ganti Kata Sandi
                </h3>

                <p class="text-sm text-gray-500">
                    Gunakan kata sandi yang aman dan mudah diingat
                </p>

            </div>

        </div>

    </div>

    {{-- FORM --}}
    <div class="p-6">

        <form action="{{ route('profile.password') }}" method="POST">

            @csrf
            @method('PUT')

            <div class="grid md:grid-cols-3 gap-4">

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
            <div class="flex justify-end mt-6">

                <button
                    type="submit"
                    class="inline-flex items-center gap-2
                           px-4 py-2 rounded-xl
                           bg-[#0b3d0b] hover:bg-[#145214]
                           text-white text-sm font-medium transition">

                    Simpan Kata Sandi

                </button>

            </div>

        </form>

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
                    flex items-center justify-center">

            <i class="fas fa-sign-out-alt text-red-500"></i>

        </div>

        {{-- TEXT --}}
        <div>

            <p class="font-medium text-gray-800">
                Keluar
            </p>

            <p class="text-sm text-gray-500">
                Keluar dari akun ActiveHub
            </p>

        </div>

    </div>

</a>

</div>

@push('styles')
<link rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@endpush

@endsection