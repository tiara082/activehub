@extends('partials.app')

@section('title', 'Discover')

@section('content')

<div class="p-6">

    {{-- HEADER --}}
    <div class="mb-5">
        <h2 class="text-2xl font-semibold text-gray-900">Discover</h2>
        <p class="text-sm text-gray-500 mt-1">
            Temukan lapangan & match di sekitarmu
        </p>
    </div>


    {{-- FILTER + TABS --}}
    <div class="bg-white border border-gray-100 rounded-2xl p-4 mb-5 flex flex-col lg:flex-row gap-3 lg:items-center lg:justify-between">

        {{-- LEFT: TABS --}}
        <div class="flex gap-6 text-sm border-b lg:border-none pb-2 lg:pb-0">

            <button class="text-[#0b3d0b] border-b-2 border-[#0b3d0b] pb-2 font-medium">
                Lapangan
            </button>

            <button class="text-gray-400">
                Public Match
            </button>

        </div>

        {{-- RIGHT: FILTER --}}
        <div class="flex gap-3">

            <select class="text-sm border border-gray-200 rounded-lg px-3 py-2">
                <option>Semua Olahraga</option>
                <option>Basket</option>
                <option>Badminton</option>
            </select>

            <select class="text-sm border border-gray-200 rounded-lg px-3 py-2">
                <option>Semua Lokasi</option>
                <option>Malang</option>
                <option>Blitar</option>
            </select>

        </div>

    </div>


    {{-- ================= NEARBY ================= --}}
    <div class="bg-white border border-gray-100 rounded-2xl p-5 mb-5">

        <div class="flex justify-between mb-4">
            <p class="text-sm font-semibold text-gray-800">
                Nearby
            </p>
            <span class="text-xs text-gray-400">Based on location</span>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">

            @for($i = 0; $i < 4; $i++)
            <div class="border border-gray-100 rounded-xl p-4 hover:shadow-sm transition">

                <div class="w-full h-24 bg-gray-100 rounded-lg mb-3"></div>

                <p class="text-sm font-medium text-gray-800">
                    Active Arena
                </p>

                <p class="text-xs text-gray-500">
                    1.2 km • Futsal
                </p>

            </div>
            @endfor

        </div>

    </div>


    {{-- ================= LIST ================= --}}
    @php
    $venues = [
        ['name'=>'Darmo Sports','location'=>'Sawojajar','sport'=>'Futsal'],
        ['name'=>'Galaxy Court','location'=>'Merjosari','sport'=>'Badminton'],
    ];

    $matches = [
        ['title'=>'Night Futsal','players'=>'8 / 14','time'=>'20:00'],
        ['title'=>'Morning Badminton','players'=>'5 / 8','time'=>'08:00'],
    ];
    @endphp


    {{-- LIST LAPANGAN --}}
    <div class="space-y-4">

        @foreach($venues as $v)

        <div class="bg-white border border-gray-100 rounded-2xl p-5 flex justify-between items-center hover:shadow-sm transition">

            <div class="flex gap-4">
                <div class="w-28 h-20 bg-gray-100 rounded-xl"></div>

                <div>
                    <p class="font-medium text-gray-900">
                        {{ $v['name'] }}
                    </p>

                    <p class="text-sm text-gray-500">
                        {{ $v['sport'] }} • {{ $v['location'] }}
                    </p>
                </div>
            </div>

            <button class="text-sm border px-4 py-1.5 rounded-lg hover:bg-gray-100">
                Lihat
            </button>

        </div>

        @endforeach

    </div>


    {{-- LIST MATCH --}}
    <div class="space-y-4 mt-6">

        @foreach($matches as $m)

        <div class="bg-white border border-gray-100 rounded-2xl p-5 flex justify-between items-center hover:shadow-sm transition">

            <div class="flex gap-4">
                <div class="w-28 h-20 bg-gray-100 rounded-xl"></div>

                <div>
                    <p class="font-medium text-gray-900">
                        {{ $m['title'] }}
                    </p>

                    <p class="text-sm text-gray-500">
                        👥 {{ $m['players'] }} pemain
                    </p>

                    <p class="text-xs text-gray-400">
                        {{ $m['time'] }}
                    </p>
                </div>
            </div>

            <button class="bg-[#0b3d0b] text-white px-4 py-1.5 rounded-lg text-sm hover:bg-[#145214] transition">
                Join
            </button>

        </div>

        @endforeach

    </div>

</div>

@endsection