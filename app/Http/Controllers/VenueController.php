<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Venue;
use App\Models\Field;
use App\Models\Booking;

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
        } elseif ($request->filled('city')) {
            $cityStr = strtolower($request->city);
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

        $venue = Venue::with(['fields' => function($query) use ($date) {
            $query->with(['timeSlots' => function($q) use ($date) {
                $q->whereDate('date', $date)
                  ->whereDoesntHave('bookings', function($b) {
                      $b->whereIn('status', ['paid', 'confirmed', 'completed']);
                  });
            }]);
        }])->findOrFail($id);

        return view('venue.show', compact('venue', 'date'));
    }

    public function store(Request $request)
    {
        // 1️⃣ Validasi
        $request->validate([
            'name' => 'required',
            'city' => 'required',
            'price' => 'required|numeric',
        ]);

        // 2️⃣ Simpan Venue
        $venue = Venue::create([
            'name' => $request->name,
            'location' => $request->city,
            'description' => 'Default description',
        ]);

        // 3️⃣ Buat Field otomatis (biar sesuai ERD)
        $field = Field::create([
            'venue_id' => $venue->id,
            'name' => 'Lapangan A',
            'sport_type' => 'Futsal',
            'price_per_hour' => $request->price,
            'capacity' => 10,
            'is_indoor' => true,
        ]);

        // 4️⃣ Buat Booking otomatis (SIMULASI)
        $booking = Booking::create([
            'user_id' => 1, // sementara (anggap login user id=1)
            'field_id' => $field->id,
            'time_slot_id' => 1, // dummy dulu
            'total_price' => $field->price_per_hour,
            'status' => 'pending',
            'is_public_match' => false,
        ]);

        // 5️⃣ Redirect ke checkout (pakai booking ID!)
        return redirect('/checkout/' . $booking->id);
    }
}