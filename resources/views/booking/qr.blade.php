<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Pembayaran QRIS - ActiveHub</title>
    @if (app()->environment('production'))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script src="https://cdn.tailwindcss.com"></script>
    @endif
    <link href="https://fonts.googleapis.com/css2?family=Anton&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .font-anton { font-family: 'Anton', sans-serif; }

        @keyframes pulse-ring {
            0%   { box-shadow: 0 0 0 0 rgba(27,58,27,0.3); }
            70%  { box-shadow: 0 0 0 16px rgba(27,58,27,0); }
            100% { box-shadow: 0 0 0 0 rgba(27,58,27,0); }
        }
        .qr-pulse { animation: pulse-ring 2s infinite; }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }
        .animate-spin-slow { animation: spin 1.2s linear infinite; }
    </style>
</head>

<body class="bg-gray-50 min-h-screen flex items-center justify-center px-5 py-10">

<div class="bg-white w-full max-w-md rounded-3xl shadow-xl p-8 text-center">

    <!-- Logo / Brand -->
    <div class="mb-6">
        <span class="font-anton text-2xl text-[#0b3d0b] tracking-wide">ACTIVEHUB</span>
        <p class="text-xs text-gray-400 mt-1">Pembayaran QRIS</p>
    </div>

    <!-- Booking Info -->
    <div class="bg-gray-50 rounded-2xl px-5 py-3 mb-6 text-left">
        <p class="text-xs text-gray-500 mb-1">Detail Booking</p>
        <p class="font-semibold text-gray-800 text-sm">{{ $booking->field->name ?? 'Lapangan' }}</p>
        <p class="text-xs text-gray-500">{{ $booking->field->venue->name ?? '' }}</p>
        @if($booking->timeSlot)
        <p class="text-xs text-gray-500 mt-1">
            {{ \Carbon\Carbon::parse($booking->timeSlot->date)->translatedFormat('d M Y') }}
            · {{ \Carbon\Carbon::parse($booking->timeSlot->start_time)->format('H:i') }}–{{ \Carbon\Carbon::parse($booking->timeSlot->end_time)->format('H:i') }}
        </p>
        @endif
    </div>

    <!-- QR Code -->
    <div id="qrContainer" class="bg-white border-2 border-gray-100 rounded-2xl p-4 inline-block qr-pulse mb-6">
        @if($qrUrl)
            {{-- QR dari Midtrans --}}
            <img src="{{ $qrUrl }}"
                 alt="QR Payment"
                 class="rounded-xl w-64 h-64 object-contain"
                 id="qrImage"
                 onerror="showQrFallback()">
        @else
            {{-- Fallback QR lokal --}}
            <img src="https://api.qrserver.com/v1/create-qr-code/?size=260x260&data={{ urlencode('ACTIVEHUB-BOOKING-' . $booking->id) }}"
                 alt="QR Payment"
                 class="rounded-xl w-64 h-64"
                 id="qrImage">
        @endif
    </div>

    <!-- TOTAL -->
    <div class="mb-2">
        <p class="text-sm text-gray-500">Total Pembayaran</p>
        <h2 class="text-3xl font-bold text-gray-900 mt-1">
            Rp {{ number_format($booking->total_price, 0, ',', '.') }}
        </h2>
    </div>

    <!-- Order ID -->
    @if($orderId)
    <p class="text-xs text-gray-400 mb-4">Order: {{ $orderId }}</p>
    @endif

    <!-- COUNTDOWN TIMER -->
    <div class="mb-6 bg-yellow-50 border border-yellow-200 rounded-xl py-3 px-4">
        <p class="text-sm text-yellow-700 font-medium">Selesaikan pembayaran dalam</p>
        <p class="text-2xl font-bold text-yellow-800 mt-1" id="countdown">15:00</p>
        <p class="text-xs text-yellow-600 mt-1">QR kadaluarsa otomatis</p>
    </div>

    <!-- STATUS CHECK -->
    <div id="statusChecking" class="mb-4 flex items-center justify-center gap-2 text-sm text-gray-500">
        <svg class="w-4 h-4 animate-spin-slow text-[#1b3a1b]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
        </svg>
        Menunggu konfirmasi pembayaran...
    </div>

    <!-- PAID SUCCESS (hidden initially) -->
    <div id="successBanner" class="hidden mb-4 bg-green-50 border border-green-200 text-green-700 rounded-xl py-3 px-4 text-sm font-semibold">
        <i class="fas fa-check-circle mr-2"></i>Pembayaran diterima! Mengalihkan...
    </div>

    <!-- EXPIRED (hidden initially) -->
    <div id="expiredBanner" class="hidden mb-4 bg-red-50 border border-red-200 text-red-700 rounded-xl py-3 px-4 text-sm">
        <i class="fas fa-times-circle mr-2"></i>QR sudah kadaluarsa. Silakan ulangi pembayaran.
    </div>

    <!-- BUTTONS -->
    <div class="space-y-3">
        <a href="{{ route('payment.success', $booking->id) }}"
           id="sudahBayarBtn"
           class="w-full flex items-center justify-center bg-[#0b3d0b] hover:bg-[#145214] text-white font-semibold py-4 rounded-xl transition">
            Saya Sudah Bayar
        </a>

        <a href="{{ route('payment.show', $booking->id) }}"
           class="w-full flex items-center justify-center border border-gray-300 hover:bg-gray-50 text-gray-600 font-semibold py-3 rounded-xl transition text-sm">
            <i class="fas fa-arrow-left mr-2"></i> Ganti Metode Pembayaran
        </a>
    </div>

