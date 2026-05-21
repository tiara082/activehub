@extends('partials.app')

@section('title', 'Pemesanan')

@section('content')

@php
$statusStyle = [
    'Selesai' => 'bg-green-50 text-green-700',
    'Berlangsung' => 'bg-yellow-50 text-yellow-700',
    'Terjadwal' => 'bg-blue-50 text-blue-700',
    'Dibatalkan' => 'bg-red-50 text-red-700',
    'Menunggu' => 'bg-orange-50 text-orange-600',
    'Diblokir' => 'bg-red-50 text-red-600',
];
@endphp

<div class="space-y-6">

    {{-- HEADER --}}
    <div>

        <h1 class="text-2xl font-semibold text-gray-900">
            Pemesanan
        </h1>

        <p class="text-sm text-gray-500 mt-1">
            Kelola seluruh pemesanan lapangan & match Anda
        </p>

    </div>


    {{-- FILTER --}}
    <div class="flex flex-col md:flex-row gap-3">

        {{-- SEARCH --}}
        <div class="flex-1 relative">

            <input
                type="text"
                id="searchInput"
                placeholder="Cari nama, nomor telepon, atau lapangan..."
                class="w-full bg-white border border-gray-200 rounded-2xl
                       px-4 py-3 pl-10 text-sm
                       focus:ring-2 focus:ring-[#1b3a1b] outline-none">

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


        {{-- FILTER DATE --}}
        <input
            type="date"
            id="dateFilter"
            class="bg-white border border-gray-200 rounded-2xl
                   px-4 py-3 text-sm
                   focus:ring-2 focus:ring-[#1b3a1b] outline-none">

    </div>


    {{-- FILTER STATUS --}}
    <div>

        <div class="flex gap-2 p-1 bg-gray-100 rounded-2xl overflow-x-auto no-scrollbar w-fit">

            <button
                onclick="showTab('all', this)"
                class="tab-btn active-tab relative flex items-center gap-2 whitespace-nowrap
                       px-4 py-2 rounded-xl
                       bg-white shadow-sm text-[#1b3a1b]
                       transition-all duration-200 ease-out">

                <span class="text-sm font-medium">
                    Semua
                </span>

                <span class="text-[11px] font-semibold px-2 py-[2px] rounded-full
                             bg-[#1b3a1b]/10 text-[#1b3a1b]">

                    {{ $allBookings->count() }}

                </span>

            </button>

            <button
                onclick="showTab('pending', this)"
                class="tab-btn relative flex items-center gap-2 whitespace-nowrap
                       px-4 py-2 rounded-xl
                       text-gray-500 hover:text-gray-800 hover:bg-white/60
                       transition-all duration-200 ease-out">

                <span class="text-sm font-medium">
                    Menunggu
                </span>

                <span class="text-[11px] font-semibold px-2 py-[2px] rounded-full
                             bg-gray-200 text-gray-500">

                    {{ $pendingBookings->count() }}

                </span>

            </button>
            
            <button
                onclick="showTab('scheduled', this)"
                class="tab-btn relative flex items-center gap-2 whitespace-nowrap
                       px-4 py-2 rounded-xl
                       text-gray-500 hover:text-gray-800 hover:bg-white/60
                       transition-all duration-200 ease-out">

                <span class="text-sm font-medium">
                    Terjadwal
                </span>

                <span class="text-[11px] font-semibold px-2 py-[2px] rounded-full
                             bg-gray-200 text-gray-500">

                    {{ $scheduledBookings->count() }}

                </span>

            </button>

            <button
                onclick="showTab('ongoing', this)"
                class="tab-btn relative flex items-center gap-2 whitespace-nowrap
                       px-4 py-2 rounded-xl
                       text-gray-500 hover:text-gray-800 hover:bg-white/60
                       transition-all duration-200 ease-out">

                <span class="text-sm font-medium">
                    Berlangsung
                </span>

                <span class="text-[11px] font-semibold px-2 py-[2px] rounded-full
                             bg-gray-200 text-gray-500">

                    {{ $ongoingBookings->count() }}

                </span>

            </button>


            <button
                onclick="showTab('done', this)"
                class="tab-btn relative flex items-center gap-2 whitespace-nowrap
                       px-4 py-2 rounded-xl
                       text-gray-500 hover:text-gray-800 hover:bg-white/60
                       transition-all duration-200 ease-out">

                <span class="text-sm font-medium">
                    Selesai
                </span>

                <span class="text-[11px] font-semibold px-2 py-[2px] rounded-full
                             bg-gray-200 text-gray-500">

                    {{ $completedBookings->count() }}

                </span>

            </button>


            <button
                onclick="showTab('cancelled', this)"
                class="tab-btn relative flex items-center gap-2 whitespace-nowrap
                       px-4 py-2 rounded-xl
                       text-gray-500 hover:text-gray-800 hover:bg-white/60
                       transition-all duration-200 ease-out">

                <span class="text-sm font-medium">
                    Dibatalkan
                </span>

                <span class="text-[11px] font-semibold px-2 py-[2px] rounded-full
                             bg-gray-200 text-gray-500">

                    {{ $cancelledBookings->count() }}

                </span>

            </button>

        </div>

    </div>


    {{-- TABLE --}}
    <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden shadow-sm">

        {{-- HEADER --}}
        <div class="flex items-center justify-between px-6 py-5 border-b border-gray-100">

            <div>

                <p class="text-sm font-semibold text-gray-800">
                    Ringkasan Pemesanan
                </p>

                <p class="text-xs text-gray-400">
                    Daftar seluruh aktivitas pemesanan Anda
                </p>

            </div>

        </div>


        {{-- TABLE CONTENT --}}
        <div class="overflow-x-auto">

            <table class="w-full text-sm">

                <thead class="text-[11px] text-gray-400 uppercase tracking-wider">

                    <tr>

                        <th class="px-6 py-4 text-left">
                            Pemesan
                        </th>

                        <th class="px-6 py-4 text-left">
                            Lapangan
                        </th>

                        <th class="px-6 py-4 text-left">
                            Jadwal
                        </th>

                        <th class="px-6 py-4 text-left">
                            Durasi
                        </th>

                        <th class="px-6 py-4 text-left">
                            Total
                        </th>

                        <th class="px-6 py-4 text-left">
                            Status
                        </th>

                        <th class="px-6 py-4 text-right">
                            Aksi
                        </th>

                    </tr>

                </thead>


                {{-- ================= SEMUA ================= --}}
                <tbody id="all" class="tab-content divide-y divide-gray-50">

                    @forelse ($allBookings as $booking)

                    <tr class="booking-item hover:bg-gray-50 transition"
                        data-name="{{ strtolower($booking->user->name ?? 'user') }}"
                        data-field="{{ $booking->field->name ?? '-' }}"
                        data-date="{{ $booking->created_at?->format('Y-m-d') }}"
                        data-status="{{ $booking->status_label }}">

                        <td class="px-6 py-4">

                            <p class="font-medium text-gray-800">
                                {{ $booking->user->name ?? 'User' }}
                            </p>

                            <p class="text-xs text-gray-400">
                                {{ $booking->user->phone ?? '-' }}
                            </p>

                        </td>

                        <td class="px-6 py-4 text-gray-600">
                            {{ $booking->field->name ?? '-' }}
                        </td>

                        <td class="px-6 py-4">

                            <p class="text-gray-700">

                                {{ $booking->timeSlot && $booking->timeSlot->date
                                    ? $booking->timeSlot->date->format('d M')
                                    : ($booking->created_at
                                        ? $booking->created_at->format('d M')
                                        : '-') }}

                            </p>

                            <p class="text-xs text-gray-400">

                                {{ $booking->timeSlot
                                    ? date('H:i', strtotime($booking->timeSlot->start_time))
                                    : '-' }}

                                -

                                {{ $booking->timeSlot
                                    ? date('H:i', strtotime($booking->timeSlot->end_time))
                                    : '-' }}

                            </p>

                        </td>

                        <td class="px-6 py-4 text-gray-600">
                            {{ $booking->duration }}
                        </td>

                        <td class="px-6 py-4 font-medium text-gray-800">
                            Rp {{ number_format($booking->total_price ?? 0, 0, ',', '.') }}
                        </td>

                        <td class="px-6 py-4">

                            <span class="px-3 py-1 rounded-full text-xs font-medium
                                {{ $statusStyle[$booking->status_label] ?? 'bg-gray-50 text-gray-600' }}">

                                {{ $booking->status_label }}

                            </span>

                        </td>

                        <td class="px-6 py-4 text-right">

                            <div class="flex justify-end gap-2">

                                <a href="{{ route('checkout.show', $booking->id) }}"
                                   class="w-9 h-9 inline-flex items-center justify-center
                                          rounded-xl hover:bg-gray-100 transition text-gray-500">

                                    <i class="fa-solid fa-eye text-sm"></i>

                                </a>

                                <button class="w-9 h-9 inline-flex items-center justify-center
                                               rounded-xl hover:bg-gray-100 transition text-gray-500">

                                    <i class="fa-solid fa-pen text-sm"></i>

                                </button>

                            </div>

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="7" class="text-center py-16 text-gray-400">

                            Belum ada pemesanan

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>


<script>

let activeTab = 'all'

function showTab(tabId, el)
{
    activeTab = tabId

    document.querySelectorAll('.tab-btn').forEach(btn => {

        btn.classList.remove(
            'bg-white',
            'shadow-sm',
            'text-[#1b3a1b]'
        )

        btn.classList.add('text-gray-500')
    })

    el.classList.add(
        'bg-white',
        'shadow-sm',
        'text-[#1b3a1b]'
    )

    el.classList.remove('text-gray-500')

    filterData()
}

const searchInput = document.getElementById('searchInput')
const dateFilter = document.getElementById('dateFilter')

function filterData()
{
    const search = searchInput.value.toLowerCase()
    const date = dateFilter.value

    document.querySelectorAll('.booking-item').forEach(item => {

        const name = item.dataset.name?.toLowerCase() || ''
        const dateData = item.dataset.date || ''
        const status = item.dataset.status || ''

        let show = true

        // SEARCH
        if(search && !name.includes(search)) {
            show = false
        }

        // DATE
        if(date && date !== dateData) {
            show = false
        }

        // TAB FILTER
        if(activeTab !== 'all') {

            if(activeTab === 'scheduled' && status !== 'Terjadwal') {
                show = false
            }

            if(activeTab === 'pending' && status !== 'Menunggu') {
                show = false
            }

            if(activeTab === 'ongoing' && status !== 'Berlangsung') {
                show = false
            }

            if(activeTab === 'done' && status !== 'Selesai') {
                show = false
            }

            if(activeTab === 'cancelled' && status !== 'Dibatalkan') {
                show = false
            }
        }

        item.style.display = show ? '' : 'none'
    })
}

searchInput.addEventListener('keyup', filterData)
dateFilter.addEventListener('change', filterData)

</script>

@push('styles')
<link rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@endpush

@endsection