<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $venue->name }} - Detail Lapangan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"/>
</head>
<body class="bg-gray-50 min-h-screen">

<div class="px-10 py-8">

    <!-- Back Button -->
    <a href="/venues" class="inline-flex items-center text-[#1b3a1b] hover:text-[#2a5a2a] mb-6 font-medium">
        <i class="fas fa-arrow-left mr-2"></i> Kembali
    </a>

    <!-- Venue Header -->
    <div class="bg-white rounded-2xl overflow-hidden mb-8 shadow-sm border border-gray-100">
        @if($venue->photos && count($venue->photos) > 0)
        <!-- Photo Gallery (Grid) -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-1">
            @foreach(array_slice($venue->photos, 0, 3) as $index => $photo)
                <div class="relative h-64 w-full {{ $index === 0 && count($venue->photos) === 1 ? 'md:col-span-2 lg:col-span-3' : ($index === 0 && count($venue->photos) === 2 ? 'lg:col-span-2' : '') }}">
                    <img src="{{ $photo }}" class="w-full h-full object-cover">
                    @if($index === 2 && count($venue->photos) > 3)
                        <div class="absolute inset-0 bg-black/50 flex items-center justify-center text-white font-bold text-2xl cursor-pointer">
                            +{{ count($venue->photos) - 3 }} Foto
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
        @elseif($venue->photo_url)
        <!-- Single Photo -->
        <div class="relative h-64 w-full">
            <img src="{{ $venue->photo_url }}" class="w-full h-full object-cover">
        </div>
        @else
        <div class="relative h-64 bg-gradient-to-r from-[#1b3a1b] to-[#2a5a2a] flex items-center justify-center">
            <i class="fas fa-building text-white/20 text-8xl"></i>
        </div>
        @endif
        <div class="p-6 md:p-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">{{ $venue->name }}</h1>
            <p class="text-gray-500 text-sm mb-2">
                <i class="fas fa-map-marker-alt mr-1 text-[#1b3a1b]"></i> {{ $venue->location ?? 'Malang' }}
            </p>
            <div class="flex items-center gap-2 mb-6">
                <i class="fas fa-clock text-[#1b3a1b] text-sm"></i>
                <span class="text-gray-500 text-sm">{{ \Carbon\Carbon::parse($venue->open_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($venue->close_time)->format('H:i') }}</span>
            </div>

            <!-- TWO COLUMN LAYOUT -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

                <!-- KIRI: Deskripsi -->
                <div>
                    <div class="mb-5">
                        <h2 class="text-lg font-bold text-gray-800 mb-2">Deskripsi</h2>
                        <div class="relative">
                            <p id="desc-text" class="text-gray-600 leading-relaxed text-sm line-clamp-3 transition-all duration-300">
                                {{ $venue->description ?? 'Deskripsi venue belum tersedia.' }}
                            </p>
                            <button id="desc-btn" onclick="toggleReadMore('desc-text', 'desc-btn')" class="text-[#1b3a1b] text-sm font-semibold mt-1 hover:underline hidden">Selengkapnya...</button>
                        </div>
                    </div>

                    @if($venue->rules)
                    <hr class="border-gray-100 mb-5">
                    <div class="mb-5">
                        <h2 class="text-lg font-bold text-gray-800 mb-2">Peraturan</h2>
                        <div class="relative">
                            <div id="rules-text" class="text-gray-600 leading-relaxed text-sm whitespace-pre-line line-clamp-3 transition-all duration-300">{{ $venue->rules }}</div>
                            <button id="rules-btn" onclick="toggleReadMore('rules-text', 'rules-btn')" class="text-[#1b3a1b] text-sm font-semibold mt-1 hover:underline hidden">Selengkapnya...</button>
                        </div>
                    </div>
                    @endif
                </div>

                <!-- KANAN: Fasilitas + Map -->
                <div>
                    <div class="mb-5">
                        <h2 class="text-lg font-bold text-gray-800 mb-3">Fasilitas</h2>
                        <div class="grid grid-cols-2 gap-y-3 gap-x-4">
                            @if(is_array($venue->facilities))
                                @foreach($venue->facilities as $fac)
                                <div class="flex items-center gap-2 text-sm text-gray-600">
                                    <i class="fas fa-check-circle text-[#1b3a1b] w-4 text-center text-sm"></i> {{ $fac }}
                                </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                    <!-- Map -->
                    <div class="rounded-xl overflow-hidden border border-gray-100 h-44 bg-gray-50 flex items-center justify-center relative">
                        @if($venue->latitude && $venue->longitude)
                            <iframe width="100%" height="100%" frameborder="0" style="border:0; position:absolute; top:0; left:0;"
                                src="https://maps.google.com/maps?q={{ $venue->latitude }},{{ $venue->longitude }}&z=15&output=embed"
                                allowfullscreen>
                            </iframe>
                        @else
                            <div class="text-center text-gray-400">
                                <i class="fas fa-map-marker-alt text-2xl mb-1 block text-[#1b3a1b]"></i>
                                <p class="text-sm">Peta Lokasi</p>
                                <p class="text-xs">{{ $venue->location ?? 'Malang, Jawa Timur' }}</p>
                            </div>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Pilih Lapangan Section -->
    <div class="bg-white rounded-2xl overflow-hidden mb-8 shadow-sm border border-gray-100">
        <div class="p-6 md:p-8">
            <h2 class="text-xl font-bold text-gray-800 mb-5">Pilih Lapangan & Jadwal</h2>

            @if(session('success'))
            <div class="bg-[#f4f7f4] border border-[#d0e0d0] text-[#1b3a1b] px-4 py-3 rounded-xl mb-4">
                {{ session('success') }}
            </div>
            @endif

            @if($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl mb-4">
                {{ $errors->first() }}
            </div>
            @endif

            <!-- Tanggal Filter -->
            <div class="mb-6">
                <div class="flex items-center justify-between flex-wrap gap-3">
                    <div class="flex gap-2 flex-wrap">
                        @php
                            use Carbon\Carbon;
                            $today = Carbon::today();
                            $selectedDate = request('date', $today->format('Y-m-d'));
                        @endphp
                        @for($i=0; $i<7; $i++)
                            @php
                                $d = $today->copy()->addDays($i);
                                $dateStr = $d->format('Y-m-d');
                                $isActive = $dateStr === $selectedDate;
                            @endphp
                            <a href="?date={{ $dateStr }}" class="px-5 py-2.5 rounded-xl border text-sm text-center transition-colors {{ $isActive ? 'border-[#1b3a1b] bg-[#f4f7f4] text-[#1b3a1b] font-bold' : 'bg-white border-gray-200 text-gray-600 hover:bg-gray-50' }}">
                                {{ $d->translatedFormat('l') }}<br>
                                <span class="text-xs font-normal {{ $isActive ? 'text-[#1b3a1b]' : 'text-gray-400' }}">{{ $d->translatedFormat('d M') }}</span>
                            </a>
                        @endfor
                    </div>
                </div>
            </div>

            <!-- Daftar Lapangan -->
            <div class="space-y-4">
                @foreach($venue->fields as $idx => $field)
                <div class="border border-gray-100 rounded-2xl overflow-hidden shadow-sm">
                    <div class="flex items-center gap-4 p-4 cursor-pointer hover:bg-gray-50 transition" onclick="toggleField('field{{ $field->id }}', this)">
                        @if($field->photo_url)
                        <img src="{{ $field->photo_url }}" class="w-24 h-20 rounded-xl object-cover flex-shrink-0">
                        @else
                        <div class="w-24 h-20 bg-[#e8f0e8] rounded-xl flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-running text-[#1b3a1b] text-3xl"></i>
                        </div>
                        @endif
                        <div class="flex-1">
                            <h3 class="text-lg font-bold text-gray-800 mb-1">{{ $field->name }}</h3>
                            <div class="flex items-center gap-3 text-sm text-gray-500 mb-2">
                                <span class="flex items-center gap-1"><i class="fas fa-futbol text-gray-300"></i> {{ $field->sport_type }}</span>
                                <span class="flex items-center gap-1"><i class="fas fa-cloud-sun text-gray-300"></i> {{ $field->is_indoor ? 'Indoor' : 'Outdoor' }}</span>
                                <span class="flex items-center gap-1"><i class="fas fa-users text-gray-300"></i> {{ $field->capacity }} orang</span>
                            </div>
                            <span class="bg-[#f4f7f4] text-[#1b3a1b] border border-[#e8f0e8] text-xs font-semibold px-3 py-1 rounded-full inline-flex items-center gap-1">
                                {{ $field->timeSlots->count() }} Jadwal Tersedia <i class="fas fa-chevron-{{ $idx === 0 ? 'up' : 'down' }} text-[10px]" id="arrow-field{{ $field->id }}"></i>
                            </span>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-bold text-[#1b3a1b]">Rp {{ number_format($field->price_per_hour, 0, ',', '.') }}</p>
                            <p class="text-xs text-gray-400">/ jam</p>
                        </div>
                    </div>

                    <!-- Jadwal Grid -->
                    <div id="field{{ $field->id }}" class="field-schedules grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-3 px-4 pb-4 border-t border-gray-50 pt-4 bg-white" @style(["display: " . ($idx === 0 ? 'grid' : 'none')])>
                        @forelse($field->timeSlots->sortBy('start_time') as $slot)
                        @php
                            $st = Carbon::parse($slot->start_time);
                            $et = Carbon::parse($slot->end_time);
                        @endphp
                        <div class="schedule-card border border-gray-200 rounded-xl p-3 text-center cursor-pointer hover:border-[#1b3a1b] hover:bg-[#f4f7f4] transition"
                             data-slot-id="{{ $slot->id }}"
                             data-field="{{ $field->name }}"
                             data-sport="{{ $field->sport_type }}"
                             data-time="{{ $st->format('H:i') }}-{{ $et->format('H:i') }}"
                             data-price="{{ $field->price_per_hour }}"
                             onclick="selectSchedule(this)">
                            <p class="text-sm font-bold text-gray-800">{{ $st->format('H:i') }} - {{ $et->format('H:i') }}</p>
                            <p class="text-xs text-[#1b3a1b] font-medium mt-1">Rp {{ number_format($field->price_per_hour, 0, ',', '.') }}</p>
                        </div>
                        @empty
                        <div class="col-span-full text-center py-4 text-gray-500 text-sm">Tidak ada jadwal tersedia di tanggal ini.</div>
                        @endforelse
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Tombol Booking (muncul setelah pilih jadwal) -->
            <div id="bookingBar" class="hidden mt-6 bg-[#f4f7f4] border border-[#d0e0d0] rounded-xl p-4 flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Dipilih:</p>
                    <p class="font-bold text-gray-800" id="selectedInfo">-</p>
                </div>
                <form method="POST" action="{{ route('venues.book') }}">
                    @csrf
                    <input type="hidden" name="time_slot_id" id="selectedSlotId">
                    @if(auth()->check() && auth()->user()->role === 'owner')
                        <button type="button" onclick="alert('Maaf, Owner tidak bisa memesan lapangan.')"
                            class="bg-[#1b3a1b] text-white px-6 py-3 rounded-xl font-semibold text-sm shadow-sm opacity-50 cursor-not-allowed w-full md:w-auto text-center">
                            Pesan
                        </button>
                    @else
                        <button type="submit"
                            class="bg-[#1b3a1b] text-white px-6 py-3 rounded-xl font-semibold text-sm shadow-sm hover:bg-[#2a5a2a] transition w-full md:w-auto text-center">
                            Pesan
                        </button>
                    @endif
                </form>
            </div>

        </div>
    </div>

    <!-- ULASAN SECTION (DUMMY DATA) -->
    <div class="bg-white rounded-2xl p-6 md:p-8 mb-8 shadow-sm border border-gray-100">
        
        <!-- Header -->
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center gap-2">
                <div class="w-6 h-6 rounded-full bg-[#e8f0e8] flex items-center justify-center">
                    <i class="fas fa-play text-[#1b3a1b] text-[10px] ml-0.5"></i>
                </div>
                <h2 class="text-xl font-bold text-gray-800">Ulasan</h2>
            </div>
            <button onclick="document.getElementById('allReviewsModal').classList.remove('hidden')" class="text-[#1b3a1b] font-semibold text-sm hover:underline">Lihat semua ulasan</button>
        </div>

        <!-- Rating Summary -->
        <div class="flex items-end gap-3 mb-8">
            <div class="flex items-baseline">
                <span class="text-4xl font-extrabold text-gray-900 leading-none">{{ number_format($avgMain, 1) }}</span>
                <span class="text-gray-400 text-lg ml-1 font-medium">/5</span>
            </div>
            <div class="flex gap-1 text-yellow-400 text-xl mb-1">
                @for ($i = 1; $i <= 5; $i++)
                    @if ($i <= round($avgMain))
                        <i class="fas fa-star"></i>
                    @else
                        <i class="far fa-star text-gray-300"></i>
                    @endif
                @endfor
            </div>
            <div class="text-gray-400 text-sm mb-1.5 ml-2 font-medium">
                {{ $totalReviews }} ulasan
            </div>
        </div>

        <!-- Category Progress Bars -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
            <!-- Kebersihan -->
            <div>
                <div class="flex justify-between items-center mb-1.5">
                    <span class="text-sm font-semibold text-gray-700">Kebersihan</span>
                    <span class="text-sm font-bold text-gray-700">{{ number_format($avgClean, 2) }}</span>
                </div>
                <div class="w-full bg-gray-200 h-1.5 rounded-full overflow-hidden">
                    <div class="bg-[#1b3a1b] h-1.5 rounded-full" @style(["width: " . (($avgClean / 5) * 100) . "%"])></div>
                </div>
            </div>
            
            <!-- Kondisi Lapangan -->
            <div>
                <div class="flex justify-between items-center mb-1.5">
                    <span class="text-sm font-semibold text-gray-700">Kondisi Lapangan</span>
                    <span class="text-sm font-bold text-gray-700">{{ number_format($avgCondition, 2) }}</span>
                </div>
                <div class="w-full bg-gray-200 h-1.5 rounded-full overflow-hidden">
                    <div class="bg-[#1b3a1b] h-1.5 rounded-full" @style(["width: " . (($avgCondition / 5) * 100) . "%"])></div>
                </div>
            </div>

            <!-- Komunikasi -->
            <div>
                <div class="flex justify-between items-center mb-1.5">
                    <span class="text-sm font-semibold text-gray-700">Komunikasi</span>
                    <span class="text-sm font-bold text-gray-700">{{ number_format($avgComms, 2) }}</span>
                </div>
                <div class="w-full bg-gray-200 h-1.5 rounded-full overflow-hidden">
                    <div class="bg-[#1b3a1b] h-1.5 rounded-full" @style(["width: " . (($avgComms / 5) * 100) . "%"])></div>
                </div>
            </div>
        </div>

        <!-- Review Cards Container (Horizontal Scroll) -->
        <div class="relative group">
            
            <!-- Left/Right Nav Buttons -->
            <button onclick="document.getElementById('reviewsContainer').scrollBy({left: -1098, behavior: 'smooth'})" class="absolute -left-4 top-1/2 -translate-y-1/2 w-8 h-8 bg-white border border-gray-200 rounded-full shadow-sm flex items-center justify-center z-10 text-gray-500 hover:text-gray-800 hover:bg-gray-50 opacity-0 group-hover:opacity-100 transition-opacity">
                <i class="fas fa-chevron-left text-xs"></i>
            </button>
            <button onclick="document.getElementById('reviewsContainer').scrollBy({left: 1098, behavior: 'smooth'})" class="absolute -right-4 top-1/2 -translate-y-1/2 w-8 h-8 bg-white border border-gray-200 rounded-full shadow-sm flex items-center justify-center z-10 text-gray-500 hover:text-gray-800 hover:bg-gray-50 opacity-0 group-hover:opacity-100 transition-opacity">
                <i class="fas fa-chevron-right text-xs"></i>
            </button>
            <div id="reviewsContainer" class="flex overflow-x-auto gap-4 pb-4 snap-x snap-mandatory hide-scrollbar" style="scrollbar-width: none;">
                <style>.hide-scrollbar::-webkit-scrollbar { display: none; }</style>

                @forelse($venue->reviews as $review)
                <div class="snap-start shrink-0 w-[350px] border border-gray-100 rounded-2xl p-5 shadow-sm bg-white">
                    <div class="flex justify-between items-start mb-4">
                        <div class="flex items-center gap-3">
                            @php
                                $colors = ['bg-pink-400', 'bg-blue-500', 'bg-green-500', 'bg-orange-400', 'bg-teal-500', 'bg-indigo-500'];
                                $randomColor = $colors[strlen($review->user->name ?? 'A') % count($colors)];
                            @endphp
                            <div class="w-10 h-10 rounded-full {{ $randomColor }} text-white font-bold flex items-center justify-center text-sm uppercase">
                                {{ substr($review->user->name ?? 'A', 0, 2) }}
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-800 text-sm leading-tight">{{ $review->user->name ?? 'Pengguna' }}</h3>
                                <p class="text-[11px] text-gray-400">Diulas: {{ $review->created_at->translatedFormat('d F Y') }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-1 border border-gray-200 px-2 py-0.5 rounded text-xs font-bold text-gray-700">
                            <i class="fas fa-star text-yellow-400 text-[10px]"></i> {{ number_format($review->rating_main, 1) }}
                        </div>
                    </div>
                    <p class="text-sm text-gray-700 mb-2 leading-relaxed">
                        {{ $review->comment ?? 'Tidak ada komentar.' }}
                    </p>
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mt-4">{{ $review->field->sport_type ?? 'UMUM' }}</p>
                </div>
                @empty
                <div class="text-gray-500 text-sm py-4 px-2">Belum ada ulasan untuk venue ini.</div>
                @endforelse
            </div>
        </div>

    </div>

</div>

<!-- Modal Semua Ulasan -->
<div id="allReviewsModal" class="fixed inset-0 z-50 hidden bg-black/60 flex items-center justify-center p-4 backdrop-blur-sm">
    <div class="bg-white rounded-2xl w-full max-w-3xl max-h-[90vh] flex flex-col shadow-2xl">
        <!-- Modal Header -->
        <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-gray-50/50 rounded-t-2xl">
            <div>
                <h2 class="text-xl font-bold text-gray-800">Semua Ulasan</h2>
                <p class="text-sm text-gray-500 mt-1"><i class="fas fa-star text-yellow-400 mr-1"></i> {{ number_format($avgMain, 1) }} dari {{ $totalReviews }} ulasan</p>
            </div>
            <button onclick="document.getElementById('allReviewsModal').classList.add('hidden')" class="w-8 h-8 bg-white border border-gray-200 rounded-full flex items-center justify-center text-gray-500 hover:text-red-500 hover:border-red-200 hover:bg-red-50 transition-colors">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <!-- Modal Body (Scrollable List) -->
        <div class="p-6 overflow-y-auto flex-1 space-y-4 bg-gray-50">
            @forelse($venue->reviews as $review)
            <div class="border border-gray-100 rounded-2xl p-5 shadow-sm bg-white shadow-sm">
                <div class="flex justify-between items-start mb-4">
                    <div class="flex items-center gap-3">
                        @php
                            $colors = ['bg-pink-400', 'bg-blue-500', 'bg-green-500', 'bg-orange-400', 'bg-teal-500', 'bg-indigo-500'];
                            $randomColor = $colors[strlen($review->user->name ?? 'A') % count($colors)];
                        @endphp
                        <div class="w-10 h-10 rounded-full {{ $randomColor }} text-white font-bold flex items-center justify-center text-sm uppercase">
                            {{ substr($review->user->name ?? 'A', 0, 2) }}
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-800 text-sm leading-tight">{{ $review->user->name ?? 'Pengguna' }}</h3>
                            <p class="text-[11px] text-gray-400">Diulas: {{ $review->created_at->translatedFormat('d F Y') }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-1 border border-gray-200 px-2 py-0.5 rounded text-xs font-bold text-gray-700 bg-gray-50">
                        <i class="fas fa-star text-yellow-400 text-[10px]"></i> {{ number_format($review->rating_main, 1) }}
                    </div>
                </div>
                <p class="text-sm text-gray-700 mb-2 leading-relaxed">
                    {{ $review->comment ?? 'Tidak ada komentar.' }}
                </p>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mt-4">{{ $review->field->sport_type ?? 'UMUM' }}</p>
            </div>
            @empty
            <div class="text-gray-500 text-center py-8">Belum ada ulasan.</div>
            @endforelse
        </div>
    </div>
</div>

<script>
    let selectedSlot = null;

    function toggleField(id, header) {
        const panel = document.getElementById(id);
        const arrowId = 'arrow-' + id;
        const arrow = document.getElementById(arrowId);
        const isOpen = panel.style.display === 'grid';

        if (isOpen) {
            panel.style.display = 'none';
            if (arrow) { arrow.classList.remove('fa-chevron-up'); arrow.classList.add('fa-chevron-down'); }
        } else {
            panel.style.display = 'grid';
            if (arrow) { arrow.classList.remove('fa-chevron-down'); arrow.classList.add('fa-chevron-up'); }
        }
    }

    function selectSchedule(card) {
        // Reset all cards
        document.querySelectorAll('.schedule-card').forEach(c => {
            c.classList.remove('border-green-500', 'bg-green-50', 'selected');
            c.classList.add('border-gray-200');
        });

        // Highlight selected
        card.classList.add('border-green-500', 'bg-green-50', 'selected');
        card.classList.remove('border-gray-200');

        // Store selection
        const slotId = card.dataset.slotId;
        const field = card.dataset.field;
        const sport = card.dataset.sport;
        const time = card.dataset.time;
        const price = parseInt(card.dataset.price);

        document.getElementById('selectedSlotId').value = slotId;
        document.getElementById('selectedInfo').innerHTML =
            `${field} - ${sport} - ${time} - Rp ${price.toLocaleString('id-ID')}`;

        document.getElementById('bookingBar').classList.remove('hidden');
    }

    function initReadMore(textId, btnId) {
        const textEl = document.getElementById(textId);
        const btnEl = document.getElementById(btnId);
        if(textEl && btnEl) {
            // Check if text exceeds line clamp height
            if(textEl.scrollHeight > textEl.clientHeight) {
                btnEl.classList.remove('hidden');
            }
        }
    }

    function toggleReadMore(textId, btnId) {
        const textEl = document.getElementById(textId);
        const btnEl = document.getElementById(btnId);
        if(textEl.classList.contains('line-clamp-3')) {
            textEl.classList.remove('line-clamp-3');
            btnEl.innerText = 'Sembunyikan';
        } else {
            textEl.classList.add('line-clamp-3');
            btnEl.innerText = 'Selengkapnya...';
        }
    }

    document.addEventListener("DOMContentLoaded", function() {
        initReadMore('desc-text', 'desc-btn');
        initReadMore('rules-text', 'rules-btn');
    });
</script>

</body>
</html>


