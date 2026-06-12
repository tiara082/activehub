@extends('partials.app')

@section('title', 'Venue Saya')

@section('content')

{{-- VENUE SELECTOR & ADD BUTTON --}}
<div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
    <div>
        <h2 class="text-xl font-bold text-gray-900">Kelola Cabang</h2>
        <p class="text-sm text-gray-500">Pilih cabang yang ingin Anda lihat dan kelola</p>
    </div>
    <div class="flex items-stretch gap-3 w-full md:w-auto">
        <form id="venueSwitchForm" method="POST" action="{{ route('owner.venue.switch') }}" class="flex-1 md:flex-none relative">
            @csrf
            <input type="hidden" name="venue_id" id="venue_id_input" value="{{ $activeVenue ? $activeVenue->id : '' }}">
            
            <div class="relative w-full md:w-64 h-full">
                <!-- Trigger Button -->
                <button type="button" onclick="toggleVenueMenu()" class="w-full h-full flex items-center justify-between border border-gray-200 rounded-xl text-sm pl-4 pr-4 py-2.5 bg-white shadow-sm font-medium text-gray-800 hover:bg-gray-50 transition focus:outline-none focus:ring-2 focus:ring-gray-900/5 focus:border-gray-900">
                    <span id="venue_selected_text" class="truncate pr-2">
                        {{ $activeVenue ? $activeVenue->name : 'Pilih Cabang' }}
                    </span>
                    <svg class="h-4 w-4 text-gray-400 transition-transform duration-200" id="venueMenuIcon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                <!-- Dropdown Menu -->
                <div id="venueDropdownMenu" class="absolute left-0 top-full mt-2 w-full bg-white rounded-xl shadow-lg border border-gray-100 py-1.5 opacity-0 invisible translate-y-2 transition-all duration-200 z-50">
                    @foreach($venues as $v)
                        <button type="button" onclick="selectVenue('{{ $v->id }}', '{{ addslashes($v->name) }}')" class="w-full text-left px-4 py-2 text-sm transition-colors {{ $activeVenue && $activeVenue->id == $v->id ? 'bg-[#1b3a1b]/5 text-[#1b3a1b] font-bold' : 'text-gray-700 hover:bg-gray-50' }}">
                            {{ $v->name }}
                        </button>
                    @endforeach
                </div>
            </div>
        </form>
        <a href="{{ route('owner.venue.create') }}" class="bg-white border border-gray-200 text-gray-700 px-4 py-2.5 rounded-xl text-sm font-medium hover:bg-gray-50 hover:text-gray-900 transition whitespace-nowrap inline-flex items-center justify-center gap-2 shadow-sm h-full">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Tambah Cabang
        </a>
    </div>
</div>

