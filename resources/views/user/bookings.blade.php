@extends('partials.app')

@section('title', 'Bookings')

@section('content')

<div class="max-w-5xl mx-auto py-8 px-4 space-y-6">

    {{-- ================= HEADER ================= --}}
    <div>
        <h1 class="text-2xl font-bold text-gray-900">
            Bookings
        </h1>

        <p class="text-gray-500 mt-2">
            Kelola seluruh booking lapangan & match kamu
        </p>
    </div>

    {{-- ================= FILTER ================= --}}
    <div class="flex flex-col lg:flex-row gap-4">

        {{-- SEARCH --}}
        <div class="flex-1 relative">
            <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>

            <input
                type="text"
                id="searchInput"
                placeholder="Cari nama, nomor, atau lapangan..."
                class="w-full pl-12 pr-4 py-4 rounded-2xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-green-500"
            >
        </div>

        {{-- FILTER LAPANGAN --}}
        <select
            id="fieldFilter"
            class="px-5 py-4 rounded-2xl border border-gray-200 focus:outline-none"
        >
            <option value="">Semua Lapangan</option>

            @foreach ($allBookings->unique('field_id') as $booking)
                <option value="{{ $booking->field->name }}">
                    {{ $booking->field->name }}
                </option>
            @endforeach
        </select>

        {{-- FILTER DATE --}}
        <input
            type="date"
            id="dateFilter"
            class="px-5 py-4 rounded-2xl border border-gray-200 focus:outline-none"
        >

    </div>

    {{-- ================= TAB ================= --}}
    <div class="flex flex-wrap gap-3">

        <button
            onclick="showTab('all', this)"
            class="tab-btn active-tab flex items-center gap-2 px-5 py-2 rounded-xl bg-white shadow-sm text-green-700 font-semibold border border-gray-200"
        >
            Semua

            <span class="bg-gray-100 text-gray-600 text-xs px-2 py-1 rounded-full">
                {{ $allBookings->count() }}
            </span>
        </button>

        <button
            onclick="showTab('scheduled', this)"
            class="tab-btn flex items-center gap-2 px-5 py-2 rounded-xl text-gray-500"
        >
            Terjadwal

            <span class="bg-gray-100 text-gray-600 text-xs px-2 py-1 rounded-full">
                {{ $pendingBookings->count() }}
            </span>
        </button>

        <button
            onclick="showTab('ongoing', this)"
            class="tab-btn flex items-center gap-2 px-5 py-2 rounded-xl text-gray-500"
        >
            Berlangsung

            <span class="bg-gray-100 text-gray-600 text-xs px-2 py-1 rounded-full">
                {{ $ongoingBookings->count() }}
            </span>
        </button>

        <button
            onclick="showTab('done', this)"
            class="tab-btn flex items-center gap-2 px-5 py-2 rounded-xl text-gray-500"
        >
            Selesai

            <span class="bg-gray-100 text-gray-600 text-xs px-2 py-1 rounded-full">
                {{ $completedBookings->count() }}
            </span>
        </button>

        <button
            onclick="showTab('cancelled', this)"
            class="tab-btn flex items-center gap-2 px-5 py-2 rounded-xl text-gray-500"
        >
            Dibatalkan

            <span class="bg-gray-100 text-gray-600 text-xs px-2 py-1 rounded-full">
                {{ $cancelledBookings->count() }}
            </span>
        </button>

    </div>

    {{-- ================= TABLE HEADER ================= --}}
    @php
    function tableHeader() {
        return '
        <div class="grid grid-cols-7 gap-4 p-5 text-xs font-bold text-gray-400 border-b bg-gray-50">
            <div>PEMESAN</div>
            <div>LAPANGAN</div>
            <div>WAKTU</div>
            <div>DURASI</div>
            <div>TOTAL</div>
            <div>STATUS</div>
            <div>AKSI</div>
        </div>';
    }
    @endphp

    {{-- ================= SEMUA ================= --}}
    <div id="all" class="tab-content">

        <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden">

            {!! tableHeader() !!}

            @forelse ($allBookings as $booking)

            <div
                class="booking-item grid grid-cols-7 gap-4 p-5 items-center border-b hover:bg-gray-50 transition"
                data-name="{{ strtolower($booking->user->name ?? 'user') }}"
                data-field="{{ $booking->field->name ?? '-' }}"
                data-date="{{ $booking->created_at?->format('Y-m-d') }}"
            >

                {{-- PEMESAN --}}
                <div>
                    <p class="font-semibold text-gray-900">
                        {{ $booking->user->name ?? 'User' }}
                    </p>

                    <p class="text-sm text-gray-400 mt-1">
                        {{ $booking->user->phone ?? '-' }}
                    </p>
                </div>

                {{-- LAPANGAN --}}
                <div>
                    {{ $booking->field->name ?? '-' }}
                </div>

                {{-- WAKTU --}}
                <div>
                    <p>
                        {{ $booking->created_at?->format('d M') ?? '-' }}
                    </p>

                    <p class="text-sm text-gray-400">
                        {{ $booking->timeSlot->start_time ?? '-' }}
                        -
                        {{ $booking->timeSlot->end_time ?? '-' }}
                    </p>
                </div>

                {{-- DURASI --}}
                <div>
                    2 jam
                </div>

                {{-- TOTAL --}}
                <div class="font-semibold">
                    Rp {{ number_format($booking->total_price ?? 0, 0, ',', '.') }}
                </div>

                {{-- STATUS --}}
                <div>

                    @if ($booking->status == 'pending')
                        <span class="px-3 py-1 text-xs rounded-full bg-blue-100 text-blue-600">
                            Terjadwal
                        </span>

                    @elseif ($booking->status == 'confirmed')
                        <span class="px-3 py-1 text-xs rounded-full bg-orange-100 text-orange-600">
                            Berlangsung
                        </span>

                    @elseif ($booking->status == 'completed')
                        <span class="px-3 py-1 text-xs rounded-full bg-green-100 text-green-600">
                            Selesai
                        </span>

                    @elseif ($booking->status == 'cancelled')
                        <span class="px-3 py-1 text-xs rounded-full bg-gray-100 text-gray-500">
                            Dibatalkan
                        </span>
                    @endif

                </div>

                {{-- AKSI --}}
                <div class="flex gap-4 text-lg">

                    <button class="text-gray-400 hover:text-blue-600">
                        <i class="fa-solid fa-eye"></i>
                    </button>

                    <button class="text-gray-400 hover:text-green-600">
                        <i class="fa-solid fa-pen"></i>
                    </button>

                </div>

            </div>

            @empty

            <div class="p-8 text-center text-gray-400">
                Tidak ada booking
            </div>

            @endforelse

        </div>

    </div>

    {{-- ================= TERJADWAL ================= --}}
    <div id="scheduled" class="tab-content hidden">

        <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden">

            {!! tableHeader() !!}

            @forelse ($pendingBookings as $booking)

            <div class="booking-item grid grid-cols-7 gap-4 p-5 items-center border-b">

                <div>
                    <p class="font-semibold">{{ $booking->user->name ?? 'User' }}</p>

                    <p class="text-sm text-gray-400">
                        {{ $booking->user->phone ?? '-' }}
                    </p>
                </div>

                <div>{{ $booking->field->name ?? '-' }}</div>

                <div>
                    <p>{{ $booking->created_at?->format('d M') ?? '-' }}</p>

                    <p class="text-sm text-gray-400">
                        {{ $booking->timeSlot->start_time ?? '-' }}
                        -
                        {{ $booking->timeSlot->end_time ?? '-' }}
                    </p>
                </div>

                <div>2 jam</div>

                <div class="font-semibold">
                    Rp {{ number_format($booking->total_price ?? 0, 0, ',', '.') }}
                </div>

                <div>
                    <span class="px-3 py-1 text-xs rounded-full bg-blue-100 text-blue-600">
                        Terjadwal
                    </span>
                </div>

                <div class="flex gap-4 text-lg">
                    <i class="fa-solid fa-eye text-gray-400"></i>
                    <i class="fa-solid fa-pen text-gray-400"></i>
                </div>

            </div>

            @empty
                <div class="p-8 text-center text-gray-400">
                    Tidak ada booking terjadwal
                </div>
            @endforelse

        </div>

    </div>

    {{-- ================= BERLANGSUNG ================= --}}
    <div id="ongoing" class="tab-content hidden">

        <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden">

            {!! tableHeader() !!}

            @forelse ($ongoingBookings as $booking)

            <div class="booking-item grid grid-cols-7 gap-4 p-5 items-center border-b">

                <div>
                    <p class="font-semibold">{{ $booking->user->name ?? 'User' }}</p>

                    <p class="text-sm text-gray-400">
                        {{ $booking->user->phone ?? '-' }}
                    </p>
                </div>

                <div>{{ $booking->field->name ?? '-' }}</div>

                <div>
                    <p>{{ $booking->created_at?->format('d M') ?? '-' }}</p>

                    <p class="text-sm text-gray-400">
                        {{ $booking->timeSlot->start_time ?? '-' }}
                        -
                        {{ $booking->timeSlot->end_time ?? '-' }}
                    </p>
                </div>

                <div>2 jam</div>

                <div class="font-semibold">
                    Rp {{ number_format($booking->total_price ?? 0, 0, ',', '.') }}
                </div>

                <div>
                    <span class="px-3 py-1 text-xs rounded-full bg-orange-100 text-orange-600">
                        Berlangsung
                    </span>
                </div>

                <div class="flex gap-4 text-lg">
                    <i class="fa-solid fa-eye text-gray-400"></i>
                    <i class="fa-solid fa-pen text-gray-400"></i>
                </div>

            </div>

            @empty
                <div class="p-8 text-center text-gray-400">
                    Tidak ada booking berlangsung
                </div>
            @endforelse

        </div>

    </div>

    {{-- ================= SELESAI ================= --}}
    <div id="done" class="tab-content hidden">

        <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden">

            {!! tableHeader() !!}

            @forelse ($completedBookings as $booking)

            <div class="booking-item grid grid-cols-7 gap-4 p-5 items-center border-b">

                <div>
                    <p class="font-semibold">{{ $booking->user->name ?? 'User' }}</p>

                    <p class="text-sm text-gray-400">
                        {{ $booking->user->phone ?? '-' }}
                    </p>
                </div>

                <div>{{ $booking->field->name ?? '-' }}</div>

                <div>
                    <p>{{ $booking->created_at?->format('d M') ?? '-' }}</p>

                    <p class="text-sm text-gray-400">
                        {{ $booking->timeSlot->start_time ?? '-' }}
                        -
                        {{ $booking->timeSlot->end_time ?? '-' }}
                    </p>
                </div>

                <div>2 jam</div>

                <div class="font-semibold">
                    Rp {{ number_format($booking->total_price ?? 0, 0, ',', '.') }}
                </div>

                <div>
                    <span class="px-3 py-1 text-xs rounded-full bg-green-100 text-green-600">
                        Selesai
                    </span>
                </div>

                <div class="flex gap-4 text-lg">
                    <i class="fa-solid fa-eye text-gray-400"></i>
                    <i class="fa-solid fa-pen text-gray-400"></i>
                </div>

            </div>

            @empty
                <div class="p-8 text-center text-gray-400">
                    Tidak ada booking selesai
                </div>
            @endforelse

        </div>

    </div>

    {{-- ================= DIBATALKAN ================= --}}
    <div id="cancelled" class="tab-content hidden">

        <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden">

            {!! tableHeader() !!}

            @forelse ($cancelledBookings as $booking)

            <div class="booking-item grid grid-cols-7 gap-4 p-5 items-center border-b">

                <div>
                    <p class="font-semibold">{{ $booking->user->name ?? 'User' }}</p>

                    <p class="text-sm text-gray-400">
                        {{ $booking->user->phone ?? '-' }}
                    </p>
                </div>

                <div>{{ $booking->field->name ?? '-' }}</div>

                <div>
                    <p>{{ $booking->created_at?->format('d M') ?? '-' }}</p>

                    <p class="text-sm text-gray-400">
                        {{ $booking->timeSlot->start_time ?? '-' }}
                        -
                        {{ $booking->timeSlot->end_time ?? '-' }}
                    </p>
                </div>

                <div>2 jam</div>

                <div class="font-semibold">
                    Rp {{ number_format($booking->total_price ?? 0, 0, ',', '.') }}
                </div>

                <div>
                    <span class="px-3 py-1 text-xs rounded-full bg-gray-100 text-gray-500">
                        Dibatalkan
                    </span>
                </div>

                <div class="flex gap-4 text-lg">
                    <i class="fa-solid fa-eye text-gray-400"></i>
                    <i class="fa-solid fa-pen text-gray-400"></i>
                </div>

            </div>

            @empty
                <div class="p-8 text-center text-gray-400">
                    Tidak ada booking dibatalkan
                </div>
            @endforelse

        </div>

    </div>

