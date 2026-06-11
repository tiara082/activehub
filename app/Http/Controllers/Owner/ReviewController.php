<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $venues = $user->venues()->get();
        $activeVenueId = session('active_venue_id');
        $venue = $activeVenueId ? ($venues->where('id', $activeVenueId)->first() ?? $venues->first()) : $venues->first();

        // Get all reviews for the active venue
        $reviews = Review::with(['user', 'field.venue'])
            ->whereHas('field', function($q) use ($venue) {
                if ($venue) {
                    $q->where('venue_id', $venue->id);
                } else {
                    $q->where('id', 0); // No reviews if no venue
                }
            })
            ->latest()
            ->get();

        return view('owner.reviews', compact('reviews'));
    }

    public function destroy(Review $review)
    {
        // Check if the review belongs to one of the owner's venues
        if ($review->field->venue->owner_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $review->delete();

        return redirect()->route('owner.reviews')->with('success', 'Ulasan berhasil dihapus.');
    }
}
