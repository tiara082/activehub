<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MatchController extends Controller
{
    /** GET /matches — daftar public match (public) */
    public function index(Request $request)
    {
        return view('matches.index');
    }

    /** GET /matches/{match} — detail public match (public) */
    public function show($match)
    {
        return view('matches.show', compact('match'));
    }

    /** GET /matches/create — form buat public match (user login) */
    public function create()
    {
        return view('matches.create');
    }

    /** POST /matches — simpan public match (user login) */
    public function store(Request $request)
    {
        $request->validate([
            'booking_id'       => ['required', 'exists:bookings,id'],
            'title'            => ['nullable', 'string', 'max:255'],
            'description'      => ['nullable', 'string'],
            'total_players'    => ['nullable', 'integer', 'min:2'],
            'price_per_person' => ['nullable', 'integer', 'min:0'],
            'gender_preference'=> ['required', 'in:mixed,male,female'],
        ]);

        // TODO: simpan match

        return redirect()->route('matches.index')->with('success', 'Match berhasil dibuat!');
    }
}
