<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Berhasil - ActiveHub</title>
    @if (app()->environment('production'))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script src="https://cdn.tailwindcss.com"></script>
    @endif
    <link href="https://fonts.googleapis.com/css2?family=Anton&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .font-anton { font-family: 'Anton', sans-serif; }

        @keyframes successPop {
            0%   { transform: scale(0.5); opacity: 0; }
            70%  { transform: scale(1.1); }
            100% { transform: scale(1); opacity: 1; }
        }
        .success-icon { animation: successPop 0.6s ease forwards; }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(16px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .fade-up { animation: fadeUp 0.5s ease forwards; }
        .delay-1 { animation-delay: 0.2s; opacity: 0; }
        .delay-2 { animation-delay: 0.4s; opacity: 0; }
        .delay-3 { animation-delay: 0.6s; opacity: 0; }
    </style>
</head>

<body class="bg-gray-50 min-h-screen flex items-center justify-center px-5 py-10">

<div class="bg-white w-full max-w-lg rounded-3xl shadow-xl p-10 text-center">

    <!-- SUCCESS ICON -->
    <div class="w-24 h-24 mx-auto rounded-full bg-green-100 flex items-center justify-center mb-6 success-icon">
        <svg xmlns="http://www.w3.org/2000/svg"
             class="w-12 h-12 text-green-600"
             fill="none"
             viewBox="0 0 24 24"
             stroke="currentColor"
             stroke-width="2.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
        </svg>
    </div>

    <!-- TITLE -->
    <h1 class="font-anton text-5xl text-[#0b3d0b] tracking-wide fade-up">SUCCESS</h1>

    <p class="text-gray-500 mt-4 leading-relaxed fade-up delay-1">
        Booking lapangan berhasil dilakukan.<br>
        Jadwal kamu sudah diamankan. 🎉
    </p>

    <!-- DETAIL BOOKING -->
    <div class="mt-8 bg-gray-50 rounded-2xl p-5 text-left space-y-3 fade-up delay-2">

        <div class="flex justify-between items-center">
            <span class="text-gray-500 text-sm">No. Booking</span>
            <span class="font-semibold text-sm text-[#0b3d0b]">#{{ str_pad($booking->id, 6, '0', STR_PAD_LEFT) }}</span>
        </div>

        <div class="border-t border-gray-100"></div>

        <div class="flex justify-between items-center">
            <span class="text-gray-500 text-sm">Lapangan</span>
            <span class="font-semibold text-sm">{{ $booking->field->name ?? '-' }}</span>
        </div>

        <div class="flex justify-between items-center">
            <span class="text-gray-500 text-sm">Venue</span>
            <span class="font-semibold text-sm">{{ $booking->field->venue->name ?? '-' }}</span>
        </div>

        @if($booking->timeSlot)
        <div class="flex justify-between items-center">
            <span class="text-gray-500 text-sm">Tanggal</span>
            <span class="font-semibold text-sm">
                {{ \Carbon\Carbon::parse($booking->timeSlot->date)->translatedFormat('d M Y') }}
            </span>
        </div>

        <div class="flex justify-between items-center">
            <span class="text-gray-500 text-sm">Jam</span>
            <span class="font-semibold text-sm">
                {{ \Carbon\Carbon::parse($booking->timeSlot->start_time)->format('H:i') }}
                –
                {{ \Carbon\Carbon::parse($booking->timeSlot->end_time)->format('H:i') }}
            </span>
        </div>
        @endif

        <div class="border-t border-gray-100"></div>

        <div class="flex justify-between items-center">
            <span class="text-gray-500 text-sm">Total Dibayar</span>
            <span class="font-bold text-[#0b3d0b] text-lg">
                Rp {{ number_format($booking->total_price, 0, ',', '.') }}
            </span>
        </div>

        <div class="flex justify-between items-center">
            <span class="text-gray-500 text-sm">Status</span>
            <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">
                <i class="fas fa-check-circle"></i> Terkonfirmasi
            </span>
        </div>

    </div>

    <!-- ACTION BUTTONS -->
    <div class="mt-8 space-y-3 fade-up delay-3">

        <!-- Buat Public Match -->
        <a href="{{ route('matches.create', ['booking' => $booking->id]) }}"
           class="w-full flex items-center justify-center bg-[#0b3d0b] hover:bg-[#145214] text-white font-semibold py-4 rounded-xl transition">
            <i class="fas fa-users mr-2"></i> Buat Public Match
        </a>

        <!-- Lihat Booking Saya -->
        <a href="{{ route('user.bookings') }}"
           class="w-full flex items-center justify-center border border-gray-300 hover:bg-gray-50 text-gray-700 font-semibold py-4 rounded-xl transition">
            <i class="fas fa-calendar-check mr-2"></i> Lihat Booking Saya
        </a>

        <!-- Kembali ke Home -->
        <a href="{{ route('home') }}"
           class="block text-sm text-gray-400 hover:text-gray-600 mt-2 transition">
            Kembali ke Beranda
        </a>

    </div>

</div>

</body>
</html>