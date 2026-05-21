<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ActiveHub - Checkout</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Anton&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .font-anton { font-family: 'Anton', sans-serif; }
    </style>
    <script src="//unpkg.com/alpinejs" defer></script>
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

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            
            <!-- Left Column: Items & Payment Methods -->
            <div class="lg:col-span-7 xl:col-span-8 space-y-6">
                
                <!-- Daftar Item -->
                <div class="bg-white border border-gray-100 rounded-2xl p-6 shadow-sm">
                    <h2 class="text-xl font-bold text-gray-900 mb-5">Detail Pesanan</h2>
                    
                    <div class="space-y-4">
                        <!-- Item 1 -->
                        <div class="booking-item flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 p-4 border border-gray-100 rounded-xl hover:bg-gray-50 transition">
                            <div class="flex gap-4 items-center">
                                <div class="w-16 h-16 bg-[#1b3a1b] rounded-xl flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-futbol text-white text-2xl"></i>
                                </div>
                                <div>
                                    <h3 class="font-bold text-lg text-gray-900 leading-tight">Lapangan A</h3>
                                    <p class="text-sm text-gray-500 mt-1"><i class="far fa-calendar-alt w-4 text-center mr-1"></i> Min, 12 April 2026 | 07:00 - 08:00</p>
                                </div>
                            </div>
                            <div class="flex items-center justify-between w-full sm:w-auto gap-4">
                                <span class="font-bold text-gray-900">Rp 100.000</span>
                                <button onclick="removeItem(this)" class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-400 hover:text-red-500 hover:bg-red-50 transition" title="Hapus Item">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Item 2 -->
                        <div class="booking-item flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 p-4 border border-gray-100 rounded-xl hover:bg-gray-50 transition">
                            <div class="flex gap-4 items-center">
                                <div class="w-16 h-16 bg-[#1b3a1b] rounded-xl flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-futbol text-white text-2xl"></i>
                                </div>
                                <div>
                                    <h3 class="font-bold text-lg text-gray-900 leading-tight">Lapangan B</h3>
                                    <p class="text-sm text-gray-500 mt-1"><i class="far fa-calendar-alt w-4 text-center mr-1"></i> Min, 12 April 2026 | 07:00 - 08:00</p>
                                </div>
                            </div>
                            <div class="flex items-center justify-between w-full sm:w-auto gap-4">
                                <span class="font-bold text-gray-900">Rp 100.000</span>
                                <button onclick="removeItem(this)" class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-400 hover:text-red-500 hover:bg-red-50 transition" title="Hapus Item">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </div>
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
                            <button onclick="selectPayment(this)" class="payment-item flex items-center gap-3 p-3.5 border border-gray-200 rounded-xl hover:border-[#1b3a1b] hover:bg-green-50/30 transition group text-left">
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

                            <button onclick="selectPayment(this)" class="payment-item flex items-center gap-3 p-3.5 border border-gray-200 rounded-xl hover:border-[#1b3a1b] hover:bg-green-50/30 transition group text-left">
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
                            
                            <button onclick="selectPayment(this)" class="payment-item flex items-center gap-3 p-3.5 border border-gray-200 rounded-xl hover:border-[#1b3a1b] hover:bg-green-50/30 transition group text-left">
                                <div class="w-10 h-7 bg-blue-50 text-blue-800 font-bold text-xs rounded flex items-center justify-center shrink-0 border border-blue-100">
                                    BCA
                                </div>
                                <div class="flex-1">
                                    <span class="block font-semibold text-gray-800 text-sm">BCA Virtual Account</span>
                                </div>
                                <div class="w-5 h-5 flex items-center justify-center rounded-full border border-gray-300 group-hover:border-[#1b3a1b] transition check-container">
                                    <i class="fas fa-check text-[10px] text-[#1b3a1b] hidden check-icon"></i>
                                </div>
                            </button>

                            <button onclick="selectPayment(this)" class="payment-item flex items-center gap-3 p-3.5 border border-gray-200 rounded-xl hover:border-[#1b3a1b] hover:bg-green-50/30 transition group text-left">
                                <div class="w-10 h-7 bg-yellow-50 text-yellow-700 font-bold text-xs rounded flex items-center justify-center shrink-0 border border-yellow-100">
                                    MDR
                                </div>
                                <div class="flex-1">
                                    <span class="block font-semibold text-gray-800 text-sm">Mandiri Virtual Account</span>
                                </div>
                                <div class="w-5 h-5 flex items-center justify-center rounded-full border border-gray-300 group-hover:border-[#1b3a1b] transition check-container">
                                    <i class="fas fa-check text-[10px] text-[#1b3a1b] hidden check-icon"></i>
                                </div>
                            </button>

                            <button onclick="selectPayment(this)" class="payment-item flex items-center gap-3 p-3.5 border border-gray-200 rounded-xl hover:border-[#1b3a1b] hover:bg-green-50/30 transition group text-left">
                                <div class="w-10 h-7 bg-orange-50 text-orange-600 font-bold text-xs rounded flex items-center justify-center shrink-0 border border-orange-100">
                                    BNI
                                </div>
                                <div class="flex-1">
                                    <span class="block font-semibold text-gray-800 text-sm">BNI Virtual Account</span>
                                </div>
                                <div class="w-5 h-5 flex items-center justify-center rounded-full border border-gray-300 group-hover:border-[#1b3a1b] transition check-container">
                                    <i class="fas fa-check text-[10px] text-[#1b3a1b] hidden check-icon"></i>
                                </div>
                            </button>

                            <button onclick="selectPayment(this)" class="payment-item flex items-center gap-3 p-3.5 border border-gray-200 rounded-xl hover:border-[#1b3a1b] hover:bg-green-50/30 transition group text-left">
                                <div class="w-10 h-7 bg-blue-50 text-blue-700 font-bold text-xs rounded flex items-center justify-center shrink-0 border border-blue-100">
                                    BRI
                                </div>
                                <div class="flex-1">
                                    <span class="block font-semibold text-gray-800 text-sm">BRI Virtual Account</span>
                                </div>
                                <div class="w-5 h-5 flex items-center justify-center rounded-full border border-gray-300 group-hover:border-[#1b3a1b] transition check-container">
                                    <i class="fas fa-check text-[10px] text-[#1b3a1b] hidden check-icon"></i>
                                </div>
                            </button>

                            <button onclick="selectPayment(this)" class="payment-item flex items-center gap-3 p-3.5 border border-gray-200 rounded-xl hover:border-[#1b3a1b] hover:bg-green-50/30 transition group text-left">
                                <div class="w-10 h-7 bg-emerald-50 text-emerald-700 font-bold text-[10px] rounded flex items-center justify-center shrink-0 border border-emerald-100">
                                    PRMT
                                </div>
                                <div class="flex-1">
                                    <span class="block font-semibold text-gray-800 text-sm">Permata Virtual Account</span>
                                </div>
                                <div class="w-5 h-5 flex items-center justify-center rounded-full border border-gray-300 group-hover:border-[#1b3a1b] transition check-container">
                                    <i class="fas fa-check text-[10px] text-[#1b3a1b] hidden check-icon"></i>
                                </div>
                            </button>

                        </div>
                    </div>
                </div>

            </div>

            <!-- Right Column: Summary -->
            <div class="lg:col-span-5 xl:col-span-4">
                
                <div class="bg-white border border-gray-100 rounded-2xl p-6 shadow-sm sticky top-28">
                    
                    <!-- Voucher -->
                    <div class="mb-6">
                        <button class="w-full bg-gray-50 border border-gray-200 text-gray-700 rounded-xl px-4 py-3.5 flex justify-between items-center hover:bg-gray-100 transition group">
                            <div class="flex items-center gap-2">
                                <i class="fas fa-ticket-alt text-yellow-500"></i>
                                <span class="font-semibold text-sm">Gunakan Promo / Voucher</span>
                            </div>
                            <i class="fas fa-chevron-right text-xs text-gray-400 group-hover:text-gray-600"></i>
                        </button>
                    </div>

                    <h3 class="text-lg font-bold text-gray-900 mb-4">Ringkasan Pembayaran</h3>

                    <div class="space-y-3 mb-6">
                        <div class="flex justify-between text-sm text-gray-600">
                            <span>Lapangan A</span>
                            <span class="font-medium text-gray-800">Rp 100.000</span>
                        </div>
                        <div class="flex justify-between text-sm text-gray-600">
                            <span>Lapangan B</span>
                            <span class="font-medium text-gray-800">Rp 100.000</span>
                        </div>
                    </div>

                    <div class="border-t border-dashed border-gray-200 pt-4 mb-6 flex justify-between items-end">
                        <span class="text-sm text-gray-500">Total Pembayaran</span>
                        <span class="text-2xl font-bold text-[#1b3a1b]">Rp 200.000</span>
                    </div>

                    <a href="{{ route('payment.qr') }}"
                       class="block w-full bg-[#1b3a1b] hover:bg-[#2a5a2a] text-white font-bold py-4 rounded-xl shadow-md shadow-green-900/10 transition transform active:scale-[0.98] text-center">
                        Bayar Sekarang
                    </a>
                    
                    <p class="text-center text-xs text-gray-400 mt-4 flex items-center justify-center gap-1">
                        <i class="fas fa-lock"></i> Pembayaran aman terenkripsi
                    </p>

                </div>

            </div>

        </div>
    </div>
