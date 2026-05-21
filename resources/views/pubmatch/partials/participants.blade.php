<div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden mb-6">
    <div class="bg-gray-50 px-4 py-3 border-b border-gray-100 flex justify-between items-center">
        <h3 class="font-bold text-gray-800 text-sm">Daftar Peserta</h3>
        <span class="bg-[#1b3a1b] text-white text-[10px] px-2 py-0.5 rounded-full font-semibold">{{ $match->participants->count() }}/{{ $match->total_players }}</span>
    </div>
    
    <div class="divide-y divide-gray-50 max-h-48 overflow-y-auto">
        <!-- Participant Dummy 1 -->
        <div class="p-4 flex items-center gap-3 hover:bg-gray-50 transition">
            <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-700 flex flex-shrink-0 items-center justify-center text-xs font-bold">
                AJ
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-semibold text-gray-800 truncate">Ahmad Jaelani</p>
                <p class="text-[10px] text-gray-400 truncate">Bergabung pada 14 Mei 2026</p>
            </div>
            <span class="text-[10px] font-semibold px-2 py-1 bg-green-100 text-green-700 rounded-md">Lunas</span>
        </div>

        <!-- Participant Dummy 2 -->
        <div class="p-4 flex items-center gap-3 hover:bg-gray-50 transition">
            <div class="w-8 h-8 rounded-full bg-pink-100 text-pink-700 flex flex-shrink-0 items-center justify-center text-xs font-bold">
                SF
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-semibold text-gray-800 truncate">Siti Fatimah</p>
                <p class="text-[10px] text-gray-400 truncate">Bergabung pada 15 Mei 2026</p>
            </div>
            <span class="text-[10px] font-semibold px-2 py-1 bg-green-100 text-green-700 rounded-md">Lunas</span>
        </div>

        <!-- Participant Dummy 3 -->
        <div class="p-4 flex items-center gap-3 hover:bg-gray-50 transition">
            <div class="w-8 h-8 rounded-full bg-purple-100 text-purple-700 flex flex-shrink-0 items-center justify-center text-xs font-bold">
                BW
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-semibold text-gray-800 truncate">Budi Wibowo</p>
                <p class="text-[10px] text-gray-400 truncate">Bergabung pada 16 Mei 2026</p>
            </div>
            <span class="text-[10px] font-semibold px-2 py-1 bg-green-100 text-green-700 rounded-md">Lunas</span>
        </div>
    </div>
</div>
