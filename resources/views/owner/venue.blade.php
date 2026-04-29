{{-- resources/views/owner/pages/venue.blade.php --}}
@extends('partials.app')

@section('title', 'My Venue')

@section('content')

<div class="grid lg:grid-cols-3 gap-6">

    {{-- =========================
        LEFT SIDE (MAIN)
    ========================= --}}
    <div class="lg:col-span-2 space-y-5">

        {{-- ===== VENUE HEADER ===== --}}
        <div class="bg-white rounded-2xl border border-gray-100 p-6 space-y-5 relative">

            {{-- ACTION ICONS --}}
            <div class="absolute top-5 right-5 flex items-center gap-2">

                {{-- EDIT (UPDATED ICON) --}}
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
                        Edit Venue
                    </span>
                </div>

            </div>

            {{-- CONTENT --}}
            <div>
                <h2 class="text-gray-900 text-2xl font-semibold">
                    Darmo Premium Sports
                </h2>
                <p class="text-gray-500 text-sm mt-1">
                    Surabaya, Jawa Timur
                </p>

                {{-- DESCRIPTION --}}
                <p class="text-sm text-gray-600 mt-3 leading-relaxed max-w-xl">
                    Venue olahraga premium dengan fasilitas lengkap untuk futsal dan badminton,
                    cocok untuk latihan rutin maupun pertandingan.
                </p>
            </div>

            {{-- TAG GROUPS --}}
            <div class="space-y-4">

                {{-- SPORT --}}
                <div>
                    <p class="text-xs text-gray-400 mb-2">Olahraga</p>
                    <div class="flex flex-wrap gap-2">
                        @foreach(['Futsal','Badminton'] as $sport)
                        <span class="text-xs font-medium bg-gray-100 text-gray-700 px-3 py-1.5 rounded-lg">
                            {{ $sport }}
                        </span>
                        @endforeach
                    </div>
                </div>

                {{-- FACILITIES --}}
                <div>
                    <p class="text-xs text-gray-400 mb-2">Fasilitas</p>
                    <div class="flex flex-wrap gap-2">
                        @foreach(['AC','CCTV'] as $facility)
                        <span class="text-xs font-medium bg-yellow-50 text-yellow-700 px-3 py-1.5 rounded-lg">
                            {{ $facility }}
                        </span>
                        @endforeach
                    </div>
                </div>

            </div>

        </div>


        {{-- ===== FIELD LIST ===== --}}
        <div class="bg-white rounded-2xl border border-gray-100 p-5">

            <div class="flex items-center justify-between mb-4">
                <h3 class="font-semibold text-gray-800">Lapangan</h3>
            </div>

            @php
            $fields = [
            ['name'=>'Court A','sport'=>'Futsal','price'=>'150K','capacity'=>'10 orang','type'=>'Indoor'],
            ['name'=>'Court B','sport'=>'Badminton','price'=>'80K','capacity'=>'4 orang','type'=>'Outdoor'],
            ['name'=>'Court C','sport'=>'Futsal','price'=>'150K','capacity'=>'10 orang','type'=>'Indoor'],
            ];
            @endphp

            <div class="space-y-3">

                @foreach($fields as $f)
                <div class="border border-gray-100 rounded-xl p-4 flex items-center justify-between hover:shadow-sm transition">

                    <div>
                        <p class="font-medium text-gray-900">{{ $f['name'] }}</p>
                        <p class="text-sm text-gray-500">
                            {{ $f['sport'] }} • {{ $f['capacity'] }}
                        </p>
                    </div>

                    <div class="flex items-center gap-6">

                        <p class="text-sm font-medium text-gray-700">
                            Rp {{ $f['price'] }}/jam
                        </p>

                        {{-- TYPE (UPDATED STYLE LIKE FACILITIES) --}}
                        @php
                        $type = $f['type'];

                        $typeClass = match($type) {
                        'Indoor' => 'bg-green-50 text-green-700',
                        'Outdoor' => 'bg-blue-50 text-blue-700',
                        default => 'bg-gray-50 text-gray-600',
                        };
                        @endphp
                        <span class="text-xs font-medium px-3 py-1.5 rounded-lg {{ $typeClass }}">
                            {{ $type }}
                        </span>

                        {{-- ACTION ICONS --}}
                        <div class="flex gap-2">

                            {{-- EDIT --}}
                            <button class="w-7 h-7 flex items-center justify-center text-gray-500 hover:text-black">
                                <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 20h9" />
                                    <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                        d="M16.5 3.5a2.121 2.121 0 113 3L7 19l-4 1 1-4 12.5-12.5z" />
                                </svg>
                            </button>

                            {{-- DELETE --}}
                            <button class="w-7 h-7 flex items-center justify-center text-red-500 hover:text-red-600">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="w-4 h-4 text-red-500"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                    stroke-linecap="round"
                                    stroke-linejoin="round">

                                    <polyline points="3 6 5 6 21 6"></polyline>
                                    <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"></path>
                                    <path d="M10 11v6"></path>
                                    <path d="M14 11v6"></path>
                                    <path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"></path>
                                </svg>
                            </button>

                        </div>

                    </div>

                </div>
                @endforeach

            </div>

        </div>

    </div>


    {{-- =========================
        RIGHT SIDE
    ========================= --}}
    <div class="space-y-5">

        {{-- LIVE FIELD STATUS --}}
        <div class="bg-white rounded-2xl border border-gray-100">

            <div class="px-5 py-4 border-b flex items-center justify-between">
                <h3 class="font-semibold text-gray-800 text-sm">
                    Live Field Status
                </h3>

                <span class="text-xs text-gray-400">
                    Now
                </span>
            </div>

            <div class="divide-y">

                @php
                $fields = [
                ['name'=>'Court A','status'=>'in_use','time'=>'08:00 - 10:00','user'=>'Agus'],
                ['name'=>'Court B','status'=>'available','time'=>null,'user'=>null],
                ['name'=>'Court C','status'=>'in_use','time'=>'09:00 - 10:00','user'=>'Fajar'],
                ];
                @endphp

                @foreach($fields as $f)

                @php
                $isInUse = $f['status'] === 'in_use';

                $statusClass = $isInUse
                ? 'bg-green-50 text-green-600'
                : 'bg-gray-50 text-gray-500';

                $label = $isInUse ? 'In Use' : 'Available';
                @endphp

                <div class="px-5 py-4 flex items-center justify-between hover:bg-gray-50 transition">

                    {{-- LEFT --}}
                    <div>
                        <p class="text-sm font-medium text-gray-800">
                            {{ $f['name'] }}
                        </p>

                        <p class="text-xs text-gray-500 mt-1">
                            @if($isInUse)
                            {{ $f['user'] }} • {{ $f['time'] }}
                            @else
                            Available
                            @endif
                        </p>
                    </div>

                    {{-- RIGHT BADGE --}}
                    <span class="text-xs px-2 py-1 rounded-full {{ $statusClass }}">
                        {{ $label }}
                    </span>

                </div>

                @endforeach

            </div>

        </div>


        {{-- PAYMENT STATUS --}}
        <div class="bg-white rounded-2xl border border-gray-100 p-5">

            <div class="flex items-center justify-between mb-4">
                <p class="text-sm font-semibold text-gray-800">
                    Payment Overview
                </p>

                <span class="text-xs text-gray-400">
                    This month
                </span>
            </div>

            <div class="space-y-3">

                {{-- PAID --}}
                <div class="flex items-center justify-between p-3 rounded-xl bg-green-50/50 hover:bg-green-50 transition">
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-green-500"></span>
                        <span class="text-sm text-gray-600">Paid</span>
                    </div>
                    <span class="text-sm font-semibold text-green-600">24</span>
                </div>

                {{-- PENDING --}}
                <div class="flex items-center justify-between p-3 rounded-xl bg-yellow-50/50 hover:bg-yellow-50 transition">
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-yellow-500"></span>
                        <span class="text-sm text-gray-600">Pending Payment</span>
                    </div>
                    <span class="text-sm font-semibold text-yellow-600">3</span>
                </div>

                {{-- EXPIRED --}}
                <div class="flex items-center justify-between p-3 rounded-xl bg-gray-50 hover:bg-gray-100 transition">
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-gray-400"></span>
                        <span class="text-sm text-gray-600">Expired</span>
                    </div>
                    <span class="text-sm font-semibold text-gray-500">5</span>
                </div>

            </div>

        </div>


        {{-- STATS --}}
        <div class="bg-white rounded-2xl border border-gray-100 p-5">

            <p class="text-sm text-gray-500 mb-4">Statistik</p>

            <div class="grid grid-cols-2 gap-4">

                <div class="bg-gray-50 rounded-xl p-4">
                    <p class="text-xs text-gray-500">Total Booking</p>
                    <p class="text-lg font-semibold text-gray-900 mt-1">247</p>
                </div>

                <div class="bg-gray-50 rounded-xl p-4">
                    <p class="text-xs text-gray-500">Revenue Bulan</p>
                    <p class="text-lg font-semibold text-gray-900 mt-1">Rp 4.2M</p>
                </div>

                <div class="bg-gray-50 rounded-xl p-4">
                    <p class="text-xs text-gray-500">Booking Hari Ini</p>
                    <p class="text-lg font-semibold text-gray-900 mt-1">12</p>
                </div>

                <div class="bg-gray-50 rounded-xl p-4">
                    <p class="text-xs text-gray-500">Jam Terpakai</p>
                    <p class="text-lg font-semibold text-gray-900 mt-1">36 jam</p>
                </div>

            </div>

        </div>

    </div>

</div>

@endsection