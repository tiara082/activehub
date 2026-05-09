@extends('layouts.app')

@section('title', 'Keranjang Booking')

@section('content')

<div class="max-w-5xl mx-auto px-6 py-10">

    <h1 class="text-3xl font-bold text-gray-800 mb-8">
        Keranjang Booking
    </h1>

    @forelse($cart as $item)

        <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 mb-4">

            <div class="flex items-start justify-between">

                <div>

                    <h2 class="text-lg font-bold text-gray-800">
                        {{ $item['field_name'] }}
                    </h2>

                    <p class="text-sm text-gray-500">
                        {{ $item['venue_name'] }}
                    </p>

                    <div class="flex gap-2 mt-3 flex-wrap">

                        <span class="px-3 py-1 rounded-full bg-gray-100 text-xs">
                            {{ $item['date'] }}
                        </span>

                        <span class="px-3 py-1 rounded-full bg-gray-100 text-xs">
                            {{ $item['time'] }}
                        </span>

                        <span class="px-3 py-1 rounded-full bg-green-50 text-green-700 text-xs">
                            {{ $item['type'] }}
                        </span>

                    </div>

                </div>

                <div class="text-right">

                    <p class="text-lg font-bold text-[#0b3d0b]">
                        Rp {{ number_format($item['price'],0,',','.') }}
                    </p>

                    <form action="{{ route('cart.remove', $item['id']) }}"
                          method="POST"
                          class="mt-3">

                        @csrf
                        @method('DELETE')

                        <button class="text-sm text-red-500 hover:underline">
                            Hapus
                        </button>

                    </form>

                </div>

            </div>

        </div>

    @empty

        <div class="bg-white rounded-2xl p-10 text-center border border-dashed">

            <p class="text-gray-500">
                Keranjang masih kosong
            </p>

        </div>

    @endforelse

</div>

@endsection