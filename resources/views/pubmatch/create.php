<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Public Match</title>

    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=DM+Sans:wght@400;500;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-[#f6f7f6]" style="font-family:'DM Sans',sans-serif;">

<div class="bg-[#123012] py-12 text-center shadow-md">
    <h1 class="text-white tracking-widest"
        style="font-family:'Bebas Neue'; font-size:clamp(2.2rem,6vw,3.6rem); letter-spacing:6px;">
        BUAT PUBLIC MATCH
    </h1>
</div>

<div class="max-w-4xl mx-auto px-6 py-10">

    <div class="grid grid-cols-2 rounded-xl overflow-hidden shadow-md mb-10">
        <button id="tab-lapangan"
            onclick="switchTab('lapangan')"
            class="py-3 text-white font-semibold transition bg-[#123012]">
            Detail Lapangan
        </button>

        <button id="tab-match"
            onclick="switchTab('match')"
            class="py-3 text-white font-semibold transition bg-gray-400">
            Detail Match
        </button>
    </div>

    <div class="bg-white rounded-2xl shadow-md p-8">

        <div id="section-lapangan">

            <div class="space-y-5">

                <div>
                    <label class="text-sm font-medium">Nama Venue</label>
                    <input
                        value="{{ $booking?->field?->venue?->name }}"
                        class="w-full border rounded-lg p-3 mt-1">
                </div>

                <div>
                    <label class="text-sm font-medium">Nama Lapangan</label>
                    <input
                        value="{{ $booking?->field?->name }}"
                        class="w-full border rounded-lg p-3 mt-1">
                </div>

                <div>
                    <label class="text-sm font-medium">Jenis Olahraga</label>
                    <input
                        value="{{ $booking?->field?->sport?->name }}"
                        class="w-full border rounded-lg p-3 mt-1 focus:ring-2 focus:ring-[#123012] outline-none">
                </div>

                <div class="grid md:grid-cols-2 gap-4">
                    <div>
                        <label class="text-sm font-medium">Tanggal</label>
                        <input
                            value="{{ $booking?->date }}"
                            type="date"
                            class="w-full border rounded-lg p-3 mt-1">
                    </div>

                    <div>
                        <label class="text-sm font-medium">Jam</label>
                        <input
                            value="{{ $booking?->time }}"
                            type="time"
                            class="w-full border rounded-lg p-3 mt-1">
                    </div>
                </div>

                <div>
                    <label class="text-sm font-medium">Lokasi</label>

                    <div class="grid md:grid-cols-2 gap-4 mt-2">
                        <textarea class="w-full border rounded-lg p-3 h-28 focus:ring-2 focus:ring-[#123012] outline-none"></textarea>

                        <div class="rounded-lg overflow-hidden border"></div>
                    </div>
                </div>

                <div>
                    <label class="text-sm font-medium">Harga Total</label>
                    <input class="w-full border rounded-lg p-3 mt-1">
                </div>

                <div class="flex justify-end pt-6">
                    <button onclick="switchTab('match')"
                        class="bg-[#123012] text-white px-6 py-2.5 rounded-lg text-sm font-semibold shadow-sm hover:shadow-md hover:scale-[1.01] transition">
                        Next →
                    </button>
                </div>

            </div>
        </div>

        <div id="section-match" class="hidden">

            <div class="space-y-5">
                <div>
                    <label class="text-sm font-medium">
                        Title <span class="text-red-500">*</span>
                    </label>
                     <input class="w-full border rounded-lg p-3 mt-1 outline-none">
                </div>

                <div>
                    <label class="text-sm font-medium">
                        Deskripsi <span class="text-red-500">*</span>
                    </label>
                    <textarea required class="w-full border rounded-lg p-3 h-28 mt-1"></textarea>
                </div>

                <div>
                    <label class="text-sm font-medium">
                        Jumlah Slot <span class="text-red-500">*</span>
                    </label>

                    <div class="relative mt-1">
                        <input id="jumlah_slot" type="number" min="1" required
                            class="w-full border rounded-lg p-3 pr-16">

                        <div class="absolute right-3 top-2 flex gap-2">
                            <button type="button" onclick="stepperChange(1)"
                                class="px-2 py-1 bg-gray-200 rounded-md hover:bg-gray-300 text-sm">+</button>
                            <button type="button" onclick="stepperChange(-1)"
                                class="px-2 py-1 bg-gray-200 rounded-md hover:bg-gray-300 text-sm">−</button>
                        </div>
                    </div>
                </div>

                <div>
                    <label class="text-sm font-medium">
                        Gender <span class="text-red-500">*</span>
                    </label>

                    <div class="relative mt-1">
                        <button type="button" onclick="toggleDropdown()"
                            class="w-full border rounded-lg p-3 flex justify-between items-center bg-white shadow-sm hover:border-[#123012] transition">
                            <span id="genderText">Bebas</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2"
                                 viewBox="0 0 24 24">
                                <path d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>

                        <div id="genderDropdown"
                            class="hidden absolute w-full mt-2 bg-white border rounded-lg shadow-lg overflow-hidden z-10">

                            <div onclick="selectGender('Bebas')"
                                class="px-4 py-2 hover:bg-[#f2f6f2] cursor-pointer">Bebas</div>

                            <div onclick="selectGender('Pria')"
                                class="px-4 py-2 hover:bg-[#f2f6f2] cursor-pointer">Pria</div>

                            <div onclick="selectGender('Wanita')"
                                class="px-4 py-2 hover:bg-[#f2f6f2] cursor-pointer">Wanita</div>
                        </div>
                    </div>
                </div>

                <div class="grid md:grid-cols-2 gap-4">
                    <div>
                        <label class="text-sm font-medium">
                            Harga Total <span class="text-red-500">*</span>
                        </label>
                        <input required class="w-full border rounded-lg p-3 mt-1">
                    </div>

                    <div>
                        <label class="text-sm font-medium">
                            Harga per Orang <span class="text-red-500">*</span>
                        </label>
                        <input required class="w-full border rounded-lg p-3 mt-1">
                    </div>
                </div>

                <div>
                    <label class="text-sm font-medium">
                        Metode Pembayaran <span class="text-red-500">*</span>
                    </label>
                    <textarea required class="w-full border rounded-lg p-3 h-24 mt-1"></textarea>
                </div>

                <div class="flex justify-between pt-6">
                    <button onclick="switchTab('lapangan')"
                        class="text-gray-500 hover:text-black text-sm font-medium transition">
                        ← Back
                    </button>

                    <button type="button"
                        class="bg-yellow-400 text-black px-6 py-2.5 rounded-lg text-sm font-bold shadow-sm hover:shadow-md hover:scale-[1.01] transition">
                        Publish
                    </button>
                </div>

            </div>
        </div>

    </div>
</div>

<script>
function switchTab(tab) {
    const lap = document.getElementById('section-lapangan');
    const match = document.getElementById('section-match');

    const tabLap = document.getElementById('tab-lapangan');
    const tabMatch = document.getElementById('tab-match');

    tabLap.className = "py-3 text-white font-semibold transition bg-gray-400";
    tabMatch.className = "py-3 text-white font-semibold transition bg-gray-400";

    if (tab === 'lapangan') {
        lap.classList.remove('hidden');
        match.classList.add('hidden');
        tabLap.className = "py-3 text-white font-semibold transition bg-[#123012]";
    } else {
        match.classList.remove('hidden');
        lap.classList.add('hidden');
        tabMatch.className = "py-3 text-white font-semibold transition bg-[#123012]";
    }

    closeDropdown();
}

function stepperChange(delta) {
    const input = document.getElementById('jumlah_slot');
    let val = parseInt(input.value) || 1;
    val += delta;
    if (val < 1) val = 1;
    input.value = val;
}

function toggleDropdown() {
    document.getElementById('genderDropdown').classList.toggle('hidden');
}

function selectGender(value) {
    document.getElementById('genderText').innerText = value;
    closeDropdown();
}

function closeDropdown() {
    document.getElementById('genderDropdown').classList.add('hidden');
}

document.addEventListener('click', function(e) {
    const dropdown = document.getElementById('genderDropdown');
    const button = e.target.closest('button');

    if (!button || !button.onclick) {
        if (!e.target.closest('#genderDropdown')) {
            dropdown.classList.add('hidden');
        }
    }
});
</script>

</body>
</html>