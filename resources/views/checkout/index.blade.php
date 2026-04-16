<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout Desktop Center - Venue Polinema</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'brand-green': '#0d2b0d',
                        'brand-yellow': '#ffff4d',
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-white font-sans min-h-screen pb-20">

    <header class="bg-green-900 text-center py-20 mb-12">
        <h1 class="text-white text-5xl font-bold tracking-[0.2em] uppercase">CHECKOUT</h1>
    </header>

    <main class="max-w-[800px] mx-auto px-6 space-y-12">
        
        <section>
            <h2 class="text-2xl font-bold border-b pb-4 mb-8 text-gray-800">Venue Polinema Jos</h2>
            
            <div class="space-y-10">
                <div class="flex justify-between items-start">
                    <div class="space-y-1">
                        <p class="font-bold text-xl">Lapangan A</p>
                        <p class="text-gray-500 text-sm font-medium">Min, 12 April 2026 | 07:00 - 08:00</p>
                        <p class="font-bold text-lg">Rp 100.000</p>
                    </div>
                    <button class="text-2xl hover:text-red-600 transition-colors" onclick="this.closest('.flex').remove()">🗑️</button>
                </div>

                <div class="flex justify-between items-start">
                    <div class="space-y-1">
                        <p class="font-bold text-xl">Lapangan B</p>
                        <p class="text-gray-500 text-sm font-medium">Min, 12 April 2026 | 07:00 - 08:00</p>
                        <p class="font-bold text-lg">Rp 100.000</p>
                    </div>
                    <button class="text-2xl hover:text-red-600 transition-colors" onclick="this.closest('.flex').remove()">🗑️</button>
                </div>
            </div>
        </section>

        <section>
            <div class="bg-green-900 text-white flex justify-between items-center px-6 py-4 rounded-lg cursor-pointer hover:bg-opacity-95 transition-all shadow-md">
                <span class="text-lg font-semibold">Gunakan Voucher</span>
                <span class="text-2xl font-bold">></span>
            </div>
        </section>

        <section class="space-y-5 pt-4">
            <h3 class="text-2xl font-bold mb-6">Rincian Biaya</h3>
            <div class="flex justify-between text-lg text-gray-800">
                <span>Biaya Sewa Lapangan A</span>
                <span>Rp 100.000</span>
            </div>
            <div class="flex justify-between text-lg text-gray-800">
                <span>Biaya Sewa Lapangan B</span>
                <span>Rp 100.000</span>
            </div>
            <div class="flex justify-between text-lg text-gray-800">
                <span>Biaya Tambahan</span>
                <span>Rp 20.000</span>
            </div>
            <div class="flex justify-between text-2xl font-bold pt-6 border-t mt-4 text-black">
                <span>Total Pembayaran</span>
                <span>Rp 220.000</span>
            </div>
        </section>

        <section class="space-y-8 pt-4">
            <div class="flex justify-between items-center">
                <h3 class="text-2xl font-bold">Metode Pembayaran</h3>
                <button class="text-xs text-gray-400 font-medium hover:text-brand-green">Lihat Semua ></button>
            </div>
            
            <div class="space-y-6">
                <div class="flex justify-between items-center cursor-pointer group">
                    <span class="text-xl font-medium text-gray-700">QRIS</span>
                    <div class="w-5 h-5 bg-brand-green rounded-full"></div>
                </div>
                <div class="flex justify-between items-center cursor-pointer group">
                    <span class="text-xl font-medium text-gray-700">Bank Mandiri</span>
                    <div class="w-5 h-5 bg-brand-green rounded-full"></div>
                </div>
                <div class="flex justify-between items-center cursor-pointer group">
                    <span class="text-xl font-medium text-gray-700">Bank BCA</span>
                    <div class="w-5 h-5 bg-brand-green rounded-full"></div>
                </div>
            </div>
        </section>

        <section class="pt-10 flex justify-center">
            <button onclick="alert('Memproses Pembayaran...')" class="w-full sm:w-[400px] bg-brand-yellow py-4 rounded-xl font-bold text-xl shadow-lg border-b-4 border-yellow-500 hover:brightness-95 active:scale-[0.98] transition-all">
                Bayar
            </button>
        </section>

    </main>

</body>
</html>