<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link href="https://fonts.googleapis.com/css2?family=Anton&display=swap" rel="stylesheet" />

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
        .font-anton {
            font-family: 'Anton', sans-serif;
        }
    </style>
</head>

<body class="bg-white min-h-screen">

<header class="bg-[#0b3d0b] text-center py-14 mb-10">
    <h1 class="text-white text-4xl md:text-5xl font-anton uppercase tracking-widest">
        Checkout
    </h1>
</header>

<main class="max-w-3xl mx-auto px-6 space-y-10 pb-20">

    <!-- ITEMS -->
    <section class="space-y-5">

        <div class="bg-white border border-gray-100 rounded-2xl p-5 flex justify-between items-stretch shadow-sm">

            <div class="flex flex-col justify-center">
                <p class="font-bold text-lg text-gray-900">Lapangan A</p>
                <p class="text-sm text-gray-500">Min, 12 April 2026 | 07:00 - 08:00</p>
                <p class="font-semibold text-gray-900 mt-2">Rp 100.000</p>
            </div>

            <div class="flex items-center">
                <button onclick="removeItem(this)"
            class="w-10 h-10 flex items-center justify-center rounded-lg text-gray-400 hover:text-red-500 hover:bg-red-50 transition">

                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="w-5 h-5"
                         viewBox="0 0 24 24"
                         fill="none"
                         stroke="currentColor"
                         stroke-width="1.8"
                         stroke-linecap="round"
                         stroke-linejoin="round">

                        <path d="M3 6h18" />
                        <path d="M8 6V4h8v2" />
                        <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6" />
                        <path d="M10 11v6" />
                        <path d="M14 11v6" />

                    </svg>

                </button>
            </div>

        </div>

        <div class="bg-white border border-gray-100 rounded-2xl p-5 flex justify-between items-stretch shadow-sm">

            <div class="flex flex-col justify-center">
                <p class="font-bold text-lg text-gray-900">Lapangan B</p>
                <p class="text-sm text-gray-500">Min, 12 April 2026 | 07:00 - 08:00</p>
                <p class="font-semibold text-gray-900 mt-2">Rp 100.000</p>
            </div>

            <div class="flex items-center">
                <button onclick="removeItem(this)"
            class="w-10 h-10 flex items-center justify-center rounded-lg text-gray-400 hover:text-red-500 hover:bg-red-50 transition">

                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="w-5 h-5"
                         viewBox="0 0 24 24"
                         fill="none"
                         stroke="currentColor"
                         stroke-width="1.8"
                         stroke-linecap="round"
                         stroke-linejoin="round">

                        <path d="M3 6h18" />
                        <path d="M8 6V4h8v2" />
                        <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6" />
                        <path d="M10 11v6" />
                        <path d="M14 11v6" />

                    </svg>

                </button>
            </div>

        </div>

    </section>

    <!-- VOUCHER -->
    <section>
        <button class="w-full bg-[#0b3d0b] text-white rounded-xl px-5 py-4 flex justify-between items-center hover:bg-[#124512] transition">
            <span class="font-semibold">Gunakan Voucher</span>
            <svg xmlns="http://www.w3.org/2000/svg"
                 class="w-5 h-5"
                 viewBox="0 0 24 24"
                 fill="none"
                 stroke="currentColor"
                 stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
            </svg>
        </button>
    </section>

    <!-- RINCIAN -->
    <section class="space-y-4">

        <h3 class="text-xl font-bold text-gray-900">Rincian Biaya</h3>

        <div class="flex justify-between text-gray-600">
            <span>Lapangan A</span>
            <span>Rp 100.000</span>
        </div>

        <div class="flex justify-between text-gray-600">
            <span>Lapangan B</span>
            <span>Rp 100.000</span>
        </div>

        <div class="flex justify-between text-gray-600">
            <span>Biaya Tambahan</span>
            <span>Rp 20.000</span>
        </div>

        <div class="border-t pt-4 flex justify-between text-lg font-bold text-gray-900">
            <span>Total</span>
            <span>Rp 220.000</span>
        </div>

    </section>

    <!-- PAYMENT -->
    <section class="space-y-4">

        <h3 class="text-xl font-bold text-gray-900">Metode Pembayaran</h3>

        <div class="space-y-3">

            <button onclick="selectPayment(this)"
                class="payment-item w-full flex justify-between items-center p-4 border border-gray-200 rounded-xl hover:border-[#0b3d0b] transition">

                <span class="font-medium text-gray-700">QRIS</span>

               <div class="w-5 h-5 flex items-center justify-center rounded-full border border-gray-400">
    
                <i class="fas fa-check text-[10px] text-[#0b3d0b] hidden check-icon"></i>

            </div>

            </button>

            <button onclick="selectPayment(this)"
                class="payment-item w-full flex justify-between items-center p-4 border border-gray-200 rounded-xl hover:border-[#0b3d0b] transition">

                <span class="font-medium text-gray-700">Bank Mandiri</span>

                <div class="w-5 h-5 flex items-center justify-center rounded-full border border-gray-400">
    
                    <i class="fas fa-check text-[10px] text-[#0b3d0b] hidden check-icon"></i>

                </div>

            </button>

            <button onclick="selectPayment(this)"
                class="payment-item w-full flex justify-between items-center p-4 border border-gray-200 rounded-xl hover:border-[#0b3d0b] transition">

                <span class="font-medium text-gray-700">Bank BCA</span>

                <div class="w-5 h-5 flex items-center justify-center rounded-full border border-gray-400">
    
                    <i class="fas fa-check text-[10px] text-[#0b3d0b] hidden check-icon"></i>

                </div>

            </button>

        </div>

    </section>

    <!-- BUTTON -->
    <section class="pt-6">

        <a href="{{ route('payment.qr') }}"
        class="block w-full bg-yellow-400 hover:bg-yellow-500
                text-[#0b3d0b] font-bold py-4 rounded-xl
                shadow-md transition active:scale-[0.98]
                text-center">

            Bayar Sekarang

        </a>

    </section>

    </main>

<script>
    function selectPayment(selectedButton) {

        const isSelected = selectedButton.classList.contains('active-payment');

        // reset semua
        document.querySelectorAll('.payment-item').forEach(item => {

            item.classList.remove(
                'border-[#0b3d0b]',
                'bg-green-50',
                'active-payment'
            );

            item.classList.add('border-gray-200');

            // sembunyikan checklist
            item.querySelector('.check-icon').classList.add('hidden');
        });

        // kalau sebelumnya BELUM dipilih → aktifkan
        if (!isSelected) {

            selectedButton.classList.remove('border-gray-200');

            selectedButton.classList.add(
                'border-[#0b3d0b]',
                'bg-green-50',
                'active-payment'
            );

            // tampilkan checklist
            selectedButton.querySelector('.check-icon').classList.remove('hidden');
        }
    }

     function removeItem(button) {

        // cari card parent
        const itemCard = button.closest('.booking-item');

        // hapus card
        itemCard.remove();
    }

</script>

</body>
</html>