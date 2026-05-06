<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
@php
    $isEdit = isset($venue);
    $action = $isEdit ? route('owner.venue.update', $venue->id) : route('owner.venue.store');
@endphp

<title>{{ $isEdit ? 'Edit Venue' : 'Daftarkan Venue' }}</title>

<link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=DM+Sans:wght@400;500;700&display=swap" rel="stylesheet">
<script src="https://cdn.tailwindcss.com"></script>

<style>
    body { font-family:'DM Sans',sans-serif; }
    .tab-active { background:#123012 !important; color:white !important; }
    .req { color:red; margin-left:2px; }

    .dropdown { position:relative; }
    .dropdown-box {
        position:absolute;
        top:100%;
        left:0;
        right:0;
        background:white;
        border:1px solid #e5e7eb;
        border-radius:10px;
        margin-top:6px;
        display:none;
        z-index:20;
        box-shadow:0 10px 20px rgba(0,0,0,0.08);
    }
    .dropdown-box div {
        padding:10px 12px;
        cursor:pointer;
    }
    .dropdown-box div:hover {
        background:#f2f6f2;
    }
    .tag {
        display:flex;
        align-items:center;
        gap:6px;
        background:#e8f5e9;
        color:#123012;
        padding:6px 10px;
        border-radius:999px;
        font-size:13px;
        font-weight:600;
    }

    .tag button {
        background:transparent;
        border:none;
        cursor:pointer;
        font-weight:bold;
        color:#123012;
    }
</style>
</head>

<body class="bg-[#f6f7f6]">

<div class="bg-[#123012] py-12 text-center">
    <h1 class="text-white tracking-widest"
        style="font-family:'Bebas Neue'; font-size:clamp(2.2rem,6vw,3.6rem); letter-spacing:6px;">
        {{ $isEdit ? 'EDIT VENUE' : 'DAFTARKAN VENUE' }}
    </h1>
</div>

<form action="{{ $action }}" method="POST" enctype="multipart/form-data" class="max-w-4xl mx-auto px-6 py-10">
    @csrf
    @if($isEdit)
        @method('PUT')
    @endif

    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-8">
            <strong class="font-bold">Terdapat Kesalahan!</strong>
            <ul class="mt-2 list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="grid grid-cols-2 rounded-xl overflow-hidden shadow-md mb-8">
        <button type="button" id="tabV" onclick="showTab('venue')" class="py-3 bg-[#123012] text-white font-semibold">
            Detail Venue
        </button>

        <button type="button" id="tabL" onclick="showTab('lapangan')" class="py-3 bg-gray-400 text-white font-semibold">
            Detail Lapangan
        </button>
    </div>

    <div class="bg-white rounded-2xl shadow-md p-8">

        <div id="venue" class="space-y-5">
            <div>
                <label>Nama Venue <span class="req">*</span></label>
                <input name="name" value="{{ old('name', $isEdit ? $venue->name : '') }}" required class="w-full border rounded-lg p-3 mt-1">
            </div>

            <div>
                <label>Deskripsi <span class="req">*</span></label>
                <textarea name="description" class="w-full border rounded-lg p-3 h-28 mt-1">{{ old('description', $isEdit ? $venue->description : '') }}</textarea>
            </div>

            <div>
                <label>Kota <span class="text-gray-400 text-sm">(Opsional)</span></label>
                <input class="w-full border rounded-lg p-3 mt-1">
            </div>

            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label>Alamat <span class="req">*</span></label>
                    <textarea name="location" required class="w-full border rounded-lg p-3 h-32 mt-1">{{ old('location', $isEdit ? $venue->location : '') }}</textarea>
                </div>
                <div class="rounded-lg border bg-gray-100 flex items-center justify-center text-gray-400">
                    Map Preview
                </div>
            </div>

            <div>
                <label>Fasilitas <span class="text-gray-400 text-sm">(Opsional)</span></label>
                <input id="facilityInput" class="w-full border rounded-lg p-3 mt-1" placeholder="Ketik lalu Enter">
                <div id="facilityTags" class="flex flex-wrap gap-2 mt-2"></div>
            </div>

            <div class="grid md:grid-cols-3 gap-4">
                <div>
                    <label>Jam Buka <span class="text-gray-400 text-sm">(Opsional)</span></label>
                    <input type="time" name="open_time" value="{{ old('open_time', $isEdit && $venue->open_time ? \Carbon\Carbon::parse($venue->open_time)->format('H:i') : '') }}" class="w-full border rounded-lg p-3 mt-1">
                </div>
                <div>
                    <label>Jam Tutup <span class="text-gray-400 text-sm">(Opsional)</span></label>
                    <input type="time" name="close_time" value="{{ old('close_time', $isEdit && $venue->close_time ? \Carbon\Carbon::parse($venue->close_time)->format('H:i') : '') }}" class="w-full border rounded-lg p-3 mt-1">
                </div>
                <div>
                    <label>Durasi Sewa <span class="text-gray-400 text-sm">(Fixed)</span></label>
                    <input class="w-full border rounded-lg p-3 mt-1 bg-gray-100 text-gray-500" value="1 Jam" disabled>
                </div>
            </div>

            <div class="dropdown">
                <label>Olahraga (Pilih Multi) <span class="text-gray-400 text-sm">(Opsional)</span></label>
                <button type="button" onclick="toggleDropdown('venueSportBox')" class="w-full border rounded-lg p-3 mt-1 flex justify-between items-center bg-white">
                    <span>Pilih Olahraga</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7"/></svg>
                </button>
                <div id="venueSportBox" class="dropdown-box">
                    <div onclick="selectSportVenue('Futsal')">Futsal</div>
                    <div onclick="selectSportVenue('Basket')">Basket</div>
                    <div onclick="selectSportVenue('Badminton')">Badminton</div>
                </div>
                <div id="venueSportTags" class="flex flex-wrap gap-2 mt-2"></div>
            </div>

            <div class="flex justify-end pt-6">
                <button type="button" onclick="showTab('lapangan')" class="bg-[#123012] text-white px-6 py-3 rounded-lg font-semibold">
                    Next →
                </button>
            </div>
        </div>

        <div id="lapangan" class="hidden space-y-6">
            <div class="flex justify-between items-center border-b pb-4">
                <h2 class="font-bold text-lg">Manajemen Lapangan</h2>
                <button type="button" onclick="addLapangan()" class="bg-yellow-400 px-5 py-2 rounded-lg font-bold">
                    + ADD
                </button>
            </div>

            <div id="lapanganContainer" class="space-y-6">
                @php
                    $fields = $isEdit ? old('fields', $venue->fields) : old('fields', [[]]);
                @endphp

                @foreach($fields as $idx => $field)
                    @php 
                        $fName = $field['name'] ?? ($field->name ?? '');
                        $fSport = $field['sport_type'] ?? ($field->sport_type ?? '');
                        $fPrice = $field['price_per_hour'] ?? ($field->price_per_hour ?? '');
                        $fCapacity = $field['capacity'] ?? ($field->capacity ?? '');
                        $fIndoor = $field['is_indoor'] ?? ($field->is_indoor ?? '0');
                    @endphp
                    <div class="border rounded-xl p-5 space-y-4">
                        <div class="flex justify-between items-center">
                            <h3 class="font-semibold text-gray-800">Lapangan {{ $idx + 1 }}</h3>
                            @if($idx > 0)
                                <button type="button" onclick="this.parentElement.parentElement.remove()" class="text-red-500 text-sm font-bold">Hapus</button>
                            @endif
                        </div>

                        <div>
                            <label class="font-medium">Nama Lapangan <span class="req">*</span></label>
                            <input name="fields[{{ $idx }}][name]" value="{{ $fName }}" required class="w-full border rounded-lg p-3 mt-1">
                        </div>

                        <div class="dropdown">
                            <label class="font-medium">Jenis Olahraga <span class="text-gray-400 text-sm">(Opsional)</span></label>
                            <input type="hidden" name="fields[{{ $idx }}][sport_type]" value="{{ $fSport }}">
                            <button type="button" onclick="toggleDropdown(this.nextElementSibling.id)" class="w-full border rounded-lg p-3 mt-1 flex justify-between items-center bg-white">
                                <span class="selected-val">{{ $fSport ?: 'Pilih 1 Olahraga' }}</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7"/></svg>
                            </button>
                            <div id="drop-{{ $idx }}" class="dropdown-box">
                                <div onclick="selectSingleSport(this, 'Futsal')">Futsal</div>
                                <div onclick="selectSingleSport(this, 'Basket')">Basket</div>
                                <div onclick="selectSingleSport(this, 'Badminton')">Badminton</div>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="font-medium">Harga per Jam <span class="req">*</span></label>
                                <div class="flex mt-1">
                                    <span class="inline-flex items-center px-4 rounded-l-lg border border-r-0 border-gray-300 bg-gray-50 text-gray-500 font-semibold">
                                        Rp
                                    </span>
                                    <input type="number" name="fields[{{ $idx }}][price_per_hour]" value="{{ $fPrice }}" required class="w-full border rounded-r-lg p-3 outline-none focus:ring-1 focus:ring-[#123012]" placeholder="0">
                                </div>
                            </div>
                            <div>
                                <label class="font-medium">Kapasitas (orang) <span class="text-gray-400 text-sm">(Opsional)</span></label>
                                <input type="number" name="fields[{{ $idx }}][capacity]" value="{{ $fCapacity }}" class="w-full border rounded-lg p-3 mt-1 outline-none focus:ring-1 focus:ring-[#123012]" placeholder="10">
                            </div>
                        </div>
                        
                        <div>
                            <label class="font-medium text-sm">Tipe Lapangan <span class="req">*</span></label>
                            <select name="fields[{{ $idx }}][is_indoor]" class="w-full border rounded-lg p-3 mt-1 outline-none focus:ring-1 focus:ring-[#123012] bg-white">
                                <option value="1" {{ (string)$fIndoor === '1' ? 'selected' : '' }}>Indoor</option>
                                <option value="0" {{ (string)$fIndoor === '0' ? 'selected' : '' }}>Outdoor</option>
                            </select>
                        </div>

                        <div>
                            <label class="font-medium">Foto Lapangan <span class="text-gray-400 text-sm">(Opsional)</span></label>
                            <div class="border-2 border-dashed rounded-xl h-32 flex items-center justify-center text-gray-400 mt-1 cursor-pointer hover:bg-gray-50">
                                Upload Foto
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="flex justify-between pt-4">
                <button type="button" onclick="showTab('venue')" class="text-gray-500">
                    ← Back
                </button>
                <button type="submit" class="bg-yellow-400 px-6 py-3 rounded-lg font-bold">
                    {{ $isEdit ? 'Update' : 'Publish' }}
                </button>
            </div>
        </div>

    </div>
</form>

<script>
let lapCount = {{ isset($venue) ? $venue->fields->count() : 1 }};

document.addEventListener('DOMContentLoaded', function() {
    if(window.location.hash === '#lapangan') {
        showTab('lapangan');
    }
});

function showTab(tab){
    const v = document.getElementById('venue');
    const l = document.getElementById('lapangan');
    const tabV = document.getElementById('tabV');
    const tabL = document.getElementById('tabL');

    if(tab === 'venue'){
        v.classList.remove('hidden');
        l.classList.add('hidden');
        tabV.classList.add('tab-active');
        tabL.classList.remove('tab-active');
        tabL.classList.add('bg-gray-400');
    } else {
        l.classList.remove('hidden');
        v.classList.add('hidden');
        tabL.classList.add('tab-active');
        tabV.classList.remove('tab-active');
        tabV.classList.add('bg-gray-400');
    }
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

/* DROPDOWN LOGIC */
function toggleDropdown(id){
    const box = document.getElementById(id);
    const isVisible = box.style.display === 'block';
    
    // Close all other boxes first
    document.querySelectorAll('.dropdown-box').forEach(b => b.style.display = 'none');
    
    box.style.display = isVisible ? 'none' : 'block';
}

// MULTI SELECT (VENUE)
let venueSports = [];
function selectSportVenue(val){
    if(!venueSports.includes(val)){
        venueSports.push(val);
        renderVenueSports();
    }
    document.getElementById('venueSportBox').style.display = 'none';
}

function renderVenueSports(){
    const container = document.getElementById('venueSportTags');
    container.innerHTML = '';
    venueSports.forEach((s, idx) => {
        const t = document.createElement('div');
        t.className = 'tag';
        t.innerHTML = `${s} <button type="button" onclick="removeVenueSport(${idx})">x</button>`;
        container.appendChild(t);
    });
}

function removeVenueSport(idx){
    venueSports.splice(idx, 1);
    renderVenueSports();
}

// SINGLE SELECT (LAPANGAN)
function selectSingleSport(el, val){
    const parent = el.closest('.dropdown');
    parent.querySelector('.selected-val').innerText = val;
    const hiddenInput = parent.querySelector('input[type="hidden"]');
    if(hiddenInput) hiddenInput.value = val;
    parent.querySelector('.dropdown-box').style.display = 'none';
}

// Close on outside click
document.addEventListener('click', function(e){
    if(!e.target.closest('.dropdown')){
        document.querySelectorAll('.dropdown-box').forEach(b => b.style.display = 'none');
    }
});

/* FACILITY */
const facilityInput = document.getElementById('facilityInput');
let facilities = [];
facilityInput.addEventListener('keydown', function(e){
    if(e.key === 'Enter'){
        e.preventDefault();
        const v = this.value.trim();
        if(v && !facilities.includes(v)){
            facilities.push(v);
            renderFacilities();
        }
        this.value = '';
    }
});

function renderFacilities(){
    const container = document.getElementById('facilityTags');
    container.innerHTML = '';
    facilities.forEach((f, idx) => {
        const t = document.createElement('div');
        t.className = 'tag';
        t.innerHTML = `${f} <button type="button" onclick="removeFacility(${idx})">x</button>`;
        container.appendChild(t);
    });
}

function removeFacility(idx){
    facilities.splice(idx, 1);
    renderFacilities();
}

/* ADD LAPANGAN */
function addLapangan(){
    const container = document.getElementById('lapanganContainer');
    const card = document.createElement('div');
    card.className = "border rounded-xl p-5 space-y-4";
    
    const dropId = `drop-${lapCount + 1}`;
    const idx = lapCount;

    card.innerHTML = `
        <div class="flex justify-between items-center">
            <span class="font-bold text-[#123012]">Lapangan Baru</span>
            <button type="button" onclick="this.parentElement.parentElement.remove()" class="text-red-500 text-sm font-bold">Hapus</button>
        </div>
        <div>
            <label class="font-medium text-sm">Nama Lapangan <span class="req">*</span></label>
            <input name="fields[${idx}][name]" required class="w-full border rounded-lg p-3 mt-1" placeholder="Nama Lapangan">
        </div>
        <div class="dropdown">
            <label class="font-medium text-sm">Jenis Olahraga <span class="text-gray-400 text-sm">(Opsional)</span></label>
            <input type="hidden" name="fields[${idx}][sport_type]">
            <button type="button" onclick="toggleDropdown('${dropId}')" class="w-full border rounded-lg p-3 mt-1 flex justify-between items-center bg-white">
                <span class="selected-val">Pilih 1 Olahraga</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7"/></svg>
            </button>
            <div id="${dropId}" class="dropdown-box">
                <div onclick="selectSingleSport(this, 'Futsal')">Futsal</div>
                <div onclick="selectSingleSport(this, 'Basket')">Basket</div>
                <div onclick="selectSingleSport(this, 'Badminton')">Badminton</div>
            </div>
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="font-medium text-sm">Harga per Jam <span class="req">*</span></label>
                <div class="flex mt-1">
                    <span class="inline-flex items-center px-4 rounded-l-lg border border-r-0 border-gray-300 bg-gray-50 text-gray-500 font-semibold">
                        Rp
                    </span>
                    <input type="number" name="fields[${idx}][price_per_hour]" required class="w-full border rounded-r-lg p-3 outline-none focus:ring-1 focus:ring-[#123012]" placeholder="0">
                </div>
            </div>
            <div>
                <label class="font-medium text-sm">Kapasitas (orang) <span class="text-gray-400 text-sm">(Opsional)</span></label>
                <input type="number" name="fields[${idx}][capacity]" class="w-full border rounded-lg p-3 mt-1 outline-none focus:ring-1 focus:ring-[#123012]" placeholder="10">
            </div>
        </div>
        <div>
            <label class="font-medium text-sm">Tipe Lapangan <span class="req">*</span></label>
            <select name="fields[${idx}][is_indoor]" class="w-full border rounded-lg p-3 mt-1 outline-none focus:ring-1 focus:ring-[#123012] bg-white">
                <option value="1">Indoor</option>
                <option value="0">Outdoor</option>
            </select>
        </div>
        <div class="border-2 border-dashed rounded-xl h-32 flex items-center justify-center text-gray-400 mt-1">
            Upload Foto
        </div>
    `;
    container.appendChild(card);
    lapCount++;
}
</script>

</body>
</html>