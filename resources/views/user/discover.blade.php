@extends('partials.app')

@section('title', 'Discover')

@section('content')

<div class="p-6">

    {{-- HEADER --}}
    <div class="mb-5">
        <h2 class="text-2xl font-semibold text-gray-900">Discover</h2>
        <p class="text-sm text-gray-500 mt-1">Temukan lapangan & match di sekitarmu</p>
    </div>

    {{-- FILTER + TABS --}}
    <form method="GET" action="{{ route('user.discover') }}">
    <div class="bg-white border border-gray-100 rounded-2xl p-4 mb-5 flex flex-col lg:flex-row gap-3 lg:items-center lg:justify-between">

        {{-- TABS --}}
        <div class="flex gap-6 text-sm border-b lg:border-none pb-2 lg:pb-0">
            <button type="button" onclick="switchTab('venue')" id="tab-venue"
                class="tab-btn text-[#0b3d0b] border-b-2 border-[#0b3d0b] pb-2 font-medium">
                Lapangan
            </button>
            <button type="button" onclick="switchTab('match')" id="tab-match"
                class="tab-btn text-gray-400 pb-2">
                Public Match
            </button>
        </div>

        {{-- FILTER --}}
        <div class="flex gap-3">
            <select name="sport" onchange="this.form.submit()"
                class="text-sm border border-gray-200 rounded-lg px-3 py-2">
                <option value="">Semua Olahraga</option>
                @foreach($sports as $sport)
                    <option value="{{ $sport }}" {{ $sportFilter == $sport ? 'selected' : '' }}>
                        {{ $sport }}
                    </option>
                @endforeach
            </select>

            <select name="city" onchange="this.form.submit()"
                class="text-sm border border-gray-200 rounded-lg px-3 py-2">
                <option value="">Semua Lokasi</option>
                @foreach($cities as $city)
                    <option value="{{ $city }}" {{ $cityFilter == $city ? 'selected' : '' }}>
                        {{ $city }}
                    </option>
                @endforeach
            </select>
        </div>

    </div>
    </form>

    {{-- ================= TAB: LAPANGAN ================= --}}
    <div id="content-venue" class="tab-content">

        {{-- NEARBY --}}
        <div class="bg-white border border-gray-100 rounded-2xl p-5 mb-5">
            <div class="flex justify-between mb-4">
                <p class="text-sm font-semibold text-gray-800">Nearby</p>
                <span class="text-xs text-gray-400">Berdasarkan lokasi</span>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">

                @php
                $nearbyVenues = [
                    ['name'=>'Araya Golf', 'sport'=>'Golf', 'distance'=>'0.8 km', 'image'=>'https://images.unsplash.com/photo-1535139262971-c51845709a48?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.0.3'],
                    ['name'=>'Champion Futsal', 'sport'=>'Futsal', 'distance'=>'1.2 km', 'image'=>'https://images.unsplash.com/photo-1534438327276-14e5300c3a48?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.0.3'],
                    ['name'=>'Tlogomas Badminton', 'sport'=>'Badminton', 'distance'=>'2.5 km', 'image'=>'https://images.unsplash.com/photo-1626224583764-f87db24ac4ea?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.0.3'],
                    ['name'=>'Bima Sakti Hoops', 'sport'=>'Basket', 'distance'=>'3.1 km', 'image'=>'https://images.unsplash.com/photo-1505666287802-931dc83948e9?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.0.3'],
                ];
                @endphp

                @foreach($nearbyVenues as $v)
                <div class="border border-gray-100 rounded-xl p-4 hover:shadow-sm transition">

                    <div class="w-full h-24 bg-gray-100 rounded-lg mb-3 overflow-hidden">
                        <img src="{{ $v['image'] }}" alt="{{ $v['name'] }}" class="w-full h-full object-cover">
                    </div>

                    <p class="text-sm font-medium text-gray-800">
                        {{ $v['name'] }}
                    </p>

                    <p class="text-xs text-gray-500">
                        {{ $v['distance'] }} • {{ $v['sport'] }}
                    </p>

                </div>
                @endforeach

            </div>
        </div>

        {{-- LIST LAPANGAN --}}
        @php
        $venues = [
            ['name'=>'Darmo Sports','location'=>'Sawojajar','sport'=>'Futsal', 'image'=>'https://images.unsplash.com/photo-1579952363873-27f3bade9f55?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.0.3'],
            ['name'=>'Galaxy Court','location'=>'Merjosari','sport'=>'Badminton', 'image'=>'https://images.unsplash.com/photo-1622279457486-62dcc4a431d6?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.0.3'],
            ['name'=>'Suhat Tennis', 'location'=>'Soekarno Hatta', 'sport'=>'Tennis', 'image'=>'https://images.unsplash.com/photo-1595435934249-5df7ed86e1c0?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.0.3'],
            ['name'=>'Metro Mini Soccer', 'location'=>'Klojen', 'sport'=>'Mini Soccer', 'image'=>'https://images.unsplash.com/photo-1459865264687-595d652de67e?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.0.3']
        ];
        @endphp

        <div class="space-y-4">
            @forelse($venues as $v)
            <div class="bg-white border border-gray-100 rounded-2xl p-5 flex justify-between items-center hover:shadow-sm transition">
                <div class="flex gap-4">
                    <div class="w-28 h-20 bg-gray-100 rounded-xl overflow-hidden shrink-0">
                        <img src="{{ $v['image'] }}" alt="{{ $v['name'] }}" class="w-full h-full object-cover">
                    </div>

                    <div class="flex flex-col justify-center">
                        <p class="font-medium text-gray-900">
                            {{ $v['name'] }}
                        </p>

                        <p class="text-sm text-gray-500">
                            {{ $v['sport'] }} • {{ $v['location'] }}
                        </p>
                        @endif
                    </div>
                </div>
                <a href="#" class="text-sm border px-4 py-1.5 rounded-lg hover:bg-gray-100">Lihat</a>
            </div>
            @empty
            <p class="text-sm text-gray-400">Belum ada lapangan tersedia.</p>
            @endforelse
        </div>

    </div>

    {{-- ================= TAB: MATCH ================= --}}
    <div id="content-match" class="tab-content hidden">

        {{-- NEARBY MATCH --}}
        <div class="bg-white border border-gray-100 rounded-2xl p-5 mb-5">
            <div class="flex justify-between mb-4">
                <div>
                    <p class="text-sm font-semibold text-gray-800">Nearby Match</p>
                    <span class="text-xs text-gray-400">Match terdekat dan segera dimulai</span>
                </div>
            </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">

        @php
        $nearMatches = [
            [
                'title'=>'Night Futsal',
                'venue'=>'Champion Futsal',
                'time'=>'20:00',
                'day'=>'Sabtu, 25 Mei',
                'players'=>'8/12'
            ],
            [
                'title'=>'Morning Badminton',
                'venue'=>'Galaxy Court',
                'time'=>'08:00',
                'day'=>'Minggu, 26 Mei',
                'players'=>'5/8'
            ],
            [
                'title'=>'Weekend Basket',
                'venue'=>'Bima Sakti Hoops',
                'time'=>'16:00',
                'day'=>'Minggu, 26 Mei',  
                'players'=>'7/10'
            ],
        ];
        @endphp

        @foreach($nearMatches as $m)
        <div class="border border-gray-100 rounded-xl p-4 hover:shadow-sm transition">

            {{-- HEADER --}}
            <div class="flex justify-between items-start mb-2">
                <p class="text-sm font-medium text-gray-900">
                    {{ $m['title'] }}
                </p>

                {{-- SLOT BADGE --}}
                <span class="text-[10px] px-2 py-1 rounded-full 
                    {{ explode('/', $m['players'])[0] < explode('/', $m['players'])[1] 
                        ? 'bg-green-50 text-green-600' 
                        : 'bg-red-50 text-red-500' }}">
                    {{ $m['players'] }}
                </span>
            </div>

            {{-- INFO --}}
            <p class="text-xs text-gray-500">
                {{ $m['venue'] }}
            </p>

            <p class="text-xs text-gray-400 mt-1">
                 {{ $m['day'] }} •  {{ $m['time'] }}
            </p>

            {{-- CTA --}}
            <button class="mt-3 w-full text-xs bg-[#0b3d0b] text-white py-2 rounded-lg hover:bg-[#145214] transition">
                Join Match
            </button>

        </div>
        @endforeach
    </div>

