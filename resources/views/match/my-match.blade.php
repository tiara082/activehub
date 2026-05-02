@extends('partials.app')

@section('title', 'My Matches')

@section('content')
<div class="p-6">
 {{-- OFFSET SIDEBAR --}}

    <div class="grid lg:grid-cols-3 gap-6">

        {{-- ================= LEFT CONTENT ================= --}}
        <div class="lg:col-span-2 space-y-5">

            {{-- HEADER --}}
            <div>
                <h2 class="text-2xl font-semibold text-gray-900">Matches</h2>
                <p class="text-sm text-gray-500 mt-1">
                    Kelola match yang kamu buat atau ikuti
                </p>
            </div>

            {{-- TABS --}}
            <div class="flex gap-6 border-b pb-3 text-sm">

                @php
                $tabs = [
                    'scheduled' => ['label'=>'Terjadwal','count'=>4],
                    'ongoing' => ['label'=>'Berlangsung','count'=>2],
                    'finished' => ['label'=>'Selesai','count'=>8],
                    'cancelled' => ['label'=>'Dibatalkan','count'=>2],
                ];
                @endphp

                @foreach($tabs as $key => $tab)
                <button
                    class="flex items-center gap-2 pb-2 border-b-2
                    {{ $loop->first ? 'text-[#0b3d0b] border-[#0b3d0b] font-medium' : 'text-gray-400 border-transparent' }}">

                    {{ $tab['label'] }}

                    <span class="text-xs px-2 py-0.5 rounded-full bg-gray-100 text-gray-600">
                        {{ $tab['count'] }}
                    </span>
                </button>
                @endforeach

            </div>


            {{-- MATCH LIST --}}
            @php
            $matches = [
                [
                    'title'=>'Fun Match Weekend',
                    'sport'=>'Futsal',
                    'format'=>'7 vs 7',
                    'location'=>'Active Arena, Jakarta Selatan',
                    'date'=>'Minggu, 26 Mei 2024',
                    'time'=>'16:00 - 18:00',
                    'players'=>'10 / 14',
                    'minmax'=>'Min 10 - Max 14',
                    'role'=>'creator'
                ],
                [
                    'title'=>'Badminton Morning',
                    'sport'=>'Badminton',
                    'format'=>'4 vs 4',
                    'location'=>'Sport Center Jaksel',
                    'date'=>'Sabtu, 25 Mei 2024',
                    'time'=>'08:00 - 10:00',
                    'players'=>'6 / 8',
                    'minmax'=>'Min 6 - Max 8',
                    'role'=>'joined'
                ],
            ];
            @endphp


            <div class="space-y-4">

                @foreach($matches as $m)

                @php
                $isCreator = $m['role'] === 'creator';

                $badgeClass = $isCreator
                ? 'bg-green-50 text-green-700'
                : 'bg-purple-50 text-purple-700';

                $btnClass = $isCreator
                ? 'border-green-600 text-green-700 hover:bg-green-600 hover:text-white'
                : 'border-purple-600 text-purple-700 hover:bg-purple-600 hover:text-white';

                $label = $isCreator ? 'You Created' : 'Joined';
                $action = $isCreator ? 'Manage' : 'View';
                @endphp


                <div class="bg-white rounded-2xl border border-gray-100 p-5 flex justify-between items-center hover:shadow-sm transition relative">

                    {{-- ACTION ICON (3 DOT) --}}
                    <div class="absolute top-4 right-4">
                        <button class="text-gray-400 hover:text-gray-600">
                            ⋮
                        </button>
                    </div>

                    {{-- LEFT --}}
                    <div class="flex gap-4">

                        <div class="w-28 h-20 bg-gray-100 rounded-xl"></div>

                        <div>
                            <h3 class="font-semibold text-gray-900">
                                {{ $m['title'] }}
                            </h3>

                            <div class="text-sm text-gray-500 mt-1 space-y-0.5">
                                <p>{{ $m['sport'] }} • {{ $m['format'] }}</p>
                                <p>{{ $m['location'] }}</p>
                                <p>{{ $m['date'] }} • {{ $m['time'] }}</p>
                            </div>
                        </div>

                    </div>

                    {{-- RIGHT --}}
                    <div class="flex items-center gap-6">

                        {{-- PLAYER --}}
                        <div class="text-right">
                            <p class="text-sm font-medium text-gray-800">
                                {{ $m['players'] }} pemain
                            </p>
                            <p class="text-xs text-gray-400">
                                {{ $m['minmax'] }}
                            </p>
                        </div>

                        {{-- ACTION BOX --}}
                        <div class="p-4 rounded-xl text-center w-40
                            {{ $isCreator ? 'bg-green-50/50' : 'bg-purple-50/50' }}">

                            <span class="text-xs px-2 py-1 rounded-full {{ $badgeClass }}">
                                {{ $label }}
                            </span>

                            <button class="mt-3 w-full border py-1.5 rounded-lg text-sm transition {{ $btnClass }}">
                                {{ $action }}
                            </button>

                            <p class="text-[11px] text-gray-400 mt-1">
                                {{ $isCreator ? 'Kelola peserta' : 'Lihat detail match' }}
                            </p>

                        </div>

                    </div>

                </div>

                @endforeach

            </div>

        </div>


        {{-- ================= RIGHT PANEL ================= --}}
        <div class="space-y-5">

            {{-- UPCOMING MATCH --}}
            <div class="bg-white rounded-2xl border border-gray-100 p-5">

                <div class="flex justify-between mb-4">
                    <p class="text-sm font-semibold text-gray-800">
                        Upcoming Match
                    </p>
                    <span class="text-xs text-gray-400">Soon</span>
                </div>

                <div class="space-y-3">

                    <div class="p-3 rounded-xl bg-gray-50">
                        <p class="text-sm font-medium text-gray-800">
                            Fun Match Weekend
                        </p>
                        <p class="text-xs text-gray-500">
                            26 Mei • 16:00
                        </p>
                    </div>

                </div>

            </div>


            {{-- MATCH STATS --}}
            <div class="bg-white rounded-2xl border border-gray-100 p-5">

                <p class="text-sm text-gray-500 mb-4">Statistik Match</p>

                <div class="grid grid-cols-2 gap-4">

                    <div class="bg-gray-50 rounded-xl p-4">
                        <p class="text-xs text-gray-500">Total Match</p>
                        <p class="text-lg font-semibold text-gray-900 mt-1">24</p>
                    </div>

                    <div class="bg-gray-50 rounded-xl p-4">
                        <p class="text-xs text-gray-500">Joined</p>
                        <p class="text-lg font-semibold text-gray-900 mt-1">10</p>
                    </div>

                    <div class="bg-gray-50 rounded-xl p-4">
                        <p class="text-xs text-gray-500">Created</p>
                        <p class="text-lg font-semibold text-gray-900 mt-1">14</p>
                    </div>

                    <div class="bg-gray-50 rounded-xl p-4">
                        <p class="text-xs text-gray-500">This Week</p>
                        <p class="text-lg font-semibold text-gray-900 mt-1">5</p>
                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection