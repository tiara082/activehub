{{-- resources/views/owner/pages/calendar.blade.php --}}
@extends('partials.app')

@section('title', 'Calendar Slot')
@section('page-title', 'Calendar Slot')
@section('page-subtitle', 'Atur ketersediaan dan blokir waktu lapangan')
@section('cta-label', 'Block Tanggal')
@section('cta-href', '#')

@section('content')

<div class="grid lg:grid-cols-5 gap-6">

    <div class="lg:col-span-2 bg-white rounded-2xl border border-gray-100 overflow-hidden shadow-sm">

        {{-- HEADER --}}
        <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100">

            {{-- LEFT INFO --}}
            <div>
                <p class="font-semibold text-gray-800 text-sm">April 2025</p>
                <p class="text-xs text-gray-400">Klik tanggal untuk lihat slot</p>
            </div>

            {{-- RIGHT ACTION (POJOK) --}}
            <div>
                <button class="px-3 py-1.5 text-[11px] rounded-xl bg-red-50 text-red-600
                               hover:bg-red-100 transition font-semibold">
                    Block Full Day
                </button>
            </div>

        </div>

        {{-- DAY LABELS --}}
        <div class="grid grid-cols-7 px-3 pt-3">
            @foreach(['Min','Sen','Sel','Rab','Kam','Jum','Sab'] as $d)
                <div class="text-center text-[10px] font-medium text-gray-400 py-1.5">
                    {{ $d }}
                </div>
            @endforeach
        </div>

        {{-- DATES --}}
        @php
        $days = [
            ['n'=>30,'empty'=>true,'type'=>''],
            ['n'=>31,'empty'=>true,'type'=>''],
            ['n'=>1,'empty'=>false,'type'=>''],
            ['n'=>2,'empty'=>false,'type'=>'booked'],
            ['n'=>3,'empty'=>false,'type'=>'booked'],
            ['n'=>4,'empty'=>false,'type'=>'partial'],
            ['n'=>5,'empty'=>false,'type'=>'booked'],
            ['n'=>6,'empty'=>false,'type'=>'booked'],
            ['n'=>7,'empty'=>false,'type'=>'partial'],
            ['n'=>8,'empty'=>false,'type'=>'booked'],
            ['n'=>9,'empty'=>false,'type'=>''],
            ['n'=>10,'empty'=>false,'type'=>'booked'],
            ['n'=>11,'empty'=>false,'type'=>'booked'],
            ['n'=>12,'empty'=>false,'type'=>'booked'],
            ['n'=>13,'empty'=>false,'type'=>''],
            ['n'=>14,'empty'=>false,'type'=>'booked'],
            ['n'=>15,'empty'=>false,'type'=>'partial'],
            ['n'=>16,'empty'=>false,'type'=>'booked'],
            ['n'=>17,'empty'=>false,'type'=>'booked'],
            ['n'=>18,'empty'=>false,'type'=>'booked'],
            ['n'=>19,'empty'=>false,'type'=>'booked'],
            ['n'=>20,'empty'=>false,'type'=>'partial'],
            ['n'=>21,'empty'=>false,'type'=>'booked'],
            ['n'=>22,'empty'=>false,'type'=>'booked'],
            ['n'=>23,'empty'=>false,'type'=>'today'],
            ['n'=>24,'empty'=>false,'type'=>''],
            ['n'=>25,'empty'=>false,'type'=>''],
            ['n'=>26,'empty'=>false,'type'=>''],
            ['n'=>27,'empty'=>false,'type'=>''],
            ['n'=>28,'empty'=>false,'type'=>''],
            ['n'=>29,'empty'=>false,'type'=>''],
            ['n'=>30,'empty'=>false,'type'=>''],
            ['n'=>1,'empty'=>true,'type'=>''],
            ['n'=>2,'empty'=>true,'type'=>''],
            ['n'=>3,'empty'=>true,'type'=>''],
        ];
        @endphp

        <div class="grid grid-cols-7 gap-1 px-3 pb-4">

            @foreach($days as $day)
            <div
                class="aspect-square flex flex-col items-center justify-center rounded-xl text-[13px]
                       relative transition-all cursor-pointer
                       hover:scale-[1.02]
                       {{ $day['empty'] ? 'text-gray-300 cursor-default' : 'hover:bg-gray-50 text-gray-700' }}
                       {{ $day['type'] === 'today' ? 'bg-[#1b3a1b] text-white font-bold' : '' }}
                       {{ $day['type'] === 'booked' ? 'bg-green-50 text-green-700' : '' }}
                       {{ $day['type'] === 'partial' ? 'bg-yellow-50 text-yellow-700' : '' }}
                ">
                {{ $day['n'] }}

                @if(in_array($day['type'],['booked','partial']))
                    <span class="absolute bottom-1 w-1 h-1 rounded-full
                                 {{ $day['type'] === 'booked' ? 'bg-green-500' : 'bg-yellow-500' }}"></span>
                @endif
            </div>
            @endforeach

        </div>

        {{-- LEGEND --}}
        <div class="flex items-center justify-between px-5 py-3 border-t border-gray-100 bg-gray-50/40">

            <div class="flex items-center gap-4 flex-wrap">

                <div class="flex items-center gap-1.5 text-[11px] text-gray-500">
                    <div class="w-2.5 h-2.5 rounded-full bg-[#1b3a1b]"></div>
                    Hari Ini
                </div>

                <div class="flex items-center gap-1.5 text-[11px] text-gray-500">
                    <div class="w-2.5 h-2.5 rounded-full bg-green-500"></div>
                    Penuh
                </div>

                <div class="flex items-center gap-1.5 text-[11px] text-gray-500">
                    <div class="w-2.5 h-2.5 rounded-full bg-yellow-400"></div>
                    Sebagian
                </div>

                <div class="flex items-center gap-1.5 text-[11px] text-gray-500">
                    <div class="w-2.5 h-2.5 rounded-full bg-gray-300"></div>
                    Kosong
                </div>

            </div>

        </div>

    </div>

    <div class="lg:col-span-3 bg-white rounded-2xl border border-gray-100 overflow-hidden shadow-sm">

        {{-- HEADER --}}
        <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100">

            <div>
                <p class="font-semibold text-gray-800 text-sm">Slot — 23 April 2025</p>
                <p class="text-xs text-gray-400">Klik slot untuk blokir jam tertentu</p>
            </div>

            <button class="px-4 py-2 text-sm rounded-xl bg-[#0b3d0b] text-white hover:bg-[#163016] transition">
                + Add Booking
            </button>

        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">

                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100">
                        <th class="text-left text-[10px] text-gray-400 uppercase px-5 py-3 w-24">Waktu</th>
                        @foreach(['Lap A','Lap B','Lap C','Lap D'] as $col)
                            <th class="text-center text-[10px] text-gray-400 uppercase px-2 py-3">
                                {{ $col }}
                            </th>
                        @endforeach
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-50">

                    @php
                    $slots = [];
                    for ($h = 7; $h < 22; $h++) {
                        $slots[] = [
                            sprintf("%02d:00", $h),
                            'free',
                            'free',
                            'free',
                            'free'
                        ];
                    }

                    $slotClass = [
                        'booked'  => 'bg-green-50 text-green-700 border border-green-100',
                        'free'    => 'bg-gray-50 text-gray-400 border border-gray-100 hover:bg-yellow-50 hover:text-yellow-700 hover:border-yellow-200 cursor-pointer',
                        'active'  => 'bg-yellow-100 text-yellow-700 border border-yellow-200',
                        'pending' => 'bg-orange-50 text-orange-600 border border-orange-100',
                        'blocked' => 'bg-red-50 text-red-400 border border-red-100',
                    ];

                    $slotLabel = [
                        'booked'  => 'Booked',
                        'free'    => 'Kosong',
                        'active'  => 'Now',
                        'pending' => 'Pending',
                        'blocked' => 'Blokir',
                    ];
                    @endphp

                    @foreach($slots as $slot)
                    <tr class="hover:bg-gray-50/40 transition">

                        <td class="px-5 py-3.5 font-mono text-[12px] text-gray-500">
                            {{ $slot[0] }}
                        </td>

                        @foreach([1,2,3,4] as $i)
                        <td class="px-2 py-3 text-center">
                            <span class="text-[11px] font-semibold px-3 py-1.5 rounded-lg inline-block transition
                                         {{ $slotClass[$slot[$i]] }}">
                                {{ $slotLabel[$slot[$i]] }}
                            </span>
                        </td>
                        @endforeach

                    </tr>
                    @endforeach

                </tbody>

            </table>
        </div>

    </div>

</div>

@endsection