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
                @forelse($nearbyVenues as $venue)
                <div class="border border-gray-100 rounded-xl p-4 hover:shadow-sm transition">
                    @if($venue->photo_url)
                        <img src="{{ $venue->photo_url }}" class="w-full h-24 object-cover rounded-lg mb-3">
                    @else
                        <div class="w-full h-24 bg-gray-100 rounded-lg mb-3"></div>
                    @endif
                    <p class="text-sm font-medium text-gray-800">{{ $venue->name }}</p>
                    <p class="text-xs text-gray-500">{{ $venue->city }} • {{ $venue->sport_type }}</p>
                </div>
                @empty
                <p class="text-sm text-gray-400 col-span-4">Belum ada lapangan tersedia.</p>
                @endforelse
            </div>
        </div>

        {{-- LIST LAPANGAN --}}
        <div class="space-y-4">
            @forelse($venues as $v)
            <div class="bg-white border border-gray-100 rounded-2xl p-5 flex justify-between items-center hover:shadow-sm transition">
                <div class="flex gap-4">
                    @if($v->photo_url)
                        <img src="{{ $v->photo_url }}" class="w-28 h-20 object-cover rounded-xl">
                    @else
                        <div class="w-28 h-20 bg-gray-100 rounded-xl"></div>
                    @endif
                    <div>
                        <p class="font-medium text-gray-900">{{ $v->name }}</p>
                        <p class="text-sm text-gray-500">{{ $v->sport_type }} • {{ $v->city }}</p>
                        @if($v->price_per_hour)
                        <p class="text-sm text-[#0b3d0b] font-medium mt-1">
                            Rp {{ number_format($v->price_per_hour, 0, ',', '.') }}/jam
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
                @forelse($nearbyMatches as $m)
                <div class="border border-gray-100 rounded-xl p-4 hover:shadow-sm transition">
                    <div class="flex justify-between items-start mb-2">
                        <p class="text-sm font-medium text-gray-900">{{ $m->title }}</p>
                        <span class="text-[10px] px-2 py-1 rounded-full
                            {{ $m->current_players < $m->max_players ? 'bg-green-50 text-green-600' : 'bg-red-50 text-red-500' }}">
                            {{ $m->current_players }}/{{ $m->max_players }}
                        </span>
                    </div>
                    <p class="text-xs text-gray-500">{{ $m->venue->name ?? '-' }}</p>
                    <p class="text-xs text-gray-400 mt-1">
                        {{ $m->scheduled_at->translatedFormat('l, d F') }} • {{ $m->scheduled_at->format('H:i') }}
                    </p>
                    <button class="mt-3 w-full text-xs bg-[#0b3d0b] text-white py-2 rounded-lg hover:bg-[#145214] transition">
                        Join Match
                    </button>
                </div>
                @empty
                <p class="text-sm text-gray-400 col-span-3">Belum ada match tersedia.</p>
                @endforelse
            </div>
        </div>

        {{-- LIST MATCH --}}
        <div class="space-y-4">
            @forelse($matches as $m)
            <div class="bg-white border border-gray-100 rounded-2xl p-5 flex justify-between items-center hover:shadow-sm transition">
                <div class="flex gap-4">
                    <div class="w-28 h-20 bg-gray-100 rounded-xl"></div>
                    <div>
                        <p class="font-medium text-gray-900">{{ $m->title }}</p>
                        <p class="text-sm text-gray-500">{{ $m->current_players }}/{{ $m->max_players }} pemain</p>
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