<?php

namespace App\Http\Controllers;

use App\Models\GameMatch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MatchController extends Controller
{
    /** GET /matches — daftar public match (public) */
    public function index(Request $request)
    {
        $query = GameMatch::with([
            'booking.field.venue',
            'booking.timeSlot',
            'creator',
            'participants',
        ])->whereHas('booking.timeSlot', function($q) {
            $q->where('date', '>=', now()->format('Y-m-d'));
        });

        // Filter: Pencarian nama lapangan atau judul match
        if ($request->filled('q')) {
            $q = strtolower($request->q);
            $query->where(function ($sq) use ($q) {
                $sq->whereRaw('LOWER(title) LIKE ?', ["%{$q}%"])
                   ->orWhereHas('booking.field', function ($qField) use ($q) {
                       $qField->whereRaw('LOWER(name) LIKE ?', ["%{$q}%"])
                              ->orWhereHas('venue', function ($qVenue) use ($q) {
                                  $qVenue->whereRaw('LOWER(name) LIKE ?', ["%{$q}%"])
                                         ->orWhereRaw('LOWER(city) LIKE ?', ["%{$q}%"])
                                         ->orWhereRaw('LOWER(location) LIKE ?', ["%{$q}%"]);
                              });
                   });
            });
        }

        // Filter: Jenis Olahraga
        if ($request->filled('sport')) {
            $sport = strtolower($request->sport);
            $query->whereHas('booking.field', function ($qField) use ($sport) {
                $qField->whereRaw('LOWER(sport_type) = ?', [$sport]);
            });
        }

        // Filter: Kota atau Lokasi Berdasarkan Koordinat
        if ($request->filled('lat') && $request->filled('lon')) {
            $lat = $request->lat;
            $lon = $request->lon;
            $radius = 30; // Radius 30 KM

            $query->whereHas('booking.field.venue', function ($qVenue) use ($lat, $lon, $radius) {
                // Haversine formula
                $qVenue->whereNotNull('latitude')->whereNotNull('longitude')
                       ->whereRaw(
                           "(6371 * acos(cos(radians(?)) * cos(radians(latitude)) * cos(radians(longitude) - radians(?)) + sin(radians(?)) * sin(radians(latitude)))) <= ?",
                           [$lat, $lon, $lat, $radius]
                       );
            });
        } elseif ($request->filled('city')) {
            // Jika pencarian text manual, ambil kata pertama sebelum koma agar lebih akurat (misal: "Malang, Jawa Timur" -> "Malang")
            $cityStr = strtolower($request->city);
            $cityParts = explode(',', $cityStr);
            $city = trim($cityParts[0]);

            $query->whereHas('booking.field.venue', function ($qVenue) use ($city) {
                $qVenue->where(function($qV) use ($city) {
                    $qV->whereRaw('LOWER(city) LIKE ?', ["%{$city}%"])
                       ->orWhereRaw('LOWER(location) LIKE ?', ["%{$city}%"]);
                });
            });
        }

        // Pengurutan (Sort)
        $sort = $request->get('sort', 'terbaru');
        
        if ($sort === 'terdekat') {
            // Urutkan berdasarkan waktu paling dekat dengan sekarang (menggunakan subquery/join ke time_slots)
            $query->join('bookings', 'matches.booking_id', '=', 'bookings.id')
                  ->join('time_slots', 'bookings.time_slot_id', '=', 'time_slots.id')
                  ->orderBy('time_slots.date', 'asc')
                  ->orderBy('time_slots.start_time', 'asc')
                  ->select('matches.*');
        } elseif ($sort === 'terlama') {
            $query->join('bookings', 'matches.booking_id', '=', 'bookings.id')
                  ->join('time_slots', 'bookings.time_slot_id', '=', 'time_slots.id')
                  ->orderBy('time_slots.date', 'desc')
                  ->orderBy('time_slots.start_time', 'desc')
                  ->select('matches.*');
        } else {
            // Default: terbaru dibuat
            $query->latest('matches.created_at');
        }

        $matches = $query->get();

        return view('pubmatch.list', compact('matches'));
    }


    /** GET /matches/{match} — detail public match (public) */
    public function nearbyAjax(Request $request)
    {
        $lat = $request->lat;
        $lon = $request->lon;
        
        if (!$lat || !$lon) {
            return response()->json(['html' => '']);
        }

        $radius = 30; // 30 KM

        $distanceRaw = "(6371 * acos(least(1.0, cos(radians(?)) * cos(radians(venues.latitude)) * cos(radians(venues.longitude) - radians(?)) + sin(radians(?)) * sin(radians(venues.latitude)))))";

        $matches = GameMatch::select('matches.*')
            ->selectRaw("{$distanceRaw} AS distance", [$lat, $lon, $lat])
            ->join('bookings', 'matches.booking_id', '=', 'bookings.id')
            ->join('fields', 'bookings.field_id', '=', 'fields.id')
            ->join('venues', 'fields.venue_id', '=', 'venues.id')
            ->join('time_slots', 'bookings.time_slot_id', '=', 'time_slots.id')
            ->whereNotNull('venues.latitude')->whereNotNull('venues.longitude')
            ->whereRaw("{$distanceRaw} <= ?", [$lat, $lon, $lat, $radius])
            ->where('time_slots.date', '>=', now()->format('Y-m-d'))
            ->orderBy('distance', 'asc')
            ->with(['booking.field.venue', 'booking.timeSlot', 'participants'])
            ->take(3)
            ->get();

        return view('pubmatch.partials.nearby', compact('matches'));
    }


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

    public function create()
    {
        return view('pubmatch.create');
    }

    public function join($id)
    {
        $match = GameMatch::findOrFail($id);

        if ($match->participants()->where('user_id', Auth::id())->exists()) {
            return back()->with('error', 'Kamu sudah join match ini');
        }

        $match->participants()->attach(Auth::id());

        return back()->with('success', 'Berhasil join match');
    }

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

        return redirect()
            ->route('matches.index')
            ->with('success', 'Match berhasil dibuat!');
    }

        public function myMatches(Request $request)
    {
        $active = $request->tab ?? 'all';

        $matches = GameMatch::with([
                'booking.field.venue',
                'participants',
                'creator'
            ])
            ->where(function ($q) {

                $q->where('creator_id', auth()->id())
                ->orWhereHas('participants', function ($qq) {

                        $qq->where('user_id', auth()->id());

                });

            })
            ->latest()
            ->get();


        // FILTER
        $filteredMatches = $matches->filter(function ($match) use ($active) {

            if ($active === 'all') {
                return true;
            }

            return $match->status === $active;

        });


        // TAB COUNT
        $tabs = [

            'all' => [
                'label' => 'Semua',
                'count' => $matches->count(),
            ],

            'open' => [
                'label' => 'open',
                'count' => $matches->where('status', 'open')->count(),
            ],

            'ongoing' => [
                'label' => 'Berlangsung',
                'count' => $matches->where('status', 'ongoing')->count(),
            ],

            'finished' => [
                'label' => 'Selesai',
                'count' => $matches->where('status', 'finished')->count(),
            ],

            'cancelled' => [
                'label' => 'Dibatalkan',
                'count' => $matches->where('status', 'cancelled')->count(),
            ],

        ];


        return view('user.my-match', compact(
            'tabs',
            'active',
            'filteredMatches'
        ));
    }
}