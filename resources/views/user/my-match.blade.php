@extends('partials.app')

@section('title', 'Permainan Saya')

@section('content')

<div class="space-y-6">

    {{-- HEADER --}}
    <div>

        <h2 class="text-2xl font-semibold text-gray-900">
            Permainan Saya
        </h2>

        <p class="text-sm text-gray-500 mt-1">
            Daftar permainan yang Anda buat atau ikuti
        </p>

    </div>


    {{-- SEARCH --}}
    <form method="GET"
          action="{{ route('matches.index') }}"
          id="filterForm">

        <div class="relative">

            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Cari permainan atau venue..."
                class="w-full bg-white border border-gray-200 rounded-2xl
                       px-4 py-3 pl-10 text-sm
                       focus:ring-2 focus:ring-[#1b3a1b] outline-none"
                onchange="document.getElementById('filterForm').submit()">

            <svg class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"
                 fill="none"
                 stroke="currentColor"
                 viewBox="0 0 24 24">

                <path stroke-width="2"
                      d="M21 21l-4.3-4.3m1.8-5.2
                         a7 7 0 11-14 0
                         7 7 0 0114 0z"/>

            </svg>

        </div>

    </form>


    {{-- FILTER TAB --}}
    <div class="flex gap-2 p-1 bg-gray-100 rounded-2xl overflow-x-auto no-scrollbar">

        @foreach($tabs as $key => $tab)

        @php
            $isActive = $active === $key;
        @endphp

        <a href="?tab={{ $key }}"
           class="relative flex items-center gap-2 whitespace-nowrap px-4 py-2 rounded-xl
           transition-all duration-200 ease-out
           {{ $isActive
                ? 'bg-white shadow-sm text-[#1b3a1b]'
                : 'text-gray-500 hover:text-gray-800 hover:bg-white/60'
           }}">

            <span class="text-sm font-medium">
                {{ $tab['label'] }}
            </span>

            <span class="text-[11px] font-semibold px-2 py-[2px] rounded-full
                {{ $isActive
                    ? 'bg-[#1b3a1b]/10 text-[#1b3a1b]'
                    : 'bg-gray-200 text-gray-500'
                }}">

                {{ $tab['count'] }}

            </span>

            @if($isActive)
                <span class="absolute inset-0 rounded-xl ring-1 ring-[#1b3a1b]/10"></span>
            @endif

        </a>

        @endforeach

    </div>


    {{-- MATCH LIST --}}
    <div class="space-y-4">

        @forelse($filteredMatches as $match)

        @php
            $isCreator = $match->creator_id == auth()->id();
        @endphp

        <div class="bg-white border border-gray-100 rounded-2xl p-5
                    flex flex-col lg:flex-row lg:items-center
                    justify-between gap-5 hover:bg-gray-50 transition">

            {{-- LEFT --}}
            <div class="flex gap-4">

                {{-- IMAGE --}}
                <div class="w-28 sm:w-36 rounded-xl overflow-hidden bg-gray-100 shrink-0">

                    <img
                        src="{{ asset($match->booking->field->image ?? 'images/default-field.jpg') }}"
                        class="w-full h-full object-cover"
                    >

                </div>


                {{-- INFO --}}
                <div>

                    <h3 class="font-semibold text-gray-900">
                        {{ $match->title }}
                    </h3>

                    <div class="text-sm text-gray-500 mt-2 space-y-1">

                        <p>
                            {{ $match->booking->field->sport ?? 'Futsal' }}
                        </p>

                        <p>
                            {{ $match->booking->field->venue->name ?? '-' }}
                        </p>

                        <p>
                            {{ $match->booking->timeSlot && $match->booking->timeSlot->date ? \Carbon\Carbon::parse($match->booking->timeSlot->date)->locale('id')->translatedFormat('j F Y') : '-' }}
                        </p>

                        <p>
                            {{ $match->booking->timeSlot && $match->booking->timeSlot->start_time ? \Carbon\Carbon::parse($match->booking->timeSlot->start_time)->format('H:i') : '' }}
                            {{ $match->booking->timeSlot && $match->booking->timeSlot->start_time ? '-' : '' }}
                            {{ $match->booking->timeSlot && $match->booking->timeSlot->end_time ? \Carbon\Carbon::parse($match->booking->timeSlot->end_time)->format('H:i') : '' }}
                        </p>

                    </div>

                </div>

            </div>


            {{-- RIGHT --}}
            <div class="flex flex-col items-start lg:items-end gap-2">

                {{-- ROLE --}}
                <span class="text-xs px-3 py-1 rounded-full
                    {{ $isCreator
                        ? 'bg-green-100 text-green-700'
                        : 'bg-blue-100 text-blue-700'
                    }}">

                    {{ $isCreator ? 'Pembuat' : 'Peserta' }}

                </span>


                {{-- PLAYER PROGRESS --}}
                <div class="w-full lg:w-48 mt-2 lg:mt-1 lg:text-right">
                    <div class="flex justify-between items-center mb-1.5">
                        <span class="text-xs font-medium text-gray-500">Peserta</span>
                        <span class="text-xs font-bold text-gray-800">{{ $match->participants->count() }} / {{ $match->total_players }}</span>
                    </div>
                    @php
                        $percentage = min(100, ($match->participants->count() / max(1, $match->total_players)) * 100);
                        $isFull = $percentage >= 100;
                    @endphp
                    <div class="w-full bg-gray-100 rounded-full h-1.5 overflow-hidden">
                        <div class="h-1.5 rounded-full transition-all duration-500 {{ $isFull ? 'bg-orange-500' : 'bg-[#1b3a1b]' }}" style="width: {{ $percentage }}%"></div>
                    </div>
                </div>


                {{-- BUTTON --}}
                <a href="{{ route('matches.show', $match->id) }}"
                class="inline-block mt-2 border border-[#1b3a1b]
                        text-[#1b3a1b]
                        hover:bg-[#1b3a1b] hover:text-white
                        transition px-4 py-2 rounded-xl text-sm">

                    Lihat Detail

                </a>

            </div>
        </div>

        @empty

        <div class="bg-white border border-dashed border-gray-200
                    rounded-2xl p-12 text-center">

            <p class="text-gray-400">
                Belum ada permainan
            </p>

        </div>

        @endforelse

    </div>

</div>

@endsection