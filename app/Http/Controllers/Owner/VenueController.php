<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class VenueController extends Controller
{
    /** GET /owner/venues — daftar venue milik owner */
    public function index()
    {
        return view('owner.venues.index');
    }

    /** GET /owner/venues/create — form tambah venue */
    public function create()
    {
        return view('owner.venues.create');
    }

    /** POST /owner/venues — simpan venue baru */
    public function store(Request $request)
    {
        $request->validate([
            'name'        => ['required', 'string', 'max:255'],
            'location'    => ['nullable', 'string'],
            'latitude'    => ['nullable', 'numeric'],
            'longitude'   => ['nullable', 'numeric'],
            'description' => ['nullable', 'string'],
        ]);

        // TODO: simpan venue dengan owner_id = auth()->id()

        return redirect()->route('owner.venues.index')->with('success', 'Venue berhasil dibuat!');
    }

    /** GET /owner/venues/{venue} — detail venue */
    public function show($venue)
    {
        return view('owner.venues.show', compact('venue'));
    }

    /** GET /owner/venues/{venue}/edit — form edit venue */
    public function edit($venue)
    {
        return view('owner.venues.edit', compact('venue'));
    }

    /** PUT /owner/venues/{venue} — update venue */
    public function update(Request $request, $venue)
    {
        // TODO: update venue

        return redirect()->route('owner.venues.index')->with('success', 'Venue berhasil diperbarui!');
    }

    /** DELETE /owner/venues/{venue} — hapus venue */
    public function destroy($venue)
    {
        // TODO: hapus venue

        return redirect()->route('owner.venues.index')->with('success', 'Venue berhasil dihapus!');
    }
}
