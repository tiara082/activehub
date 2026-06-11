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
<div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-[0_8px_30px_rgba(0,0,0,0.02)] relative overflow-hidden">
    <div class="absolute top-0 left-0 right-0 h-1.5 bg-gradient-to-r from-[#0b3d0b] to-[#fbbf24]"></div>

    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">

        {{-- LEFT --}}
        <div class="flex items-center gap-4">

            {{-- AVATAR --}}
            <div class="relative group">
                <div class="absolute inset-0 rounded-full bg-gradient-to-tr from-[#0b3d0b] to-[#fbbf24] blur-[2px] -m-0.5 animate-pulse"></div>
                <div class="w-16 h-16 rounded-full relative z-10 bg-white p-0.5">
                    <div class="w-full h-full rounded-full bg-gradient-to-br from-[#0b3d0b] to-[#145214] flex items-center justify-center text-white text-xl font-bold font-mono">
                        {{ strtoupper(substr($user->name,0,2)) }}
                    </div>
                </div>
            </div>

            {{-- INFO --}}
            <div>

                <h2 class="text-lg font-bold text-gray-900 flex items-center gap-2">

                    {{ $user->name }}

                    <span class="text-[10px] font-bold bg-green-50 text-green-700 px-2.5 py-0.5 rounded-full border border-green-200 uppercase tracking-wider">
                        {{ ucfirst($user->role) }}
                    </span>

                </h2>

                <div class="text-xs text-gray-500 mt-2 space-y-1.5 font-medium">

                    <p class="flex items-center gap-1.5">
                        <i class="fas fa-envelope text-gray-400 w-4"></i>
                        {{ $user->email }}
                    </p>

                    <p class="flex items-center gap-1.5">
                        <i class="fas fa-phone text-gray-400 w-4"></i>
                        {{ $user->phone }}
                    </p>

                    <p class="flex items-center gap-1.5">
                        <i class="fas fa-venus-mars text-gray-400 w-4"></i>
                        {{ $user->gender === 'female' ? 'Wanita (Female)' : 'Pria (Male)' }}
                    </p>
                </div>

            </div>

        </div>

        {{-- EDIT --}}
        <div class="flex lg:justify-end">

            <a href="{{ route('profile.edit') }}"
               class="inline-flex items-center gap-2
                      px-5 py-2.5 rounded-xl
                      bg-[#0b3d0b] hover:bg-[#145214] hover:shadow-lg hover:shadow-green-900/10
                      text-white text-xs font-bold transition-all duration-300">

                <i class="fas fa-pen text-xs"></i>

                Edit Profil

            </a>

        </div>

    </div>

</div>

{{-- ================= STATISTIK ================= --}}
<div class="grid grid-cols-1 md:grid-cols-3 gap-6">

    @foreach($stats as $s)
    @php
        $bgColorMap = [
            'green' => 'bg-green-50 text-green-700',
            'blue' => 'bg-blue-50 text-blue-700',
            'yellow' => 'bg-amber-50 text-amber-600',
        ];
        $bgStyle = $bgColorMap[$s['color']] ?? 'bg-gray-50 text-gray-700';
    @endphp

    <div class="bg-white border border-gray-100 rounded-2xl p-5
                flex items-center justify-between shadow-[0_8px_30px_rgba(0,0,0,0.02)] hover:shadow-[0_12px_30px_rgba(11,61,11,0.05)] hover:-translate-y-0.5 transition-all duration-300 group">

        <div>

            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider group-hover:text-green-700 transition-colors">
                {{ $s['label'] }}
            </p>

            <p class="text-2xl font-black text-gray-800 mt-1 font-mono">
                {{ $s['value'] }}
            </p>

        </div>

        <div class="w-12 h-12 rounded-xl {{ $bgStyle }} flex items-center justify-center group-hover:scale-110 transition-transform">

            <i class="fas fa-{{ $s['icon'] }} text-lg"></i>

        </div>

    </div>

    @endforeach

</div>

{{-- ================= GANTI PASSWORD ================= --}}
<div class="bg-white rounded-2xl border border-gray-100 overflow-hidden shadow-[0_8px_30px_rgba(0,0,0,0.02)]">

    {{-- HEADER --}}
    <div class="px-6 py-5 border-b border-gray-100 bg-gray-50/50">

        <div class="flex items-center gap-3">

            <div class="w-11 h-11 rounded-xl
                        bg-yellow-50
                        flex items-center justify-center">

                <i class="fas fa-lock text-yellow-500"></i>

            </div>

            <div>

                <h3 class="font-bold text-gray-900 text-sm flex items-center gap-2">
                    <span class="w-1.5 h-4 bg-[#0b3d0b] rounded-full"></span>
                    Ganti Kata Sandi
                </h3>

                <p class="text-xs text-gray-500 mt-1 font-medium">
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

                    <label class="text-xs font-bold text-gray-600 mb-2 block">
                        Kata Sandi Lama
                    </label>

                    <input
                        type="password"
                        name="old_password"
                        placeholder="••••••••"
                        class="w-full border border-gray-200
                               rounded-xl px-4 py-3 text-sm
                               focus:outline-none
                               focus:ring-4 focus:ring-[#0b3d0b]/10
                               focus:border-[#0b3d0b] transition-all">

                </div>

                {{-- PASSWORD BARU --}}
                <div>

                    <label class="text-xs font-bold text-gray-600 mb-2 block">
                        Kata Sandi Baru
                    </label>

                    <input
                        type="password"
                        name="new_password"
                        placeholder="••••••••"
                        class="w-full border border-gray-200
                               rounded-xl px-4 py-3 text-sm
                               focus:outline-none
                               focus:ring-4 focus:ring-[#0b3d0b]/10
                               focus:border-[#0b3d0b] transition-all">

                </div>

                {{-- KONFIRMASI --}}
                <div>

                    <label class="text-xs font-bold text-gray-600 mb-2 block">
                        Konfirmasi Kata Sandi
                    </label>

                    <input
                        type="password"
                        name="new_password_confirmation"
                        placeholder="••••••••"
                        class="w-full border border-gray-200
                               rounded-xl px-4 py-3 text-sm
                               focus:outline-none
                               focus:ring-4 focus:ring-[#0b3d0b]/10
                               focus:border-[#0b3d0b] transition-all">

                </div>

            </div>

            {{-- BUTTON --}}
            <div class="flex justify-end mt-6">

                <button
                    type="submit"
                    class="inline-flex items-center gap-2
                           px-5 py-2.5 rounded-xl
                           bg-[#0b3d0b] hover:bg-[#145214] hover:shadow-lg hover:shadow-green-900/10
                           text-white text-xs font-bold transition-all duration-300">

                    Simpan Kata Sandi

                </button>

            </div>

        </form>

    </div>

</div>

{{-- ===== LOGOUT ===== --}}
<a href="{{ route('logout') }}"
   onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
   class="bg-white rounded-2xl border border-gray-100 p-5
          flex items-center justify-between shadow-[0_8px_30px_rgba(0,0,0,0.02)] hover:border-red-100 hover:bg-red-50/10 transition-all duration-300 group">

    <div class="flex items-center gap-3">

        {{-- ICON --}}
        <div class="w-11 h-11 rounded-xl
                    bg-red-50 group-hover:bg-red-500 group-hover:text-white transition-colors
                    flex items-center justify-center text-red-500">

            <i class="fas fa-sign-out-alt"></i>

        </div>

        {{-- TEXT --}}
        <div>

            <p class="font-bold text-gray-800 text-sm group-hover:text-red-700 transition-colors">
                Keluar
            </p>

            <p class="text-xs text-gray-400 font-medium">
                Keluar dari akun ActiveHub
            </p>

        </div>

    </div>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
        @csrf
    </form>
</a>

</div>

@push('styles')
<link rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@endpush

@endsection