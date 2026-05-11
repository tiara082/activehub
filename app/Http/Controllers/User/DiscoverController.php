<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Venue;
use App\Models\PublicMatch;
use Illuminate\Http\Request;

class DiscoverController extends Controller
{
    public function index(Request $request)
    {
        $sportFilter = $request->query('sport');
        $cityFilter  = $request->query('city');

        // VENUES
        $venueQuery = Venue::query();
        if ($sportFilter) $venueQuery->where('sport_type', $sportFilter);
        if ($cityFilter)  $venueQuery->where('city', $cityFilter);

        $nearbyVenues = (clone $venueQuery)->latest()->take(4)->get();
        $venues       = (clone $venueQuery)->latest()->get();

        // PUBLIC MATCHES
        $matchQuery = PublicMatch::with('venue')
            ->where('scheduled_at', '>=', now());
        if ($sportFilter) $matchQuery->where('sport_type', $sportFilter);
        if ($cityFilter)  $matchQuery->where('city', $cityFilter);

        $nearbyMatches = (clone $matchQuery)->orderBy('scheduled_at')->take(3)->get();
        $matches       = (clone $matchQuery)->orderBy('scheduled_at')->get();

        // Filter dropdown
        $sports = Venue::distinct()->pluck('sport_type');
        $cities = Venue::distinct()->pluck('city');

        return view('user.discover', compact(
            'nearbyVenues', 'venues',
            'nearbyMatches', 'matches',
            'sports', 'cities',
            'sportFilter', 'cityFilter'
        ));
    }
}