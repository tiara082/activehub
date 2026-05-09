<!DOCTYPE html>
<html lang="id">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $venue->name }} - Detail Lapangan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"/>
</head>
<body class="bg-gray-100 min-h-screen">

<div class="px-10 py-8">

    <!-- Back Button -->
    <a href="/venues" class="inline-flex items-center text-[#1b3a1b] hover:text-[#2a5a2a] mb-6">
        <i class="fas fa-arrow-left mr-2"></i> Kembali 
    </a>

    <!-- Venue Header -->
    <div class="bg-white rounded-xl overflow-hidden mb-8">
        <div class="relative h-64 bg-gradient-to-r bg-[#1b3a1b] flex items-center justify-center">
            <i class="text-white text-8xl"></i>
        </div>
        <div class="p-6">
            <h1 class="text-3xl font-bold text-gray-800 mb-1">{{ $venue->name }}</h1>
            <div class="flex items-center gap-2 mb-5">
                <i class="fas fa-clock text-green-600 text-sm"></i>
                <span class="text-gray-500 text-sm">07:00 – 22:00</span>
            </div>

            <!-- TWO COLUMN LAYOUT -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

                <!-- KIRI: Deskripsi + Aturan -->
                <div>
                    <div class="mb-5">
                        <h2 class="text-lg font-bold text-gray-800 mb-2">Deskripsi</h2>
                        <p class="text-gray-600 leading-relaxed text-sm">
                            Samator Tennis Court merupakan lapangan tennis indoor tertutup dengan lantai khusus tenis
                            yang mendukung pergerakan cepat dan aman. Area ini memiliki pencahayaan buatan yang stabil,
                            dinding pelindung, serta ruang yang cukup luas untuk aktivitas bermain. Lapangan ini
                            memungkinkan permainan tenis dilakukan kapan saja tanpa terpengaruh kondisi cuaca.
                        </p>
                    </div>
                    <hr class="border-gray-200 mb-5">
                    <div>
                        <h2 class="text-lg font-bold text-gray-800 mb-2">Aturan Venue</h2>
                        <ul class="text-gray-600 text-sm space-y-1.5">
                            <li class="flex items-start gap-2"><span class="text-green-600 font-bold">1.</span> Gunakan sepatu olahraga khusus tennis</li>
                            <li class="flex items-start gap-2"><span class="text-green-600 font-bold">2.</span> Dilarang membawa minuman keras, narkoba</li>
                            <li class="flex items-start gap-2"><span class="text-green-600 font-bold">3.</span> Lapangan buka mulai pukul 06.00–22.00...</li>
                        </ul>
                        <button class="text-green-600 text-sm font-semibold mt-2 hover:text-green-700">Baca Selengkapnya →</button>
                    </div>
                </div>

                <!-- KANAN: Fasilitas + Map -->
                <div>
                    <div class="mb-5">
                        <h2 class="text-lg font-bold text-gray-800 mb-3">Fasilitas</h2>
                        <div class="grid grid-cols-2 gap-y-2 gap-x-4">
                            <div class="flex items-center gap-2 text-sm text-gray-600">
                                <i class="fas fa-motorcycle text-[#1b3a1b] w-4 text-center text-sm"></i> Parkir Motor
                            </div>
                            <div class="flex items-center gap-2 text-sm text-gray-600">
                                <i class="fas fa-shower text-[#1b3a1b] w-4 text-center text-sm"></i> Shower
                            </div>
                            <div class="flex items-center gap-2 text-sm text-gray-600">
                                <i class="fas fa-car text-[#1b3a1b] w-4 text-center text-sm"></i> Parkir Mobil
                            </div>
                            <div class="flex items-center gap-2 text-sm text-gray-600">
                                <i class="fas fa-toilet text-[#1b3a1b] w-4 text-center text-sm"></i> Toilet
                            </div>
                            <div class="flex items-center gap-2 text-sm text-gray-600">
                                <i class="fas fa-utensils text-[#1b3a1b] w-4 text-center text-sm"></i> Kantin
                            </div>
                            <div class="flex items-center gap-2 text-sm text-gray-600">
                                <i class="fas fa-mosque text-[#1b3a1b] w-4 text-center text-sm"></i> Mushola
                            </div>
                        </div>
                    </div>
                    <!-- Map -->
                    <div class="rounded-xl overflow-hidden border border-gray-200 h-44 bg-gray-100 flex items-center justify-center">
                        <div class="text-center text-gray-400">
                            <i class="fas fa-map-marker-alt text-2xl mb-1 block text-[#1b3a1b]"></i>
                            <p class="text-sm">Peta Lokasi</p>
                            <p class="text-xs">{{ $venue->location ?? 'Malang, Jawa Timur' }}</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Pilih Lapangan Section -->
    <div class="bg-white rounded-xl overflow-hidden mb-8">
        <div class="p-6">
            <h2 class="text-xl font-bold text-gray-800 mb-5">Pilih Lapangan</h2>

            <!-- Tanggal Filter -->
            <div class="mb-6">
                <div class="flex items-center justify-between flex-wrap gap-3">
                    <div class="flex gap-2 flex-wrap ">
                        <button onclick="selectDay(this)" class="day-btn active px-5 py-2.5 rounded-lg border border-green-500 text-sm bg-gray-100 text-gray-600 hover:bg-gray-200">Senin<br><span class="text-xs font-normal">13 Apr</span></button>
                        <button onclick="selectDay(this)" class="day-btn px-5 py-2.5 rounded-lg border text-sm bg-gray-100 text-gray-600 hover:bg-gray-200">Selasa<br><span class="text-xs font-normal">14 Apr</span></button>
                        <button onclick="selectDay(this)" class="day-btn px-5 py-2.5 rounded-lg border text-sm bg-gray-100 text-gray-600 hover:bg-gray-200">Rabu<br><span class="text-xs font-normal">15 Apr</span></button>
                        <button onclick="selectDay(this)" class="day-btn px-5 py-2.5 rounded-lg border text-sm bg-gray-100 text-gray-600 hover:bg-gray-200">Kamis<br><span class="text-xs font-normal">16 Apr</span></button>
                        <button onclick="selectDay(this)" class="day-btn px-5 py-2.5 rounded-lg border text-sm bg-gray-100 text-gray-600 hover:bg-gray-200">Jumat<br><span class="text-xs font-normal">17 Apr</span></button>
                        <button onclick="selectDay(this)" class="day-btn px-5 py-2.5 rounded-lg border text-sm bg-gray-100 text-gray-600 hover:bg-gray-200">Sabtu<br><span class="text-xs font-normal">18 Apr</span></button>
                        <button onclick="selectDay(this)" class="day-btn px-5 py-2.5 rounded-lg text-sm bg-gray-100 text-gray-600 hover:bg-gray-200">Minggu<br><span class="text-xs font-normal">19 Apr</span></button>
                    </div>
                    <div class="flex gap-2">
                        <button class="px-4 py-2 rounded-lg text-sm border border-gray-300 text-gray-600 hover:bg-gray-50">
                            <i class="fas fa-filter mr-1"></i> Filter Waktu
                        </button>
                        <button class="px-4 py-2 rounded-lg text-sm border border-gray-300 text-gray-600 hover:bg-gray-50">
                            <i class="fas fa-calendar-alt mr-1"></i> Cari
                        </button>
                    </div>
                </div>
            </div>

            <!-- Daftar Lapangan -->
            <div class="space-y-4">

                <!-- Lapangan 1 -->
                <div class="border border-gray-200 rounded-xl overflow-hidden">
                    <div class="flex items-center gap-4 p-4 cursor-pointer hover:bg-gray-50 transition" onclick="toggleField('field1', this)">
                        <!-- Thumbnail -->
                        <div class="w-28 h-20 bg-green-800 rounded-lg flex items-center justify-center flex-shrink-0">
                            <i class=" text-white text-3xl"></i>
                        </div>
                        <!-- Info -->
                        <div class="flex-1">
                            <h3 class="text-lg font-bold text-gray-800 mb-1">Lapangan 1</h3>
                            <div class="flex items-center gap-3 text-sm text-gray-500 mb-2">
                                <span class="flex items-center gap-1"><i class="fas fa-tennis-ball text-gray-400 text-xs"></i> Tennis</span>
                                <span class="flex items-center gap-1"><i class="fas fa-expand-arrows-alt text-gray-400 text-xs"></i> Outdoor</span>
                            </div>
                            <button class="bg-yellow-500 text-white text-xs font-semibold px-4 py-1.5 rounded-full flex items-center gap-1">
                                2 Jadwal Tersedia <i class="fas fa-chevron-up text-xs" id="arrow-field1"></i>
                            </button>
                        </div>
                    </div>
                    <!-- Jadwal Grid -->