<div class="grid xl:grid-cols-3 gap-6">

    {{-- ===================== LEFT COL ===================== --}}
    <div class="lg:col-span-2 space-y-5">

        @if($activeVenue)

        {{-- ===== VENUE HEADER ===== --}}
        <div class="bg-white rounded-2xl border border-gray-100 p-6 space-y-5 relative">

            {{-- ACTION BUTTONS --}}
            <div class="absolute top-5 right-5 flex items-center gap-2">

                {{-- EDIT VENUE --}}
                <div class="relative group">
                    <a href="{{ route('owner.venue.edit', $activeVenue->id) }}"
                        class="w-9 h-9 rounded-lg bg-gray-100 hover:bg-gray-200 flex items-center justify-center transition">
                        <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M12 20h9"/>
                            <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                d="M16.5 3.5a2.121 2.121 0 113 3L7 19l-4 1 1-4 12.5-12.5z"/>
                        </svg>
                    </a>
                    <span class="absolute right-0 top-full mt-2 text-xs bg-gray-900 text-white px-2 py-1 rounded
                                 opacity-0 group-hover:opacity-100 transition whitespace-nowrap z-10">
                        Edit Venue
                    </span>
                </div>

                {{-- DELETE VENUE --}}
                <div class="relative group">
                    <button type="button" onclick="openDeleteVenue({{ $activeVenue->id }}, '{{ addslashes($activeVenue->name) }}')"
                        class="w-9 h-9 rounded-lg bg-red-50 hover:bg-red-100 flex items-center justify-center transition">
                        <svg class="w-4 h-4 text-red-500" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="3 6 5 6 21 6"/>
                            <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/>
                            <path d="M10 11v6"/><path d="M14 11v6"/>
                            <path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/>
                        </svg>
                    </button>
                    <span class="absolute right-0 top-full mt-2 text-xs bg-gray-900 text-white px-2 py-1 rounded
                                 opacity-0 group-hover:opacity-100 transition whitespace-nowrap z-10">
                        Hapus Venue
                    </span>
                </div>

            </div>

            {{-- VENUE INFO --}}
            <div>
                <h2 class="text-gray-900 text-2xl font-semibold pr-24">
                    {{ $activeVenue->name }}
                </h2>
                <p class="text-gray-500 text-sm mt-1">
                    {{ $activeVenue->location ?? '-' }}
                </p>
                @if($activeVenue->description)
                <p class="text-sm text-gray-600 mt-3 leading-relaxed max-w-xl">
                    {{ $activeVenue->description }}
                </p>
                @endif
            </div>

            {{-- SPORT TAGS (unique from fields) --}}
            @php $sports = $activeVenue->fields->pluck('sport_type')->unique()->filter(); @endphp
            @if($sports->isNotEmpty())
            <div>
                <p class="text-xs text-gray-400 mb-2">Olahraga</p>
                <div class="flex flex-wrap gap-2">
                    @foreach($sports as $sport)
                    <span class="text-xs font-medium bg-gray-100 text-gray-700 px-3 py-1.5 rounded-lg">
                        {{ $sport }}
                    </span>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- FACILITIES TAGS --}}
            @if(!empty($activeVenue->facilities))
            <div class="pt-1">
                <p class="text-xs text-gray-400 mb-2">Fasilitas</p>
                <div class="flex flex-wrap gap-2">
                    @foreach($activeVenue->facilities as $facility)
                    <span class="text-xs font-medium bg-gray-100 text-gray-700 px-3 py-1.5 rounded-lg">
                        {{ $facility }}
                    </span>
                    @endforeach
                </div>
            </div>
            @endif

        </div>


        {{-- ===== FIELD LIST ===== --}}
        <div class="bg-white rounded-2xl border border-gray-100 p-5">

            <div class="flex items-center justify-between mb-4">
                <h3 class="font-semibold text-gray-800">Lapangan</h3>
                <button type="button" onclick="openAddField()"
                    class="inline-flex items-center gap-1.5 text-xs font-medium bg-gray-900 hover:bg-gray-700
                           text-white px-3 py-2 rounded-lg transition">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-width="2" stroke-linecap="round" d="M12 5v14M5 12h14"/>
                    </svg>
                    Tambah Lapangan
                </button>
            </div>

            @if($activeVenue->fields->isEmpty())
                <p class="text-sm text-gray-400 text-center py-8">Belum ada lapangan. Tambahkan lapangan pertama kamu.</p>
            @else
            <div class="space-y-3">
                @foreach($activeVenue->fields as $field)
                @php
                    $typeClass = $field->is_indoor
                        ? 'bg-green-50 text-green-700'
                        : 'bg-blue-50 text-blue-700';
                    $typeLabel = $field->is_indoor ? 'Indoor' : 'Outdoor';
                @endphp
                <div class="border border-gray-100 rounded-xl p-4 hover:shadow-sm transition">
                    <div class="flex items-start gap-4">
                        @if($field->photo_url)
                        <img src="{{ $field->photo_url }}" class="w-12 h-12 rounded-lg object-cover flex-shrink-0">
                        @else
                        <div class="w-12 h-12 rounded-lg bg-gray-100 flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-image text-gray-300"></i>
                        </div>
                        @endif
                        <div class="flex-1 min-w-0">
                            <p class="font-medium text-gray-900">{{ $field->name }}</p>
                            <p class="text-sm text-gray-500">
                                @if($field->capacity) Kapasitas: {{ $field->capacity }} orang @endif
                            </p>
                        </div>
                    </div>
                    <div class="flex items-center justify-between mt-3 flex-wrap gap-2">
                        <div class="flex items-center gap-2 flex-wrap">
                            <p class="text-sm font-medium text-gray-700">Rp {{ number_format($field->price_per_hour, 0, ',', '.') }}/jam</p>
                            <span class="text-xs font-medium px-3 py-1.5 rounded-lg {{ $typeClass }}">{{ $typeLabel }}</span>
                        </div>
                        <div class="flex items-center gap-1">
                            <button type="button" onclick="openEditField({{ $field->id }}, '{{ addslashes($field->name) }}', '{{ addslashes($field->sport_type) }}', {{ $field->price_per_hour }}, {{ $field->capacity ?? 0 }}, {{ $field->is_indoor }})"
                                class="w-8 h-8 flex items-center justify-center text-gray-400 hover:text-gray-700 hover:bg-gray-100 rounded-lg transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M16.5 3.5a2.121 2.121 0 113 3L7 19l-4 1 1-4 12.5-12.5z"/>
                                </svg>
                            </button>
                            <button onclick="openDeleteField({{ $field->id }}, '{{ addslashes($field->name) }}')"
                                class="w-8 h-8 flex items-center justify-center text-red-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition">
                                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="3 6 5 6 21 6"/>
                                    <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/>
                                    <path d="M10 11v6"/><path d="M14 11v6"/>
                                    <path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @endif

        </div>

        @else

        {{-- ===== NO VENUE EMPTY STATE ===== --}}
        <div class="bg-white rounded-2xl border border-gray-100 p-12 text-center">
            <div class="w-14 h-14 bg-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                <svg class="w-7 h-7 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                        d="M3 9.75L12 3l9 6.75V21a.75.75 0 01-.75.75H3.75A.75.75 0 013 21V9.75z"/>
                    <path stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" d="M9 21V12h6v9"/>
                </svg>
            </div>
            <p class="text-gray-800 font-semibold text-base">Belum ada venue</p>
            <p class="text-gray-400 text-sm mt-1 mb-5">Tambahkan venue pertama Anda untuk mulai mengelola lapangan.</p>
