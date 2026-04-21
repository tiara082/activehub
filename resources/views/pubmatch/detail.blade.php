<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Public Match Detail</title>
<script src="https://cdn.tailwindcss.com"></script>
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

            <!-- TITLE -->
            <div class="mb-4">
                <h1 class="text-2xl font-bold">FUTSAL MATCH</h1>
                <p class="text-gray-500">Lapangan Polinema Jos</p>
            </div>

            <hr class="mb-4">

            <!-- DESKRIPSI -->
            <div class="mb-6">
                <h2 class="font-semibold mb-2">Deskripsi</h2>
                <p class="text-gray-600 text-sm leading-relaxed">
                    Open match futsal santai untuk semua level. Cocok buat kamu yang ingin
                    bermain santai, cari teman baru, atau sekadar olahraga ringan.
                    Slot terbatas, jadi pastikan kamu booking lebih awal ya!
                </p>
            </div>

            <hr class="mb-4">

            <!-- DETAIL -->
            <div class="grid grid-cols-2 gap-4 text-sm mb-6">

                <div>
                    <p class="text-gray-400">Hari & Tanggal</p>
                    <p class="font-medium">Minggu, 12 April 2026</p>
                </div>

                <div>
                    <p class="text-gray-400">Jam</p>
                    <p class="font-medium">08:00 - 10:00</p>
                </div>

                <div>
                    <p class="text-gray-400">Jumlah Slot</p>
                    <p class="font-medium text-green-600">8/10 pemain</p>
                </div>

                <div>
                    <p class="text-gray-400">Gender</p>
                    <p class="font-medium">Pria</p>
                </div>

                <div>
                    <p class="text-gray-400">Harga</p>
                    <p class="font-medium text-blue-600">Rp 25.000</p>
                </div>

                <div>
                    <p class="text-gray-400">Pembayaran</p>
                    <p class="font-medium">Bank BCA</p>
                </div>

            </div>

            <!-- LOKASI (MAP KECIL) -->
            <div class="mb-6">
                <h2 class="font-semibold mb-3">Lokasi</h2>

                <div class="grid grid-cols-3 gap-4 items-start">

                    <!-- MAP -->
                    <div class="col-span-1 rounded-xl overflow-hidden shadow">
                        <iframe 
                            src="https://www.google.com/maps?q=Polinema%20Malang&output=embed"
                            class="w-full h-32 border-0">
                        </iframe>
                    </div>

                    <!-- TEXT -->
                    <div class="col-span-2 text-sm text-gray-600">
                        <p class="font-medium text-gray-800 mb-1">
                            Lapangan Polinema Jos
                        </p>
                        <p>
                            Jl. Soekarno Hatta No.9, Lowokwaru,<br>
                            Kota Malang, Jawa Timur
                        </p>

                        <a href="https://www.google.com/maps?q=Polinema%20Malang"
                           target="_blank"
                           class="inline-block mt-3 text-green-600 font-medium hover:underline">
                           📍 Buka di Google Maps
                        </a>
                    </div>

                </div>
            </div>

            <!-- CTA -->
            <button class="w-full bg-green-600 hover:bg-green-700 text-white py-3 rounded-xl font-semibold shadow-md transition">
                Join Match
            </button>

        </div>
    </div>

</div>

</body>
</html>