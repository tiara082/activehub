<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\GameMatch;
use App\Services\SupabaseStorageService;
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
        } elseif ($request->filled('city') || $request->filled('location')) {
            // Jika pencarian text manual, ambil kata pertama sebelum koma agar lebih akurat (misal: "Malang, Jawa Timur" -> "Malang")
            $cityStr = strtolower($request->filled('city') ? $request->city : $request->location);
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

        $hasBooking = Auth::check()
            ? Booking::where('user_id', Auth::id())->exists()
            : false;

        return view('pubmatch.list', compact('matches', 'hasBooking'));
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

        // Validasi Gender
        if ($match->gender_preference !== 'mixed' && Auth::user()->gender !== $match->gender_preference) {
            return back()->with('error', 'Gender Anda tidak sesuai dengan preferensi pertandingan ini.');
        }

        // Validasi Kapasitas
        $currentParticipants = $match->participants()->where('payment_status', 'confirmed')->count();
        if ($currentParticipants >= $match->total_players) {
            return back()->with('error', 'Pertandingan sudah penuh');
        }

        // Proteksi Bypass Pembayaran
        if ($match->price_per_person > 0) {
            return back()->with('error', 'Pertandingan ini berbayar. Silakan bergabung dari halaman detail match.');
        }

        // Join match gratis secara aman
        $match->participants()->attach(Auth::id(), [
            'payment_status' => 'confirmed'
        ]);

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
            'photo'             => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ]);

        $photoUrl = null;
        if ($request->hasFile('photo')) {
            $supabase = app(SupabaseStorageService::class);
            $photoUrl = $supabase->upload($request->file('photo'), 'matches');
        }

        $match = GameMatch::create([
            'booking_id'        => $validated['booking_id'],
            'creator_id'        => Auth::id(),
            'title'             => $validated['title'],
            'description'       => $validated['description'],
            'total_players'     => $validated['total_players'],
            'price_per_person'  => $validated['price_per_person'],
            'gender_preference' => $validated['gender_preference'],
            'status'            => 'open',
            'photo_url'         => $photoUrl,
        ]);

        // Otomatis daftarkan creator sebagai participant (sudah lunas — bayar saat checkout booking)
        \App\Models\MatchParticipant::create([
            'match_id'       => $match->id,
            'user_id'        => Auth::id(),
            'payment_status' => 'confirmed',
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'success'  => true,
                'match_id' => $match->id,
                'message'  => 'Match berhasil dibuat!',
            ]);
        }

        return redirect()
            ->route('matches.show', $match->id)
            ->with('success', 'Match berhasil dipublikasikan!');
    }

    public function edit($id)
    {
        $match = GameMatch::with(['booking.field.venue', 'booking.timeSlot'])->findOrFail($id);
        
        // Ensure only creator can edit
        if ($match->creator_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('pubmatch.edit', compact('match'));
    }

    public function update(Request $request, $id)
    {
        $match = GameMatch::findOrFail($id);

        if ($match->creator_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'title'             => ['required', 'string', 'max:255'],
            'description'       => ['required', 'string'],
            'total_players'     => ['required', 'integer', 'min:2'],
            'price_per_person'  => ['required', 'integer', 'min:0'],
            'gender_preference' => ['required', 'in:mixed,male,female'],
            'photo'             => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ]);

        $photoUrl = $match->photo_url;
        if ($request->hasFile('photo')) {
            $supabase = app(SupabaseStorageService::class);
            // Hapus foto lama jika ada di Supabase
            if ($photoUrl && !str_starts_with($photoUrl, '/storage/')) {
                $supabase->delete($photoUrl);
            }
            $photoUrl = $supabase->upload($request->file('photo'), 'matches');
        }

        $match->update([
            'title'             => $validated['title'],
            'description'       => $validated['description'],
            'total_players'     => $validated['total_players'],
            'price_per_person'  => $validated['price_per_person'],
            'gender_preference' => $validated['gender_preference'],
            'photo_url'         => $photoUrl,
        ]);

        return redirect()
            ->route('matches.show', $match->id)
            ->with('success', 'Match berhasil diperbarui!');
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
                'label' => 'Menunggu',
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

        ];


        return view('user.my-match', compact(
            'tabs',
            'active',
            'filteredMatches'
        ));
    }
}