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

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl">
            {{ session('error') }}
        </div>
    @endif

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
                placeholder="Cari venue atau lapangan..."
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


        {{-- FILTER DATE & SORT --}}
        <div class="flex gap-2 w-full md:w-auto">
            <input
                type="date"
                id="dateFilter"
                class="bg-white border border-gray-200 rounded-2xl
                       px-4 py-3 text-sm w-full md:w-auto
                       focus:ring-2 focus:ring-[#1b3a1b] outline-none">
                       
            {{-- CUSTOM SORT DROPDOWN --}}
            <div class="relative w-full md:w-auto" id="customSortDropdown">
                <button type="button" onclick="toggleSortMenu()" 
                    class="w-full bg-white border border-gray-200 hover:border-gray-300 rounded-2xl px-4 py-3 text-sm focus:ring-2 focus:ring-[#1b3a1b]/20 outline-none flex items-center justify-between gap-3 transition-colors shadow-sm text-gray-700 font-medium">
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-arrow-down-wide-short text-gray-400"></i>
                        <span id="sortLabel">Urutkan: Paling Baru</span>
                    </div>
                    <i class="fa-solid fa-chevron-down text-gray-400 text-xs transition-transform duration-300" id="sortIcon"></i>
                </button>

                <!-- Dropdown Menu -->
                <div id="sortMenu" class="absolute z-50 mt-2 w-full md:w-[260px] bg-white rounded-2xl shadow-xl border border-gray-100 py-2 opacity-0 invisible translate-y-2 transition-all duration-300 origin-top right-0">
                    
                    <button type="button" onclick="selectSort('paling_baru', 'Paling Baru', this)" class="sort-option w-full text-left px-4 py-2.5 text-sm hover:bg-gray-50 flex items-center justify-between text-gray-700 bg-gray-50 font-semibold transition-colors">
                        <span>Paling Baru <span class="text-[10px] text-gray-400 block font-normal leading-none mt-1">Berdasarkan tanggal pemesanan</span></span>
                        <i class="fa-solid fa-check text-[#1b3a1b] text-xs check-icon"></i>
                    </button>

                    <button type="button" onclick="selectSort('paling_dekat', 'Paling Dekat', this)" class="sort-option w-full text-left px-4 py-2.5 text-sm hover:bg-gray-50 flex items-center justify-between text-gray-500 transition-colors">
                        <span>Paling Dekat <span class="text-[10px] text-gray-400 block font-normal leading-none mt-1">Berdasarkan jadwal main terdekat</span></span>
                        <i class="fa-solid fa-check text-[#1b3a1b] text-xs check-icon hidden"></i>
                    </button>

                    <button type="button" onclick="selectSort('paling_lama', 'Paling Lama', this)" class="sort-option w-full text-left px-4 py-2.5 text-sm hover:bg-gray-50 flex items-center justify-between text-gray-500 transition-colors">
                        <span>Paling Lama <span class="text-[10px] text-gray-400 block font-normal leading-none mt-1">Berdasarkan jadwal main terlama</span></span>
                        <i class="fa-solid fa-check text-[#1b3a1b] text-xs check-icon hidden"></i>
                    </button>
                </div>
                
                <input type="hidden" id="sortFilter" value="paling_baru">
            </div>
        </div>

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

                        <th class="px-6 py-4 text-center">
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
                        data-status="{{ $booking->status_label }}"
                        data-created="{{ $booking->created_at }}"
                        data-matchdate="{{ $booking->timeSlot && $booking->timeSlot->date ? $booking->timeSlot->date->format('Y-m-d') . ' ' . $booking->timeSlot->start_time : $booking->created_at }}">

                        <td class="px-6 py-4">

                            <p class="font-medium text-gray-800">
                                {{ $booking->user->name ?? 'User' }}
                            </p>

                            <p class="text-xs text-gray-400">
                                {{ $booking->user->phone ?? '-' }}
                            </p>

                        </td>

                        <td class="px-6 py-4">
                            <p class="font-medium text-gray-800">
                                {{ $booking->field->venue->name ?? '-' }}
                            </p>
                            <p class="text-xs text-gray-400">
                                {{ $booking->field->name ?? '-' }}
                            </p>
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

                        <td class="px-6 py-4 text-center">
                            <div class="flex justify-center gap-2 items-center">
                                @if($booking->status_label === 'Menunggu')
                                    <a href="{{ route('user.bookings.show', $booking->id) }}"
                                       class="w-9 h-9 inline-flex items-center justify-center
                                              rounded-xl hover:bg-gray-100 transition text-gray-500" title="Lihat Detail">
                                        <i class="fa-solid fa-eye text-sm"></i>
                                    </a>
                                @elseif($booking->status_label === 'Terjadwal')
                                    @php
                                        $bVenue = addslashes($booking->field->venue->name ?? '-');
                                        $bField = addslashes($booking->field->name ?? '-');
                                        $bDate = $booking->timeSlot && $booking->timeSlot->date ? $booking->timeSlot->date->format('d F Y') : '-';
                                        $bTime = $booking->timeSlot ? date('H:i', strtotime($booking->timeSlot->start_time)) . ' - ' . date('H:i', strtotime($booking->timeSlot->end_time)) : '-';
                                        $bPrice = number_format($booking->total_price, 0, ',', '.');
                                        $bOrderDate = $booking->created_at->format('d M Y, H:i');
                                        $bCity = addslashes($booking->field->venue->city ?? '-');
                                    @endphp
                                    <button onclick="openReceiptModal('{{ $booking->id }}', '{{ $bVenue }}', '{{ $bField }}', '{{ $bCity }}', '{{ $bDate }}', '{{ $bTime }}', '{{ $bPrice }}', '{{ $bOrderDate }}')"
                                       class="w-9 h-9 inline-flex items-center justify-center
                                              rounded-xl hover:bg-gray-100 transition text-emerald-600 bg-emerald-50 border border-emerald-100" title="Lihat E-Ticket / Kwitansi">
                                        <i class="fa-solid fa-ticket text-sm"></i>
                                    </button>
                                @elseif($booking->status_label === 'Selesai')
                                    @if($booking->review)
                                        <span class="px-3 py-1.5 text-xs font-medium text-gray-500 bg-gray-50 border border-gray-200 rounded-lg cursor-not-allowed" title="Selesai">
                                            <i class="fa-solid fa-check mr-1"></i> Selesai
                                        </span>
                                    @else
                                        <button onclick="openRatingModal({{ $booking->id }}, '{{ addslashes($booking->field->name ?? '-') }}')" class="px-3 py-1.5 text-xs font-medium text-yellow-600 bg-yellow-50 border border-yellow-200 rounded-lg hover:bg-yellow-100 transition" title="Beri Rating">
                                            <i class="fa-solid fa-star mr-1"></i> Beri Rating
                                        </button>
                                    @endif
                                @else
                                    <span class="text-gray-300 text-sm">-</span>
                                @endif
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
const sortFilter = document.getElementById('sortFilter')

function sortData() {
    const sortBy = sortFilter.value;
    const tbody = document.getElementById('all');
    const rows = Array.from(tbody.querySelectorAll('.booking-item'));
    
    rows.sort((a, b) => {
        if (sortBy === 'paling_baru') {
            const dateA = new Date(a.dataset.created);
            const dateB = new Date(b.dataset.created);
            return dateB - dateA;
        } else if (sortBy === 'paling_dekat') {
            const dateA = new Date(a.dataset.matchdate);
            const dateB = new Date(b.dataset.matchdate);
            return dateA - dateB;
        } else if (sortBy === 'paling_lama') {
            const dateA = new Date(a.dataset.matchdate);
            const dateB = new Date(b.dataset.matchdate);
            return dateB - dateA;
        }
    });
    
    // Append in new order
    rows.forEach(row => tbody.appendChild(row));
}

let sortMenuOpen = false;

function toggleSortMenu() {
    const menu = document.getElementById('sortMenu');
    const icon = document.getElementById('sortIcon');
    
    if (sortMenuOpen) {
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
    sortMenuOpen = !sortMenuOpen;
}

// Close dropdown when clicking outside
document.addEventListener('click', function(event) {
    const dropdown = document.getElementById('customSortDropdown');
    if (sortMenuOpen && !dropdown.contains(event.target)) {
        toggleSortMenu();
    }
});

function selectSort(value, label, btn) {
    document.getElementById('sortFilter').value = value;
    document.getElementById('sortLabel').innerText = 'Urutkan: ' + label;
    
    // Update active styling
    document.querySelectorAll('.sort-option').forEach(el => {
        el.classList.remove('bg-gray-50', 'font-semibold', 'text-gray-700');
        el.classList.add('text-gray-500');
        el.querySelector('.check-icon').classList.add('hidden');
    });
    
    btn.classList.remove('text-gray-500');
    btn.classList.add('bg-gray-50', 'font-semibold', 'text-gray-700');
    btn.querySelector('.check-icon').classList.remove('hidden');
    
    toggleSortMenu();
    sortData();
}

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

// RATING MODAL LOGIC
let ratings = {
    Main: 0,
    Clean: 0,
    Condition: 0,
    Comms: 0
};

function openRatingModal(bookingId, fieldName) {
    document.getElementById('ratingBookingId').value = bookingId;
    document.getElementById('ratingModalField').textContent = fieldName;
    document.getElementById('ratingModal').classList.remove('hidden');
    document.getElementById('ratingForm').reset();
    setRating('Main', 0);
    setRating('Clean', 0);
    setRating('Condition', 0);
    setRating('Comms', 0);
}

function closeRatingModal() {
    document.getElementById('ratingModal').classList.add('hidden');
}

function openReceiptModal(id, venue, field, city, date, time, price, orderDate) {
    document.getElementById('receiptOrderId').textContent = '#' + id;
    document.getElementById('receiptOrderDate').textContent = orderDate;
    document.getElementById('receiptVenue').textContent = venue;
    document.getElementById('receiptField').textContent = field;
    document.getElementById('receiptCity').textContent = city;
    document.getElementById('receiptDate').textContent = date;
    document.getElementById('receiptTime').textContent = time + ' WIB';
    document.getElementById('receiptPrice').textContent = 'Rp ' + price;
    
    // Set href for download button
    const url = "{{ url('/user/bookings') }}/" + id + "/receipt";
    document.getElementById('receiptDownloadBtn').href = url;
    
    document.getElementById('receiptModal').classList.remove('hidden');
}

function closeReceiptModal() {
    document.getElementById('receiptModal').classList.add('hidden');
}

function setRating(category, rating) {
    ratings[category] = rating;
    document.getElementById('rating' + category).value = rating;
    const stars = document.getElementById('starContainer' + category).children;
    for (let i = 0; i < stars.length; i++) {
        if (i < rating) {
            stars[i].classList.remove('text-gray-300');
            stars[i].classList.add('text-yellow-400');
        } else {
            stars[i].classList.add('text-gray-300');
            stars[i].classList.remove('text-yellow-400');
        }
    }
}

document.getElementById('ratingForm').addEventListener('submit', function(e) {
    if(ratings.Main === 0 || ratings.Clean === 0 || ratings.Condition === 0 || ratings.Comms === 0) {
        e.preventDefault();
        alert('Silakan lengkapi semua rating bintang terlebih dahulu!');
    }
});

</script>

<!-- Modal Beri Rating -->
<div id="ratingModal" class="fixed inset-0 z-[60] hidden bg-black/60 flex items-center justify-center p-4 backdrop-blur-sm">
    <div class="bg-white rounded-2xl w-full max-w-md shadow-2xl overflow-hidden transform transition-all">
        <!-- Modal Header -->
        <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-emerald-50/50">
            <div>
                <h2 class="text-xl font-bold text-gray-800">Beri Ulasan</h2>
                <p id="ratingModalField" class="text-sm text-gray-500 mt-1">Lapangan Anda</p>
            </div>
            <button type="button" onclick="closeRatingModal()" class="w-8 h-8 bg-white border border-gray-200 rounded-full flex items-center justify-center text-gray-500 hover:text-red-500 hover:border-red-200 hover:bg-red-50 transition-colors">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <!-- Modal Body -->
        <form id="ratingForm" action="{{ route('user.reviews.store') }}" method="POST" class="p-6 space-y-5">
            @csrf
            <input type="hidden" id="ratingBookingId" name="booking_id">
            
            <!-- Bintang Utama -->
            <div class="text-center">
                <p class="text-sm font-bold text-gray-800 mb-2">Penilaian Keseluruhan</p>
                <div class="flex justify-center gap-2" id="starContainerMain">
                    <button type="button" class="text-3xl text-gray-300 hover:text-yellow-400 transition" onclick="setRating('Main', 1)"><i class="fas fa-star"></i></button>
                    <button type="button" class="text-3xl text-gray-300 hover:text-yellow-400 transition" onclick="setRating('Main', 2)"><i class="fas fa-star"></i></button>
                    <button type="button" class="text-3xl text-gray-300 hover:text-yellow-400 transition" onclick="setRating('Main', 3)"><i class="fas fa-star"></i></button>
                    <button type="button" class="text-3xl text-gray-300 hover:text-yellow-400 transition" onclick="setRating('Main', 4)"><i class="fas fa-star"></i></button>
                    <button type="button" class="text-3xl text-gray-300 hover:text-yellow-400 transition" onclick="setRating('Main', 5)"><i class="fas fa-star"></i></button>
                </div>
                <input type="hidden" id="ratingMain" name="rating_main" required>
            </div>

            <!-- Sub Kategori -->
            <div class="space-y-3 bg-gray-50 rounded-xl p-4 border border-gray-100">
                <div class="flex items-center justify-between">
                    <span class="text-sm font-medium text-gray-700">Kebersihan</span>
                    <div class="flex gap-1" id="starContainerClean">
                        <button type="button" class="text-lg text-gray-300" onclick="setRating('Clean', 1)"><i class="fas fa-star"></i></button>
                        <button type="button" class="text-lg text-gray-300" onclick="setRating('Clean', 2)"><i class="fas fa-star"></i></button>
                        <button type="button" class="text-lg text-gray-300" onclick="setRating('Clean', 3)"><i class="fas fa-star"></i></button>
                        <button type="button" class="text-lg text-gray-300" onclick="setRating('Clean', 4)"><i class="fas fa-star"></i></button>
                        <button type="button" class="text-lg text-gray-300" onclick="setRating('Clean', 5)"><i class="fas fa-star"></i></button>
                    </div>
                    <input type="hidden" id="ratingClean" name="rating_clean">
                </div>
                
                <div class="flex items-center justify-between">
                    <span class="text-sm font-medium text-gray-700">Kondisi Lapangan</span>
                    <div class="flex gap-1" id="starContainerCondition">
                        <button type="button" class="text-lg text-gray-300" onclick="setRating('Condition', 1)"><i class="fas fa-star"></i></button>
                        <button type="button" class="text-lg text-gray-300" onclick="setRating('Condition', 2)"><i class="fas fa-star"></i></button>
                        <button type="button" class="text-lg text-gray-300" onclick="setRating('Condition', 3)"><i class="fas fa-star"></i></button>
                        <button type="button" class="text-lg text-gray-300" onclick="setRating('Condition', 4)"><i class="fas fa-star"></i></button>
                        <button type="button" class="text-lg text-gray-300" onclick="setRating('Condition', 5)"><i class="fas fa-star"></i></button>
                    </div>
                    <input type="hidden" id="ratingCondition" name="rating_condition">
                </div>

                <div class="flex items-center justify-between">
                    <span class="text-sm font-medium text-gray-700">Komunikasi</span>
                    <div class="flex gap-1" id="starContainerComms">
                        <button type="button" class="text-lg text-gray-300" onclick="setRating('Comms', 1)"><i class="fas fa-star"></i></button>
                        <button type="button" class="text-lg text-gray-300" onclick="setRating('Comms', 2)"><i class="fas fa-star"></i></button>
                        <button type="button" class="text-lg text-gray-300" onclick="setRating('Comms', 3)"><i class="fas fa-star"></i></button>
                        <button type="button" class="text-lg text-gray-300" onclick="setRating('Comms', 4)"><i class="fas fa-star"></i></button>
                        <button type="button" class="text-lg text-gray-300" onclick="setRating('Comms', 5)"><i class="fas fa-star"></i></button>
                    </div>
                    <input type="hidden" id="ratingComms" name="rating_comms">
                </div>
            </div>

            <!-- Komentar -->
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Tulis Ulasan (Opsional)</label>
                <textarea name="comment" rows="3" class="w-full border border-gray-200 rounded-xl p-3 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition" placeholder="Ceritakan pengalaman Anda bermain di sini..."></textarea>
            </div>

            <!-- Submit -->
            <button type="submit" class="w-full bg-emerald-600 text-white font-bold py-3 rounded-xl hover:bg-emerald-700 transition shadow-sm">
                Kirim Ulasan
            </button>
        </form>
    </div>
</div>

<!-- Modal E-Ticket / Kwitansi -->
<div id="receiptModal" class="fixed inset-0 z-[60] hidden bg-black/60 flex items-center justify-center p-4 backdrop-blur-sm">
    <div class="bg-white rounded-2xl w-full max-w-md shadow-2xl overflow-hidden transform transition-all border border-gray-100">
        
        <!-- Modal Header (Receipt Style) -->
        <div class="relative bg-[#1b3a1b] p-6 text-white text-center">
            <!-- Decorative circles -->
            <div class="absolute -bottom-3 -left-3 w-6 h-6 bg-white rounded-full"></div>
            <div class="absolute -bottom-3 -right-3 w-6 h-6 bg-white rounded-full"></div>
            
            <h2 class="text-2xl font-black tracking-tighter uppercase">ActiveHub</h2>
            <p class="text-emerald-100 text-sm mt-1">E-Ticket / Bukti Pemesanan</p>
            
            <button type="button" onclick="closeReceiptModal()" class="absolute top-4 right-4 w-8 h-8 bg-white/10 hover:bg-white/20 rounded-full flex items-center justify-center text-white transition-colors">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <!-- Modal Body (Receipt Style) -->
        <div class="p-6 relative">
            
            <div class="flex justify-between items-center border-b border-dashed border-gray-200 pb-4 mb-4">
                <div>
                    <p class="text-xs text-gray-500 font-bold uppercase tracking-wider">Order ID</p>
                    <p class="font-bold text-gray-800 text-lg" id="receiptOrderId">#0</p>
                </div>
                <div class="text-right">
                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">Tanggal Order</p>
                    <p class="font-semibold text-gray-700 text-sm" id="receiptOrderDate">-</p>
                </div>
            </div>

            <div class="space-y-4 mb-6">
                <div>
                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider mb-1">Detail Lapangan</p>
                    <p class="font-bold text-gray-800 text-base" id="receiptVenue">-</p>
                    <p class="text-sm text-gray-600" id="receiptField">-</p>
                    <p class="text-xs text-gray-500 mt-0.5" id="receiptCity">-</p>
                </div>

                <div class="bg-gray-50 rounded-xl p-4 border border-gray-100">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider mb-1">Tanggal Main</p>
                            <p class="font-bold text-[#1b3a1b] text-sm" id="receiptDate">-</p>
                        </div>
                        <div>
                            <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider mb-1">Pukul</p>
                            <p class="font-bold text-[#1b3a1b] text-sm" id="receiptTime">-</p>
                        </div>
                    </div>
                </div>
                
                <div class="flex justify-between items-center pt-2">
                    <p class="text-xs font-bold text-gray-500 uppercase tracking-wider">Total Lunas</p>
                    <p class="font-black text-gray-900 text-xl" id="receiptPrice">Rp 0</p>
                </div>
            </div>

            <a id="receiptDownloadBtn" href="#" target="_blank" class="w-full bg-[#1b3a1b] text-white font-bold py-3.5 rounded-xl hover:bg-[#285228] transition-all flex items-center justify-center gap-2 shadow-sm">
                <i class="fa-solid fa-download"></i> Download / Print Kwitansi
            </a>
            
        </div>
    </div>
</div>

@push('styles')
<link rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@endpush

@endsection