<a href="{{ route('owner.venue.create') }}"
   class="inline-flex items-center gap-2 bg-gray-900 hover:bg-gray-700 text-white text-sm font-medium px-5 py-2.5 rounded-xl transition">
    Tambah Venue
</a>
        </div>

        @endif

    </div>


    {{-- ===================== RIGHT SIDEBAR ===================== --}}
    <div class="space-y-5">

        @if($activeVenue)

        {{-- LIVE FIELD STATUS --}}
        <div class="bg-white rounded-2xl border border-gray-100">
            <div class="px-5 py-4 border-b flex items-center justify-between">
                <h3 class="font-semibold text-gray-800 text-sm">Status Lapangan Langsung</h3>
                <span class="text-xs text-gray-400">Sekarang</span>
            </div>
            <div class="divide-y">
                @forelse($activeVenue->fields as $field)
                @php
                    $now           = now();
                    $activeBooking = $field->bookings()
                        ->where('status', 'confirmed')
                        ->whereHas('timeSlot', function ($q) use ($now) {
                            $q->whereDate('date', $now->toDateString())
                              ->where('start_time', '<=', $now->format('H:i:s'))
                              ->where('end_time', '>=', $now->format('H:i:s'));
                        })
                        ->with('user')
                        ->first();
                    $isInUse     = (bool) $activeBooking;
                    $statusClass = $isInUse ? 'bg-green-50 text-green-600' : 'bg-gray-50 text-gray-500';
                    $label       = $isInUse ? 'Digunakan' : 'Tersedia';
                @endphp
                <div class="px-5 py-4 flex items-center justify-between hover:bg-gray-50 transition">
                    <div>
                        <p class="text-sm font-medium text-gray-800">{{ $field->name }}</p>
                        <p class="text-xs text-gray-500 mt-1">
                            @if($isInUse)
                                {{ $activeBooking->user->name ?? '-' }} •
                                {{ \Carbon\Carbon::parse($activeBooking->start_time)->format('H:i') }} -
                                {{ \Carbon\Carbon::parse($activeBooking->end_time)->format('H:i') }}
                            @else
                                Tersedia
                            @endif
                        </p>
                    </div>
                    <span class="text-xs px-2 py-1 rounded-full {{ $statusClass }}">{{ $label }}</span>
                </div>
                @empty
                <p class="text-sm text-gray-400 text-center py-6 px-5">Tidak ada lapangan.</p>
                @endforelse
            </div>
        </div>


        {{-- PAYMENT OVERVIEW --}}
        <div class="bg-white rounded-2xl border border-gray-100 p-5">
            <div class="flex items-center justify-between mb-4">
                <p class="text-sm font-semibold text-gray-800">Ringkasan Pembayaran</p>
                <span class="text-xs text-gray-400">Bulan ini</span>
            </div>
            @php
                $venueFieldIds = $activeVenue->fields->pluck('id');
                $paid    = \App\Models\Booking::whereIn('field_id', $venueFieldIds)
                               ->whereMonth('created_at', now()->month)
                               ->where('status', 'paid')->count();
                $pending = \App\Models\Booking::whereIn('field_id', $venueFieldIds)
                               ->whereMonth('created_at', now()->month)
                               ->where('status', 'pending')->count();
                $expired = \App\Models\Booking::whereIn('field_id', $venueFieldIds)
                               ->whereMonth('created_at', now()->month)
                               ->where('status', 'expired')->count();
            @endphp
            <div class="space-y-3">
                <div class="flex items-center justify-between p-3 rounded-xl bg-green-50/50 hover:bg-green-50 transition">
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-green-500"></span>
                        <span class="text-sm text-gray-600">Lunas</span>
                    </div>
                    <span class="text-sm font-semibold text-green-600">{{ $paid }}</span>
                </div>
                <div class="flex items-center justify-between p-3 rounded-xl bg-yellow-50/50 hover:bg-yellow-50 transition">
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-yellow-500"></span>
                        <span class="text-sm text-gray-600">Menunggu Pembayaran</span>
                    </div>
                    <span class="text-sm font-semibold text-yellow-600">{{ $pending }}</span>
                </div>
                <div class="flex items-center justify-between p-3 rounded-xl bg-gray-50 hover:bg-gray-100 transition">
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-gray-400"></span>
                        <span class="text-sm text-gray-600">Kadaluarsa</span>
                    </div>
                    <span class="text-sm font-semibold text-gray-500">{{ $expired }}</span>
                </div>
            </div>
        </div>


        {{-- STATS --}}
        <div class="bg-white rounded-2xl border border-gray-100 p-5">
            <p class="text-sm text-gray-500 mb-4">Statistik</p>
            @php
                $totalBookings = \App\Models\Booking::whereIn('field_id', $venueFieldIds)->count();
                $monthRevenue  = \App\Models\Booking::whereIn('field_id', $venueFieldIds)
                                     ->whereMonth('created_at', now()->month)
                                     ->where('status', 'paid')
                                     ->sum('total_price');
                $todayBookings = \App\Models\Booking::whereIn('field_id', $venueFieldIds)
                                     ->whereDate('created_at', today())->count();
                $hoursUsed     = \App\Models\Booking::whereIn('field_id', $venueFieldIds)
                                     ->where('status', 'confirmed')
                                     ->with('timeSlot')
                                     ->get()
                                     ->sum(function($b) {
                                         if (!$b->timeSlot) return 0;
                                         return \Carbon\Carbon::parse($b->timeSlot->start_time)
                                             ->diffInHours(\Carbon\Carbon::parse($b->timeSlot->end_time));
                                     });
            @endphp
            <div class="grid grid-cols-2 gap-4">
                <div class="bg-gray-50 rounded-xl p-4">
                    <p class="text-xs text-gray-500">Total Booking</p>
                    <p class="text-lg font-semibold text-gray-900 mt-1">{{ $totalBookings }}</p>
                </div>
                <div class="bg-gray-50 rounded-xl p-4">
                    <p class="text-xs text-gray-500">Revenue Bulan</p>
                    <p class="text-lg font-semibold text-gray-900 mt-1">
                        Rp {{ $monthRevenue >= 1000000
                            ? number_format($monthRevenue / 1000000, 1) . 'M'
                            : number_format($monthRevenue, 0, ',', '.') }}
                    </p>
                </div>
                <div class="bg-gray-50 rounded-xl p-4">
                    <p class="text-xs text-gray-500">Booking Hari Ini</p>
                    <p class="text-lg font-semibold text-gray-900 mt-1">{{ $todayBookings }}</p>
                </div>
                <div class="bg-gray-50 rounded-xl p-4">
                    <p class="text-xs text-gray-500">Jam Terpakai</p>
                    <p class="text-lg font-semibold text-gray-900 mt-1">{{ $hoursUsed }} jam</p>
                </div>
            </div>
        </div>

        @else
        <div class="bg-white rounded-2xl border border-gray-100 p-6 text-center">
            <p class="text-sm text-gray-400">Statistik akan muncul setelah venue ditambahkan.</p>
        </div>
        @endif

    </div>