</div>

<script>
    // ============ COUNTDOWN TIMER ============
    const DURATION = 15 * 60; // 15 menit
    let timeLeft = DURATION;
    let timerExpired = false;

    const countdownEl = document.getElementById('countdown');

    function updateCountdown() {
        if (timeLeft <= 0) {
            countdownEl.textContent = '00:00';
            timerExpired = true;
            document.getElementById('expiredBanner').classList.remove('hidden');
            document.getElementById('statusChecking').classList.add('hidden');
            document.getElementById('sudahBayarBtn').classList.add('opacity-50', 'pointer-events-none');
            return;
        }
        const m = String(Math.floor(timeLeft / 60)).padStart(2, '0');
        const s = String(timeLeft % 60).padStart(2, '0');
        countdownEl.textContent = `${m}:${s}`;
        timeLeft--;
    }

    updateCountdown();
    const timerInterval = setInterval(updateCountdown, 1000);

    // ============ POLLING STATUS ============
    const bookingId = {{ $booking->id }};
    const orderId   = '{{ $orderId }}';
    let pollInterval;

    async function checkPaymentStatus() {
        if (timerExpired) {
            clearInterval(pollInterval);
            return;
        }

        try {
            const res = await fetch(`/payment/${bookingId}/status?order_id=${orderId}`, {
                headers: { 'Accept': 'application/json' }
            });
            const data = await res.json();

            if (data.status === 'paid') {
                clearInterval(pollInterval);
                clearInterval(timerInterval);

                document.getElementById('statusChecking').classList.add('hidden');
                document.getElementById('successBanner').classList.remove('hidden');

                setTimeout(() => {
                    window.location.href = data.redirect_url || `/payment/${bookingId}/success`;
                }, 1500);
            }

            if (data.status === 'failed') {
                clearInterval(pollInterval);
                document.getElementById('expiredBanner').classList.remove('hidden');
                document.getElementById('statusChecking').classList.add('hidden');
            }
        } catch (e) {
            // Abaikan error network, lanjut polling
        }
    }

    // Poll setiap 5 detik
    pollInterval = setInterval(checkPaymentStatus, 5000);
    // Langsung cek sekali di awal (setelah 3 detik)
    setTimeout(checkPaymentStatus, 3000);

    function showQrFallback() {
        document.getElementById('qrImage').src =
            `https://api.qrserver.com/v1/create-qr-code/?size=260x260&data=ACTIVEHUB-BOOKING-${bookingId}`;
    }
</script>

</body>
</html>