</div>
        @php
        $matches = [
            ['title'=>'Night Futsal','players'=>'8 / 14','day'=>'Sabtu, 25 Mei','time'=>'20:00', 'location'=>'Malang', 'image'=>'https://images.unsplash.com/photo-1534438327276-14e5300c3a48?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.0.3'],
            ['title'=>'Morning Badminton','players'=>'5 / 8','day'=>'Minggu, 26 Mei','time'=>'08:00', 'location'=>'Blitar', 'image'=>'https://images.unsplash.com/photo-1622279457486-62dcc4a431d6?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.0.3'],
            ['title'=>'Weekend Basket','players'=>'7 / 10','day'=>'Minggu, 26 Mei','time'=>'16:00', 'location'=>'Batu', 'image'=>'https://images.unsplash.com/photo-1505666287802-931dc83948e9?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.0.3'],
        ];
        @endphp

        <div class="space-y-4">
            @forelse($matches as $m)
            <div class="bg-white border border-gray-100 rounded-2xl p-5 flex justify-between items-center hover:shadow-sm transition">
                <div class="flex gap-4">
                    <div class="w-28 h-20 bg-gray-100 rounded-xl overflow-hidden shrink-0">
                        <img src="{{ $m['image'] }}" alt="{{ $m['title'] }}" class="w-full h-full object-cover">
                    </div>

                    <div class="flex flex-col justify-center">
                        <p class="font-medium text-gray-900">
                            {{ $m['title'] }}
                        </p>

                        <p class="text-sm text-gray-500">
                            {{ $m->scheduled_at->translatedFormat('l, d F') }} | {{ $m->scheduled_at->format('H:i') }}
                        </p>
                        <p class="text-sm text-gray-500">{{ $m->city }}</p>
                    </div>
                </div>
                <button class="text-sm border px-4 py-1.5 rounded-lg hover:bg-gray-100">Join</button>
            </div>
            @empty
            <p class="text-sm text-gray-400">Belum ada match tersedia.</p>
            @endforelse
        </div>

    </div>

</div>

{{-- SCRIPT TAB --}}
<script>
function switchTab(tab) {
    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.classList.remove('text-[#0b3d0b]', 'border-b-2', 'border-[#0b3d0b]', 'font-medium');
        btn.classList.add('text-gray-400');
    });
    document.querySelectorAll('.tab-content').forEach(c => c.classList.add('hidden'));
    document.getElementById('content-' + tab).classList.remove('hidden');
    const activeTab = document.getElementById('tab-' + tab);
    activeTab.classList.add('text-[#0b3d0b]', 'border-b-2', 'border-[#0b3d0b]', 'font-medium');
    activeTab.classList.remove('text-gray-400');
}
</script>

@endsection