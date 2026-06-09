<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Venue;
use App\Models\Field;
use App\Models\Booking;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class VenueController extends Controller
{

    public function index(Request $request)
    {
        $query = Venue::with('fields')->withCount('fields');

        // Filter: Pencarian nama venue
        if ($request->filled('q')) {
            $q = strtolower($request->q);
            $query->whereRaw('LOWER(name) LIKE ?', ["%{$q}%"]);
        }

        // Filter: Jenis Olahraga
        if ($request->filled('sport')) {
            $sport = strtolower($request->sport);
            $query->whereHas('fields', function ($qField) use ($sport) {
                $qField->whereRaw('LOWER(sport_type) = ?', [$sport]);
            });
        }

        // Filter: Kota atau Lokasi Berdasarkan Koordinat
        if ($request->filled('lat') && $request->filled('lon')) {
            $lat = $request->lat;
            $lon = $request->lon;
            $radius = 30; // Radius 30 KM

            $query->whereNotNull('latitude')->whereNotNull('longitude')
                  ->whereRaw(
                      "(6371 * acos(cos(radians(?)) * cos(radians(latitude)) * cos(radians(longitude) - radians(?)) + sin(radians(?)) * sin(radians(latitude)))) <= ?",
                      [$lat, $lon, $lat, $radius]
                  );
        } elseif ($request->filled('city') || $request->filled('location')) {
            $cityStr = strtolower($request->filled('city') ? $request->city : $request->location);
            $cityParts = explode(',', $cityStr);
            $city = trim($cityParts[0]);

            $query->where(function($qV) use ($city) {
                $qV->whereRaw('LOWER(city) LIKE ?', ["%{$city}%"])
                   ->orWhereRaw('LOWER(location) LIKE ?', ["%{$city}%"]);
            });
        }

        // Pengurutan (Sort)
        $sort = $request->get('sort', 'terdekat');
        if ($sort === 'terdekat') {
            $query->latest();
        } elseif ($sort === 'terlama') {
            $query->oldest();
        }

        $venues = $query->get();

        return view('venue.index', compact('venues'));
    }

    public function nearbyAjax(Request $request)
    {
        $lat = $request->lat;
        $lon = $request->lon;
        
        if (!$lat || !$lon) {
            return response()->json(['html' => '']);
        }

        $radius = 30; // 30 KM

        $distanceRaw = "(6371 * acos(least(1.0, cos(radians(?)) * cos(radians(latitude)) * cos(radians(longitude) - radians(?)) + sin(radians(?)) * sin(radians(latitude)))))";

        $venues = Venue::with('fields')->withCount('fields')
            ->select('*')
            ->selectRaw("{$distanceRaw} AS distance", [$lat, $lon, $lat])
            ->whereNotNull('latitude')->whereNotNull('longitude')
            ->whereRaw("{$distanceRaw} <= ?", [$lat, $lon, $lat, $radius])
            ->orderBy('distance', 'asc')
            ->take(3)
            ->get();

        return view('venue.partials.nearby', compact('venues'));
    }

    public function show(Request $request, $id)
    {
        $date = $request->query('date', \Carbon\Carbon::today()->format('Y-m-d'));

        $venue = Venue::with('fields')->findOrFail($id);

        // Generate dynamic time slots if none exist for this date
        foreach ($venue->fields as $field) {
            $exists = \App\Models\TimeSlot::where('field_id', $field->id)
                ->whereDate('date', $date)
                ->exists();
            if (!$exists) {
                $openTime = $venue->open_time ?: '07:00:00';
                $closeTime = $venue->close_time ?: '22:00:00';
                
                try {
                    $start = \Carbon\Carbon::parse($openTime);
                    $end = \Carbon\Carbon::parse($closeTime);
                } catch (\Exception $e) {
                    $start = \Carbon\Carbon::parse('07:00:00');
                    $end = \Carbon\Carbon::parse('22:00:00');
                }
                
                $current = $start->copy();
                while ($current->copy()->addHours(2)->lte($end)) {
                    $slotStart = $current->format('H:i');
                    $current->addHours(2);
                    $slotEnd = $current->format('H:i');
                    
                    \App\Models\TimeSlot::create([
                        'field_id'   => $field->id,
                        'date'       => $date,
                        'start_time' => $slotStart,
                        'end_time'   => $slotEnd,
                    ]);
                }
            }
        }

        // Reload fields and time slots properly filtering by date and booking status
        $venue->load(['fields' => function($query) use ($date) {
            $query->with(['timeSlots' => function($q) use ($date) {
                $q->whereDate('date', $date)
                  ->whereDoesntHave('bookings', function($b) {
                      $b->whereIn('status', ['paid', 'confirmed', 'completed']);
                  });
            }]);
        }]);

        $venue->load(['reviews.user']);

        $totalReviews = $venue->reviews->count();
        $avgMain = 0;
        $avgClean = 0;
        $avgCondition = 0;
        $avgComms = 0;

        if ($totalReviews > 0) {
            $avgMain = round($venue->reviews->avg('rating_main'), 1);
            $avgClean = round($venue->reviews->avg('rating_clean'), 2);
            $avgCondition = round($venue->reviews->avg('rating_condition'), 2);
            $avgComms = round($venue->reviews->avg('rating_comms'), 2);
        }

        return view('venue.show', compact(
            'venue', 'date', 'totalReviews', 
            'avgMain', 'avgClean', 'avgCondition', 'avgComms'
        ));
    }

    public function create()
    {
        return view('venue.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'location' => 'required|string',
            'description' => 'required|string',
            'photos.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'fields' => 'required|array',
        ]);

        $photos = [];
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $file) {
                $path = $file->store('venues', 'public');
                $photos[] = '/storage/' . $path;
            }
        }
        $photoUrl = count($photos) > 0 ? $photos[0] : null;

        $facilities = $request->input('facilities', []);
        $sportTypes = $request->input('sport_type', []);

        $venue = Venue::create([
            'owner_id' => Auth::id() ?? 1,
            'name' => $request->name,
            'city' => $request->city,
            'location' => $request->location,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'description' => $request->description,
            'rules' => $request->rules,
            'open_time' => $request->open_time,
            'close_time' => $request->close_time,
            'facilities' => json_encode($facilities),
            'sport_type' => is_array($sportTypes) ? implode(', ', $sportTypes) : $sportTypes,
            'photo_url' => $photoUrl,
            'photos' => $photos,
            'price_per_hour' => 0, // Akan dihitung dari min price fields
        ]);

        $minPrice = 0;
        if ($request->has('fields')) {
            $prices = [];
            foreach ($request->fields as $fieldData) {
                Field::create([
                    'venue_id' => $venue->id,
                    'name' => $fieldData['name'],
                    'sport_type' => $fieldData['sport_type'] ?? 'Futsal',
                    'price_per_hour' => $fieldData['price_per_hour'] ?? 0,
                    'capacity' => $fieldData['capacity'] ?? 10,
                    'is_indoor' => $fieldData['is_indoor'] ?? true,
                ]);
                $prices[] = $fieldData['price_per_hour'] ?? 0;
            }
            if (!empty($prices)) {
                $minPrice = min($prices);
                $venue->update(['price_per_hour' => $minPrice]);
            }
        }

        return redirect()->route('venues.show', $venue->id)->with('success', 'Venue berhasil didaftarkan!');
    }

    public function edit($id)
    {
        $venue = Venue::with('fields')->findOrFail($id);
        return view('venue.edit', compact('venue'));
    }

    public function update(Request $request, $id)
    {
        $venue = Venue::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'location' => 'required|string',
            'description' => 'required|string',
            'photos.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'fields' => 'required|array',
        ]);

        $photos = $venue->photos ?? [];
        $photoUrl = $venue->photo_url;
        
        if ($request->hasFile('photos')) {
            // Delete old photos
            if (is_array($venue->photos)) {
                foreach ($venue->photos as $oldPhoto) {
                    if ($oldPhoto && str_starts_with($oldPhoto, '/storage/')) {
                        Storage::disk('public')->delete(str_replace('/storage/', '', $oldPhoto));
                    }
                }
            } elseif ($photoUrl && str_starts_with($photoUrl, '/storage/')) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $photoUrl));
            }
            
            $photos = [];
            foreach ($request->file('photos') as $file) {
                $path = $file->store('venues', 'public');
                $photos[] = '/storage/' . $path;
            }
            $photoUrl = count($photos) > 0 ? $photos[0] : null;
        }

        $facilities = $request->input('facilities', []);
        $sportTypes = $request->input('sport_type', []);

        $venue->update([
            'name' => $request->name,
            'city' => $request->city,
            'location' => $request->location,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'description' => $request->description,
            'rules' => $request->rules,
            'open_time' => $request->open_time,
            'close_time' => $request->close_time,
            'facilities' => json_encode($facilities),
            'sport_type' => is_array($sportTypes) ? implode(', ', $sportTypes) : $sportTypes,
            'photo_url' => $photoUrl,
            'photos' => $photos,
        ]);

        // Sync fields: Delete existing fields and recreate them to simplify
        $venue->fields()->delete();
        $minPrice = $venue->price_per_hour;

        if ($request->has('fields')) {
            $prices = [];
            foreach ($request->fields as $fieldData) {
                Field::create([
                    'venue_id' => $venue->id,
                    'name' => $fieldData['name'],
                    'sport_type' => $fieldData['sport_type'] ?? 'Futsal',
                    'price_per_hour' => $fieldData['price_per_hour'] ?? 0,
                    'capacity' => $fieldData['capacity'] ?? 10,
                    'is_indoor' => $fieldData['is_indoor'] ?? true,
                ]);
                $prices[] = $fieldData['price_per_hour'] ?? 0;
            }
            if (!empty($prices)) {
                $minPrice = min($prices);
                $venue->update(['price_per_hour' => $minPrice]);
            }
        }

        return redirect()->route('venues.show', $venue->id)->with('success', 'Venue berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $venue = Venue::findOrFail($id);
        
        if ($venue->photo_url && str_starts_with($venue->photo_url, '/storage/')) {
            Storage::disk('public')->delete(str_replace('/storage/', '', $venue->photo_url));
        }
        
        $venue->delete();

        return redirect()->route('venues.index')->with('success', 'Venue berhasil dihapus.');
    }
}