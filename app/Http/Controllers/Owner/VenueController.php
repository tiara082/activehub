<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Venue;
use App\Models\Booking;
use Carbon\Carbon;

class VenueController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Ambil venue milik owner + relasi fields
        $venue = Venue::with('fields')
            ->where('owner_id', $user->id)
            ->first();

        // Kalau belum punya venue
        if (!$venue) {
            return view('owner.pages.venue', [
                'venue' => null,
                'fields' => collect(),
                'liveFields' => [],
                'stats' => [],
                'payments' => []
            ]);
        }

        $fields = $venue->fields;

        // =========================
        // 🔴 LIVE FIELD STATUS
        // =========================
        $now = Carbon::now();

        $liveFields = $fields->map(function ($field) use ($now) {

            $activeBooking = Booking::with(['timeSlot', 'user'])
                ->where('field_id', $field->id)
                ->where('status', '!=', 'Cancelled')
                ->whereHas('timeSlot', function ($q) use ($now) {
                    $q->where('start_time', '<=', $now)
                      ->where('end_time', '>=', $now);
                })
                ->first();

            if ($activeBooking) {
                return [
                    'name' => $field->name,
                    'status' => 'in_use',
                    'time' => $activeBooking->timeSlot->start_time . ' - ' . $activeBooking->timeSlot->end_time,
                    'user' => $activeBooking->user->name ?? '-',
                ];
            }

            return [
                'name' => $field->name,
                'status' => 'available',
                'time' => null,
                'user' => null,
            ];
        });

        // =========================
        // 💰 PAYMENT OVERVIEW
        // =========================
        $monthlyBookings = Booking::whereHas('field', function ($q) use ($venue) {
                $q->where('venue_id', $venue->id);
            })
            ->whereMonth('created_at', now()->month)
            ->get();

        $payments = [
            'paid' => $monthlyBookings->where('status', 'Paid')->count(),
            'pending' => $monthlyBookings->where('status', 'Pending')->count(),
            'expired' => $monthlyBookings->where('status', 'Expired')->count(),
        ];

        // =========================
        // 📊 STATS
        // =========================
        $allBookings = Booking::whereHas('field', function ($q) use ($venue) {
            $q->where('venue_id', $venue->id);
        })->get();

        $todayBookings = $allBookings->filter(function ($b) {
            return $b->created_at->isToday();
        });

        $stats = [
            'total_booking' => $allBookings->count(),
            'revenue_month' => $monthlyBookings->where('status', 'Paid')->sum('total_price'),
            'booking_today' => $todayBookings->count(),
            'hours_used' => $monthlyBookings->count() * 1, // asumsi 1 booking = 1 jam
        ];

        // =========================
        // 🚀 RETURN VIEW
        // =========================
        return view('owner.pages.venue', compact(
            'venue',
            'fields',
            'liveFields',
            'payments',
            'stats'
        ));
    }
}