<div id="field1" class="field-schedules open grid-cols-2 md:grid-cols-4 gap-3 px-4 pb-4 border-t border-gray-100 pt-4">

    <div class="schedule-card border border-gray-200 rounded-xl p-3 text-center cursor-pointer hover:border-green-400 transition"
         onclick="selectSchedule(this)">
        <p class="text-xs text-gray-400 mb-0.5">60 menit</p>
        <p class="text-sm font-bold text-gray-800">08:00 - 09:00</p>
        <p class="text-xs text-gray-500 mt-0.5">Rp 100.000</p>
    </div>

    <div class="schedule-card border border-gray-200 rounded-xl p-3 text-center cursor-pointer hover:border-green-400 transition"
         onclick="selectSchedule(this)">
        <p class="text-xs text-gray-400 mb-0.5">60 menit</p>
        <p class="text-sm font-bold text-gray-800">09:00 - 10:00</p>
        <p class="text-xs text-gray-500 mt-0.5">Rp 100.000</p>
    </div>

    <div class="schedule-card border border-gray-200 rounded-xl p-3 text-center cursor-pointer hover:border-green-400 transition"
         onclick="selectSchedule(this)">
        <p class="text-xs text-gray-400 mb-0.5">60 menit</p>
        <p class="text-sm font-bold text-gray-800">10:00 - 11:00</p>
        <p class="text-xs text-gray-500 mt-0.5">Rp 100.000</p>
    </div>

    <div class="schedule-card border border-gray-200 rounded-xl p-3 text-center cursor-pointer hover:border-green-400 transition"
         onclick="selectSchedule(this)">
        <p class="text-xs text-gray-400 mb-0.5">60 menit</p>
        <p class="text-sm font-bold text-gray-800">11:00 - 12:00</p>
        <p class="text-xs text-gray-500 mt-0.5">Rp 50.000</p>
    </div>

