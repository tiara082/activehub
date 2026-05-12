<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Booking;
use Carbon\Carbon;

class EarningsController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $venue = $user->venues()->with('fields')->first();
        
        if (!$venue) {
            return back()->with('error', 'Venue tidak ditemukan.');
        }

        $fieldIds = $venue->fields->pluck('id');
        
        // Total Pendapatan
        $totalRevenue = Booking::whereIn('field_id', $fieldIds)
            ->whereIn('status', ['paid', 'confirmed', 'completed'])
            ->sum('total_price');

        // Pendapatan Bulan Ini & Bulan Lalu
        $now = Carbon::now();
        $thisMonthRevenue = Booking::whereIn('field_id', $fieldIds)
            ->whereIn('status', ['paid', 'confirmed', 'completed'])
            ->whereHas('timeSlot', function($q) use ($now) {
                $q->whereMonth('date', $now->month)
                  ->whereYear('date', $now->year);
            })->sum('total_price');

        $lastMonth = clone $now;
        $lastMonth->subMonth();
        $lastMonthRevenue = Booking::whereIn('field_id', $fieldIds)
            ->whereIn('status', ['paid', 'confirmed', 'completed'])
            ->whereHas('timeSlot', function($q) use ($lastMonth) {
                $q->whereMonth('date', $lastMonth->month)
                  ->whereYear('date', $lastMonth->year);
            })->sum('total_price');

        $growth = 0;
        if ($lastMonthRevenue > 0) {
            $growth = (($thisMonthRevenue - $lastMonthRevenue) / $lastMonthRevenue) * 100;
        } elseif ($thisMonthRevenue > 0) {
            $growth = 100;
        }

        // Pendapatan Bulanan (7 bulan terakhir)
        $bars = [];
        $maxRevenue = 0;
        for ($i = 6; $i >= 0; $i--) {
            $monthDate = clone $now;
            $monthDate->subMonths($i);
            
            $monthRevenue = Booking::whereIn('field_id', $fieldIds)
                ->whereIn('status', ['paid', 'confirmed', 'completed'])
                ->whereHas('timeSlot', function($q) use ($monthDate) {
                    $q->whereMonth('date', $monthDate->month)
                      ->whereYear('date', $monthDate->year);
                })->sum('total_price');

            $revenueInMillions = $monthRevenue / 1000000;
            if ($revenueInMillions > $maxRevenue) {
                $maxRevenue = $revenueInMillions;
            }

            $bars[] = [
                'month' => $monthDate->translatedFormat('M'),
                'val' => round($revenueInMillions, 1),
                'current' => $i === 0,
            ];
        }

        if ($maxRevenue == 0) $maxRevenue = 1; // avoid division by zero
        foreach ($bars as $i => $bar) {
            $bars[$i]['pct'] = ($bar['val'] / $maxRevenue) * 100;
        }

        // Rincian per Lapangan (Bulan Ini)
        $laps = [];
        $maxFieldRevenue = 0;
        foreach ($venue->fields as $field) {
            $fieldThisMonthQuery = Booking::where('field_id', $field->id)
                ->whereIn('status', ['paid', 'confirmed', 'completed'])
                ->whereHas('timeSlot', function($q) use ($now) {
                    $q->whereMonth('date', $now->month)
                      ->whereYear('date', $now->year);
                });
            
            $fieldTotalRevenue = (clone $fieldThisMonthQuery)->sum('total_price');
            $fieldBookings = (clone $fieldThisMonthQuery)->count();
            // Estimasi 1 booking = 1 jam (karena kita buat per jam di timeslots)
            $fieldHours = $fieldBookings; 

            $fieldLastMonthQuery = Booking::where('field_id', $field->id)
                ->whereIn('status', ['paid', 'confirmed', 'completed'])
                ->whereHas('timeSlot', function($q) use ($lastMonth) {
                    $q->whereMonth('date', $lastMonth->month)
                      ->whereYear('date', $lastMonth->year);
                });
            $fieldPrevRevenue = (clone $fieldLastMonthQuery)->sum('total_price');

            if ($fieldTotalRevenue > $maxFieldRevenue) {
                $maxFieldRevenue = $fieldTotalRevenue;
            }

            $laps[] = [
                'name' => $field->name,
                'booking' => $fieldBookings,
                'jam' => $fieldHours,
                'total' => $fieldTotalRevenue,
                'prev' => $fieldPrevRevenue,
            ];
        }

        if ($maxFieldRevenue == 0) $maxFieldRevenue = 1;
        foreach ($laps as $i => $lap) {
            $laps[$i]['pct'] = ($lap['total'] / $maxFieldRevenue) * 100;
        }

        // Riwayat Transaksi (Terbaru)
        $txnsData = Booking::with(['user', 'field', 'timeSlot'])
            ->whereIn('field_id', $fieldIds)
            ->whereIn('status', ['paid', 'confirmed', 'completed'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        $txns = [];
        foreach ($txnsData as $booking) {
            $source = ($booking->user_id === $user->id) ? 'offline' : 'online';
            $userName = $booking->user ? $booking->user->name : 'Guest';
            if ($source === 'offline') {
                $userName = 'Booking Offline';
            }

            $detail = $booking->field->name . ' • 1 jam';
            $dateFormatted = $booking->created_at->format('d M, H:i');
            
            if ($booking->timeSlot) {
                $dateFormatted = Carbon::parse($booking->timeSlot->date)->format('d M') . ', ' . Carbon::parse($booking->timeSlot->start_time)->format('H:i');
            }

            $txns[] = [
                'date' => $dateFormatted,
                'name' => $userName,
                'detail' => $detail,
                'amount' => 'Rp ' . number_format($booking->total_price, 0, ',', '.'),
                'source' => $source
            ];
        }

        return view('owner.earnings', compact('totalRevenue', 'thisMonthRevenue', 'lastMonthRevenue', 'growth', 'bars', 'laps', 'txns', 'maxFieldRevenue'));
    }
}
