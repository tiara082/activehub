@extends('partials.app')

@section('title', 'My Match')

@section('content')

<div class="space-y-6">

    {{-- HEADER --}}
    <div>

        <h2 class="text-2xl font-semibold text-gray-900">
            My Match
        </h2>

        <p class="text-sm text-gray-500 mt-1">
            Match yang kamu buat atau ikuti
        </p>

    </div>


    {{-- TABS --}}
    <div class="flex gap-6 border-b border-gray-100">

        @foreach($tabs as $key => $tab)

        @php
            $isActive = $active === $key;
        @endphp

        <a href="?tab={{ $key }}"
           class="pb-3 relative text-sm flex items-center gap-2
           {{ $isActive
                ? 'text-green-700 font-semibold'
                : 'text-gray-400'
           }}">

            <span>{{ $tab['label'] }}</span>

            <span class="text-[11px] px-2 py-0.5 rounded-full
                {{ $isActive
                    ? 'bg-green-100 text-green-700'
                    : 'bg-gray-100 text-gray-500'
                }}">
                {{ $tab['count'] }}
            </span>

            @if($isActive)
            <div class="absolute bottom-0 left-0 w-full h-[2px] bg-green-700 rounded-full"></div>
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

        <div class="bg-white border border-gray-100 rounded-2xl p-5 flex justify-between items-center">

            {{-- LEFT --}}
            <div class="flex gap-4">

                {{-- IMAGE --}}
                <div class="w-28 h-20 rounded-xl overflow-hidden bg-gray-100">

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

                    <div class="text-sm text-gray-500 mt-1 space-y-1">

                        <p>
                            {{ $match->booking->field->sport ?? 'Futsal' }}
                        </p>

                        <p>
                            {{ $match->booking->field->venue->name ?? '-' }}
                        </p>

                        <p>
                            {{ \Carbon\Carbon::parse($match->booking->booking_date)->translatedFormat('d F Y') }}
                        </p>

                        <p>
                            {{ $match->booking->start_time }}
                            -
                            {{ $match->booking->end_time }}
                        </p>

                    </div>

                </div>

            </div>


            {{-- RIGHT --}}
            <div class="text-right">

                <span class="text-xs px-3 py-1 rounded-full
                    {{ $isCreator
                        ? 'bg-green-100 text-green-700'
                        : 'bg-blue-100 text-blue-700'
                    }}">

                    {{ $isCreator ? 'Creator' : 'Joined' }}

                </span>


                <p class="text-sm font-semibold text-gray-800 mt-3">

                    {{ $match->participants->count() }}
                    /
                    {{ $match->total_players }}

                    pemain

                </p>


                <a href="{{ route('matches.show', $match->id) }}"
                   class="inline-block mt-3 border border-green-700 text-green-700
                          hover:bg-green-700 hover:text-white
                          transition px-4 py-2 rounded-xl text-sm">

                    Detail

                </a>

            </div>

        </div>

        @empty

        <div class="bg-white border border-dashed rounded-2xl p-10 text-center">

            <p class="text-gray-400">
                Belum ada match
            </p>

        </div>

        @endforelse

    </div>

</div>

@endsection