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
        // TOTAL
        // =========================
        $totalBooking = Booking::where('user_id', $userId)->count();

        // =========================
        // MATCH
        // =========================
        $matchBooking = Booking::where('user_id', $userId)
            ->where('is_public_match', true)
            ->count();

        // =========================
        // ✅ FIX: CEK ADA BOOKING
        // =========================
        $hasBooking = Booking::where('user_id', $userId)->exists();

        // =========================
        // CHART STACKED
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

        // =========================
        // TERDEKAT
        // =========================
        $nearestBooking = Booking::with(['field', 'timeSlot'])
            ->where('user_id', $userId)
            ->latest()
            ->first();

        $nearestMatch = Booking::with(['field', 'timeSlot'])
            ->where('user_id', $userId)
            ->where('is_public_match', true)
            ->latest()
            ->first();

        // =========================
        // RETURN VIEW
        // =========================
        return view('user.dashboard', compact(
            'totalBooking',
            'matchBooking',
            'hasBooking', // 🔥 INI YANG BIKIN ERROR HILANG
            'months',
            'pendingData',
            'confirmedData',
            'completedData',
            'nearestBooking',
            'nearestMatch'
        ));
    }
}