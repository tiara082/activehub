<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        // =========================
        // TOTAL BOOKING
        // =========================
        $totalBooking = Booking::where('user_id', $userId)->count();

        // =========================
        // MATCH BOOKING
        // =========================
        $matchBooking = Booking::where('user_id', $userId)
            ->where('is_public_match', true)
            ->count();

        // =========================
        // CHART 6 BULAN
        // =========================
        $chart = [];
        $months = [];

        for ($i = 5; $i >= 0; $i--) {

            $date = Carbon::now()->subMonths($i);

            $total = Booking::where('user_id', $userId)
                ->whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();

            $chart[] = $total;

            $months[] = $date->translatedFormat('M');
        }

        // =========================
        // BOOKING TERDEKAT
        // =========================
        $nearestBooking = Booking::with(['field', 'timeSlot'])
            ->where('user_id', $userId)
            ->latest()
            ->first();

        // =========================
        // MATCH TERDEKAT
        // =========================
        $nearestMatch = Booking::with(['field', 'timeSlot'])
            ->where('user_id', $userId)
            ->where('is_public_match', true)
            ->latest()
            ->first();

        return view('user.dashboard', compact(
            'totalBooking',
            'matchBooking',
            'chart',
            'months',
            'nearestBooking',
            'nearestMatch'
        ));
    }

    public function bookings()
    {
        $userId = Auth::id();

        $bookings = Booking::with(['field', 'timeSlot'])
            ->where('user_id', $userId)
            ->get();

        return view('user.bookings', [
            'pendingBookings'   => $bookings->where('status', 'pending'),
            'ongoingBookings'   => $bookings->where('status', 'confirmed'),
            'completedBookings' => $bookings->where('status', 'completed'),
            'cancelledBookings' => $bookings->where('status', 'cancelled'),
        ]);
    }
}