</div>


{{-- ============================================================ --}}
{{--  MODALS                                                       --}}
{{-- ============================================================ --}}

{{-- ===== ADD VENUE ===== --}}
<div id="addVenueModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/40 px-4">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-md p-6">
        <div class="flex items-center justify-between mb-5">
            <h3 class="font-semibold text-gray-900">Tambah Venue</h3>
            <button onclick="closeModal('addVenueModal')" class="text-gray-400 hover:text-gray-600 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-width="2" stroke-linecap="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <form method="POST" action="{{ route('owner.venue.store') }}" class="space-y-4">
            @csrf
            <div>
                <label class="text-xs text-gray-500 mb-1 block">Nama Venue <span class="text-red-400">*</span></label>
                <input type="text" name="name" required
                    class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-gray-300"
                    placeholder="cth. Darmo Premium Sports">
            </div>
            <div>
                <label class="text-xs text-gray-500 mb-1 block">Lokasi</label>
                <input type="text" name="location"
                    class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-gray-300"
                    placeholder="cth. Surabaya, Jawa Timur">
            </div>
            <div>
                <label class="text-xs text-gray-500 mb-1 block">Deskripsi</label>
                <textarea name="description" rows="3"
                    class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-gray-300 resize-none"
                    placeholder="Deskripsi singkat venue..."></textarea>
            </div>
            <div class="flex gap-3 pt-1">
                <button type="button" onclick="closeModal('addVenueModal')"
                    class="flex-1 border border-gray-200 text-gray-600 text-sm font-medium py-2.5 rounded-xl hover:bg-gray-50 transition">
                    Batal
                </button>
                <button type="submit"
                    class="flex-1 bg-gray-900 hover:bg-gray-700 text-white text-sm font-medium py-2.5 rounded-xl transition">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>





