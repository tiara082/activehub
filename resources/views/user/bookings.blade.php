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
                class="w-full pl-12 pr-4 py-4 rounded-2xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-green-500 text-sm"
            >
        </div>



        {{-- FILTER DATE --}}
        <input
            type="date"
            id="dateFilter"
            class="px-5 py-4 rounded-2xl border border-gray-200 focus:outline-none text-sm"
        >

    </div>

    {{-- ================= TAB ================= --}}
    <div class="flex flex-wrap gap-2 p-1 bg-gray-50 rounded-2xl w-fit">

        <button
            onclick="showTab('all', this)"
            class="tab-btn active-tab flex items-center gap-2 px-4 py-2 rounded-xl bg-white shadow-sm text-green-700 font-semibold border border-gray-100 transition-all text-sm"
        >
            Semua
            <span class="bg-gray-100 text-gray-600 text-[10px] px-2 py-0.5 rounded-full">
                {{ $allBookings->count() }}
            </span>
        </button>

        <button
            onclick="showTab('scheduled', this)"
            class="tab-btn flex items-center gap-2 px-4 py-2 rounded-xl text-gray-500 hover:bg-white/60 transition-all text-sm"
        >
            Terjadwal
            <span class="bg-gray-100 text-gray-600 text-[10px] px-2 py-0.5 rounded-full">
                {{ $pendingBookings->count() }}
            </span>
        </button>

        <button
            onclick="showTab('ongoing', this)"
            class="tab-btn flex items-center gap-2 px-4 py-2 rounded-xl text-gray-500 hover:bg-white/60 transition-all text-sm"
        >
            Berlangsung
            <span class="bg-gray-100 text-gray-600 text-[10px] px-2 py-0.5 rounded-full">
                {{ $ongoingBookings->count() }}
            </span>
        </button>

        <button
            onclick="showTab('done', this)"
            class="tab-btn flex items-center gap-2 px-4 py-2 rounded-xl text-gray-500 hover:bg-white/60 transition-all text-sm"
        >
            Selesai
            <span class="bg-gray-100 text-gray-600 text-[10px] px-2 py-0.5 rounded-full">
                {{ $completedBookings->count() }}
            </span>
        </button>

        <button
            onclick="showTab('cancelled', this)"
            class="tab-btn flex items-center gap-2 px-4 py-2 rounded-xl text-gray-500 hover:bg-white/60 transition-all text-sm"
        >
            Dibatalkan
            <span class="bg-gray-100 text-gray-600 text-[10px] px-2 py-0.5 rounded-full">
                {{ $cancelledBookings->count() }}
            </span>
        </button>

    </div>

    {{-- ================= TABLE CONTAINER ================= --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50/50 text-[11px] text-gray-400 font-bold uppercase tracking-wider border-b border-gray-100">
                    <tr>
                        <th class="px-6 py-4 text-left">Pemesan</th>
                        <th class="px-6 py-4 text-left">Lapangan</th>
                        <th class="px-6 py-4 text-left">Waktu</th>
                        <th class="px-6 py-4 text-left">Durasi</th>
                        <th class="px-6 py-4 text-left">Total</th>
                        <th class="px-6 py-4 text-left">Status</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>

                {{-- ================= SEMUA ================= --}}
                <tbody id="all" class="tab-content divide-y divide-gray-50">
                    @forelse ($allBookings as $booking)
                    <tr class="booking-item hover:bg-gray-50/50 transition-colors"
                        data-name="{{ strtolower($booking->user->name ?? 'user') }}"
                        data-field="{{ $booking->field->name ?? '-' }}"
                        data-date="{{ $booking->created_at?->format('Y-m-d') }}">
                        
                        <td class="px-6 py-4">
                            <p class="font-semibold text-gray-900">{{ $booking->user->name ?? 'User' }}</p>
                            <p class="text-xs text-gray-400 mt-0.5">{{ $booking->user->phone ?? '-' }}</p>
                        </td>
                        <td class="px-6 py-4 text-gray-600">{{ $booking->field->name ?? '-' }}</td>
                        <td class="px-6 py-4">
                            <p class="text-gray-900">
                                {{ $booking->timeSlot && $booking->timeSlot->date ? $booking->timeSlot->date->format('d M') : ($booking->created_at ? $booking->created_at->format('d M') : '-') }}
                            </p>
                            <p class="text-xs text-gray-400 mt-0.5">
                                {{ $booking->timeSlot ? date('H:i', strtotime($booking->timeSlot->start_time)) : '-' }} - {{ $booking->timeSlot ? date('H:i', strtotime($booking->timeSlot->end_time)) : '-' }}
                            </p>
                        </td>
                        <td class="px-6 py-4 text-gray-600">{{ $booking->duration }}</td>
                        <td class="px-6 py-4 font-semibold text-gray-900">Rp {{ number_format($booking->total_price ?? 0, 0, ',', '.') }}</td>
                        <td class="px-6 py-4">
                            @php
                                $color = $booking->status_color ?? 'gray';
                                $bg = "bg-{$color}-50";
                                $text = "text-{$color}-600";
                                // Fallback for tailwind classes if needed
                                if($color == 'orange') { $bg = 'bg-orange-50'; $text = 'text-orange-600'; }
                                if($color == 'green') { $bg = 'bg-green-50'; $text = 'text-green-600'; }
                                if($color == 'blue') { $bg = 'bg-blue-50'; $text = 'text-blue-600'; }
                                if($color == 'gray') { $bg = 'bg-gray-50'; $text = 'text-gray-400'; }
                            @endphp
                            <span class="px-3 py-1 text-[10px] font-bold rounded-full {{ $bg }} {{ $text }} uppercase">
                                {{ $booking->status_label }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex justify-end gap-2 text-gray-400">
                                <a href="{{ route('checkout.show', $booking->id) }}" class="hover:text-blue-600 transition-colors"><i class="fa-solid fa-eye text-sm"></i></a>
                                <button class="hover:text-green-600 transition-colors"><i class="fa-solid fa-pen text-sm"></i></button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="px-6 py-12 text-center text-gray-400">Tidak ada booking</td></tr>
                    @endforelse
                </tbody>

                {{-- ================= TERJADWAL ================= --}}
                <tbody id="scheduled" class="tab-content divide-y divide-gray-50 hidden">
                    @forelse ($pendingBookings as $booking)
                    <tr class="booking-item hover:bg-gray-50/50 transition-colors"
                        data-name="{{ strtolower($booking->user->name ?? 'user') }}"
                        data-field="{{ $booking->field->name ?? '-' }}"
                        data-date="{{ $booking->created_at?->format('Y-m-d') }}">
                        <td class="px-6 py-4">
                            <p class="font-semibold text-gray-900">{{ $booking->user->name ?? 'User' }}</p>
                            <p class="text-xs text-gray-400 mt-0.5">{{ $booking->user->phone ?? '-' }}</p>
                        </td>
                        <td class="px-6 py-4 text-gray-600">{{ $booking->field->name ?? '-' }}</td>
                        <td class="px-6 py-4">
                            <p class="text-gray-900">
                                {{ $booking->timeSlot && $booking->timeSlot->date ? $booking->timeSlot->date->format('d M') : ($booking->created_at ? $booking->created_at->format('d M') : '-') }}
                            </p>
                            <p class="text-xs text-gray-400 mt-0.5">
                                {{ $booking->timeSlot ? date('H:i', strtotime($booking->timeSlot->start_time)) : '-' }} - {{ $booking->timeSlot ? date('H:i', strtotime($booking->timeSlot->end_time)) : '-' }}
                            </p>
                        </td>
                        <td class="px-6 py-4 text-gray-600">{{ $booking->duration }}</td>
                        <td class="px-6 py-4 font-semibold text-gray-900">Rp {{ number_format($booking->total_price ?? 0, 0, ',', '.') }}</td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 text-[10px] font-bold rounded-full bg-blue-50 text-blue-600 uppercase">Terjadwal</span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex justify-end gap-2 text-gray-400">
                                <a href="{{ route('checkout.show', $booking->id) }}" class="hover:text-blue-600 transition-colors"><i class="fa-solid fa-eye text-sm"></i></a>
                                <button class="hover:text-green-600 transition-colors"><i class="fa-solid fa-pen text-sm"></i></button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="px-6 py-12 text-center text-gray-400">Tidak ada booking terjadwal</td></tr>
                    @endforelse
                </tbody>

                {{-- ================= BERLANGSUNG ================= --}}
                <tbody id="ongoing" class="tab-content divide-y divide-gray-50 hidden">
                    @forelse ($ongoingBookings as $booking)
                    <tr class="booking-item hover:bg-gray-50/50 transition-colors"
                        data-name="{{ strtolower($booking->user->name ?? 'user') }}"
                        data-field="{{ $booking->field->name ?? '-' }}"
                        data-date="{{ $booking->created_at?->format('Y-m-d') }}">
                        <td class="px-6 py-4">
                            <p class="font-semibold text-gray-900">{{ $booking->user->name ?? 'User' }}</p>
                            <p class="text-xs text-gray-400 mt-0.5">{{ $booking->user->phone ?? '-' }}</p>
                        </td>
                        <td class="px-6 py-4 text-gray-600">{{ $booking->field->name ?? '-' }}</td>
                        <td class="px-6 py-4">
                            <p class="text-gray-900">
                                {{ $booking->timeSlot && $booking->timeSlot->date ? $booking->timeSlot->date->format('d M') : ($booking->created_at ? $booking->created_at->format('d M') : '-') }}
                            </p>
                            <p class="text-xs text-gray-400 mt-0.5">
                                {{ $booking->timeSlot ? date('H:i', strtotime($booking->timeSlot->start_time)) : '-' }} - {{ $booking->timeSlot ? date('H:i', strtotime($booking->timeSlot->end_time)) : '-' }}
                            </p>
                        </td>
                        <td class="px-6 py-4 text-gray-600">{{ $booking->duration }}</td>
                        <td class="px-6 py-4 font-semibold text-gray-900">Rp {{ number_format($booking->total_price ?? 0, 0, ',', '.') }}</td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 text-[10px] font-bold rounded-full bg-orange-50 text-orange-600 uppercase">Berlangsung</span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex justify-end gap-2 text-gray-400">
                                <a href="{{ route('checkout.show', $booking->id) }}" class="hover:text-blue-600 transition-colors"><i class="fa-solid fa-eye text-sm"></i></a>
                                <button class="hover:text-green-600 transition-colors"><i class="fa-solid fa-pen text-sm"></i></button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="px-6 py-12 text-center text-gray-400">Tidak ada booking berlangsung</td></tr>
                    @endforelse
                </tbody>

                {{-- ================= SELESAI ================= --}}
                <tbody id="done" class="tab-content divide-y divide-gray-50 hidden">
                    @forelse ($completedBookings as $booking)
                    <tr class="booking-item hover:bg-gray-50/50 transition-colors"
                        data-name="{{ strtolower($booking->user->name ?? 'user') }}"
                        data-field="{{ $booking->field->name ?? '-' }}"
                        data-date="{{ $booking->created_at?->format('Y-m-d') }}">
                        <td class="px-6 py-4">
                            <p class="font-semibold text-gray-900">{{ $booking->user->name ?? 'User' }}</p>
                            <p class="text-xs text-gray-400 mt-0.5">{{ $booking->user->phone ?? '-' }}</p>
                        </td>
                        <td class="px-6 py-4 text-gray-600">{{ $booking->field->name ?? '-' }}</td>
                        <td class="px-6 py-4">
                            <p class="text-gray-900">
                                {{ $booking->timeSlot && $booking->timeSlot->date ? $booking->timeSlot->date->format('d M') : ($booking->created_at ? $booking->created_at->format('d M') : '-') }}
                            </p>
                            <p class="text-xs text-gray-400 mt-0.5">
                                {{ $booking->timeSlot ? date('H:i', strtotime($booking->timeSlot->start_time)) : '-' }} - {{ $booking->timeSlot ? date('H:i', strtotime($booking->timeSlot->end_time)) : '-' }}
                            </p>
                        </td>
                        <td class="px-6 py-4 text-gray-600">{{ $booking->duration }}</td>
                        <td class="px-6 py-4 font-semibold text-gray-900">Rp {{ number_format($booking->total_price ?? 0, 0, ',', '.') }}</td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 text-[10px] font-bold rounded-full bg-green-50 text-green-600 uppercase">Selesai</span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex justify-end gap-2 text-gray-400">
                                <a href="{{ route('checkout.show', $booking->id) }}" class="hover:text-blue-600 transition-colors"><i class="fa-solid fa-eye text-sm"></i></a>
                                <button class="hover:text-green-600 transition-colors"><i class="fa-solid fa-pen text-sm"></i></button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="px-6 py-12 text-center text-gray-400">Tidak ada booking selesai</td></tr>
                    @endforelse
                </tbody>

                {{-- ================= DIBATALKAN ================= --}}
                <tbody id="cancelled" class="tab-content divide-y divide-gray-50 hidden">
                    @forelse ($cancelledBookings as $booking)
                    <tr class="booking-item hover:bg-gray-50/50 transition-colors"
                        data-name="{{ strtolower($booking->user->name ?? 'user') }}"
                        data-field="{{ $booking->field->name ?? '-' }}"
                        data-date="{{ $booking->created_at?->format('Y-m-d') }}">
                        <td class="px-6 py-4">
                            <p class="font-semibold text-gray-900">{{ $booking->user->name ?? 'User' }}</p>
                            <p class="text-xs text-gray-400 mt-0.5">{{ $booking->user->phone ?? '-' }}</p>
                        </td>
                        <td class="px-6 py-4 text-gray-600">{{ $booking->field->name ?? '-' }}</td>
                        <td class="px-6 py-4">
                            <p class="text-gray-900">
                                {{ $booking->timeSlot && $booking->timeSlot->date ? $booking->timeSlot->date->format('d M') : ($booking->created_at ? $booking->created_at->format('d M') : '-') }}
                            </p>
                            <p class="text-xs text-gray-400 mt-0.5">
                                {{ $booking->timeSlot ? date('H:i', strtotime($booking->timeSlot->start_time)) : '-' }} - {{ $booking->timeSlot ? date('H:i', strtotime($booking->timeSlot->end_time)) : '-' }}
                            </p>
                        </td>
                        <td class="px-6 py-4 text-gray-600">{{ $booking->duration }}</td>
                        <td class="px-6 py-4 font-semibold text-gray-900">Rp {{ number_format($booking->total_price ?? 0, 0, ',', '.') }}</td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 text-[10px] font-bold rounded-full bg-gray-50 text-gray-400 uppercase">{{ $booking->status_label }}</span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex justify-end gap-2 text-gray-400">
                                <a href="{{ route('checkout.show', $booking->id) }}" class="hover:text-blue-600 transition-colors"><i class="fa-solid fa-eye text-sm"></i></a>
                                <button class="hover:text-green-600 transition-colors"><i class="fa-solid fa-pen text-sm"></i></button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="px-6 py-12 text-center text-gray-400">Tidak ada booking dibatalkan</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

<script>

function showTab(tabId, el)
{
    document.querySelectorAll('.tab-content').forEach(tab => {
        tab.classList.add('hidden')
    })

    const targetTab = document.getElementById(tabId);
    if(targetTab) targetTab.classList.remove('hidden')

    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.classList.remove(
            'bg-white',
            'shadow-sm',
            'text-green-700',
            'font-semibold',
            'border',
            'border-gray-100'
        )
        btn.classList.add('text-gray-500')
    })

    el.classList.add(
        'bg-white',
        'shadow-sm',
        'text-green-700',
        'font-semibold',
        'border',
        'border-gray-100'
    )
    el.classList.remove('text-gray-500')
}

const searchInput = document.getElementById('searchInput')
const dateFilter = document.getElementById('dateFilter')

function filterData()
{
    const search = searchInput.value.toLowerCase()
    const date = dateFilter.value

    document.querySelectorAll('.booking-item').forEach(item => {
        const name = item.dataset.name?.toLowerCase() || ''
        const dateData = item.dataset.date

        let show = true

        if(search && !name.includes(search)) {
            show = false
        }

        if(date && date !== dateData) {
            show = false
        }

        item.style.display = show ? '' : 'none'
    })
}

searchInput.addEventListener('keyup', filterData)
dateFilter.addEventListener('change', filterData)

</script>

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@endpush

@endsection