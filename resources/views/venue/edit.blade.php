<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Edit Venue - ActiveHub</title>

<link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=DM+Sans:wght@400;500;700&display=swap" rel="stylesheet">
@if (app()->environment('production'))
    @vite(['resources/css/app.css', 'resources/js/app.js'])
@else
    <script src="https://cdn.tailwindcss.com"></script>
@endif

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

    #map {
        height: 300px;
        width: 100%;
        border-radius: 12px;
    }

    /* Autocomplete Styles */
    .pac-container {
        border-radius: 10px;
        border: 1px solid #e5e7eb;
        box-shadow: 0 10px 20px rgba(0,0,0,0.08);
        font-family: 'DM Sans', sans-serif;
        margin-top: 5px;
    }
    .pac-item {
        padding: 8px 12px;
        cursor: pointer;
    }
    .pac-item:hover {
        background-color: #f2f6f2;
    }
</style>
</head>

<body class="bg-[#f6f7f6]">

<div class="bg-[#123012] py-12 text-center">
    <h1 class="text-white tracking-widest"
        style="font-family:'Bebas Neue'; font-size:clamp(2.2rem,6vw,3.6rem); letter-spacing:6px;">
        EDIT VENUE
    </h1>
</div>

<div class="max-w-4xl mx-auto px-6 py-10">

    @if ($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl mb-6">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('owner.venue.update', $venue->id) }}" method="POST" id="venueForm" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="bg-white rounded-2xl shadow-md p-8">

            {{-- STEP 1: VENUE DETAILS --}}
            <div id="venueSection" class="space-y-5">
                <div>
                    <label class="text-sm font-semibold text-gray-700">Nama Venue <span class="req">*</span></label>
                    <input name="name" value="{{ $venue->name }}" required class="w-full border rounded-lg p-3 mt-1 focus:ring-2 focus:ring-[#123012] outline-none" placeholder="Masukkan nama venue">
                </div>

                <div>
                    <label class="text-sm font-semibold text-gray-700">Deskripsi <span class="req">*</span></label>
                    <textarea name="description" required class="w-full border rounded-lg p-3 h-28 mt-1 focus:ring-2 focus:ring-[#123012] outline-none" placeholder="Ceritakan tentang venue Anda...">{{ $venue->description }}</textarea>
                </div>

                <div>
                    <label class="text-sm font-semibold text-gray-700">Foto Venue (Galeri)</label>
                    <div class="mt-1 flex flex-col justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-[#123012] transition bg-gray-50" id="drop-zone">
                        <div class="space-y-1 text-center">
                            <div id="image-preview" class="{{ $venue->photos && count($venue->photos) > 0 || $venue->photo_url ? '' : 'hidden' }} mb-4 grid grid-cols-2 md:grid-cols-4 gap-4">
                                @if($venue->photos && count($venue->photos) > 0)
                                    @foreach($venue->photos as $photo)
                                        <img src="{{ $photo }}" alt="Preview" class="w-full h-32 object-cover rounded-lg shadow-sm">
                                    @endforeach
                                @elseif($venue->photo_url)
                                    <img src="{{ $venue->photo_url }}" alt="Preview" class="w-full h-32 object-cover rounded-lg shadow-sm">
                                @endif
                            </div>
                            <div id="upload-placeholder" class="{{ $venue->photos && count($venue->photos) > 0 || $venue->photo_url ? 'hidden' : '' }}">
                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="flex text-sm text-gray-600 justify-center mt-2">
                                    <label for="file-upload" class="relative cursor-pointer bg-white rounded-md font-medium text-[#123012] hover:text-green-700 focus-within:outline-none px-1">
                                        <span>Ganti file (pilih beberapa sekaligus)</span>
                                        <input id="file-upload" name="photos[]" type="file" multiple class="sr-only" accept="image/*" onchange="previewImages(event)">
                                    </label>
                                </div>
                                <p class="text-xs text-gray-500 mt-1">Mengunggah file baru akan menimpa foto lama.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <script>
                    function previewImages(event) {
                        const files = event.target.files;
                        const previewContainer = document.getElementById('image-preview');
                        const placeholder = document.getElementById('upload-placeholder');
                        
                        if (files.length > 0) {
                            previewContainer.classList.remove('hidden');
                            previewContainer.innerHTML = ''; // Clear previous previews
                            placeholder.classList.add('hidden'); // Hide placeholder
                            
                            Array.from(files).forEach(file => {
                                const reader = new FileReader();
                                reader.onload = function(e) {
                                    const img = document.createElement('img');
                                    img.src = e.target.result;
                                    img.className = 'w-full h-32 object-cover rounded-lg shadow-sm';
                                    previewContainer.appendChild(img);
                                }
                                reader.readAsDataURL(file);
                            });
                        } else {
                            previewContainer.classList.add('hidden');
                            placeholder.classList.remove('hidden');
                        }
                    }
                </script>

                <div>
                    <label class="text-sm font-semibold text-gray-700">Peraturan Venue</label>
                    <textarea name="rules" class="w-full border rounded-lg p-3 h-28 mt-1 focus:ring-2 focus:ring-[#123012] outline-none" placeholder="1. Wajib memakai sepatu&#10;2. Dilarang membawa makanan dari luar&#10;3. Dilarang merokok">{{ isset($venue) ? $venue->rules : '' }}</textarea>
                    <p class="text-xs text-gray-400 mt-1 italic">Pisahkan setiap peraturan dengan baris baru (Enter).</p>
                </div>

                <div class="grid md:grid-cols-2 gap-4">
                    <div>
                        <label class="text-sm font-semibold text-gray-700">Kota <span class="req">*</span></label>
                        <input name="city" value="{{ $venue->city }}" id="cityInput" required class="w-full border rounded-lg p-3 mt-1 focus:ring-2 focus:ring-[#123012] outline-none" placeholder="Masukkan kota">
                    </div>
                    <div>
                        <label class="text-sm font-semibold text-gray-700">Alamat Lengkap <span class="req">*</span></label>
                        <input name="location" value="{{ $venue->location }}" id="locationAutocomplete" required class="w-full border rounded-lg p-3 mt-1 focus:ring-2 focus:ring-[#123012] outline-none" placeholder="Cari lokasi atau ketik alamat...">
                    </div>
                </div>

                <div>
                    <label class="text-sm font-semibold text-gray-700 mb-2 block">Pilih Lokasi di Peta <span class="req">*</span></label>
                    <div id="map"></div>
                    <p class="text-xs text-gray-400 mt-2 italic">Geser marker untuk menentukan titik lokasi yang tepat.</p>
                    <input type="hidden" name="latitude" id="latInput" value="{{ $venue->latitude }}">
                    <input type="hidden" name="longitude" id="lngInput" value="{{ $venue->longitude }}">
                </div>

                <div>
                    <label class="text-sm font-semibold text-gray-700">Fasilitas <span class="req">*</span></label>
                    <input id="facilityInput" class="w-full border rounded-lg p-3 mt-1 focus:ring-2 focus:ring-[#123012] outline-none" placeholder="Ketik lalu tekan Enter">
                    <div id="facilityTags" class="flex flex-wrap gap-2 mt-2"></div>
                    <div id="facilityHiddenInputs"></div>
                </div>

                <div class="grid md:grid-cols-2 gap-4">
                    <div>
                        <label class="text-sm font-semibold text-gray-700">Jam Buka <span class="req">*</span></label>
                        <input type="time" name="open_time" value="{{ \Carbon\Carbon::parse($venue->open_time)->format('H:i') }}" required class="w-full border rounded-lg p-3 mt-1 focus:ring-2 focus:ring-[#123012] outline-none">
                    </div>
                    <div>
                        <label class="text-sm font-semibold text-gray-700">Jam Tutup <span class="req">*</span></label>
                        <input type="time" name="close_time" value="{{ \Carbon\Carbon::parse($venue->close_time)->format('H:i') }}" required class="w-full border rounded-lg p-3 mt-1 focus:ring-2 focus:ring-[#123012] outline-none">
                    </div>
                </div>

                <div class="dropdown">
                    <label class="text-sm font-semibold text-gray-700">Olahraga (Pilih Multi) <span class="req">*</span></label>
                    <button type="button" onclick="toggleDropdown('venueSportBox')" class="w-full border rounded-lg p-3 mt-1 flex justify-between items-center bg-white hover:bg-gray-50 transition">
                        <span id="sportPlaceholder">Pilih Olahraga</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div id="venueSportBox" class="dropdown-box">
                        <div onclick="selectSportVenue('Futsal')">Futsal</div>
                        <div onclick="selectSportVenue('Basket')">Basket</div>
                        <div onclick="selectSportVenue('Bulu Tangkis')">Bulu Tangkis</div>
                        <div onclick="selectSportVenue('Tennis')">Tennis</div>
                        <div onclick="selectSportVenue('Voli')">Voli</div>
                        <div onclick="selectSportVenue('Padel')">Padel</div>
                        <div onclick="selectSportVenue('Kebugaran')">Kebugaran</div>
                    </div>
                    <div id="venueSportTags" class="flex flex-wrap gap-2 mt-2"></div>
                    <div id="venueSportHiddenInputs"></div>
                </div>

                <div class="flex justify-between pt-8 border-t">
                    <a href="{{ route('owner.venue') }}" class="flex items-center gap-2 text-gray-500 font-bold hover:text-gray-900 transition group">
                        <span class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center group-hover:bg-gray-200 transition">←</span>
                        Batal
                    </a>
                    <button type="submit" class="bg-[#fbbf24] hover:bg-[#d97706] text-[#123012] px-8 py-3 rounded-xl font-bold transition-all hover:scale-105 active:scale-95 shadow-md uppercase tracking-wider text-sm">
                        Simpan Perubahan Venue
                    </button>
                </div>
            </div>

        </div>
    </form>
</div>

{{-- LEAFLET CSS & JS --}}
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
let map, marker;
let lapCount = 0;

function initMap() {
    const defaultLat = {{ $venue->latitude ?? '-6.2088' }};
    const defaultLng = {{ $venue->longitude ?? '106.8456' }};
    
    map = L.map('map').setView([defaultLat, defaultLng], 15);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap'
    }).addTo(map);

    marker = L.marker([defaultLat, defaultLng], {
        draggable: true
    }).addTo(map);

    marker.on('dragend', function(e) {
        const position = marker.getLatLng();
        updateCoords(position.lat, position.lng);
    });

    map.on('click', function(e) {
        marker.setLatLng(e.latlng);
        updateCoords(e.latlng.lat, e.latlng.lng);
    });

    updateCoords(defaultLat, defaultLng);
    setupSearch();
    
    // Load existing tags
    @if($venue->facilities)
        @php
            $existingFacilities = is_array($venue->facilities) ? $venue->facilities : json_decode($venue->facilities, true);
        @endphp
        @if(is_array($existingFacilities))
            @foreach($existingFacilities as $fac)
                if(!facilities.includes("{{ $fac }}")) {
                    facilities.push("{{ $fac }}");
                }
            @endforeach
            renderFacilities();
        @endif
    @endif
    
    @if($venue->sport_type)
        @php
            $existingSports = is_array($venue->sport_type) ? $venue->sport_type : array_map('trim', explode(',', $venue->sport_type));
        @endphp
        @if(is_array($existingSports))
            @foreach($existingSports as $spt)
                if(!venueSports.includes("{{ $spt }}")) {
                    venueSports.push("{{ $spt }}");
                }
            @endforeach
            renderVenueSports();
        @endif
    @endif
    
    // Fields array rendering logic removed since fields are managed in the dashboard now
}

