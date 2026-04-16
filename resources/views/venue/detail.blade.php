<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Detail Venue</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-200 p-5 font-sans">

<div class="max-w-[600px] mx-auto bg-white rounded-lg shadow-xl overflow-hidden">

    <!-- HEADER -->
    <div class="bg-[#0d2b0d] text-white text-center py-6">
        <h1 class="text-2xl font-bold uppercase">DETAIL VENUE</h1>
    </div>

    <div class="p-5 space-y-6">

        <!-- DETAIL VENUE -->
        <div>
            <h2 class="text-lg font-bold text-[#0d2b0d] mb-2">Informasi Venue</h2>

            <p><b>Nama:</b> GOR Sudirman</p>
            <p><b>Kota:</b> Malang</p>
            <p><b>Alamat:</b> Jl. Soekarno Hatta No.10</p>

            <p class="mt-2">
                <b>Deskripsi:</b><br>
                Venue olahraga lengkap dengan fasilitas modern.
            </p>

            <p class="mt-2"><b>Jam:</b> 07:00 - 22:00</p>
        </div>

        <!-- LAPANGAN -->
        <div>
            <h2 class="text-lg font-bold text-[#0d2b0d] mb-3">Daftar Lapangan</h2>

            <!-- CARD -->
            <div class="border p-4 rounded mb-3">
                <p class="font-bold text-lg">Lapangan A</p>
                <p class="text-sm text-gray-500">Futsal</p>

                <div class="flex justify-between items-center mt-2">
                    <span class="font-bold text-[#0d2b0d]">Rp 100.000</span>
                    <a href="/checkout/1"
                        class="bg-[#0d2b0d] text-white px-3 py-1 rounded text-sm">
                        Booking
                    </a>
                </div>
            </div>

            <!-- CARD -->
            <div class="border p-4 rounded">
                <p class="font-bold text-lg">Lapangan B</p>
                <p class="text-sm text-gray-500">Badminton</p>

                <div class="flex justify-between items-center mt-2">
                    <span class="font-bold text-[#0d2b0d]">Rp 80.000</span>
                    <a href="/checkout/1"
                        class="bg-[#0d2b0d] text-white px-3 py-1 rounded text-sm">
                        Booking
                    </a>
                </div>
            </div>

        </div>

    </div>

</div>

</body>
</html>