<!-- BUTTON BOOKING -->
<div class="col-span-full flex justify-end pt-2">

    <a href="{{ route('payment.index') }}"
       id="bookingButton"
       class="inline-flex justify-center items-center
              bg-gray-300 text-white text-sm font-semibold
              px-5 py-2.5 rounded-lg
              cursor-not-allowed pointer-events-none transition">

        Booking Sekarang

    </a>

</div>
</div>
                <!-- Lapangan 2 -->
                <div class="border border-gray-200 rounded-xl overflow-hidden">
                    <div class="flex items-center gap-4 p-4 cursor-pointer hover:bg-gray-50 transition" onclick="toggleField('field2', this)">
                        <div class="w-28 h-20 bg-green-800 rounded-lg flex items-center justify-center flex-shrink-0">
                            <i class="text-white text-3xl"></i>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-lg font-bold text-gray-800 mb-1">Lapangan 2</h3>
                            <div class="flex items-center gap-3 text-sm text-gray-500 mb-2">
                                <span class="flex items-center gap-1"><i class="fas fa-tennis-ball text-gray-400 text-xs"></i> Tennis</span>
                                <span class="flex items-center gap-1"><i class="fas fa-expand-arrows-alt text-gray-400 text-xs"></i> Outdoor</span>
                            </div>
                            <button class="bg-yellow-500 text-white text-xs font-semibold px-4 py-1.5 rounded-full flex items-center gap-1">
                                6 Jadwal Tersedia <i class="fas fa-chevron-down text-xs" id="arrow-field2"></i>
                            </button>
                        </div>
                    </div>
                    <!-- Jadwal Grid (hidden by default) -->
                    <div id="field2" class="field-schedules grid-cols-2 md:grid-cols-4 gap-3 px-4 pb-4 border-t border-gray-100 pt-4">
                        <div class="schedule-card border border-gray-200 rounded-xl p-3 text-center cursor-pointer hover:border-green-400" onclick="selectSchedule(this)">
                            <p class="text-xs text-gray-400 mb-0.5">60 menit</p>
                            <p class="text-sm font-bold text-gray-800">12:00 - 13:00</p>
                            <p class="text-xs text-gray-500 mt-0.5">Rp 50.000</p>
                        </div>
                        <div class="schedule-card border border-gray-200 rounded-xl p-3 text-center cursor-pointer hover:border-green-400" onclick="selectSchedule(this)">
                            <p class="text-xs text-gray-400 mb-0.5">60 menit</p>
                            <p class="text-sm font-bold text-gray-800">13:00 - 14:00</p>
                            <p class="text-xs text-gray-500 mt-0.5">Rp 50.000</p>
                        </div>
                        <div class="schedule-card border border-gray-200 rounded-xl p-3 text-center cursor-pointer hover:border-green-400" onclick="selectSchedule(this)">
                            <p class="text-xs text-gray-400 mb-0.5">60 menit</p>
                            <p class="text-sm font-bold text-gray-800">14:00 - 15:00</p>
                            <p class="text-xs text-gray-500 mt-0.5">Rp 50.000</p>
                        </div>
                        <div class="schedule-card border border-gray-200 rounded-xl p-3 text-center cursor-pointer hover:border-green-400" onclick="selectSchedule(this)">
                            <p class="text-xs text-gray-400 mb-0.5">60 menit</p>
                            <p class="text-sm font-bold text-gray-800">15:00 - 16:00</p>
                            <p class="text-xs text-gray-500 mt-0.5">Rp 100.000</p>
                        </div>
                        <div class="schedule-card border border-gray-200 rounded-xl p-3 text-center cursor-pointer hover:border-green-400" onclick="selectSchedule(this)">
                            <p class="text-xs text-gray-400 mb-0.5">60 menit</p>
                            <p class="text-sm font-bold text-gray-800">16:00 - 17:00</p>
                            <p class="text-xs text-gray-500 mt-0.5">Rp 100.000</p>
                        </div>
                        <div class="schedule-card border border-gray-200 rounded-xl p-3 text-center cursor-pointer hover:border-green-400" onclick="selectSchedule(this)">
                            <p class="text-xs text-gray-400 mb-0.5">60 menit</p>
                            <p class="text-sm font-bold text-gray-800">17:00 - 18:00</p>
                            <p class="text-xs text-gray-500 mt-0.5">Rp 100.000</p>
                        </div>
                        <div class="schedule-card border border-gray-200 rounded-xl p-3 text-center cursor-pointer hover:border-green-400" onclick="selectSchedule(this)">
                            <p class="text-xs text-gray-400 mb-0.5">60 menit</p>
                            <p class="text-sm font-bold text-gray-800">18:00 - 19:00</p>
                            <p class="text-xs text-gray-500 mt-0.5">Rp 100.000</p>
                        </div>
                        <div class="schedule-card border border-gray-200 rounded-xl p-3 text-center cursor-pointer hover:border-green-400" onclick="selectSchedule(this)">
                            <p class="text-xs text-gray-400 mb-0.5">60 menit</p>
                            <p class="text-sm font-bold text-gray-800">19:00 - 20:00</p>
                            <p class="text-xs text-gray-500 mt-0.5">Rp 100.000</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

