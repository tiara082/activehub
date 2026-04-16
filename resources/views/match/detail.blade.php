@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">

    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">

        <!-- IMAGE -->
        <img src="{{ asset('images/futsal.jpg') }}"
             class="w-full h-60 object-cover">

        <div class="p-6 space-y-6">

            <!-- TITLE -->
            <div>
                <h1 class="text-2xl font-bold text-gray-800">
                    {{ $match->title }}
                </h1>
                <p class="text-gray-500">
                    Status: {{ $match->status }}
                </p>
            </div>

            <!-- DESCRIPTION -->
            <div>
                <h2 class="font-semibold text-gray-700">Deskripsi</h2>
                <p class="text-sm text-gray-600">
                    {{ $match->description }}
                </p>
            </div>

            <hr>

            <!-- DETAIL -->
            <div class="grid grid-cols-2 gap-4 text-sm">

                <div>
                    <p class="text-gray-500">Total Pemain</p>
                    <p class="font-medium">
                        {{ $match->total_players }}
                    </p>
                </div>

                <div>
                    <p class="text-gray-500">Harga</p>
                    <p class="font-semibold text-green-600">
                        Rp {{ number_format($match->price_per_person, 0, ',', '.') }}
                    </p>
                </div>

                <div>
                    <p class="text-gray-500">Gender</p>
                    <p class="font-medium">
                        {{ ucfirst($match->gender_preference) }}
                    </p>
                </div>

                <div>
                    <p class="text-gray-500">Status</p>
                    <p class="font-medium">
                        {{ $match->status }}
                    </p>
                </div>

            </div>

            <hr>

            <!-- BUTTON -->
            <form action="{{ route('match.join', $match->id) }}" method="POST">
                @csrf

                <button 
                    class="w-full py-3 rounded-xl font-semibold text-white
                    {{ $match->status == 'full' ? 'bg-gray-400 cursor-not-allowed' : 'bg-green-500 hover:bg-green-600' }}"
                    {{ $match->status == 'full' ? 'disabled' : '' }}>
                    
                    {{ $match->status == 'full' ? 'Slot Penuh' : 'Join Match' }}

                </button>
            </form>

        </div>
    </div>

</div>
@endsection