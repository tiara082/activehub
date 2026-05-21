<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'booking_id' => 'required|exists:bookings,id',
            'rating_main' => 'required|integer|min:1|max:5',
            'rating_clean' => 'required|integer|min:1|max:5',
            'rating_condition' => 'required|integer|min:1|max:5',
            'rating_comms' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        $booking = Booking::findOrFail($request->booking_id);

        // Check if user owns booking
        if ($booking->user_id !== Auth::id()) {
            return back()->with('error', 'Unauthorized.');
        }

        // Check if review already exists for this booking
        if (Review::where('booking_id', $booking->id)->exists()) {
            return back()->with('error', 'Anda sudah memberikan ulasan untuk pesanan ini.');
        }

        Review::create([
            'user_id' => Auth::id(),
            'field_id' => $booking->field_id,
            'booking_id' => $booking->id,
            'rating_main' => $request->rating_main,
            'rating_clean' => $request->rating_clean,
            'rating_condition' => $request->rating_condition,
            'rating_comms' => $request->rating_comms,
            'comment' => $request->comment,
        ]);

        return back()->with('success', 'Terima kasih! Ulasan Anda berhasil dikirim.');
    }
}
