<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>ActiveHub - Checkout</title>
    @if (app()->environment('production'))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script src="https://cdn.tailwindcss.com"></script>
    @endif
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Anton&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .font-anton { font-family: 'Anton', sans-serif; }
    </style>
    {{-- Midtrans Snap JS --}}
    <script src="https://app.sandbox.midtrans.com/snap/snap.js"
            data-client-key="{{ config('midtrans.client_key') }}"></script>
</head>
<body class="bg-gray-50 min-h-screen flex flex-col">

<!-- Navbar -->
@include('navbar')

<main class="flex-grow pt-28 pb-16">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Checkout</h1>
            <p class="text-gray-500">Selesaikan pembayaran Anda untuk mengamankan jadwal lapangan.</p>
        </div>

        @if(session('error'))
            <div class="mb-6 bg-red-50 border border-red-200 text-red-700 rounded-xl px-4 py-3 text-sm">
                <i class="fas fa-exclamation-circle mr-2"></i>{{ session('error') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

            <!-- Left Column: Detail Booking & Metode Pembayaran -->
            <div class="lg:col-span-7 xl:col-span-8 space-y-6">

                <!-- Detail Booking -->
                <div class="bg-white border border-gray-100 rounded-2xl p-6 shadow-sm">
                    <h2 class="text-xl font-bold text-gray-900 mb-5">Detail Pesanan</h2>

                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 p-4 border border-gray-100 rounded-xl bg-gray-50">
                        <div class="flex gap-4 items-center">
                            <div class="w-16 h-16 bg-[#1b3a1b] rounded-xl flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-futbol text-white text-2xl"></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-lg text-gray-900 leading-tight">
                                    {{ $booking->field->name ?? 'Lapangan' }}
                                </h3>
                                <p class="text-sm text-gray-500 mt-1">
                                    <i class="fas fa-map-marker-alt w-4 text-center mr-1 text-green-700"></i>
                                    {{ $booking->field->venue->name ?? '-' }}
                                </p>
                                @if($booking->timeSlot)
                                <p class="text-sm text-gray-500 mt-0.5">
                                    <i class="far fa-calendar-alt w-4 text-center mr-1"></i>
                                    {{ \Carbon\Carbon::parse($booking->timeSlot->date)->translatedFormat('D, d M Y') }}
                                    | {{ \Carbon\Carbon::parse($booking->timeSlot->start_time)->format('H:i') }}
                                    - {{ \Carbon\Carbon::parse($booking->timeSlot->end_time)->format('H:i') }}
                                </p>
                                @endif
                            </div>
                        </div>
                        <div class="font-bold text-gray-900 text-lg">
                            Rp {{ number_format($booking->total_price, 0, ',', '.') }}
                        </div>
                    </div>
                </div>

                <!-- Metode Pembayaran -->
                <div class="bg-white border border-gray-100 rounded-2xl p-6 shadow-sm">
                    <h2 class="text-xl font-bold text-gray-900 mb-2">Metode Pembayaran</h2>
                    <p class="text-sm text-gray-500 mb-6">Pilih metode pembayaran yang Anda inginkan. Pembayaran diproses aman oleh Midtrans.</p>

                    <!-- E-Wallet & QRIS -->
                    <div class="mb-6">
                        <h3 class="font-bold text-gray-800 mb-3 text-xs uppercase tracking-wider flex items-center gap-2">
                            <i class="fas fa-qrcode text-gray-400"></i> E-Wallet & QRIS
                        </h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <button onclick="selectPayment(this, 'qris')"
                                    data-method="qris"
                                    class="payment-item flex items-center gap-3 p-3.5 border border-gray-200 rounded-xl hover:border-[#1b3a1b] hover:bg-green-50/30 transition group text-left">
                                <div class="w-10 h-7 bg-gray-100 rounded flex items-center justify-center shrink-0">
                                    <i class="fas fa-qrcode text-gray-600 text-sm"></i>
                                </div>
                                <div class="flex-1">
                                    <span class="block font-semibold text-gray-800 text-sm">QRIS</span>
                                    <span class="block text-[11px] text-gray-500 leading-tight mt-0.5">Semua E-Wallet & M-Banking</span>
                                </div>
                                <div class="w-5 h-5 flex items-center justify-center rounded-full border border-gray-300 group-hover:border-[#1b3a1b] transition check-container">
                                    <i class="fas fa-check text-[10px] text-[#1b3a1b] hidden check-icon"></i>
                                </div>
                            </button>

                            <button onclick="selectPayment(this, 'snap')"
                                    data-method="snap"
                                    class="payment-item flex items-center gap-3 p-3.5 border border-gray-200 rounded-xl hover:border-[#1b3a1b] hover:bg-green-50/30 transition group text-left">
                                <div class="w-10 h-7 bg-gray-100 rounded flex items-center justify-center shrink-0">
                                    <i class="fas fa-wallet text-gray-600 text-sm"></i>
                                </div>
                                <div class="flex-1">
                                    <span class="block font-semibold text-gray-800 text-sm">GoPay / ShopeePay</span>
                                    <span class="block text-[11px] text-gray-500 leading-tight mt-0.5">Bayar instan via aplikasi</span>
                                </div>
                                <div class="w-5 h-5 flex items-center justify-center rounded-full border border-gray-300 group-hover:border-[#1b3a1b] transition check-container">
                                    <i class="fas fa-check text-[10px] text-[#1b3a1b] hidden check-icon"></i>
                                </div>
                            </button>
                        </div>
                    </div>

                    <!-- Virtual Account -->
                    <div>
                        <h3 class="font-bold text-gray-800 mb-3 text-xs uppercase tracking-wider flex items-center gap-2">
                            <i class="fas fa-university text-gray-400"></i> Transfer Bank (Virtual Account)
                        </h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            @foreach([
                                ['code' => 'bca',     'label' => 'BCA Virtual Account',     'bg' => 'bg-blue-50',    'text' => 'text-blue-800',   'border' => 'border-blue-100',   'display' => 'BCA'],
                                ['code' => 'mandiri', 'label' => 'Mandiri Virtual Account',  'bg' => 'bg-yellow-50',  'text' => 'text-yellow-700', 'border' => 'border-yellow-100', 'display' => 'MDR'],
                                ['code' => 'bni',     'label' => 'BNI Virtual Account',      'bg' => 'bg-orange-50',  'text' => 'text-orange-600', 'border' => 'border-orange-100', 'display' => 'BNI'],
                                ['code' => 'bri',     'label' => 'BRI Virtual Account',      'bg' => 'bg-blue-50',    'text' => 'text-blue-700',   'border' => 'border-blue-100',   'display' => 'BRI'],
                                ['code' => 'permata', 'label' => 'Permata Virtual Account',  'bg' => 'bg-emerald-50', 'text' => 'text-emerald-700','border' => 'border-emerald-100','display' => 'PRMT'],
                            ] as $bank)
                            <button onclick="selectPayment(this, 'snap')"
                                    data-method="snap"
                                    class="payment-item flex items-center gap-3 p-3.5 border border-gray-200 rounded-xl hover:border-[#1b3a1b] hover:bg-green-50/30 transition group text-left">
                                <div class="w-10 h-7 {{ $bank['bg'] }} {{ $bank['text'] }} font-bold text-xs rounded flex items-center justify-center shrink-0 border {{ $bank['border'] }}">
                                    {{ $bank['display'] }}
                                </div>
                                <div class="flex-1">
                                    <span class="block font-semibold text-gray-800 text-sm">{{ $bank['label'] }}</span>
                                </div>
                                <div class="w-5 h-5 flex items-center justify-center rounded-full border border-gray-300 group-hover:border-[#1b3a1b] transition check-container">
                                    <i class="fas fa-check text-[10px] text-[#1b3a1b] hidden check-icon"></i>
                                </div>
                            </button>
                            @endforeach
                        </div>
                    </div>
                </div>

            </div>

            <!-- Right Column: Summary -->
            <div class="lg:col-span-5 xl:col-span-4">
                <div class="bg-white border border-gray-100 rounded-2xl p-6 shadow-sm sticky top-28">

                    <h3 class="text-lg font-bold text-gray-900 mb-4">Ringkasan Pembayaran</h3>

                    <div class="space-y-3 mb-6">
                        <div class="flex justify-between text-sm text-gray-600">
                            <span>{{ $booking->field->name ?? 'Lapangan' }}</span>
                            <span class="font-medium text-gray-800">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-sm text-gray-600">
                            <span>Biaya Layanan</span>
                            <span class="font-medium text-green-700">Gratis</span>
                        </div>
                    </div>

                    <div class="border-t border-dashed border-gray-200 pt-4 mb-6 flex justify-between items-end">
                        <span class="text-sm text-gray-500">Total Pembayaran</span>
                        <span class="text-2xl font-bold text-[#1b3a1b]">
                            Rp {{ number_format($booking->total_price, 0, ',', '.') }}
                        </span>
                    </div>

                    <!-- Loading indicator -->
                    <div id="loadingBtn" class="hidden w-full bg-gray-300 text-white font-bold py-4 rounded-xl text-center">
                        <i class="fas fa-spinner fa-spin mr-2"></i> Memproses...
                    </div>

                    <button id="payBtn"
                            onclick="bayarSekarang()"
                            class="w-full bg-[#1b3a1b] hover:bg-[#2a5a2a] text-white font-bold py-4 rounded-xl shadow-md shadow-green-900/10 transition transform active:scale-[0.98] text-center">
                        Bayar Sekarang
                    </button>

                    <p id="noMethodMsg" class="text-center text-xs text-red-500 mt-3 hidden">
                        <i class="fas fa-exclamation-circle"></i> Pilih metode pembayaran terlebih dahulu.
                    </p>

                    <p class="text-center text-xs text-gray-400 mt-4 flex items-center justify-center gap-1">
                        <i class="fas fa-lock"></i> Pembayaran aman terenkripsi oleh Midtrans
                    </p>

                </div>
            </div>

        </div>
    </div>
</main>

<script>
    let selectedMethod = null;

    function selectPayment(selectedButton, methodType) {
        selectedMethod = methodType;

        // Reset semua
        document.querySelectorAll('.payment-item').forEach(item => {
            item.classList.remove('border-[#1b3a1b]', 'bg-green-50/50', 'active-payment');
            item.classList.add('border-gray-200');

            const checkContainer = item.querySelector('.check-container');
            checkContainer.classList.remove('border-[#1b3a1b]');
            checkContainer.classList.add('border-gray-300');
            item.querySelector('.check-icon').classList.add('hidden');
        });

        // Aktifkan yang dipilih
        selectedButton.classList.remove('border-gray-200');
        selectedButton.classList.add('border-[#1b3a1b]', 'bg-green-50/50', 'active-payment');

        const checkContainer = selectedButton.querySelector('.check-container');
        checkContainer.classList.remove('border-gray-300');
        checkContainer.classList.add('border-[#1b3a1b]');
        selectedButton.querySelector('.check-icon').classList.remove('hidden');

        // Sembunyikan error
        document.getElementById('noMethodMsg').classList.add('hidden');
    }

    function setLoading(isLoading) {
        document.getElementById('payBtn').classList.toggle('hidden', isLoading);
        document.getElementById('loadingBtn').classList.toggle('hidden', !isLoading);
    }

    async function bayarSekarang() {
        if (!selectedMethod) {
            document.getElementById('noMethodMsg').classList.remove('hidden');
            return;
        }

        setLoading(true);

        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
        const bookingId = {{ $booking->id }};

        if (selectedMethod === 'qris') {
            // Flow QRIS → tampilkan halaman QR
            try {
                const res = await fetch(`/payment/${bookingId}/qris`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                    },
                });

                const data = await res.json();

                if (data.error) {
                    alert('Gagal: ' + data.error);
                    setLoading(false);
                    return;
                }

                // Redirect ke halaman QR
                window.location.href = data.redirect_url;

            } catch (e) {
                alert('Terjadi kesalahan. Coba lagi.');
                setLoading(false);
            }

        } else {
            // Flow Snap popup (GoPay, VA, dll)
            try {
                const res = await fetch(`/payment/${bookingId}/snap`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                    },
                });

                const data = await res.json();

                if (data.error) {
                    alert('Gagal: ' + data.error);
                    setLoading(false);
                    return;
                }

                // Buka Snap popup
                snap.pay(data.snap_token, {
                    onSuccess: function(result) {
                        window.location.href = `/payment/${bookingId}/success`;
                    },
                    onPending: function(result) {
                        window.location.href = `/payment/${bookingId}/success`;
                    },
                    onError: function(result) {
                        alert('Pembayaran gagal. Silakan coba lagi.');
                        setLoading(false);
                    },
                    onClose: function() {
                        window.location.href = `/payment/${bookingId}/success`;
                    }
                });

            } catch (e) {
                alert('Terjadi kesalahan. Coba lagi.');
                setLoading(false);
            }
        }
    }
</script>

</body>
</html>