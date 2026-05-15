<?php

namespace App\Http\Controllers;

use App\Models\GameMatch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MatchController extends Controller
{
    /** GET /matches — daftar public match (public) */
   public function index()
    {
        $matches = GameMatch::with([
            'booking.field.venue',
            'booking.timeSlot',
            'creator',
            'participants',
        ])->latest()->get();

        return view('pubmatch.list', compact('matches'));
    }

    /** GET /matches/{match} — detail public match (public) */
    public function show(GameMatch $match)
    {
        $match->load([
            'creator',
            'booking',
            'booking.field',
            'booking.field.venue',
            'booking.timeSlot',
            'participants',
        ]);

        return view('pubmatch.detail', compact('match'));
    }

    /** GET /matches/create — form buat public match (user login) */
    public function create()
    {
        return view('pubmatch.create');
    }

    public function join($id)
        {
            // logic join match

            return back()->with('success', 'Berhasil join match');
        }

    /** POST /matches — simpan public match (user login) */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'booking_id'        => ['required', 'exists:bookings,id'],
            'title'             => ['required', 'string', 'max:255'],
            'description'       => ['required', 'string'],
            'total_players'     => ['required', 'integer', 'min:2'],
            'price_per_person'  => ['required', 'integer', 'min:0'],
            'gender_preference' => ['required', 'in:mixed,male,female'],
        ]);

        $match = GameMatch::create([
            'booking_id'        => $validated['booking_id'],
            'creator_id'        => Auth::id(),
            'title'             => $validated['title'],
            'description'       => $validated['description'],
            'total_players'     => $validated['total_players'],
            'price_per_person'  => $validated['price_per_person'],
            'gender_preference' => $validated['gender_preference'],
            'status'            => 'open',
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'success'  => true,
                'match_id' => $match->id,
                'message'  => 'Match berhasil dibuat!',
            ]);
        }

        return redirect()->route('matches.index')->with('success', 'Match berhasil dibuat!');
    }
}