</main>

<!-- Footer Placeholder if needed -->

<script>
    function selectPayment(selectedButton) {
        const isSelected = selectedButton.classList.contains('active-payment');

        // Reset semua
        document.querySelectorAll('.payment-item').forEach(item => {
            item.classList.remove('border-[#1b3a1b]', 'bg-green-50/50', 'active-payment');
            item.classList.add('border-gray-200');
            
            const checkContainer = item.querySelector('.check-container');
            checkContainer.classList.remove('border-[#1b3a1b]');
            checkContainer.classList.add('border-gray-300');
            
            item.querySelector('.check-icon').classList.add('hidden');
        });

        // Kalau belum dipilih -> aktifkan
        if (!isSelected) {
            selectedButton.classList.remove('border-gray-200');
            selectedButton.classList.add('border-[#1b3a1b]', 'bg-green-50/50', 'active-payment');
            
            const checkContainer = selectedButton.querySelector('.check-container');
            checkContainer.classList.remove('border-gray-300');
            checkContainer.classList.add('border-[#1b3a1b]');
            
            selectedButton.querySelector('.check-icon').classList.remove('hidden');
        }
    }

    function removeItem(button) {
        const itemCard = button.closest('.booking-item');
        itemCard.remove();
        // Disini idealnya ada logic update total harga di DOM
    }
</script>

</body>
</html>