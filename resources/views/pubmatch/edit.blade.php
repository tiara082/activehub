<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Permainan</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=DM+Sans:wght@400;500;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-[#f6f7f6]" style="font-family:'DM Sans',sans-serif;">

<div class="bg-[#123012] py-12 text-center shadow-md">
    <h1 class="text-white tracking-widest"
        style="font-family:'Bebas Neue'; font-size:clamp(2.2rem,6vw,3.6rem); letter-spacing:6px;">
        EDIT PERMAINAN
    </h1>
</div>

@php $booking = $match->booking; @endphp
<form id="matchForm" class="max-w-4xl mx-auto px-6 py-10" method="POST" action="{{ route('matches.update', $match->id) }}" enctype="multipart/form-data">

    @csrf
    @method('PUT')

    <div class="grid grid-cols-2 rounded-xl overflow-hidden shadow-md mb-10">
        <button type="button" id="tab-lapangan"
            onclick="switchTab('lapangan')"
            class="py-3 text-white font-semibold transition bg-[#123012]">
            Detail Lapangan
        </button>

        <button type="button" id="tab-match"
            onclick="switchTab('match')"
            class="py-3 text-white font-semibold transition bg-gray-400">
            Detail Permainan
        </button>
    </div>

    <div class="bg-white rounded-2xl shadow-md p-8">

        {{-- ============ TAB LAPANGAN ============ --}}
        <div id="section-lapangan">
            <div class="space-y-5">

                <div>
                    <label class="text-sm font-medium">Nama Venue</label>
                    <input readonly
                        value="{{ $booking->field->venue->name ?? '-' }}"
                        class="w-full border rounded-lg p-3 mt-1 bg-gray-50 text-gray-700">
                </div>

                <div>
                    <label class="text-sm font-medium">Nama Lapangan</label>
                    <input readonly
                        value="{{ $booking->field->name ?? '-' }}"
                        class="w-full border rounded-lg p-3 mt-1 bg-gray-50 text-gray-700">
                </div>

                <div>
                    <label class="text-sm font-medium">Jenis Olahraga</label>
                    <input readonly
                        value="{{ $booking->field->sport_type ?? '-' }}"
                        class="w-full border rounded-lg p-3 mt-1 bg-gray-50 text-gray-700">
                </div>

                <div class="grid md:grid-cols-2 gap-4">
                    <div>
                        <label class="text-sm font-medium">Tanggal</label>
                        <input readonly
                            value="{{ $booking->timeSlot ? $booking->timeSlot->date->format('Y-m-d') : '-' }}"
                            type="date"
                            class="w-full border rounded-lg p-3 mt-1 bg-gray-50 text-gray-700">
                    </div>

                    <div>
                        <label class="text-sm font-medium">Jam</label>
                        <input readonly
                            value="{{ $booking->timeSlot ? \Carbon\Carbon::parse($booking->timeSlot->start_time)->format('H:i') . ' - ' . \Carbon\Carbon::parse($booking->timeSlot->end_time)->format('H:i') : '-' }}"
                            class="w-full border rounded-lg p-3 mt-1 bg-gray-50 text-gray-700">
                    </div>
                </div>

                <div class="grid md:grid-cols-2 gap-4">
                    <div>
                        <label class="text-sm font-medium">Tipe Lapangan</label>
                        <input readonly
                            value="{{ ($booking->field->is_indoor ?? false) ? 'Indoor' : 'Outdoor' }}"
                            class="w-full border rounded-lg p-3 mt-1 bg-gray-50 text-gray-700">
                    </div>

                    <div>
                        <label class="text-sm font-medium">Kapasitas</label>
                        <input readonly
                            value="{{ $booking->field->capacity ?? '-' }} orang"
                            class="w-full border rounded-lg p-3 mt-1 bg-gray-50 text-gray-700">
                    </div>
                </div>

                <div>
                    <label class="text-sm font-medium">Harga Lapangan</label>
                    <input readonly id="fieldPrice"
                        value="{{ $booking->field->price_per_hour ?? 0 }}"
                        class="hidden">
                    <input readonly
                        value="Rp {{ number_format($booking->field->price_per_hour ?? 0, 0, ',', '.') }} / jam"
                        class="w-full border rounded-lg p-3 mt-1 bg-gray-50 text-gray-700 font-semibold">
                </div>

                <div class="flex justify-end pt-6">
                    <button type="button" onclick="switchTab('match')"
                        class="bg-[#123012] text-white px-6 py-2.5 rounded-lg text-sm font-semibold shadow-sm hover:shadow-md hover:scale-[1.01] transition">
                        Lanjut →
                    </button>
                </div>

            </div>
        </div>

        {{-- ============ TAB MATCH ============ --}}
        <div id="section-match" class="hidden">

            <div class="space-y-5">

                {{-- Ringkasan lapangan --}}
                <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-2">
                    <p class="text-sm text-green-800">
                        <strong>{{ $booking->field->venue->name ?? '' }}</strong> &mdash;
                        {{ $booking->field->name ?? '' }} &mdash;
                        {{ $booking->field->sport_type ?? '' }}
                        &middot;
                        {{ $booking->timeSlot && $booking->timeSlot->date ? $booking->timeSlot->date->format('d M Y') : '' }}
                        ({{ $booking->timeSlot ? \Carbon\Carbon::parse($booking->timeSlot->start_time)->format('H:i') . ' - ' . \Carbon\Carbon::parse($booking->timeSlot->end_time)->format('H:i') : '' }})
                    </p>
                </div>

                <div>
                    <label class="text-sm font-medium">
                        Judul Permainan <span class="text-red-500">*</span>
                    </label>
                    <input name="title" required value="{{ $match->title }}"
                        placeholder="Contoh: Futsal Santai Minggu Sore"
                        class="w-full border rounded-lg p-3 mt-1 outline-none focus:ring-2 focus:ring-[#123012]">
                </div>

                <div>
                    <label class="text-sm font-medium">
                        Deskripsi <span class="text-red-500">*</span>
                    </label>
                    <textarea name="description" required
                        placeholder="Jelaskan siapa yang kamu cari, level permainan, dll."
                        class="w-full border rounded-lg p-3 h-28 mt-1 outline-none focus:ring-2 focus:ring-[#123012]">{{ $match->description }}</textarea>
                </div>

                <div>
                    <label class="text-sm font-medium">Foto (Opsional)</label>
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-[#123012] transition bg-gray-50" id="drop-zone">
                        <div class="space-y-1 text-center">
                            <div id="image-preview" class="{{ $match->photo_url ? '' : 'hidden' }} mb-4">
                                <img src="{{ $match->photo_url ?? '' }}" alt="Preview" class="mx-auto h-48 w-auto rounded-lg object-cover shadow-sm">
                            </div>
                            <div id="upload-placeholder" class="{{ $match->photo_url ? 'hidden' : '' }}">
                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="flex text-sm text-gray-600 justify-center mt-2">
                                    <label for="file-upload" class="relative cursor-pointer bg-white rounded-md font-medium text-[#123012] hover:text-green-700 focus-within:outline-none px-1">
                                        <span>Pilih file</span>
                                        <input id="file-upload" name="photo" type="file" class="sr-only" accept="image/*" onchange="previewImage(event)">
                                    </label>
                                    <p class="pl-1">atau drag and drop</p>
                                </div>
                                <p class="text-xs text-gray-500 mt-1">PNG, JPG, WEBP up to 2MB</p>
                            </div>
                        </div>
                    </div>
                </div>

                <script>
                    function previewImage(event) {
                        const file = event.target.files[0];
                        if (file) {
                            const reader = new FileReader();
                            reader.onload = function(e) {
                                document.getElementById('image-preview').classList.remove('hidden');
                                document.getElementById('image-preview').querySelector('img').src = e.target.result;
                                document.getElementById('upload-placeholder').classList.add('hidden');
                            }
                            reader.readAsDataURL(file);
                        }
                    }
                </script>

                <div>
                    <label class="text-sm font-medium">
                        Jumlah Slot (termasuk kamu) <span class="text-red-500">*</span>
                    </label>

                    <div class="relative mt-1">
                        <input name="total_players" id="jumlah_slot" type="number" min="2" value="{{ $match->total_players }}" required
                            class="w-full border rounded-lg p-3 pr-16 outline-none focus:ring-2 focus:ring-[#123012]"
                            oninput="calcPricePerPerson()">

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

                    <input type="hidden" name="gender_preference" id="genderInput" value="{{ $match->gender_preference }}">

                    <div class="relative mt-1">
                        <button type="button" onclick="toggleDropdown()"
                            class="w-full border rounded-lg p-3 flex justify-between items-center bg-white shadow-sm hover:border-[#123012] transition">
                            <span id="genderText">
                                @if($match->gender_preference === 'male') Pria
                                @elseif($match->gender_preference === 'female') Wanita
                                @else Bebas (Mixed)
                                @endif
                            </span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2"
                                 viewBox="0 0 24 24">
                                <path d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>

                        <div id="genderDropdown"
                            class="hidden absolute w-full mt-2 bg-white border rounded-lg shadow-lg overflow-hidden z-10">
                            <div onclick="selectGender('mixed', 'Bebas (Mixed)')"
                                class="px-4 py-2 hover:bg-[#f2f6f2] cursor-pointer">Bebas (Mixed)</div>
                            <div onclick="selectGender('male', 'Pria')"
                                class="px-4 py-2 hover:bg-[#f2f6f2] cursor-pointer">Pria</div>
                            <div onclick="selectGender('female', 'Wanita')"
                                class="px-4 py-2 hover:bg-[#f2f6f2] cursor-pointer">Wanita</div>
                        </div>
                    </div>
                </div>

                {{-- Ringkasan harga --}}
                <div class="grid md:grid-cols-2 gap-4">
                    <div>
                        <label class="text-sm font-medium text-gray-500">Harga Total Lapangan</label>
                        <div class="w-full border rounded-lg p-3 mt-1 bg-gray-50 text-gray-700 font-semibold">
                            Rp {{ number_format($booking->field->price_per_hour ?? 0, 0, ',', '.') }}
                        </div>
                    </div>

                    <div>
                        <label class="text-sm font-medium">Harga per Orang (otomatis)</label>
                        <input name="price_per_person" id="priceInput" type="hidden" value="0">
                        <div id="priceDisplay" class="w-full border rounded-lg p-3 mt-1 bg-yellow-50 text-yellow-800 font-bold text-lg">
                            Rp 0
                        </div>
                    </div>
                </div>

                {{-- Info pembagian --}}
                <div id="breakdownBox" class="hidden bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <p class="text-sm text-blue-800 font-medium mb-2">Pembagian Biaya:</p>
                    <div id="breakdownContent" class="text-sm text-blue-700 space-y-1"></div>
                </div>

                <div class="flex justify-between pt-6">
                    <button type="button" onclick="switchTab('lapangan')"
                        class="text-gray-500 hover:text-black text-sm font-medium transition">
                        ← Kembali
                    </button>

                    <button type="submit" id="publishBtn"
                        class="bg-[#123012] text-white px-6 py-2.5 rounded-lg text-sm font-bold shadow-sm hover:shadow-md hover:scale-[1.01] transition">
                        Update Match
                    </button>
                </div>

            </div>
        </div>

    </div>
</form>



<script>
const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
const fieldPrice = parseInt(document.getElementById('fieldPrice').value) || 0;

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
        calcPricePerPerson();
    }
    closeDropdown();
}

