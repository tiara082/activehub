<?php

namespace App\Http\Controllers;

use App\Models\GameMatch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MatchController extends Controller
{
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

        return redirect()->route('matches.index')->with('success', 'Match berhasil dibuat!');
    }

        public function myMatches(Request $request)
    {
        $active = $request->tab ?? 'open';

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

            return $match->status === $active;

        });


        // TAB COUNT
        $tabs = [

            'open' => [
                'label' => 'Open',
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