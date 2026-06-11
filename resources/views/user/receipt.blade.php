<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kwitansi Pemesanan - #{{ $booking->id }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            body { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
            .no-print { display: none !important; }
        }
    </style>
</head>
<body class="bg-gray-100 p-8 flex justify-center items-start min-h-screen font-sans">
    <div class="bg-white p-8 rounded-2xl shadow-lg w-full max-w-2xl border border-gray-200 relative overflow-hidden">
        
        <!-- Decorative Header Bar -->
        <div class="absolute top-0 left-0 w-full h-2 bg-[#1b3a1b]"></div>

        <div class="flex justify-between items-start border-b border-gray-100 pb-6 mb-6 mt-2">
            <div>
                <h1 class="text-3xl font-black text-[#1b3a1b] tracking-tighter uppercase">ActiveHub</h1>
                <p class="text-sm text-gray-500 mt-1 font-medium">Bukti Pemesanan Lapangan (E-Ticket)</p>
            </div>
            <div class="text-right">
                <p class="text-sm font-bold text-gray-800">Order ID: #{{ $booking->id }}</p>
                <p class="text-xs text-gray-500 mt-0.5">{{ $booking->created_at->format('d M Y, H:i') }}</p>
                <span class="inline-block mt-2 px-3 py-1 bg-emerald-100 text-emerald-700 text-xs font-bold rounded-full border border-emerald-200">
                    LUNAS
                </span>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-8 mb-8">
            <div>
                <p class="text-[10px] text-gray-400 uppercase tracking-widest font-bold mb-1.5">Data Pemesan</p>
                <p class="font-bold text-gray-800">{{ $booking->user->name }}</p>
                <p class="text-sm text-gray-600 mt-0.5">{{ $booking->user->phone ?? '-' }}</p>
                <p class="text-sm text-gray-600 mt-0.5">{{ $booking->user->email }}</p>
            </div>
            <div>
                <p class="text-[10px] text-gray-400 uppercase tracking-widest font-bold mb-1.5">Detail Lapangan</p>
                <p class="font-bold text-gray-800">{{ $booking->field->venue->name ?? '-' }}</p>
                <p class="text-sm text-gray-600 mt-0.5">{{ $booking->field->name ?? '-' }}</p>
                <p class="text-sm text-gray-600 mt-0.5">{{ $booking->field->venue->city ?? '-' }}</p>
            </div>
        </div>

        <div class="bg-gray-50/80 rounded-xl p-5 mb-8 border border-gray-100">
            <p class="text-[10px] text-gray-400 uppercase tracking-widest font-bold mb-3">Jadwal Bermain</p>
            <div class="flex items-center gap-4">
                <div class="bg-white p-4 rounded-xl border border-gray-200 shadow-sm flex-1 text-center">
                    <p class="text-xs text-gray-500 mb-1">Tanggal</p>
                    <p class="font-bold text-[#1b3a1b] text-lg">
                        {{ $booking->timeSlot && $booking->timeSlot->date ? $booking->timeSlot->date->format('d F Y') : '-' }}
                    </p>
                </div>
                <div class="bg-white p-4 rounded-xl border border-gray-200 shadow-sm flex-1 text-center">
                    <p class="text-xs text-gray-500 mb-1">Pukul (WIB)</p>
                    <p class="font-bold text-[#1b3a1b] text-lg">
                        {{ $booking->timeSlot ? date('H:i', strtotime($booking->timeSlot->start_time)) : '-' }} - 
                        {{ $booking->timeSlot ? date('H:i', strtotime($booking->timeSlot->end_time)) : '-' }}
                    </p>
                </div>
            </div>
        </div>

        <div class="border-t border-dashed border-gray-300 pt-6 mb-8">
            <div class="flex justify-between items-center">
                <div>
                    <span class="block text-sm font-bold text-gray-800">Total Pembayaran</span>
                    <span class="block text-xs text-gray-500 mt-0.5">Termasuk pajak & biaya layanan</span>
                </div>
                <span class="font-black text-[#1b3a1b] text-2xl">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</span>
            </div>
        </div>

        <div class="text-center text-xs text-gray-500 border-t border-gray-100 pt-6 bg-gray-50 -mx-8 -mb-8 p-8 mt-4">
            <p class="font-semibold text-gray-700">Terima kasih telah menggunakan layanan ActiveHub!</p>
            <p class="mt-1 max-w-md mx-auto">Harap tunjukkan e-tiket / kwitansi digital ini kepada petugas venue melalui HP Anda saat kedatangan.</p>
        </div>
    </div>
    
    <div class="fixed bottom-8 right-8 no-print">
        <button onclick="window.print()" class="bg-[#1b3a1b] hover:bg-[#285228] text-white px-6 py-3 rounded-xl font-bold shadow-lg flex items-center gap-2 transition-transform hover:scale-105 active:scale-95">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
            Print / Simpan PDF
        </button>
    </div>

    <script>
        window.onload = function() {
            // window.print();
        }
    </script>
</body>
</html>
