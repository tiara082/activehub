<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran QR</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link href="https://fonts.googleapis.com/css2?family=Anton&display=swap" rel="stylesheet" />

    <style>
        .font-anton {
            font-family: 'Anton', sans-serif;
        }
    </style>
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center px-5">

<div class="bg-white w-full max-w-md rounded-3xl shadow-xl p-8 text-center">

    <h1 class="font-anton text-4xl text-[#0b3d0b] tracking-wide mb-2">
        QR PAYMENT
    </h1>

    <p class="text-sm text-gray-500 mb-8">
        Scan QR berikut untuk menyelesaikan pembayaran booking.
    </p>

    <!-- QR -->
    <div class="bg-white border-2 border-gray-100 rounded-2xl p-4 inline-block">
        <img
            src="https://api.qrserver.com/v1/create-qr-code/?size=260x260&data=ACTIVEHUB_PAYMENT"
            alt="QR Payment"
            class="rounded-xl"
        >
    </div>

    <!-- TOTAL -->
    <div class="mt-8">

        <p class="text-sm text-gray-500">
            Total Pembayaran
        </p>

        <h2 class="text-4xl font-bold text-gray-900 mt-1">
            Rp 220.000
        </h2>

    </div>

    <!-- TIMER -->
    <div class="mt-6 bg-yellow-50 border border-yellow-200 rounded-xl py-3">

        <p class="text-sm text-yellow-700 font-medium">
            Selesaikan pembayaran dalam
        </p>

        <p class="text-2xl font-bold text-yellow-800 mt-1">
            14:59
        </p>

    </div>

    <!-- BUTTON -->
    <div class="mt-8">

        <a href="{{ route('payment.success') }}"
           class="w-full flex items-center justify-center
                  bg-[#0b3d0b] hover:bg-[#145214]
                  text-white font-semibold py-4 rounded-xl transition">

            Saya Sudah Bayar

        </a>

    </div>

</div>

</body>
</html>