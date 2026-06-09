@if($matches->count() > 0)
    <div class="mb-10">
        <div class="flex items-center gap-2 mb-4 px-1">
            <h2 class="text-xl font-bold text-gray-900">Permainan Terdekat dari Lokasi Anda</h2>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
            @foreach($matches as $match)
            @php
                $venue = $match->booking->field->venue;
                $field = $match->booking->field;
                
                $pricePerPerson = $match->price_per_person;
                $filled = $match->participants->count();
                $target = $match->total_players;
                $percentage = $target > 0 ? min(100, ($filled / $target) * 100) : 0;
            @endphp

            <a href="{{ route('matches.show', $match->id) }}"
               class="bg-white rounded-2xl overflow-hidden shadow border border-gray-100 hover:shadow-lg
                      transition-all duration-300 block group relative flex flex-col">

                <!-- Badge Terdekat & Jarak -->
                <div class="absolute top-0 right-0 bg-[#1b3a1b] text-white text-[10px] font-bold px-3 py-1.5 rounded-bl-xl z-10 flex items-center gap-1 shadow-sm">
                    <span class="uppercase tracking-wider">Terdekat</span>
                    @if(isset($match->distance))
                        <span class="text-white/80">•</span>
                        <span>{{ number_format($match->distance, 1, ',', '.') }} KM</span>
                    @endif
                </div>

                <div class="relative h-32 overflow-hidden bg-gray-100 shrink-0">
                    <img src="{{ $venue->photo_url ?? 'https://images.unsplash.com/photo-1575361204480-aadea25e6e68?w=600&q=80' }}"
                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" />
                    <div class="absolute inset-0 bg-black/30 group-hover:bg-black/20 transition-colors duration-300"></div>
                    
                    <div class="absolute bottom-3 left-3 text-white">
                        <h2 class="font-bold text-lg leading-tight truncate w-56 text-white">{{ $match->title }}</h2>
                    </div>
                </div>

                <div class="p-4 flex flex-col flex-1">
                    
                    <div class="flex items-center gap-2 text-xs text-gray-600 mb-2 font-medium">
                        <i class="far fa-calendar-alt w-3 text-center text-gray-400"></i>
                        <span>{{ \Carbon\Carbon::parse($match->booking->timeSlot->date)->format('d M Y') }}</span>
                        <span class="text-gray-300">•</span>
                        <span>{{ \Carbon\Carbon::parse($match->booking->timeSlot->start_time)->format('H:i') }}</span>
                    </div>

                    <div class="flex items-center gap-2 text-xs text-gray-500 mb-4 truncate border-b border-gray-100 pb-3">
                        <i class="fas fa-map-marker-alt w-3 text-center text-gray-400"></i>
                        <span class="truncate">{{ $venue->name }} - {{ $venue->city ?? $venue->location }}</span>
                    </div>

                    <div class="mt-auto">
                        <div class="flex justify-between items-end mb-1.5">
                            <span class="text-[10px] font-semibold text-gray-400 uppercase tracking-wider">Slot Terisi</span>
                            <span class="text-xs font-bold text-gray-700">{{ $filled }}/{{ $target }}</span>
                        </div>
                        <div class="w-full bg-gray-100 rounded-full h-1.5 mb-4 overflow-hidden">
                            <div class="bg-blue-500 h-1.5 rounded-full" style="width: {{ $percentage }}%"></div>
                        </div>

                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-[10px] text-gray-400 font-semibold uppercase tracking-wider mb-0.5">Patungan</p>
                                <span class="font-bold text-[#1b3a1b] text-base">
                                    Rp {{ number_format($pricePerPerson, 0, ',', '.') }}<span class="font-normal text-[10px] text-gray-500">/org</span>
                                </span>
                            </div>
                            <div class="w-8 h-8 rounded-full bg-gray-50 border border-gray-100 flex items-center justify-center text-gray-400 group-hover:bg-[#1b3a1b] group-hover:text-white transition-colors">
                                <i class="fas fa-arrow-right text-xs"></i>
                            </div>
                        </div>
                    </div>

                </div>

                @auth
                    @if($match->creator_id === auth()->id())
                        <div class="bg-blue-50 text-blue-700 text-xs font-semibold py-2.5 px-4 text-center border-t border-blue-100">
                            <i class="fas fa-user-shield mr-1"></i> Kamu adalah Pembuat Match
                        </div>
                    @elseif($match->participants->where('id', auth()->id())->count() > 0)
                        <div class="bg-green-50 text-green-700 text-xs font-semibold py-2.5 px-4 text-center border-t border-green-100">
                            <i class="fas fa-check-circle mr-1"></i> Kamu sudah bergabung (Lihat Detail)
                        </div>
                    @else
                        <div class="bg-gray-50 text-gray-500 text-xs font-semibold py-2.5 px-4 text-center border-t border-gray-100 group-hover:bg-green-50 group-hover:text-green-700 transition duration-200">
                            Lihat Detail Match
                        </div>
                    @endif
                @else
                    <div class="bg-gray-50 text-gray-500 text-xs font-semibold py-2.5 px-4 text-center border-t border-gray-100 group-hover:bg-green-50 group-hover:text-green-700 transition duration-200">
                        Lihat Detail Match
                    </div>
                @endauth
            </a>
            @endforeach
        </div>
    </div>
@else
    <div class="mb-10 p-6 bg-gray-50 border border-gray-100 rounded-2xl flex flex-col items-center justify-center text-center">
        <div class="w-12 h-12 rounded-full bg-gray-200 flex items-center justify-center mb-3">
            <i class="fas fa-search-location text-gray-400 text-xl"></i>
        </div>
        <p class="text-gray-500 font-medium">Belum ada permainan di sekitar Anda.</p>
    </div>
@endif
