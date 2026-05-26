<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Public Match Detail</title>
<script src="https://cdn.tailwindcss.com"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"/>
<script type="text/javascript"
    src="https://app.sandbox.midtrans.com/snap/snap.js"
    data-client-key="{{ config('midtrans.client_key') }}"></script>
</head>

<body class="bg-gray-100 min-h-screen font-sans">

<div class="px-10 py-8">

    <!-- Back Button -->
    <a href="{{ url()->previous() !== url()->current() ? url()->previous() : route('matches.index') }}" class="inline-flex items-center text-[#1b3a1b] hover:text-[#2a5a2a] mb-6">
        <i class="fas fa-arrow-left mr-2"></i> Kembali
    </a>

    <!-- Match Header -->
    <div class="bg-white rounded-xl overflow-hidden mb-8 shadow-sm">
        <div class="relative h-64">
            <img src="{{ $match->booking->field->venue->photo_url ?? 'https://images.unsplash.com/photo-1584466977773-e625c37cdd50' }}"
                 class="w-full h-full object-cover">
        </div>
        
        <div class="p-6">
            @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-4">
                {{ session('success') }}
            </div>
            @endif

            @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-4">
                {{ session('error') }}
            </div>
            @endif

            <h1 class="text-3xl font-bold text-gray-800 mb-1">{{ $match->title ?? 'Public Match' }}</h1>
            <p class="text-gray-500 text-sm mb-1">
                <i class="fas fa-map-marker-alt mr-1"></i> {{ $match->booking->field->venue->name ?? '' }} - {{ $match->booking->field->venue->city ?? '' }}
            </p>
            <div class="flex items-center gap-2 mb-5">
                <i class="fas fa-calendar-alt text-green-600 text-sm"></i>
                <span class="text-gray-500 text-sm">
                    {{ \Carbon\Carbon::parse($match->booking->timeSlot->date)->translatedFormat('d F Y') }} | 
                    {{ \Carbon\Carbon::parse($match->booking->timeSlot->start_time)->format('H:i') }} – {{ \Carbon\Carbon::parse($match->booking->timeSlot->end_time)->format('H:i') }}
                </span>
            </div>

            <!-- TWO COLUMN LAYOUT -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

                <!-- KIRI: Deskripsi -->
                <div>
                    <div class="mb-5">
                        <h2 class="text-lg font-bold text-gray-800 mb-2">Deskripsi</h2>
                        <p class="text-gray-600 leading-relaxed text-sm">
                            {{ $match->description ?? 'Tidak ada deskripsi.' }}
                        </p>
                    </div>
                    <hr class="border-gray-200 mb-5">

                    <div class="mb-5">
                        <h2 class="text-lg font-bold text-gray-800 mb-4">Informasi Match</h2>
                        
                        <div class="grid grid-cols-2 gap-y-4 gap-x-4 text-sm">
                            <div>
                                <p class="text-gray-400">Lapangan</p>
                                <p class="font-medium text-gray-800">{{ $match->booking->field->name ?? '-' }}</p>
                            </div>
                            <div>
                                <p class="text-gray-400">Jenis Olahraga</p>
                                <p class="font-medium text-gray-800">{{ $match->booking->field->sport_type ?? '-' }}</p>
                            </div>
                            <div>
                                <p class="text-gray-400">Jumlah Slot</p>
                                <p class="font-medium text-green-600">
                                    {{ $match->participants->count() }}/{{ $match->total_players ?? '-' }} pemain
                                </p>
                            </div>
                            <div>
                                <p class="text-gray-400">Gender</p>
                                <p class="font-medium text-gray-800">
                                    @if($match->gender_preference === 'mixed') Bebas (Mixed)
                                    @elseif($match->gender_preference === 'male') Pria
                                    @elseif($match->gender_preference === 'female') Wanita
                                    @else {{ ucfirst($match->gender_preference) }}
                                    @endif
                                </p>
                            </div>
                            <div>
                                <p class="text-gray-400">Harga per Orang</p>
                                <p class="font-medium text-blue-600">
                                    @if($match->price_per_person > 0)
                                        Rp {{ number_format($match->price_per_person, 0, ',', '.') }}
                                    @else
                                        Gratis
                                    @endif
                                </p>
                            </div>
                            <div>
                                <p class="text-gray-400">Status</p>
                                <p class="font-medium">
                                    @if($match->status === 'open')
                                        <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-semibold">Open</span>
                                    @elseif($match->status === 'full')
                                        <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs font-semibold">Full</span>
                                    @else
                                        <span class="bg-gray-100 text-gray-600 px-3 py-1 rounded-full text-xs font-semibold">{{ ucfirst($match->status) }}</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- KANAN: Fasilitas + Map -->
                <div>
                    <!-- Map -->
                    <div class="mb-5">
                        <h2 class="text-lg font-bold text-gray-800 mb-3">Peta Lokasi</h2>
                        <div class="rounded-xl overflow-hidden border border-gray-200 h-44 bg-gray-100 flex items-center justify-center relative">
                            @php
                                $venue = $match->booking->field->venue;
                            @endphp
                            @if($venue && $venue->latitude && $venue->longitude)
                                <iframe width="100%" height="100%" frameborder="0" style="border:0; position:absolute; top:0; left:0;"
                                    src="https://maps.google.com/maps?q={{ $venue->latitude }},{{ $venue->longitude }}&z=15&output=embed"
                                    allowfullscreen>
                                </iframe>
                            @else
                                <div class="text-center text-gray-400">
                                    <i class="fas fa-map-marker-alt text-2xl mb-1 block text-[#1b3a1b]"></i>
                                    <p class="text-sm">Peta Lokasi Belum Tersedia</p>
                                </div>
                            @endif
                        </div>
                        @if($venue)
                        <p class="text-xs text-gray-500 mt-2"><i class="fas fa-map-pin mr-1"></i> {{ $venue->location }}</p>
                        @endif
                    </div>

                    <!-- PEMBUAT -->
                    <div class="bg-gray-50 rounded-xl p-4 mb-6 border border-gray-100 flex items-center gap-4">
                        <div class="w-10 h-10 bg-green-100 text-green-700 rounded-full flex items-center justify-center font-bold text-lg">
                            {{ strtoupper(substr($match->creator->name ?? 'U', 0, 1)) }}
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 uppercase tracking-wider font-semibold">Dibuat oleh</p>
                            <p class="font-bold text-gray-800">{{ $match->creator->name ?? '-' }}</p>
                        </div>
                    </div>

                    @auth
                        @if(auth()->id() === $match->creator_id)
                            @include('pubmatch.partials.participants')
                        @endif
                    @endauth

                    <!-- CTA -->
                    @auth
                        @php $isCreator = auth()->id() === $match->creator_id; @endphp

                        @if($isCreator)
                            <div class="w-full bg-green-50 text-green-700 py-3 rounded-xl font-semibold text-center border border-green-200">
                                Kamu adalah pembuat match ini
                            </div>
                        @elseif($match->status === 'open' && $match->participants->where('user_id', auth()->id())->count() === 0)
                            @if($match->price_per_person > 0)
                                <button onclick="payAndJoin()"
                                    class="w-full bg-[#1b3a1b] hover:bg-[#2a5a2a] text-white py-3 rounded-xl font-semibold shadow-md transition">
                                    Join & Bayar Rp {{ number_format($match->price_per_person, 0, ',', '.') }}
                                </button>
                            @else
                                <button onclick="joinFree()"
                                    class="w-full bg-[#1b3a1b] hover:bg-[#2a5a2a] text-white py-3 rounded-xl font-semibold shadow-md transition">
                                    Join Match (Gratis)
                                </button>
                            @endif
                        @elseif($match->participants->where('user_id', auth()->id())->count() > 0)
                            <div class="w-full bg-gray-100 text-gray-600 py-3 rounded-xl font-semibold text-center border border-gray-200">
                                <i class="fas fa-check-circle text-green-600 mr-1"></i> Kamu sudah bergabung
                            </div>
                        @else
                            <div class="w-full bg-red-50 text-red-600 py-3 rounded-xl font-semibold text-center border border-red-200">
                                Match sudah penuh
                            </div>
                        @endif
                    @else
                        <a href="{{ route('login') }}"
                            class="block w-full bg-[#1b3a1b] hover:bg-[#2a5a2a] text-white py-3 rounded-xl font-semibold shadow-md transition text-center">
                            Login untuk Join
                        </a>
                    @endif
                </div>

            </div>
        </div>
    </div>
