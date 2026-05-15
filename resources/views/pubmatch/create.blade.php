<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Public Match</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=DM+Sans:wght@400;500;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script type="text/javascript"
        src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('midtrans.client_key') }}"></script>
</head>

<body class="bg-[#f6f7f6]" style="font-family:'DM Sans',sans-serif;">

<div class="bg-[#123012] py-12 text-center shadow-md">
    <h1 class="text-white tracking-widest"
        style="font-family:'Bebas Neue'; font-size:clamp(2.2rem,6vw,3.6rem); letter-spacing:6px;">
        BUAT PUBLIC MATCH
    </h1>
</div>

<form id="matchForm" class="max-w-4xl mx-auto px-6 py-10">

    @csrf
    <input type="hidden" name="booking_id" value="{{ $booking?->id }}">

    <div class="grid grid-cols-2 rounded-xl overflow-hidden shadow-md mb-10">
        <button type="button" id="tab-lapangan"
            onclick="switchTab('lapangan')"
            class="py-3 text-white font-semibold transition bg-[#123012]">
            Detail Lapangan
        </button>

        <button type="button" id="tab-match"
            onclick="switchTab('match')"
            class="py-3 text-white font-semibold transition bg-gray-400">
            Detail Match
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
                            value="{{ $booking->timeSlot->date ?? '-' }}"
                            type="date"
                            class="w-full border rounded-lg p-3 mt-1 bg-gray-50 text-gray-700">
                    </div>

                    <div>
                        <label class="text-sm font-medium">Jam</label>
                        <input readonly
                            value="{{ $booking->timeSlot->start_time ?? '' }} - {{ $booking->timeSlot->end_time ?? '' }}"
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
                        Next →
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
                        {{ $booking->timeSlot->date ?? '' }}
                        {{ $booking->timeSlot->start_time ?? '' }}-{{ $booking->timeSlot->end_time ?? '' }}
                    </p>
                </div>

                <div>
                    <label class="text-sm font-medium">
                        Title <span class="text-red-500">*</span>
                    </label>
                    <input name="title" required
                        placeholder="Contoh: Futsal Santai Minggu Sore"
                        class="w-full border rounded-lg p-3 mt-1 outline-none focus:ring-2 focus:ring-[#123012]">
                </div>

                <div>
                    <label class="text-sm font-medium">
                        Deskripsi <span class="text-red-500">*</span>
                    </label>
                    <textarea name="description" required
                        placeholder="Jelaskan siapa yang kamu cari, level permainan, dll."
                        class="w-full border rounded-lg p-3 h-28 mt-1 outline-none focus:ring-2 focus:ring-[#123012]"></textarea>
                </div>

                <div>
                    <label class="text-sm font-medium">
                        Jumlah Slot (termasuk kamu) <span class="text-red-500">*</span>
                    </label>

                    <div class="relative mt-1">
                        <input name="total_players" id="jumlah_slot" type="number" min="2" value="2" required
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

                    <input type="hidden" name="gender_preference" id="genderInput" value="mixed">

                    <div class="relative mt-1">
                        <button type="button" onclick="toggleDropdown()"
                            class="w-full border rounded-lg p-3 flex justify-between items-center bg-white shadow-sm hover:border-[#123012] transition">
                            <span id="genderText">Bebas (Mixed)</span>
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
                        ← Back
                    </button>

                    <button type="submit" id="publishBtn"
                        class="bg-yellow-400 text-black px-6 py-2.5 rounded-lg text-sm font-bold shadow-sm hover:shadow-md hover:scale-[1.01] transition">
                        Publish & Bayar
                    </button>
                </div>

            </div>
        </div>

    </div>
</form>

<div id="loadingOverlay" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50">
    <div class="bg-white rounded-2xl p-8 text-center">
        <div class="animate-spin w-10 h-10 border-4 border-[#123012] border-t-transparent rounded-full mx-auto mb-4"></div>
        <p class="font-medium">Memproses pembayaran...</p>
    </div>
</div>

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
            <div class="flex justify-between font-bold"><span>Kamu (pembuat) bayar:</span><span class="text-green-700">Rp ${fieldPrice.toLocaleString('id-ID')} (full)</span></div>
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

document.getElementById('matchForm').addEventListener('submit', async function(e) {
    e.preventDefault();

    const btn = document.getElementById('publishBtn');
    btn.disabled = true;
    btn.innerText = 'Memproses...';

    const formData = new FormData(this);

    try {
        const res = await fetch('{{ route("matches.store") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
            },
            body: formData,
        });

        const data = await res.json();

        if (!res.ok) {
            alert(data.message || 'Gagal membuat match');
            btn.disabled = false;
            btn.innerText = 'Publish & Bayar';
            return;
        }

        const matchId = data.match_id;

        // Creator always pays full price
        const payRes = await fetch('{{ route("payment.match.create") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            },
            body: JSON.stringify({ match_id: matchId, is_creator: true }),
        });

        const payData = await payRes.json();

        if (!payRes.ok || !payData.snap_token) {
            alert(payData.error || 'Gagal membuat token pembayaran');
            btn.disabled = false;
            btn.innerText = 'Publish & Bayar';
            return;
        }

        showLoading(true);

        snap.pay(payData.snap_token, {
            onSuccess: function(result) {
                showLoading(false);
                window.location.href = '{{ url("payment/match/finish") }}?order_id=' + payData.order_id + '&match_id=' + matchId;
            },
            onPending: function(result) {
                showLoading(false);
                alert('Pembayaran pending. Silakan selesaikan pembayaran.');
                window.location.href = '{{ url("matches") }}/' + matchId;
            },
            onError: function(result) {
                showLoading(false);
                alert('Pembayaran gagal. Silakan coba lagi.');
                btn.disabled = false;
                btn.innerText = 'Publish & Bayar';
            },
            onClose: function() {
                showLoading(false);
                alert('Kamu menutup popup. Match sudah dibuat, bisa bayar nanti.');
                window.location.href = '{{ url("matches") }}/' + matchId;
            }
        });

    } catch (err) {
        console.error(err);
        alert('Terjadi kesalahan. Silakan coba lagi.');
        btn.disabled = false;
        btn.innerText = 'Publish & Bayar';
    }
});
</script>

</body>
</html>