@if($activeVenue)
{{-- ===== DELETE VENUE ===== --}}
<div id="deleteVenueModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/40 px-4">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-sm p-6 text-center">
        <div class="w-12 h-12 bg-red-50 rounded-2xl flex items-center justify-center mx-auto mb-4">
            <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"
                    d="M12 9v4m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
            </svg>
        </div>
        <h3 class="font-semibold text-gray-900 mb-1">Hapus Venue?</h3>
        <p class="text-sm text-gray-500 mb-6">
            Venue <strong id="deleteVenueName"></strong> dan semua lapangannya akan dihapus permanen.
        </p>
        <div class="flex gap-3">
            <button type="button" onclick="closeModal('deleteVenueModal')"
                class="flex-1 border border-gray-200 text-gray-600 text-sm font-medium py-2.5 rounded-xl hover:bg-gray-50 transition">
                Batal
            </button>
            <form id="deleteVenueForm" method="POST" action="" class="flex-1">
                @csrf
                @method('DELETE')
                <button type="submit"
                    class="w-full bg-red-500 hover:bg-red-600 text-white text-sm font-medium py-2.5 rounded-xl transition">
                    Hapus
                </button>
            </form>
        </div>
    </div>
</div>





{{-- ===== FIELD MODAL (ADD / EDIT) ===== --}}
<div id="fieldModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/40 px-4">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-md p-6">
        <div class="flex items-center justify-between mb-5">
            <h3 class="font-semibold text-gray-900" id="fieldModalTitle">Tambah Lapangan</h3>
            <button onclick="closeModal('fieldModal')" class="text-gray-400 hover:text-gray-600 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-width="2" stroke-linecap="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <form id="fieldForm" method="POST" action="" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <input type="hidden" name="_method" id="fieldFormMethod" value="POST">
            <div>
                <label class="text-xs text-gray-500 mb-1 block">Nama Lapangan <span class="text-red-400">*</span></label>
                <input type="text" name="name" id="fieldName" required
                    class="w-full border border-gray-200 rounded-xl px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-gray-300"
                    placeholder="cth. Lapangan A">
            </div>
            <div>
                <label class="text-xs text-gray-500 mb-1 block">Tipe Olahraga <span class="text-red-400">*</span></label>
                <select name="sport_type" id="fieldSportType" required
                    class="w-full border border-gray-200 rounded-xl px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-gray-300 bg-white">
                    <option value="">-- Pilih Olahraga --</option>
                    <option value="Futsal">Futsal</option>
                    <option value="Basket">Basket</option>
                    <option value="Bulu Tangkis">Bulu Tangkis</option>
                    <option value="Tennis">Tennis</option>
                    <option value="Voli">Voli</option>
                    <option value="Padel">Padel</option>
                    <option value="Kebugaran">Kebugaran</option>
                </select>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="text-xs text-gray-500 mb-1 block">Harga / Jam <span class="text-red-400">*</span></label>
                    <input type="number" name="price_per_hour" id="fieldPrice" required
                        class="w-full border border-gray-200 rounded-xl px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-gray-300"
                        placeholder="cth. 150000">
                </div>
                <div>
                    <label class="text-xs text-gray-500 mb-1 block">Kapasitas</label>
                    <input type="number" name="capacity" id="fieldCapacity"
                        class="w-full border border-gray-200 rounded-xl px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-gray-300"
                        placeholder="cth. 10">
                </div>
            </div>
            <div>
                <label class="text-xs text-gray-500 mb-1 block">Tipe Tempat <span class="text-red-400">*</span></label>
                <select name="is_indoor" id="fieldIsIndoor" required
                    class="w-full border border-gray-200 rounded-xl px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-gray-300">
                    <option value="1">Indoor</option>
                    <option value="0">Outdoor</option>
                </select>
            </div>
            <div>
                <label class="text-xs text-gray-500 mb-1 block">Foto Lapangan</label>
                <input type="file" name="photo" id="fieldPhoto" accept="image/*"
                    class="w-full border border-gray-200 rounded-xl px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-gray-300">
            </div>
            <div class="flex gap-3 pt-1">
                <button type="button" onclick="closeModal('fieldModal')"
                    class="flex-1 border border-gray-200 text-gray-600 text-sm font-medium py-2 rounded-xl hover:bg-gray-50 transition">
                    Batal
                </button>
                <button type="submit" id="fieldSubmitBtn"
                    class="flex-1 bg-gray-900 hover:bg-gray-700 text-white text-sm font-medium py-2 rounded-xl transition">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ===== DELETE FIELD ===== --}}