</div>

<div id="loadingOverlay" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50">
    <div class="bg-white rounded-2xl p-8 text-center">
        <div class="animate-spin w-10 h-10 border-4 border-green-600 border-t-transparent rounded-full mx-auto mb-4"></div>
        <p class="font-medium">Memproses pembayaran...</p>
    </div>
</div>

<script>
const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
const matchId = {{ $match->id }};

function showLoading(show) {
    document.getElementById('loadingOverlay').classList.toggle('hidden', !show);
}

// Joiner bayar = price_per_person (bukan full)
async function payAndJoin() {
    showLoading(true);

    try {
        const res = await fetch('{{ route("payment.match.create") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            },
            body: JSON.stringify({ match_id: matchId, is_creator: false }),
        });

        const data = await res.json();

        if (!res.ok || !data.snap_token) {
            showLoading(false);
            alert(data.error || 'Gagal membuat token pembayaran');
            return;
        }

        showLoading(false);

        snap.pay(data.snap_token, {
            onSuccess: function(result) {
                showLoading(true);
                fetch('{{ route("payment.match.finish") }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({ order_id: data.order_id, match_id: matchId }),
                }).then(() => {
                    window.location.reload();
                });
            },
            onPending: function(result) {
                showLoading(true);
                fetch('{{ route("payment.match.finish") }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({ order_id: data.order_id, match_id: matchId }),
                }).then(() => {
                    window.location.reload();
                });
            },
            onError: function(result) {
                alert('Pembayaran gagal. Silakan coba lagi.');
            },
            onClose: function() {
                showLoading(true);
                fetch('{{ route("payment.match.finish") }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({ order_id: data.order_id, match_id: matchId }),
                }).then(() => {
                    window.location.reload();
                });
            }
        });

    } catch (err) {
        showLoading(false);
        alert('Terjadi kesalahan. Silakan coba lagi.');
    }
}

async function joinFree() {
    try {
        const res = await fetch('{{ route("payment.match.join") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            },
            body: JSON.stringify({ match_id: matchId }),
        });

        const data = await res.json();

        if (res.ok) {
            alert('Berhasil bergabung!');
            window.location.reload();
        } else {
            alert(data.error || 'Gagal bergabung');
        }
    } catch (err) {
        alert('Terjadi kesalahan. Silakan coba lagi.');
    }
}
</script>

</body>
</html>
