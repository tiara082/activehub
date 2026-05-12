<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

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
        $months = [];
        $pendingData = [];
        $confirmedData = [];
        $completedData = [];

        for ($i = 5; $i >= 0; $i--) {

            $date = Carbon::now()->subMonths($i);

            $months[] = $date->translatedFormat('M');

            $pendingData[] = Booking::where('user_id', $userId)
                ->where('status', 'pending')
                ->whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();

            $confirmedData[] = Booking::where('user_id', $userId)
                ->where('status', 'confirmed')
                ->whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();

            $completedData[] = Booking::where('user_id', $userId)
                ->where('status', 'completed')
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
            'pendingData',
            'confirmedData',
            'completedData',
            'nearestBooking',
            'nearestMatch'
        ));
    }
}