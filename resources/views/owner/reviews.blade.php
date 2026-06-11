@extends('partials.app')

@section('title', 'Ulasan Pelanggan')
@section('page-title', 'Ulasan Pelanggan')
@section('page-subtitle', 'Kelola dan pantau ulasan dari pelanggan untuk venue Anda.')

@section('content')

<div class="bg-white rounded-2xl border border-gray-100 overflow-hidden shadow-sm">
    @if($reviews->isEmpty())
        <div class="p-10 text-center">
            <div class="w-16 h-16 bg-gray-50 rounded-2xl flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                </svg>
            </div>
            <h3 class="text-gray-900 font-semibold text-lg">Belum ada ulasan</h3>
            <p class="text-gray-500 text-sm mt-1">Ulasan dari pelanggan akan muncul di sini.</p>
        </div>
    @else
        {{-- HEADER --}}
        <div class="flex items-center justify-between px-6 py-5 border-b border-gray-100">
            <div>
                <p class="text-sm font-semibold text-gray-800">Daftar Ulasan</p>
                <p class="text-xs text-gray-400">Menampilkan semua ulasan pelanggan</p>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-center">
                <thead class="text-[11px] text-gray-400 uppercase tracking-wider text-center bg-gray-50/50">
                    <tr>
                        <th class="px-6 py-4">Pelanggan</th>
                        <th class="px-6 py-4">Venue & Lapangan</th>
                        <th class="px-6 py-4">Rating Utama</th>
                        <th class="px-6 py-4">Komentar</th>
                        <th class="px-6 py-4">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($reviews as $review)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4">
                                <p class="font-medium text-gray-800">{{ $review->user->name ?? 'Pengguna' }}</p>
                                <p class="text-xs text-gray-400">{{ $review->created_at->format('d M Y') }}</p>
                            </td>
                            <td class="px-6 py-4">
                                <p class="font-medium text-gray-800">{{ $review->field->venue->name ?? '-' }}</p>
                                <p class="text-xs text-gray-400">{{ $review->field->name ?? '-' }} ({{ $review->field->sport_type ?? '-' }})</p>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-center">
                                    <span class="px-2.5 py-1 rounded-lg text-xs font-semibold bg-yellow-50 text-yellow-700 border border-yellow-100 inline-flex items-center gap-1.5">
                                        <i class="fas fa-star text-yellow-400 text-[10px]"></i> {{ number_format($review->rating_main, 1) }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-gray-600 max-w-xs truncate mx-auto" title="{{ $review->comment }}">
                                    {{ $review->comment ?: '-' }}
                                </p>
                            </td>
                            <td class="px-6 py-4">
                                <div id="review-data-{{ $review->id }}" class="hidden" 
                                    data-user="{{ $review->user->name ?? 'Pengguna' }}"
                                    data-venue="{{ $review->field->venue->name ?? '-' }} ({{ $review->field->name ?? '-' }})"
                                    data-date="{{ $review->created_at->format('d M Y') }}"
                                    data-rating="{{ number_format($review->rating_main, 1) }}"
                                    data-rating-clean="{{ number_format($review->rating_clean, 1) }}"
                                    data-rating-condition="{{ number_format($review->rating_condition, 1) }}"
                                    data-rating-comms="{{ number_format($review->rating_comms, 1) }}"
                                    data-comment="{{ $review->comment ?: 'Tidak ada komentar.' }}">
                                </div>
                                <div class="flex justify-center gap-2">
                                    <button type="button" onclick="openDetailReviewModal({{ $review->id }})" class="w-9 h-9 inline-flex items-center justify-center rounded-xl hover:bg-gray-100 transition text-gray-500" title="Lihat Detail">
                                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                            <path stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5 c4.477 0 8.268 2.943 9.542 7 C20.268 16.057 16.477 19 12 19 c-4.477 0-8.268-2.943-9.542-7z"/>
                                            <circle cx="12" cy="12" r="3" stroke-width="2"/>
                                        </svg>
                                    </button>
                                    <button type="button" onclick="openDeleteReviewModal({{ $review->id }})" class="w-9 h-9 inline-flex items-center justify-center rounded-xl hover:bg-red-50 hover:text-red-600 transition text-gray-500" title="Hapus Ulasan">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>

{{-- MODAL DETAIL ULASAN --}}
<div id="detailReviewModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/40 px-4 backdrop-blur-sm transition-opacity">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-lg p-6 transform scale-95 transition-transform">
        <div class="flex justify-between items-start border-b border-gray-100 pb-4 mb-4">
            <div>
                <h3 class="font-bold text-gray-900 text-lg">Detail Ulasan</h3>
                <p id="detail-date" class="text-xs text-gray-500 mt-1"></p>
            </div>
            <button type="button" onclick="closeDetailReviewModal()" class="text-gray-400 hover:text-gray-600 p-1">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        
        <div class="space-y-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Pelanggan</p>
                    <p id="detail-user" class="font-medium text-gray-900"></p>
                </div>
                <div class="text-right">
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Rating Utama</p>
                    <div id="detail-rating" class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-yellow-50 text-yellow-700 font-bold border border-yellow-100/50">
                    </div>
                </div>
            </div>
            
            <div class="grid grid-cols-3 gap-3 pt-3 pb-1">
                <div class="text-center bg-gray-50 border border-gray-100 rounded-xl py-2 px-1">
                    <p class="text-[10px] font-semibold text-gray-500 uppercase tracking-wider mb-0.5">Kebersihan</p>
                    <div id="detail-rating-clean" class="text-xs font-bold text-gray-800 flex items-center justify-center gap-1"></div>
                </div>
                <div class="text-center bg-gray-50 border border-gray-100 rounded-xl py-2 px-1">
                    <p class="text-[10px] font-semibold text-gray-500 uppercase tracking-wider mb-0.5">Kondisi Lap.</p>
                    <div id="detail-rating-condition" class="text-xs font-bold text-gray-800 flex items-center justify-center gap-1"></div>
                </div>
                <div class="text-center bg-gray-50 border border-gray-100 rounded-xl py-2 px-1">
                    <p class="text-[10px] font-semibold text-gray-500 uppercase tracking-wider mb-0.5">Komunikasi</p>
                    <div id="detail-rating-comms" class="text-xs font-bold text-gray-800 flex items-center justify-center gap-1"></div>
                </div>
            </div>
            
            <div>
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Venue & Lapangan</p>
                <p id="detail-venue" class="font-medium text-gray-900"></p>
            </div>
            
            <div>
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Komentar</p>
                <div class="bg-gray-50 rounded-xl p-4 border border-gray-100">
                    <p id="detail-comment" class="text-gray-700 text-sm leading-relaxed whitespace-pre-wrap"></p>
                </div>
            </div>
        </div>
        
        <div class="mt-6 pt-4 border-t border-gray-100 text-right">
            <button type="button" onclick="closeDetailReviewModal()" class="bg-[#0b3d0b] text-white px-5 py-2.5 rounded-xl text-sm font-semibold hover:bg-[#145214] transition">
                Tutup
            </button>
        </div>
    </div>
</div>

{{-- MODAL HAPUS ULASAN --}}
<div id="deleteReviewModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/40 px-4 backdrop-blur-sm transition-opacity">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-sm p-6 text-center transform scale-95 transition-transform">
        <div class="w-12 h-12 bg-red-50 rounded-2xl flex items-center justify-center mx-auto mb-4 border border-red-100">
            <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
        </div>
        <h3 class="font-semibold text-gray-900 text-lg mb-1">Hapus Ulasan?</h3>
        <p class="text-sm text-gray-500 mb-6 leading-relaxed">
            Ulasan ini akan dihapus secara permanen dan tidak dapat dikembalikan.
        </p>
        <div class="flex gap-3">
            <button type="button" onclick="closeDeleteReviewModal()" class="flex-1 border border-gray-200 text-gray-700 text-sm font-semibold py-2.5 rounded-xl hover:bg-gray-50 transition active:bg-gray-100">
                Batal
            </button>
            <form id="deleteReviewForm" method="POST" action="" class="flex-1">
                @csrf
                @method('DELETE')
                <button type="submit" class="w-full bg-red-500 hover:bg-red-600 text-white text-sm font-semibold py-2.5 rounded-xl transition shadow-sm shadow-red-500/20 active:bg-red-700">
                    Ya, Hapus
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    function openDetailReviewModal(reviewId) {
        const modal = document.getElementById('detailReviewModal');
        const data = document.getElementById('review-data-' + reviewId).dataset;
        
        document.getElementById('detail-user').innerText = data.user;
        document.getElementById('detail-venue').innerText = data.venue;
        document.getElementById('detail-date').innerText = data.date;
        document.getElementById('detail-rating').innerHTML = `<i class="fas fa-star text-[10px]"></i> ` + data.rating;
        
        document.getElementById('detail-rating-clean').innerHTML = `<i class="fas fa-star text-yellow-400 text-[10px]"></i> ` + data.ratingClean;
        document.getElementById('detail-rating-condition').innerHTML = `<i class="fas fa-star text-yellow-400 text-[10px]"></i> ` + data.ratingCondition;
        document.getElementById('detail-rating-comms').innerHTML = `<i class="fas fa-star text-yellow-400 text-[10px]"></i> ` + data.ratingComms;
        
        document.getElementById('detail-comment').innerText = data.comment;
        
        modal.classList.remove('hidden');
        setTimeout(() => {
            modal.querySelector('div').classList.remove('scale-95');
            modal.querySelector('div').classList.add('scale-100');
        }, 10);
    }

    function closeDetailReviewModal() {
        const modal = document.getElementById('detailReviewModal');
        modal.querySelector('div').classList.remove('scale-100');
        modal.querySelector('div').classList.add('scale-95');
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 150);
    }

    document.getElementById('detailReviewModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeDetailReviewModal();
        }
    });

    function openDeleteReviewModal(reviewId) {
        const modal = document.getElementById('deleteReviewModal');
        const form = document.getElementById('deleteReviewForm');
        
        form.action = `/owner/reviews/${reviewId}`;
        
        modal.classList.remove('hidden');
        // Small delay to allow display:block to apply before scaling up
        setTimeout(() => {
            modal.querySelector('div').classList.remove('scale-95');
            modal.querySelector('div').classList.add('scale-100');
        }, 10);
    }

    function closeDeleteReviewModal() {
        const modal = document.getElementById('deleteReviewModal');
        modal.querySelector('div').classList.remove('scale-100');
        modal.querySelector('div').classList.add('scale-95');
        
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 150); // wait for scale down animation
    }
    
    // Close on click outside
    document.getElementById('deleteReviewModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeDeleteReviewModal();
        }
    });
</script>

@endsection