</div>

<script>
    function selectDay(btn) {
        document.querySelectorAll('.day-btn').forEach(b => {
            b.classList.remove('active');
            b.classList.add('bg-gray-100', 'text-gray-600');
            b.classList.remove('bg-white', 'text-[#1c3a0c]');
        });
        btn.classList.add('active');
        btn.classList.remove('bg-gray-100', 'text-gray-600');
        btn.classList.add('bg-white', 'text-[#1c3a0c]');
    }

    function toggleField(id, header) {
        const panel = document.getElementById(id);
        const arrowId = 'arrow-' + id;
        const arrow = document.getElementById(arrowId);
        const isOpen = panel.classList.contains('open');
        if (isOpen) {
            panel.classList.remove('open');
            panel.style.display = 'none';
            if (arrow) { arrow.classList.remove('fa-chevron-up'); arrow.classList.add('fa-chevron-down'); }
        } else {
            panel.classList.add('open');
            panel.style.display = 'grid';
            if (arrow) { arrow.classList.remove('fa-chevron-down'); arrow.classList.add('fa-chevron-up'); }
        }
    }

   function selectSchedule(card) {

    const parent = card.closest('.field-schedules');

    parent.querySelectorAll('.schedule-card').forEach(c => {
        c.classList.remove('border-green-500', 'bg-green-50');
        c.classList.add('border-gray-200');
    });

    // active selected card
    card.classList.add('border-green-500', 'bg-green-50');
    card.classList.remove('border-gray-200');

    // ACTIVE BUTTON BOOKING
    const bookingButton = document.getElementById('bookingButton');

    bookingButton.classList.remove(
        'bg-gray-300',
        'cursor-not-allowed',
        'pointer-events-none'
    );

    bookingButton.classList.add(
        'bg-[#0b3d0b]',
        'hover:bg-[#145214]'
    );
}

    // Init: show field1, hide field2
    document.getElementById('field1').style.display = 'grid';
    document.getElementById('field2').style.display = 'none';
</script>

</body>
</html>