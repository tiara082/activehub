@extends('partials.app')

@section('title', 'Edit Profile')

@section('content')

@php
    $user = auth()->user();
@endphp

<div class="space-y-6">

    {{-- FORM --}}
    <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">

        {{-- TOP --}}
        <div class="px-6 py-5 border-b border-gray-100">

            <div class="flex items-center gap-3">

                <div class="w-12 h-12 rounded-xl
                            bg-green-50
                            flex items-center justify-center">

                    <i class="fas fa-user-edit text-[#0b3d0b] text-lg"></i>

                </div>

                <div>

                    <h3 class="font-semibold text-gray-900 text-lg">
                        Informasi Profil
                    </h3>

                    <p class="text-sm text-gray-500">
                        Perbarui data akun ActiveHub Anda
                    </p>

                </div>

            </div>

        </div>

        {{-- BODY --}}
        <div class="p-6">

            <form action="{{ route('profile.update') }}"
                  method="POST"
                  class="space-y-6">

                @csrf
                @method('PUT')

                <div class="grid md:grid-cols-2 gap-6">

                    {{-- NAME --}}
                    <div>

                        <label class="text-sm font-medium text-gray-700 mb-2 block">
                            Nama Lengkap
                        </label>

                        <div class="relative">

                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
                                <i class="fas fa-user"></i>
                            </span>

                            <input
                                type="text"
                                name="name"
                                value="{{ old('name', $user->name) }}"
                                class="w-full border border-gray-200
                                       rounded-xl pl-11 pr-4 py-3
                                       focus:outline-none
                                       focus:ring-2
                                       focus:ring-[#0b3d0b]/20
                                       focus:border-[#0b3d0b]">

                        </div>

                    </div>

                    {{-- EMAIL --}}
                    <div>

                        <label class="text-sm font-medium text-gray-700 mb-2 block">
                            Email
                        </label>

                        <div class="relative">

                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
                                <i class="fas fa-envelope"></i>
                            </span>

                            <input
                                type="email"
                                name="email"
                                value="{{ old('email', $user->email) }}"
                                class="w-full border border-gray-200
                                       rounded-xl pl-11 pr-4 py-3
                                       focus:outline-none
                                       focus:ring-2
                                       focus:ring-[#0b3d0b]/20
                                       focus:border-[#0b3d0b]">

                        </div>

                    </div>

                {{-- PHONE --}}
                <div>

                    <label class="text-sm font-medium text-gray-700 mb-2 block">
                        Nomor HP
                    </label>

                    <div class="relative">

                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
                            <i class="fas fa-phone"></i>
                        </span>

                        <input
                            type="text"
                            name="phone"
                            value="{{ old('phone', $user->phone) }}"
                            class="w-full border border-gray-200
                                   rounded-xl pl-11 pr-4 py-3
                                   focus:outline-none
                                   focus:ring-2
                                   focus:ring-[#0b3d0b]/20
                                   focus:border-[#0b3d0b]">

                    </div>

                </div>

                {{-- GENDER --}}
                <div>

                    <label class="text-sm font-medium text-gray-700 mb-2 block">
                        Gender / Jenis Kelamin
                    </label>

                    <div class="relative">

                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
                            <i class="fas fa-venus-mars"></i>
                        </span>

                        <select
                            name="gender"
                            class="w-full border border-gray-200
                                   rounded-xl pl-11 pr-4 py-3
                                   focus:outline-none
                                   focus:ring-2
                                   focus:ring-[#0b3d0b]/20
                                   focus:border-[#0b3d0b]">
                            <option value="male" {{ old('gender', $user->gender) === 'male' ? 'selected' : '' }}>Pria (Male)</option>
                            <option value="female" {{ old('gender', $user->gender) === 'female' ? 'selected' : '' }}>Wanita (Female)</option>
                        </select>

                    </div>

                </div>
                </div>

                {{-- BUTTON --}}
                <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">

                    <a href="{{ route('user.profile') }}"
                       class="px-5 py-2.5 rounded-xl
                              border border-gray-200
                              hover:bg-gray-50
                              text-gray-700 text-sm font-medium transition">

                        Batal

                    </a>

                    <button
                        type="submit"
                        class="inline-flex items-center gap-2
                               px-5 py-2.5 rounded-xl
                               bg-[#0b3d0b]
                               hover:bg-[#145214]
                               text-white text-sm font-medium transition">

                        Simpan Perubahan

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@push('styles')
<link rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@endpush

@endsection