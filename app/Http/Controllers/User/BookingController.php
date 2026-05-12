<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        $now = \Carbon\Carbon::now();

        $bookings = Booking::with(['field.venue', 'timeSlot', 'user'])
            ->where('user_id', $userId)
            ->latest()
            ->get();

        $mappedBookings = $bookings->map(function ($b) use ($now) {
            $ts = $b->timeSlot;
            $statusStr = 'Unknown';
            $statusColor = 'gray';

            if ($b->status === 'cancelled') {
                $statusStr = 'Dibatalkan';
                $statusColor = 'gray';
            } elseif ($b->status === 'pending') {
                $statusStr = 'Pending';
                $statusColor = 'blue';
            } elseif ($b->status === 'completed') {
                $statusStr = 'Selesai';
                $statusColor = 'green';
            } elseif (in_array($b->status, ['confirmed', 'paid'])) {
                if (!$ts || !$ts->date) {
                    $statusStr = 'Terjadwal';
                    $statusColor = 'blue';
                } else {
                    $start = \Carbon\Carbon::parse($ts->date->format('Y-m-d') . ' ' . $ts->start_time);
                    $end = \Carbon\Carbon::parse($ts->date->format('Y-m-d') . ' ' . $ts->end_time);

                    if ($end->isPast()) {
                        $statusStr = 'Selesai';
                        $statusColor = 'green';
                    } elseif ($now->between($start, $end)) {
                        $statusStr = 'Berlangsung';
                        $statusColor = 'orange';
                    } else {
                        $statusStr = 'Terjadwal';
                        $statusColor = 'blue';
                    }
                }
            }

            // Calculate duration
            $dur = 0;
            if ($ts && $ts->start_time && $ts->end_time) {
                $dur = \Carbon\Carbon::parse($ts->start_time)->diffInHours(\Carbon\Carbon::parse($ts->end_time));
            }

            return (object) [
                'id' => $b->id,
                'user' => $b->user,
                'field' => $b->field,
                'timeSlot' => $ts,
                'created_at' => $b->created_at,
                'total_price' => $b->total_price,
                'status_label' => $statusStr,
                'status_color' => $statusColor,
                'duration' => $dur . ' jam',
                'raw_status' => $b->status
            ];
        });

        $allBookings = $mappedBookings;
        $pendingBookings = $mappedBookings->where('status_label', 'Terjadwal');
        $ongoingBookings = $mappedBookings->where('status_label', 'Berlangsung');
        $completedBookings = $mappedBookings->where('status_label', 'Selesai');
        $cancelledBookings = $mappedBookings->whereIn('status_label', ['Dibatalkan', 'Pending']);

        return view('user.bookings', compact(
            'allBookings',
            'pendingBookings',
            'ongoingBookings',
            'completedBookings',
            'cancelledBookings'
        ));
    }
}
