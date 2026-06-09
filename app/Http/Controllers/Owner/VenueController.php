<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Field;
use App\Models\Venue;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class VenueController extends Controller
{
    // =========================================================
    //  VENUE
    // =========================================================

    public function index(): View
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $venues = $user
            ->venues()
            ->with('fields')
            ->latest()
            ->get();

        $activeVenue = $venues->first();

        return view('owner.venue', compact('venues', 'activeVenue'));
    }

    public function create(): View
    {
        return view('venue.create');
    }

    public function edit(Venue $venue): View
    {
        $this->authorizeVenue($venue);
        return view('venue.edit', compact('venue'));
    }

    /**
     * STORE VENUE + FIELDS (FIXED)
     */
    public function storeVenue(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'sport_type'  => 'nullable|array',
            'location'    => 'required|string|max:255',
            'city'        => 'nullable|string|max:100',
            'description' => 'nullable|string',
            'latitude'    => 'nullable|numeric',
            'longitude'   => 'nullable|numeric',
            'open_time'   => 'nullable|date_format:H:i',
            'close_time'  => 'nullable|date_format:H:i',
            'facilities'  => 'nullable|array',
            'facilities.*'=> 'string|max:100',
            'rules'       => 'nullable|string',

            // fields
            'fields'                   => 'required|array|min:1',
            'fields.*.name'           => 'required|string|max:255',
            'fields.*.sport_type'     => 'nullable|string|max:100',
            'fields.*.price_per_hour' => 'required|integer|min:0',
            'fields.*.capacity'       => 'nullable|integer|min:1',
            'fields.*.is_indoor'      => 'required|in:0,1',
        ]);

        // 1. create venue
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $venue = $user->venues()->create([
            'name'        => $data['name'],
            'sport_type'  => $data['sport_type'] ?? [],
            'location'    => $data['location'],
            'city'        => $data['city'] ?? null,
            'description' => $data['description'] ?? null,
            'latitude'    => $data['latitude'] ?? null,
            'longitude'   => $data['longitude'] ?? null,
            'open_time'   => $data['open_time'] ?? '07:00',
            'close_time'  => $data['close_time'] ?? '22:00',
            'facilities'  => $data['facilities'] ?? [],
            'rules'       => $data['rules'] ?? null,
        ]);

        // 2. create fields
        foreach ($data['fields'] as $field) {
            $venue->fields()->create($field);
        }

        return redirect()->route('owner.venue')
            ->with('success', 'Venue & lapangan berhasil ditambahkan.');
    }

    /**
     * UPDATE VENUE + FIELDS (FIXED)
     */
    public function updateVenue(Request $request, Venue $venue): RedirectResponse
    {
        $this->authorizeVenue($venue);

        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'sport_type'  => 'nullable|array',
            'location'    => 'required|string|max:255',
            'city'        => 'nullable|string|max:100',
            'description' => 'nullable|string',
            'latitude'    => 'nullable|numeric',
            'longitude'   => 'nullable|numeric',
            'open_time'   => 'nullable|string',
            'close_time'  => 'nullable|string',
            'facilities'  => 'nullable|array',
            'facilities.*'=> 'string|max:100',
            'rules'       => 'nullable|string',
            'photos.*'    => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $photos = $venue->photos ?? [];
        if ($request->hasFile('photos')) {
            // Delete old photos
            if ($venue->photos) {
                foreach ($venue->photos as $oldPhoto) {
                    if (str_starts_with($oldPhoto, '/storage/')) {
                        \Illuminate\Support\Facades\Storage::disk('public')->delete(str_replace('/storage/', '', $oldPhoto));
                    }
                }
            }
            $photos = [];
            foreach ($request->file('photos') as $file) {
                $path = $file->store('venues', 'public');
                $photos[] = '/storage/' . $path;
            }
        }

        $photoUrl = count($photos) > 0 ? $photos[0] : null;

        $venue->update([
            'name'        => $data['name'],
            'sport_type'  => $data['sport_type'] ?? [],
            'location'    => $data['location'],
            'city'        => $data['city'] ?? null,
            'description' => $data['description'] ?? null,
            'latitude'    => $data['latitude'] ?? null,
            'longitude'   => $data['longitude'] ?? null,
            'open_time'   => $data['open_time'] ?? '07:00',
            'close_time'  => $data['close_time'] ?? '22:00',
            'facilities'  => $data['facilities'] ?? [],
            'rules'       => $data['rules'] ?? null,
            'photos'      => $photos,
            'photo_url'   => $photoUrl,
        ]);

        return redirect()->route('owner.venue')
            ->with('success', 'Detail venue berhasil diperbarui.');
    }

    public function storeField(Request $request, Venue $venue): RedirectResponse
    {
        $this->authorizeVenue($venue);

        $data = $request->validate([
            'name'           => 'required|string|max:255',
            'sport_type'     => 'nullable|string|max:100',
            'price_per_hour' => 'required|integer|min:0',
            'capacity'       => 'nullable|integer|min:1',
            'is_indoor'      => 'required|in:0,1',
            'photo'          => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('fields', 'public');
            $data['photo_url'] = '/storage/' . $path;
        }

        $venue->fields()->create($data);

        // Update venue min price
        $minPrice = $venue->fields()->min('price_per_hour') ?? 0;
        $venue->update(['price_per_hour' => $minPrice]);

        return redirect()->route('owner.venue')
            ->with('success', 'Lapangan berhasil ditambahkan.');
    }

    public function updateField(Request $request, Venue $venue, Field $field): RedirectResponse
    {
        $this->authorizeVenue($venue);

        if ($field->venue_id !== $venue->id) {
            abort(404);
        }

        $data = $request->validate([
            'name'           => 'required|string|max:255',
            'sport_type'     => 'nullable|string|max:100',
            'price_per_hour' => 'required|integer|min:0',
            'capacity'       => 'nullable|integer|min:1',
            'is_indoor'      => 'required|in:0,1',
            'photo'          => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            if ($field->photo_url && str_starts_with($field->photo_url, '/storage/')) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete(str_replace('/storage/', '', $field->photo_url));
            }
            $path = $request->file('photo')->store('fields', 'public');
            $data['photo_url'] = '/storage/' . $path;
        }

        $field->update($data);

        // Update venue min price
        $minPrice = $venue->fields()->min('price_per_hour') ?? 0;
        $venue->update(['price_per_hour' => $minPrice]);

        return redirect()->route('owner.venue')
            ->with('success', 'Lapangan berhasil diperbarui.');
    }

    public function destroyVenue(Venue $venue): RedirectResponse
    {
        $this->authorizeVenue($venue);

        $venue->delete();

        return redirect()->route('owner.venue')
            ->with('success', 'Venue berhasil dihapus.');
    }

    public function destroyField(Venue $venue, Field $field): RedirectResponse
    {
        $this->authorizeVenue($venue);

        if ($field->venue_id !== $venue->id) {
            abort(404);
        }

        $field->delete();

        return redirect()->route('owner.venue')
            ->with('success', 'Lapangan berhasil dihapus.');
    }

    // =========================================================
    // HELPERS
    // =========================================================

    private function authorizeVenue(Venue $venue): void
    {
        abort_if($venue->owner_id !== Auth::id(), 403);
    }
}
