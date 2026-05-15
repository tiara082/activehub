<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Public Match Detail</title>
<script src="https://cdn.tailwindcss.com"></script>
<script type="text/javascript"
    src="https://app.sandbox.midtrans.com/snap/snap.js"
    data-client-key="{{ config('midtrans.client_key') }}"></script>
</head>

<body class="bg-gray-100 font-sans">

<div class="max-w-4xl mx-auto py-10 px-6">

    <!-- CARD -->
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden">

        <!-- HERO IMAGE -->
        <img src="https://images.unsplash.com/photo-1584466977773-e625c37cdd50"
            class="w-full h-72 object-cover">

        <!-- CONTENT -->
        <div class="p-6">

            @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-4">
                {{ session('success') }}
            </div>
            @endif

            <!-- TITLE -->
            <div class="mb-4">
                <h1 class="text-2xl font-bold">{{ $match->title ?? 'Public Match' }}</h1>
                <p class="text-gray-500">{{ $match->booking->field->venue->name ?? '' }}</p>
            </div>

            <hr class="mb-4">

            <!-- DESKRIPSI -->
            <div class="mb-6">
                <h2 class="font-semibold mb-2">Deskripsi</h2>
                <p class="text-gray-600 text-sm leading-relaxed">
                    {{ $match->description ?? 'Tidak ada deskripsi.' }}
                </p>
            </div>

            <hr class="mb-4">

            <!-- DETAIL -->
            <div class="grid grid-cols-2 gap-4 text-sm mb-6">

                <div>
                    <p class="text-gray-400">Lapangan</p>
                    <p class="font-medium">{{ $match->booking->field->name ?? '-' }}</p>
                </div>

                <div>
                    <p class="text-gray-400">Jenis Olahraga</p>
                    <p class="font-medium">{{ $match->booking->field->sport_type ?? '-' }}</p>
                </div>

                <div>
                    <p class="text-gray-400">Tanggal</p>
                    <p class="font-medium">{{ $match->booking->timeSlot->date ?? '-' }}</p>
                </div>

                <div>
                    <p class="text-gray-400">Jam</p>
                    <p class="font-medium">
                        {{ $match->booking->timeSlot->start_time ?? '' }} - {{ $match->booking->timeSlot->end_time ?? '' }}
                    </p>
                </div>

                <div>
                    <p class="text-gray-400">Jumlah Slot</p>
                    <p class="font-medium text-green-600">
                        {{ $match->participants->count() }}/{{ $match->total_players ?? '-' }} pemain
                    </p>
                </div>

                <div>
                    <p class="text-gray-400">Gender</p>
                    <p class="font-medium">
                        @if($match->gender_preference === 'mixed') Bebas (Mixed)
                        @elseif($match->gender_preference === 'male') Pria
                        @elseif($match->gender_preference === 'female') Wanita
                        @else {{ $match->gender_preference }}
                        @endif
                    </p>
                </div>

                <div>
                    <p class="text-gray-400">Harga Lapangan (Total)</p>
                    <p class="font-medium text-gray-600">
                        Rp {{ number_format($match->booking->field->price_per_hour ?? 0, 0, ',', '.') }}
                    </p>
                </div>

                <div>
                    <p class="text-gray-400">Harga per Orang (Patungan)</p>
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
                            <span class="text-green-600">Open</span>
                        @elseif($match->status === 'full')
                            <span class="text-yellow-600">Full</span>
                        @else
                            <span class="text-gray-500">{{ ucfirst($match->status) }}</span>
                        @endif
                    </p>
                </div>

            </div>

            <!-- PEMBUAT -->
            <div class="bg-gray-50 rounded-lg p-4 mb-6">
                <p class="text-sm text-gray-500">Dibuat oleh:</p>
                <p class="font-medium">{{ $match->creator->name ?? '-' }}</p>
            </div>

            <!-- CTA -->
            @auth
                @php $isCreator = auth()->id() === $match->creator_id; @endphp

                @if($isCreator)
                    <div class="w-full bg-green-100 text-green-700 py-3 rounded-xl font-semibold text-center border border-green-300">
                        Kamu pembuat match ini
                    </div>
                @elseif($match->status === 'open' && $match->participants->where('user_id', auth()->id())->count() === 0)
                    @if($match->price_per_person > 0)
                        <button onclick="payAndJoin()"
                            class="w-full bg-green-600 hover:bg-green-700 text-white py-3 rounded-xl font-semibold shadow-md transition">
                            Join & Bayar Rp {{ number_format($match->price_per_person, 0, ',', '.') }}
                        </button>
                    @else
                        <button onclick="joinFree()"
                            class="w-full bg-green-600 hover:bg-green-700 text-white py-3 rounded-xl font-semibold shadow-md transition">
                            Join Match (Gratis)
                        </button>
                    @endif
                @elseif($match->participants->where('user_id', auth()->id())->count() > 0)
                    <div class="w-full bg-gray-200 text-gray-600 py-3 rounded-xl font-semibold text-center">
                        Kamu sudah bergabung
                    </div>
                @else
                    <div class="w-full bg-gray-200 text-gray-600 py-3 rounded-xl font-semibold text-center">
                        Match sudah penuh
                    </div>
                @endif
            @else
                <a href="{{ route('login') }}"
                    class="block w-full bg-green-600 hover:bg-green-700 text-white py-3 rounded-xl font-semibold shadow-md transition text-center">
                    Login untuk Join
                </a>
            @endif

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
                alert('Pembayaran pending. Silakan selesaikan pembayaran.');
            },
            onError: function(result) {
                alert('Pembayaran gagal. Silakan coba lagi.');
            },
            onClose: function() {
                alert('Kamu menutup popup pembayaran.');
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
