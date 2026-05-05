<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        return view('user.dashboard');
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