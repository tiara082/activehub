<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Daftarkan Venue</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    body { margin: 0; padding: 0; }
    /* Menghilangkan outline biru agar tetap bersih */
    input:focus, textarea:focus, select:focus { 
        outline: none; 
        border-color: #0d2b0d !important; 
        box-shadow: 0 0 0 4px rgba(13, 43, 13, 0.05);
    }
    .tab-content { display: none; }
    .tab-content.active { display: block; }
  </style>
</head>
<body class="bg-gray-200 font-sans">

  <div class="max-w-5xl mx-auto shadow-2xl min-h-screen bg-gray-100">
    
    <header class="bg-[#0d2b0d] text-center py-20">
      <h1 class="text-white text-4xl font-black tracking-[0.3em] uppercase">DAFTARKAN VENUE</h1>
    </header>

    <div class="flex p-8 gap-4 bg-gray-50 border-b border-gray-200">
      <button id="tabV" onclick="showTab('venue')" 
        class="flex-1 bg-[#0d2b0d] text-white py-4 rounded-2xl font-bold text-xl transition-all shadow-md">
        Detail Venue
      </button>

      <button id="tabL" onclick="showTab('lapangan')" 
        class="flex-1 bg-gray-400 text-white py-4 rounded-2xl font-bold text-xl transition-all shadow-md">
        Detail Lapangan
      </button>
    </div>

    <div class="p-10">
      <form>
        
        <div id="venue" class="tab-content active space-y-8">
          <h2 class="text-2xl font-black text-gray-800 border-l-8 border-[#0d2b0d] pl-5 uppercase">Lengkapi Informasi Venue</h2>

          <div class="space-y-6">
            <div>
              <label class="block font-bold text-gray-700 mb-2 uppercase text-sm tracking-wider">Nama Venue</label>
              <input type="text" placeholder="Contoh: GOR Polinema" class="w-full border-2 border-gray-200 rounded-xl px-4 py-4 bg-white text-lg">
            </div>

            <div>
              <label class="block font-bold text-gray-700 mb-2 uppercase text-sm tracking-wider">Deskripsi</label>
              <textarea placeholder="Ceritakan keunggulan venue Anda..." class="w-full border-2 border-gray-200 rounded-xl px-4 py-4 h-32 bg-white text-lg"></textarea>
            </div>

            <div>
              <label class="block font-bold text-gray-700 mb-2 uppercase text-sm tracking-wider">Kota / Area</label>
              <input type="text" placeholder="Contoh: Malang" class="w-full border-2 border-gray-200 rounded-xl px-4 py-4 bg-white text-lg">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
              <div class="md:col-span-2">
                <label class="block font-bold text-gray-700 mb-2 uppercase text-sm tracking-wider">Lokasi Alamat</label>
                <textarea placeholder="Alamat lengkap..." class="w-full border-2 border-gray-200 rounded-xl px-4 py-4 h-40 bg-white text-lg"></textarea>
              </div>
              <div class="bg-gray-300 rounded-2xl flex flex-col items-center justify-center border-2 border-gray-200 overflow-hidden relative">
                 <span class="text-gray-500 font-black text-xs uppercase z-10">Map Preview</span>
                 <img src="https://maps.gstatic.com/tactile/pane/default_geocode-2x.png" class="absolute inset-0 w-full h-full object-cover opacity-40">
              </div>
            </div>

            <div>
              <label class="block font-bold text-gray-700 mb-2 uppercase text-sm tracking-wider">Fasilitas</label>
              <input type="text" placeholder="Contoh: Parkir, Kantin, Mushola" class="w-full border-2 border-gray-200 rounded-xl px-4 py-4 bg-white text-lg">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
              <div>
                <label class="block font-bold text-gray-700 mb-2 uppercase text-sm tracking-wider">Jam Buka</label>
                <input type="time" class="w-full border-2 border-gray-200 rounded-xl px-4 py-4 bg-white font-bold">
              </div>
              <div>
                <label class="block font-bold text-gray-700 mb-2 uppercase text-sm tracking-wider">Jam Tutup</label>
                <input type="time" class="w-full border-2 border-gray-200 rounded-xl px-4 py-4 bg-white font-bold">
              </div>
              <div>
                <label class="block font-bold text-gray-700 mb-2 uppercase text-sm tracking-wider">Durasi Sewa</label>
                <input type="text" placeholder="Per Jam" class="w-full border-2 border-gray-200 rounded-xl px-4 py-4 bg-white font-bold text-center">
              </div>
            </div>

            <div>
              <label class="block font-bold text-gray-700 mb-2 uppercase text-sm tracking-wider">Jenis Olahraga Utama</label>
              <select class="w-full border-2 border-gray-200 rounded-xl px-4 py-4 bg-white font-bold text-lg cursor-pointer">
                <option>Pilih Olahraga</option>
                <option>Basket</option>
                <option>Futsal</option>
                <option>Badminton</option>
              </select>
            </div>

            <div>
              <label class="block font-bold text-gray-700 mb-2 uppercase text-sm tracking-wider">Foto Utama Venue</label>
              <div class="border-4 border-dashed border-gray-300 h-56 flex items-center justify-center bg-white rounded-[2.5rem] text-gray-400 font-black text-xl hover:bg-white hover:border-[#0d2b0d] transition-all cursor-pointer">
                DRAG & DROP FOTO VENUE
              </div>
            </div>
          </div>
        </div>

        <div id="lapangan" class="tab-content space-y-8">
          <div class="flex justify-between items-center border-b-4 border-gray-200 pb-4 mb-8">
            <h2 class="text-2xl font-black text-gray-800 uppercase">Manajemen Lapangan</h2>
            <button type="button" class="bg-yellow-400 hover:bg-yellow-500 px-8 py-2 rounded-xl font-bold shadow-md transition-all active:scale-95">+ ADD</button>
          </div>

          <div class="space-y-6">
            <div>
              <label class="block font-bold text-gray-700 mb-2 uppercase text-sm">Nama Lapangan</label>
              <input type="text" placeholder="Contoh: Lapangan A" class="w-full border-2 border-gray-200 rounded-xl px-4 py-4 bg-white text-lg">
            </div>

            <div>
              <label class="block font-bold text-gray-700 mb-2 uppercase text-sm">Jenis Olahraga</label>
              <select class="w-full border-2 border-gray-200 rounded-xl px-4 py-4 bg-white font-bold text-lg">
                <option>Pilih Olahraga</option>
              </select>
            </div>

            <div>
              <label class="block font-bold text-gray-700 mb-2 uppercase text-sm">Harga per Jam</label>
              <input type="text" placeholder="Rp" class="w-full border-2 border-gray-200 rounded-xl px-4 py-4 bg-white text-lg">
            </div>

            <div>
              <label class="block font-bold text-gray-700 mb-2 uppercase text-sm">Tipe Lapangan / Permukaan</label>
              <input type="text" placeholder="Contoh: Interlock / Vinyl" class="w-full border-2 border-gray-200 rounded-xl px-4 py-4 bg-white text-lg">
            </div>

            <div>
              <label class="block font-bold text-gray-700 mb-2 uppercase text-sm">Foto Detail Lapangan</label>
              <div class="border-4 border-dashed border-gray-300 h-56 flex items-center justify-center bg-white rounded-[2.5rem] text-gray-400 font-black text-xl">
                UPLOAD FOTO LAPANGAN
              </div>
            </div>
          </div>

          <div class="mt-16 pt-10 border-t-2 border-gray-200">
            <button class="w-full bg-yellow-400 hover:bg-yellow-500 text-[#0d2b0d] py-6 rounded-3xl font-black text-3xl uppercase tracking-[0.3em] shadow-xl border-b-8 border-yellow-600 active:border-b-0 active:translate-y-2 transition-all">
              Publish
            </button>
          </div>
        </div>

      </form>
    </div>
  </div>

  <script>
    function showTab(tab) {
      const vSection = document.getElementById('venue');
      const lSection = document.getElementById('lapangan');
      const vTab = document.getElementById('tabV');
      const lTab = document.getElementById('tabL');

      if (tab === 'venue') {
        vSection.classList.add('active');
        lSection.classList.remove('active');
        vTab.className = "flex-1 bg-[#0d2b0d] text-white py-4 rounded-2xl font-bold text-xl transition-all shadow-md";
        lTab.className = "flex-1 bg-gray-400 text-white py-4 rounded-2xl font-bold text-xl transition-all shadow-md";
      } else {
        lSection.classList.add('active');
        vSection.classList.remove('active');
        lTab.className = "flex-1 bg-[#0d2b0d] text-white py-4 rounded-2xl font-bold text-xl transition-all shadow-md";
        vTab.className = "flex-1 bg-gray-400 text-white py-4 rounded-2xl font-bold text-xl transition-all shadow-md";
      }
      window.scrollTo({ top: 0, behavior: 'smooth' });
    }
  </script>

</body>
</html>