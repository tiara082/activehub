@if($venues->count() > 0)
    <div class="mb-10">
        <div class="flex items-center gap-2 mb-4 px-1">
            <h2 class="text-xl font-bold text-gray-900">Lapangan Terdekat dari Lokasi Anda</h2>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
            @foreach($venues as $venue)
            @php
                $prices = [];
                foreach($venue->fields as $field) {
                    if($field->price_per_hour > 0) {
                        $prices[] = $field->price_per_hour;
                    }
                }
                $minPrice = count($prices) > 0 ? min($prices) : 0;
            @endphp

            <a href="{{ route('venues.show', $venue->id) }}"
               class="bg-white rounded-2xl overflow-hidden shadow border border-gray-100 hover:shadow-lg
                      transition-all duration-300 block group relative">

                <!-- Badge Terdekat & Jarak -->
                <div class="absolute top-0 right-0 bg-[#1b3a1b] text-white text-[10px] font-bold px-3 py-1.5 rounded-bl-xl z-10 flex items-center gap-1 shadow-sm">
                    <span class="uppercase tracking-wider">Terdekat</span>
                    @if(isset($venue->distance))
                        <span class="text-white/80">•</span>
                        <span>{{ number_format($venue->distance, 1, ',', '.') }} KM</span>
                    @endif
                </div>

            @php
                $defaultPhotos = [
                    'https://images.unsplash.com/photo-1575361204480-aadea25e6e68?w=600&q=80',
                    'https://images.unsplash.com/photo-1541534741688-6078c6bfb5c5?w=600&q=80',
                    'https://images.unsplash.com/photo-1461896836934-ffe607ba8211?w=600&q=80',
                ];
                $bgImage = $venue->photo_url ?? $defaultPhotos[$loop->index % count($defaultPhotos)];
            @endphp
            <div class="relative">
                <img src="{{ $bgImage }}"
                    class="w-full h-40 object-cover group-hover:scale-[1.02] transition-transform duration-300" />
            </div>

                <div class="p-4">
                    <div class="flex justify-between items-start mb-1">
                        <h2 class="font-bold text-lg text-gray-900 leading-tight truncate pr-2">
                            {{ $venue->name }}
                        </h2>
                    </div>
                    
                    <p class="text-xs text-gray-500 mb-3 truncate flex items-center gap-1 border-b border-gray-100 pb-3">
                        <i class="fas fa-map-marker-alt text-gray-400"></i>
                        {{ $venue->city ?? $venue->location }}
                    </p>

                    <div class="flex items-center justify-between mt-2">
                        <div>
                            <p class="text-[10px] text-gray-400 font-semibold uppercase tracking-wider mb-0.5">Mulai dari</p>
                            <span class="font-bold text-[#1b3a1b] text-base">
                                @if($minPrice > 0)
                                    Rp {{ number_format($minPrice, 0, ',', '.') }}<span class="font-normal text-xs text-gray-500">/jam</span>
                                @else
                                    <span class="text-green-600">Hubungi Admin</span>
                                @endif
                            </span>
                        </div>
                        <div class="w-8 h-8 rounded-full bg-gray-50 border border-gray-100 flex items-center justify-center text-gray-400 group-hover:bg-[#1b3a1b] group-hover:text-white transition-colors">
                            <i class="fas fa-arrow-right text-xs"></i>
                        </div>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </div>
@else
    <div class="mb-10 p-6 bg-gray-50 border border-gray-100 rounded-2xl flex flex-col items-center justify-center text-center">
        <div class="w-12 h-12 rounded-full bg-gray-200 flex items-center justify-center mb-3">
            <i class="fas fa-map-marker-slash text-gray-400 text-xl"></i>
        </div>
        <p class="text-gray-500 font-medium">Belum ada lapangan di sekitar Anda.</p>
    </div>
@endif