</div>

<script>

function showTab(tabId, el)
{
    document.querySelectorAll('.tab-content').forEach(tab => {
        tab.classList.add('hidden')
    })

    document.getElementById(tabId).classList.remove('hidden')

    document.querySelectorAll('.tab-btn').forEach(btn => {

        btn.classList.remove(
            'bg-white',
            'shadow-sm',
            'text-green-700',
            'font-semibold',
            'border',
            'border-gray-200'
        )

        btn.classList.add('text-gray-500')
    })

    el.classList.add(
        'bg-white',
        'shadow-sm',
        'text-green-700',
        'font-semibold',
        'border',
        'border-gray-200'
    )

    el.classList.remove('text-gray-500')
}

const searchInput = document.getElementById('searchInput')
const fieldFilter = document.getElementById('fieldFilter')
const dateFilter = document.getElementById('dateFilter')

function filterData()
{
    const search = searchInput.value.toLowerCase()
    const field = fieldFilter.value
    const date = dateFilter.value

    document.querySelectorAll('.booking-item').forEach(item => {

        const name = item.dataset.name?.toLowerCase() || ''
        const fieldData = item.dataset.field
        const dateData = item.dataset.date

        let show = true

        if(search && !name.includes(search)) {
            show = false
        }

        if(field && field !== fieldData) {
            show = false
        }

        if(date && date !== dateData) {
            show = false
        }

        item.style.display = show ? 'grid' : 'none'

    })
}

searchInput.addEventListener('keyup', filterData)
fieldFilter.addEventListener('change', filterData)
dateFilter.addEventListener('change', filterData)

</script>

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@endpush

@endsection