function stepperChange(delta) {
    const input = document.getElementById('jumlah_slot');
    let val = parseInt(input.value) || 2;
    val += delta;
    if (val < 2) val = 2;
    input.value = val;
    calcPricePerPerson();
}

function calcPricePerPerson() {
    const slots = parseInt(document.getElementById('jumlah_slot').value) || 2;
    const perPerson = Math.ceil(fieldPrice / slots);

    document.getElementById('priceInput').value = perPerson;
    document.getElementById('priceDisplay').innerText = 'Rp ' + perPerson.toLocaleString('id-ID');

    const box = document.getElementById('breakdownBox');
    const content = document.getElementById('breakdownContent');

    if (fieldPrice > 0 && slots > 1) {
        box.classList.remove('hidden');
        let html = `
            <div class="flex justify-between"><span>Total harga lapangan:</span><span class="font-semibold">Rp ${fieldPrice.toLocaleString('id-ID')}</span></div>
            <div class="flex justify-between"><span>Dibagi ${slots} orang:</span><span class="font-semibold">Rp ${fieldPrice.toLocaleString('id-ID')} ÷ ${slots} = Rp ${perPerson.toLocaleString('id-ID')}</span></div>
            <hr class="border-blue-200 my-1">
            <div class="flex justify-between font-bold"><span>Kamu (pembuat):</span><span class="text-green-700">✓ Sudah Lunas (bayar saat checkout)</span></div>
            <div class="flex justify-between font-bold"><span>Joiner bayar:</span><span class="text-yellow-700">Rp ${perPerson.toLocaleString('id-ID')} / orang</span></div>
        `;
        content.innerHTML = html;
    } else {
        box.classList.add('hidden');
    }
}

function toggleDropdown() {
    document.getElementById('genderDropdown').classList.toggle('hidden');
}

function selectGender(value, label) {
    document.getElementById('genderInput').value = value;
    document.getElementById('genderText').innerText = label;
    closeDropdown();
}

function closeDropdown() {
    document.getElementById('genderDropdown').classList.add('hidden');
}

function showLoading(show) {
    document.getElementById('loadingOverlay').classList.toggle('hidden', !show);
}

document.addEventListener('click', function(e) {
    if (!e.target.closest('#genderDropdown') && !e.target.closest('button[onclick="toggleDropdown()"]')) {
        closeDropdown();
    }
});

// Initial calc
calcPricePerPerson();

document.getElementById('matchForm').addEventListener('submit', function(e) {
    const btn = document.getElementById('publishBtn');
    btn.disabled = true;
    btn.innerText = 'Memproses...';
});
</script>

</body>
</html>