<div id="deleteFieldModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/40 px-4">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-sm p-6 text-center">
        <div class="w-12 h-12 bg-red-50 rounded-2xl flex items-center justify-center mx-auto mb-4">
            <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"
                    d="M12 9v4m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
            </svg>
        </div>
        <h3 class="font-semibold text-gray-900 mb-1">Hapus Lapangan?</h3>
        <p class="text-sm text-gray-500 mb-6">
            Lapangan <strong id="deleteFieldName"></strong> akan dihapus permanen.
        </p>
        <div class="flex gap-3">
            <button onclick="closeModal('deleteFieldModal')"
                class="flex-1 border border-gray-200 text-gray-600 text-sm font-medium py-2.5 rounded-xl hover:bg-gray-50 transition">
                Batal
            </button>
            <form id="deleteFieldForm" method="POST" action="" class="flex-1">
                @csrf
                @method('DELETE')
                <button type="submit"
                    class="w-full bg-red-500 hover:bg-red-600 text-white text-sm font-medium py-2.5 rounded-xl transition">
                    Hapus
                </button>
            </form>
        </div>
    </div>
</div>

@endif {{-- end @if($activeVenue) for modals --}}


{{-- ============================================================ --}}
{{--  JAVASCRIPT                                                   --}}
{{-- ============================================================ --}}
<script>
    function openModal(id) {
        document.getElementById(id).classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }

    function closeModal(id) {
        document.getElementById(id).classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }

    // Close modal on backdrop click
    document.querySelectorAll('[id$="Modal"]').forEach(modal => {
        modal.addEventListener('click', function (e) {
            if (e.target === this) closeModal(this.id);
        });
    });

    // Custom Venue Dropdown
    let venueMenuOpen = false;
    function toggleVenueMenu() {
        const menu = document.getElementById('venueDropdownMenu');
        const icon = document.getElementById('venueMenuIcon');
        if (venueMenuOpen) {
            menu.classList.replace('opacity-100', 'opacity-0');
            menu.classList.replace('visible', 'invisible');
            menu.classList.replace('translate-y-0', 'translate-y-2');
            icon.style.transform = 'rotate(0deg)';
        } else {
            menu.classList.replace('opacity-0', 'opacity-100');
            menu.classList.replace('invisible', 'visible');
            menu.classList.replace('translate-y-2', 'translate-y-0');
            icon.style.transform = 'rotate(180deg)';
        }
        venueMenuOpen = !venueMenuOpen;
    }

    function selectVenue(id, name) {
        document.getElementById('venue_id_input').value = id;
        document.getElementById('venue_selected_text').textContent = name;
        toggleVenueMenu();
        document.getElementById('venueSwitchForm').submit();
    }

    // Close venue dropdown on outside click
    document.addEventListener('click', function(event) {
        const dropdownForm = document.getElementById('venueSwitchForm');
        if (venueMenuOpen && dropdownForm && !dropdownForm.contains(event.target)) {
            toggleVenueMenu();
        }
    });

    // Populate delete venue modal
    function openDeleteVenue(id, name) {
        const baseUrl = "{{ url('owner/venue') }}/";
        document.getElementById('deleteVenueForm').action = baseUrl + id;
        document.getElementById('deleteVenueName').textContent = name;
        openModal('deleteVenueModal');
    }

    // Open add field modal
    function openAddField() {
        document.getElementById('fieldModalTitle').textContent = 'Tambah Lapangan';
        document.getElementById('fieldFormMethod').value = 'POST';
        document.getElementById('fieldForm').action = "{{ url('owner/venue') }}/{{ $activeVenue->id ?? '' }}/field";
        document.getElementById('fieldSubmitBtn').textContent = 'Tambah';
        
        document.getElementById('fieldName').value = '';
        document.getElementById('fieldSportType').value = '';
        document.getElementById('fieldPrice').value = '';
        document.getElementById('fieldCapacity').value = '';
        document.getElementById('fieldIsIndoor').value = '1';
        document.getElementById('fieldPhoto').value = '';
        
        openModal('fieldModal');
    }

    // Open edit field modal
    function openEditField(id, name, sportType, price, capacity, isIndoor) {
        document.getElementById('fieldModalTitle').textContent = 'Edit Lapangan';
        document.getElementById('fieldFormMethod').value = 'PUT';
        document.getElementById('fieldForm').action = "{{ url('owner/venue') }}/{{ $activeVenue->id ?? '' }}/field/" + id;
        document.getElementById('fieldSubmitBtn').textContent = 'Simpan';
        
        document.getElementById('fieldName').value = name;
        document.getElementById('fieldSportType').value = sportType;
        document.getElementById('fieldPrice').value = price;
        document.getElementById('fieldCapacity').value = capacity > 0 ? capacity : '';
        document.getElementById('fieldIsIndoor').value = isIndoor ? '1' : '0';
        document.getElementById('fieldPhoto').value = '';
        
        openModal('fieldModal');
    }

    // Populate delete field modal
    function openDeleteField(id, name) {
        const baseUrl = "{{ url('owner/venue') }}/{{ $activeVenue->id ?? '' }}/field/";
        document.getElementById('deleteFieldForm').action = baseUrl + id;
        document.getElementById('deleteFieldName').textContent = name;
        openModal('deleteFieldModal');
    }
</script>

@endsection