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

        // TERDEKAT BOOKING
        $nearestBooking = Booking::with(['field', 'timeSlot'])
            ->where('user_id', $userId)
            ->latest()
            ->first();

        // TERDEKAT MATCH
        $nearestMatch = Booking::with(['field', 'timeSlot'])
            ->where('user_id', $userId)
            ->where('is_public_match', true)
            ->latest()
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

    // =========================
    // BOOKINGS PAGE (FIX SEMUA VARIABLE BLADE)
    // =========================
    public function bookings()
    {
        $userId = Auth::id();

        $allBookings = Booking::where('user_id', $userId)->get();

        $pendingBookings = Booking::where('user_id', $userId)
            ->where('status', 'pending')
            ->get();

        $ongoingBookings = Booking::where('user_id', $userId)
            ->where('status', 'confirmed')
            ->get();

        $completedBookings = Booking::where('user_id', $userId)
            ->where('status', 'completed')
            ->get();

        $cancelledBookings = Booking::where('user_id', $userId)
            ->where('status', 'cancelled')
            ->get();

        return view('user.bookings', compact(
            'allBookings',
            'pendingBookings',
            'ongoingBookings',
            'completedBookings',
            'cancelledBookings'
        ));
    }
}