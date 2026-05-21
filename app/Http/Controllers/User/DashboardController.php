<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\GameMatch;

class DashboardController extends Controller
{
    // =========================
    // DASHBOARD PAGE
    // =========================
    public function index()
    {
        $userId = Auth::id();
        $now = Carbon::now();

        // TOTAL BOOKING
        $totalBooking = Booking::where('user_id', $userId)->count();

        // PUBLIC MATCH BOOKING
        $matchBooking = Booking::where('user_id', $userId)
            ->where('is_public_match', true)
            ->count();

        // CEK ADA BOOKING
        $hasBooking = Booking::where('user_id', $userId)->exists();

        // =========================
        // CHART DATA (6 BULAN)
        // =========================
        $bookingData = [];
        $joinedMatchData = [];
        $createdMatchData = [];
        $months = [];

        for ($i = 5; $i >= 0; $i--) {

            $date = Carbon::now()->subMonths($i);

            $months[] = $date->translatedFormat('M');

            // TOTAL BOOKING
            $bookingData[] = Booking::where('user_id', $userId)
                ->whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();

            // MATCH DIIKUTI
            $joinedMatchData[] = \App\Models\MatchParticipant::where('user_id', $userId)
                ->whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();

            // MATCH DIBUAT
            $createdMatchData[] = \App\Models\GameMatch::where('creator_id', $userId)
                ->whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
        }

        // TERDEKAT BOOKING (Actual upcoming)
        $nearestBooking = Booking::with(['field.venue', 'timeSlot'])
            ->where('user_id', $userId)
            ->whereIn('status', ['confirmed', 'paid', 'pending'])
            ->whereHas('timeSlot', function($q) use ($now) {
                $q->where('date', '>=', $now->toDateString());
            })
            ->get()
            ->filter(function($b) use ($now) {
                if (!$b->timeSlot) return false;
                $end = Carbon::parse($b->timeSlot->date->format('Y-m-d') . ' ' . $b->timeSlot->end_time);
                return $end->isFuture();
            })
            ->sortBy(function($b) {
                return $b->timeSlot->date->format('Y-m-d') . ' ' . $b->timeSlot->start_time;
            })
            ->first();

        // TERDEKAT MATCH (Actual upcoming)
        $nearestMatch = Booking::with(['field.venue', 'timeSlot'])
            ->where('user_id', $userId)
            ->where('is_public_match', true)
            ->whereIn('status', ['confirmed', 'paid', 'pending'])
            ->whereHas('timeSlot', function($q) use ($now) {
                $q->where('date', '>=', $now->toDateString());
            })
            ->get()
            ->filter(function($b) use ($now) {
                if (!$b->timeSlot) return false;
                $end = Carbon::parse($b->timeSlot->date->format('Y-m-d') . ' ' . $b->timeSlot->end_time);
                return $end->isFuture();
            })
            ->sortBy(function($b) {
                return $b->timeSlot->date->format('Y-m-d') . ' ' . $b->timeSlot->start_time;
            })
            ->first();

        return view('user.dashboard', compact(
            'totalBooking',
            'matchBooking',
            'hasBooking',
            'months',
            'nearestBooking',
            'nearestMatch',
            'bookingData',
            'joinedMatchData',
            'createdMatchData'
        ));
    }
}