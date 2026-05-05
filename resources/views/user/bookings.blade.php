@extends('partials.app')

@section('title', 'Bookings')

@section('content')

<div class="max-w-5xl mx-auto py-10 px-4 space-y-10">

    {{-- 1. PREMIUM WELCOME BANNER --}}
    <div class="relative overflow-hidden bg-gradient-to-br from-[#1D3D1F] via-[#244d27] to-[#2d5f30] rounded-[2.5rem] p-8 text-white shadow-2xl shadow-green-100">
        <div class="relative z-10 flex flex-col md:flex-row justify-between items-center gap-8">
            <div class="text-center md:text-left">
                <span class="bg-white/20 px-3 py-1 rounded-full text-[10px] font-bold tracking-widest uppercase mb-4 inline-block">Member Gold</span>
                <h2 class="text-3xl md:text-4xl font-black leading-tight tracking-tight">Waktunya Berkeringat, <br>{{ auth()->user()->name ?? 'Garino Wijaya' }}!</h2>
                <p class="text-green-100 mt-3 text-sm opacity-90 max-w-sm font-medium">Kamu punya beberapa jadwal main minggu ini. Jangan lupa pemanasan ya!</p>
            </div>
            <div class="shrink-0 flex flex-col items-center gap-2">
                <button class="bg-white text-[#1D3D1F] px-10 py-4 rounded-2xl font-black text-sm hover:shadow-xl hover:-translate-y-1 transition-all">
                    Booking Lapangan Lagi
                </button>
                <p class="text-[10px] text-green-100 font-bold opacity-70">Tersedia 5 Lapangan Kosong</p>
            </div>
        </div>
        <div class="absolute -right-10 -top-10 w-48 h-48 bg-white/10 rounded-full blur-3xl"></div>
        <div class="absolute -left-10 -bottom-10 w-64 h-64 bg-green-400/20 rounded-full blur-3xl"></div>
    </div>

    {{-- 2. USER STATS BOX --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="bg-white p-6 rounded-[2rem] border border-gray-100 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 bg-green-50 text-[#1D3D1F] rounded-2xl flex items-center justify-center text-xl shadow-inner"><i class="fas fa-calendar-alt"></i></div>
            <div>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Jadwal</p>
                <p class="text-xl font-black text-gray-900">2 <span class="text-[10px] text-gray-400">Sesi</span></p>
            </div>
        </div>
        <div class="bg-white p-6 rounded-[2rem] border border-gray-100 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 bg-orange-50 text-orange-600 rounded-2xl flex items-center justify-center text-xl shadow-inner"><i class="fas fa-clock"></i></div>
            <div>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Total Jam</p>
                <p class="text-xl font-black text-gray-900">12 <span class="text-[10px] text-gray-400">Jam</span></p>
            </div>
        </div>
        <div class="hidden md:flex bg-white p-6 rounded-[2rem] border border-gray-100 shadow-sm items-center gap-4">
            <div class="w-12 h-12 bg-green-50 text-green-600 rounded-2xl flex items-center justify-center text-xl shadow-inner"><i class="fas fa-fire"></i></div>
            <div>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Streak</p>
                <p class="text-xl font-black text-gray-900">4 <span class="text-[10px] text-gray-400">Minggu</span></p>
            </div>
        </div>
        <div class="hidden md:flex bg-white p-6 rounded-[2rem] border border-gray-100 shadow-sm items-center gap-4">
            <div class="w-12 h-12 bg-purple-50 text-purple-600 rounded-2xl flex items-center justify-center text-xl shadow-inner"><i class="fas fa-wallet"></i></div>
            <div>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Saldo</p>
                <p class="text-xl font-black text-gray-900">50K</p>
            </div>
        </div>
    </div>

    {{-- 3. INTERACTIVE NAVIGATION --}}
    <div class="flex flex-col gap-8">
        <div class="flex items-center justify-between border-b border-gray-100 pb-1 overflow-x-auto no-scrollbar">
            <div class="flex gap-10">
                <button onclick="showTab('scheduled', this)" class="tab-btn pb-4 border-b-4 border-[#1D3D1F] text-[#1D3D1F] font-black text-sm whitespace-nowrap transition-all">
                    Terjadwal <span class="ml-1 bg-blue-100 text-blue-600 px-2 py-0.5 rounded-full text-[10px]">1</span>
                </button>
                <button onclick="showTab('ongoing', this)" class="tab-btn pb-4 border-b-4 border-transparent text-gray-400 font-bold text-sm whitespace-nowrap transition-all hover:text-gray-600">
                    Berlangsung <span class="ml-1 bg-orange-100 text-orange-600 px-2 py-0.5 rounded-full text-[10px]">1</span>
                </button>
                <button onclick="showTab('done', this)" class="tab-btn pb-4 border-b-4 border-transparent text-gray-400 font-bold text-sm whitespace-nowrap transition-all hover:text-gray-600">
                    Selesai <span class="bg-gray-100 text-gray-500 px-2 py-0.5 rounded-full text-[10px]">1</span>
                </button>
                <button onclick="showTab('cancelled', this)" class="tab-btn pb-4 border-b-4 border-transparent text-gray-400 font-bold text-sm whitespace-nowrap transition-all hover:text-gray-600">
                    Dibatalkan <span class="bg-red-50 text-red-400 px-2 py-0.5 rounded-full text-[10px]">1</span>
                </button>
            </div>
        </div>

        {{-- 4. DYNAMIC LIST CONTENT --}}
        <div class="space-y-6">

            {{-- 🔵 TAB: TERJADWAL --}}
            <div id="scheduled" class="tab-content animate-in slide-in-from-bottom-4 duration-500">
                <div class="group relative">
                    <div class="absolute -inset-1 bg-gradient-to-r from-blue-400 to-indigo-500 rounded-[2.5rem] blur opacity-10"></div>
                    <div class="relative bg-white border border-gray-100 rounded-[2rem] p-6 md:p-8 flex flex-col md:flex-row items-center gap-8">
                        <div class="flex flex-col items-center justify-center bg-blue-50 text-blue-600 rounded-3xl w-24 h-24 shrink-0 border border-blue-100">
                            <span class="text-[10px] font-black uppercase tracking-tighter">APR</span>
                            <span class="text-4xl font-black tracking-tighter leading-none">23</span>
                        </div>
                        <div class="flex-1 text-center md:text-left">
                            <h4 class="text-lg font-black text-gray-900 leading-tight">Rizky Ramadhan</h4>
                            <p class="text-xs text-gray-400 font-medium">+62 877-1122-3344</p>
                            <div class="mt-4 flex flex-wrap justify-center md:justify-start gap-y-2 gap-x-6 text-[11px] font-bold text-gray-500">
                                <span class="flex items-center gap-2"><i class="fas fa-map-marker-alt text-blue-500"></i> Lapangan A</span>
                                <span class="flex items-center gap-2"><i class="far fa-clock text-blue-500"></i> 19:00 - 21:00 (2 Jam)</span>
                            </div>
                        </div>
                        <div class="flex flex-col items-center md:items-end gap-3">
                            <span class="px-4 py-1.5 bg-blue-50 text-blue-600 text-[10px] font-black rounded-full uppercase tracking-widest">Terjadwal</span>
                            <p class="text-2xl font-black text-gray-900">Rp 300K</p>
                            <button class="bg-gray-900 text-white px-6 py-2 rounded-xl text-[10px] font-bold hover:shadow-lg transition-all">Download Tiket</button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- 🟠 TAB: BERLANGSUNG --}}
            <div id="ongoing" class="tab-content hidden animate-in slide-in-from-bottom-4 duration-500">
                <div class="group relative">
                    <div class="absolute -inset-1 bg-gradient-to-r from-orange-400 to-yellow-500 rounded-[2.5rem] blur opacity-10"></div>
                    <div class="relative bg-white border-2 border-orange-100 rounded-[2rem] p-6 md:p-8 flex flex-col md:flex-row items-center gap-8">
                        <div class="flex flex-col items-center justify-center bg-orange-50 text-orange-600 rounded-3xl w-24 h-24 shrink-0 border border-orange-100">
                            <span class="text-[10px] font-black uppercase tracking-tighter">APR</span>
                            <span class="text-4xl font-black tracking-tighter leading-none">23</span>
                        </div>
                        <div class="flex-1 text-center md:text-left">
                            <h4 class="text-lg font-black text-gray-900 leading-tight">Tim Harimau FC</h4>
                            <p class="text-xs text-gray-400 font-medium">+62 856-7654-3210</p>
                            <div class="mt-4 flex flex-wrap justify-center md:justify-start gap-y-2 gap-x-6 text-[11px] font-bold text-gray-500">
                                <span class="flex items-center gap-2"><i class="fas fa-map-marker-alt text-orange-500"></i> Lapangan B</span>
                                <span class="flex items-center gap-2"><i class="far fa-clock text-orange-500"></i> 13:00 - 15:00 (2 Jam)</span>
                            </div>
                        </div>
                        <div class="flex flex-col items-center md:items-end gap-3">
                            <span class="px-4 py-1.5 bg-orange-100 text-orange-600 text-[10px] font-black rounded-full uppercase tracking-widest animate-pulse">Berlangsung</span>
                            <p class="text-2xl font-black text-gray-900 leading-none">Rp 300K</p>
                            <p class="text-[9px] font-black text-orange-500 uppercase">Sisa: 01:14:55</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ✅ TAB: SELESAI --}}
            <div id="done" class="tab-content hidden animate-in slide-in-from-bottom-4 duration-500">
                <div class="relative bg-white border border-gray-100 rounded-[2rem] p-6 md:p-8 flex flex-col md:flex-row items-center gap-8 shadow-sm">
                    <div class="flex flex-col items-center justify-center bg-green-50 text-green-600 rounded-3xl w-24 h-24 shrink-0 border border-green-100">
                        <span class="text-[10px] font-black uppercase tracking-tighter">APR</span>
                        <span class="text-4xl font-black tracking-tighter leading-none">23</span>
                    </div>
                    <div class="flex-1 text-center md:text-left">
                        <h4 class="text-lg font-black text-gray-900 leading-tight">Agus Santoso</h4>
                        <p class="text-xs text-gray-400 font-medium">+62 812-3456-7890</p>
                        <div class="mt-4 flex flex-wrap justify-center md:justify-start gap-y-2 gap-x-6 text-[11px] font-bold text-gray-500">
                            <span class="flex items-center gap-2"><i class="fas fa-map-marker-alt text-green-500"></i> Lapangan A</span>
                            <span class="flex items-center gap-2"><i class="far fa-clock text-green-500"></i> 08:00 - 10:00 (2 Jam)</span>
                        </div>
                    </div>
                    <div class="flex flex-col items-center md:items-end gap-3">
                        <span class="px-4 py-1.5 bg-green-50 text-green-600 text-[10px] font-black rounded-full uppercase tracking-widest">Selesai</span>
                        <p class="text-2xl font-black text-gray-900">Rp 300K</p>
                        <div class="flex gap-2">
                            <button class="bg-gray-100 text-gray-600 p-2 rounded-lg hover:bg-gray-200 transition-all"><i class="fas fa-file-invoice"></i></button>
                            <button class="bg-[#1D3D1F] text-white px-4 py-2 rounded-xl text-[10px] font-bold hover:bg-green-800 transition-all">Main Lagi</button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ❌ TAB: DIBATALKAN (Versi Estetik & Berwarna) --}}
            <div id="cancelled" class="tab-content hidden animate-in slide-in-from-bottom-4 duration-500">
                <div class="group relative">
                    {{-- Efek Cahaya Merah Halus saat Hover --}}
                    <div class="absolute -inset-1 bg-gradient-to-r from-red-100 to-rose-200 rounded-[2.5rem] blur opacity-0 group-hover:opacity-100 transition duration-500"></div>
                    
                    <div class="relative bg-white border border-red-50 rounded-[2rem] p-6 md:p-8 flex flex-col md:flex-row items-center gap-8 transition-all duration-300 shadow-sm group-hover:shadow-md group-hover:border-red-100">
                        
                        <div class="flex flex-col items-center justify-center bg-red-50 text-red-400 rounded-3xl w-24 h-24 shrink-0 border border-red-100 group-hover:bg-red-400 group-hover:text-white transition-all duration-500">
                            <span class="text-[10px] font-black uppercase tracking-tighter opacity-80">APR</span>
                            <span class="text-4xl font-black tracking-tighter leading-none">24</span>
                        </div>

                        <div class="flex-1 text-center md:text-left">
                            <div class="flex items-center justify-center md:justify-start gap-2 mb-1">
                                <span class="px-2 py-0.5 bg-red-50 text-red-500 text-[9px] font-black rounded uppercase tracking-wider border border-red-100">Voided</span>
                            </div>
                            <h4 class="text-lg font-black text-gray-400 line-through leading-tight group-hover:text-gray-600 transition-colors">Sari Indrawati</h4>
                            <p class="text-xs text-gray-300 font-medium">+62 895-5544-3322</p>
                            
                            <div class="mt-4 flex flex-wrap justify-center md:justify-start gap-y-2 gap-x-6 text-[11px] font-bold text-gray-400">
                                <span class="flex items-center gap-2">
                                    <i class="fas fa-map-marker-alt text-red-200 group-hover:text-red-400 transition-colors"></i> Lapangan D
                                </span>
                                <span class="flex items-center gap-2">
                                    <i class="far fa-clock text-red-200 group-hover:text-red-400 transition-colors"></i> 16:00 - 18:00
                                </span>
                                <span class="flex items-center gap-2 text-red-300 italic">
                                    <i class="fas fa-info-circle"></i> Pembatalan Sistem
                                </span>
                            </div>
                        </div>

                        <div class="flex flex-col items-center md:items-end gap-3">
                            <span class="px-4 py-1.5 bg-red-50 text-red-400 text-[10px] font-black rounded-full uppercase tracking-widest border border-red-100">Dibatalkan</span>
                            <p class="text-2xl font-black text-gray-300 line-through group-hover:text-red-400 transition-colors">Rp 300K</p>
                            <button class="text-red-400 text-[10px] font-black hover:text-red-600 underline decoration-2 underline-offset-4 transition-all">
                                Butuh Bantuan?
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

{{-- FLOATING BUTTON FOR MOBILE --}}
<div class="fixed bottom-10 right-10 md:hidden">
    <button class="bg-[#1D3D1F] text-white w-16 h-16 rounded-full shadow-2xl flex items-center justify-center text-xl hover:scale-110 active:scale-95 transition-all">
        <i class="fas fa-plus"></i>
    </button>
</div>

<style>
    .no-scrollbar::-webkit-scrollbar { display: none; }
    .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
</style>

<script>
function showTab(tabId, el) {
    document.querySelectorAll('.tab-content').forEach(t => t.classList.add('hidden'));
    const target = document.getElementById(tabId);
    if(target) target.classList.remove('hidden');

    document.querySelectorAll('.tab-btn').forEach(b => {
        b.classList.remove('border-[#1D3D1F]', 'text-[#1D3D1F]', 'font-black');
        b.classList.add('border-transparent', 'text-gray-400', 'font-bold');
    });

    el.classList.add('border-[#1D3D1F]', 'text-[#1D3D1F]', 'font-black');
    el.classList.remove('text-gray-400', 'font-bold');
}
</script>

@endsection