function updateCoords(lat, lng) {
    document.getElementById('latInput').value = lat.toFixed(6);
    document.getElementById('lngInput').value = lng.toFixed(6);
}

function setupSearch() {
    const input = document.getElementById("locationAutocomplete");
    const suggestionBox = document.createElement('div');
    suggestionBox.className = 'absolute z-50 w-full bg-white border rounded-lg mt-1 shadow-xl hidden overflow-hidden';
    input.parentNode.style.position = 'relative';
    input.parentNode.appendChild(suggestionBox);

    let timeout;
    input.addEventListener('input', function() {
        clearTimeout(timeout);
        const query = input.value.trim();
        if (query.length < 3) {
            suggestionBox.classList.add('hidden');
            return;
        }

        timeout = setTimeout(() => {
            fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}&limit=5`)
                .then(res => res.json())
                .then(data => {
                    suggestionBox.innerHTML = '';
                    if (data.length > 0) {
                        data.forEach(item => {
                            const div = document.createElement('div');
                            div.className = 'p-3 hover:bg-gray-50 cursor-pointer border-b last:border-0 text-sm';
                            div.innerText = item.display_name;
                            div.onclick = () => {
                                input.value = item.display_name;
                                const lat = parseFloat(item.lat);
                                const lng = parseFloat(item.lon);
                                
                                map.setView([lat, lng], 16);
                                marker.setLatLng([lat, lng]);
                                updateCoords(lat, lng);
                                suggestionBox.classList.add('hidden');

                                // Try to extract city
                                fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`)
                                    .then(res => res.json())
                                    .then(revData => {
                                        const city = revData.address.city || revData.address.town || revData.address.municipality || revData.address.county;
                                        if (city) document.getElementById('cityInput').value = city;
                                    });
                            };
                            suggestionBox.appendChild(div);
                        });
                        suggestionBox.classList.remove('hidden');
                    } else {
                        suggestionBox.classList.add('hidden');
                    }
                });
        }, 500);
    });

    // Close suggestions on outside click
    document.addEventListener('click', (e) => {
        if (!input.contains(e.target)) suggestionBox.classList.add('hidden');
    });
}

