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
        $matches = GameMatch::latest()->get();

        return view('pubmatch.list', compact('matches'));
    }

    /** GET /matches/{match} — detail public match (public) */
    public function show(GameMatch $match)
    {
        $match->load(['booking', 'creator']);

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
            'title'             => ['nullable', 'string', 'max:255'],
            'description'       => ['nullable', 'string'],
            'total_players'     => ['nullable', 'integer', 'min:2'],
            'price_per_person'  => ['nullable', 'integer', 'min:0'],
            'gender_preference' => ['required', 'in:mixed,male,female'],
        ]);

        GameMatch::create([
            'booking_id'        => $validated['booking_id'],
            'creator_id'        => Auth::id(),
            'title'             => $validated['title'] ?? null,
            'description'       => $validated['description'] ?? null,
            'total_players'     => $validated['total_players'] ?? null,
            'price_per_person'  => $validated['price_per_person'] ?? null,
            'gender_preference' => $validated['gender_preference'],
            'status'            => 'open',
        ]);

        return redirect()->route('matches.index')->with('success', 'Match berhasil dibuat!');
    }
}
