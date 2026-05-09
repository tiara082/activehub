<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Berhasil</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link href="https://fonts.googleapis.com/css2?family=Anton&display=swap" rel="stylesheet" />

    <style>
        .font-anton {
            font-family: 'Anton', sans-serif;
        }
    </style>
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center px-5">

<div class="bg-white w-full max-w-lg rounded-3xl shadow-xl p-10 text-center">

    <!-- ICON -->
    <div class="w-24 h-24 mx-auto rounded-full bg-green-100 flex items-center justify-center mb-6">

        <svg xmlns="http://www.w3.org/2000/svg"
             class="w-12 h-12 text-green-600"
             fill="none"
             viewBox="0 0 24 24"
             stroke="currentColor"
             stroke-width="2.5">

            <path stroke-linecap="round"
                  stroke-linejoin="round"
                  d="M5 13l4 4L19 7"/>

        </svg>

    </div>

    <!-- TITLE -->
    <h1 class="font-anton text-5xl text-[#0b3d0b] tracking-wide">
        SUCCESS
    </h1>

    <p class="text-gray-500 mt-4 leading-relaxed">
        Booking lapangan berhasil dilakukan.
        Jadwal kamu sudah diamankan.
    </p>

    <!-- DETAIL -->
    <div class="mt-8 bg-gray-50 rounded-2xl p-5 text-left space-y-3">

        <div class="flex justify-between">
            <span class="text-gray-500">Lapangan</span>
            <span class="font-semibold">Lapangan A</span>
        </div>

        <div class="flex justify-between">
            <span class="text-gray-500">Tanggal</span>
            <span class="font-semibold">12 April 2026</span>
        </div>

        <div class="flex justify-between">
            <span class="text-gray-500">Jam</span>
            <span class="font-semibold">07:00 - 08:00</span>
        </div>

        <div class="flex justify-between">
            <span class="text-gray-500">Total</span>
            <span class="font-bold text-[#0b3d0b]">Rp 220.000</span>
        </div>

    </div>

    <!-- ACTION BUTTON -->
    <div class="mt-10 space-y-3">

        <!-- PUBLIC MATCH -->
       <a href="{{ route('matches.create', ['booking' => $booking->id]) }}"
        class="w-full flex items-center justify-center
                bg-[#0b3d0b] hover:bg-[#145214]
                text-white font-semibold py-4 rounded-xl transition">

            Buat Public Match

        </a>

        <!-- MAIN SENDIRI -->
        <a href="{{ route('user.dashboard') }}"
           class="w-full flex items-center justify-center
                  border border-gray-300 hover:bg-gray-50
                  text-gray-700 font-semibold py-4 rounded-xl transition">

            Main Sendiri

        </a>

    </div>

</div>

</body>
</html>