// Load map
window.onload = initMap;



/* DROPDOWN LOGIC */
function toggleDropdown(id){
    const box = document.getElementById(id);
    const isVisible = box.style.display === 'block';
    document.querySelectorAll('.dropdown-box').forEach(b => b.style.display = 'none');
    box.style.display = isVisible ? 'none' : 'block';
}

// MULTI SELECT (VENUE SPORTS)
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
    const hiddenContainer = document.getElementById('venueSportHiddenInputs');
    container.innerHTML = '';
    hiddenContainer.innerHTML = '';
    
    venueSports.forEach((s, idx) => {
        const t = document.createElement('div');
        t.className = 'tag animate-in fade-in duration-300';
        t.innerHTML = `${s} <button type="button" onclick="removeVenueSport(${idx})">x</button>`;
        container.appendChild(t);

        const hidden = document.createElement('input');
        hidden.type = 'hidden';
        hidden.name = 'sport_type[]';
        hidden.value = s;
        hiddenContainer.appendChild(hidden);
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
    parent.querySelector('.sport-hidden-input').value = val;
    parent.querySelector('.dropdown-box').style.display = 'none';
}

function selectCustom(el, val, label){
    const parent = el.closest('.dropdown');
    parent.querySelector('.selected-val').innerText = label;
    parent.querySelector('input[type="hidden"]').value = val;
    parent.querySelector('.dropdown-box').style.display = 'none';
}

// Close on outside click
document.addEventListener('click', function(e){
    if(!e.target.closest('.dropdown')){
        document.querySelectorAll('.dropdown-box').forEach(b => b.style.display = 'none');
    }
});

/* FACILITIES LOGIC */
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
    const hiddenContainer = document.getElementById('facilityHiddenInputs');
    container.innerHTML = '';
    hiddenContainer.innerHTML = '';
    
    facilities.forEach((f, idx) => {
        const t = document.createElement('div');
        t.className = 'tag animate-in fade-in duration-300';
        t.innerHTML = `${f} <button type="button" onclick="removeFacility(${idx})">x</button>`;
        container.appendChild(t);

        const hidden = document.createElement('input');
        hidden.type = 'hidden';
        hidden.name = 'facilities[]';
        hidden.value = f;
        hiddenContainer.appendChild(hidden);
    });
}

function removeFacility(idx){
    facilities.splice(idx, 1);
    renderFacilities();
}


</script>

</body>
</html>