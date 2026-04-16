@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-6 py-6">

    <!-- IMAGE -->
    <img src="{{ asset($data['image']) }}"
         class="w-full h-64 object-cover rounded">

    <!-- TITLE -->
    <div class="mt-4">
        <h1 class="text-2xl font-bold">FUTSAL</h1>
        <p class="text-gray-600 font-semibold">
            {{ $data['location_name'] }}
        </p>
    </div>

    <hr class="my-4">

    <!-- DESKRIPSI -->
    <div>
        <h2 class="font-semibold mb-2">Deskripsi</h2>
        <p class="text-gray-600 text-sm leading-relaxed">
            {{ $data['description'] }}
        </p>
    </div>

    <hr class="my-4">

    <!-- DETAIL -->
    <div class="space-y-3 text-sm">

        <div class="flex justify-between">
            <span class="text-gray-600">Hari & Tanggal</span>
            <span>{{ $data['date'] }}</span>
        </div>

        <div class="flex justify-between">
            <span class="text-gray-600">Jam</span>
            <span>{{ $data['time'] }}</span>
        </div>

        <div class="flex justify-between">
            <span class="text-gray-600">Alamat</span>
            <span class="text-right max-w-xs">
                {{ $data['address'] }}
            </span>
        </div>

        <div class="flex justify-between">
            <span class="text-gray-600">Jumlah Slot</span>
            <span>{{ $data['slot_filled'] }}/{{ $data['slot_total'] }} pemain</span>
        </div>

        <div class="flex justify-between">
            <span class="text-gray-600">Gender</span>
            <span>{{ $data['gender'] }}</span>
        </div>

        <div class="flex justify-between">
            <span class="text-gray-600">Harga per Orang</span>
            <span>Rp {{ number_format($data['price'], 0, ',', '.') }}/orang</span>
        </div>

    </div>

    <hr class="my-4">

    <!-- PEMBAYARAN -->
    <div class="text-sm">
        <p class="font-semibold">Metode Pembayaran</p>
        <p>{{ $data['bank_name'] }}</p>
        <p id="rekening">{{ $data['account_number'] }}</p>
        <p class="text-gray-600">a/n {{ $data['account_name'] }}</p>
    </div>

    <!-- BUTTON -->
    <form action="{{ route('match.join', $data['id']) }}" method="POST" class="mt-6">
        @csrf
        <button class="w-full bg-black text-white py-3 rounded">
            Join Match
        </button>
    </form>

</div>
@endsection