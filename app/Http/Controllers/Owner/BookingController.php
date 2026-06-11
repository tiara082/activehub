<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Booking;
use Carbon\Carbon;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $venues = $user->venues()->with('fields')->get();
        $activeVenueId = session('active_venue_id');
        $venue = $activeVenueId ? ($venues->where('id', $activeVenueId)->first() ?? $venues->first()) : $venues->first();
        
        if (!$venue) {
            return view('owner.bookings', [
                'bookings' => collect(),
                'tabs' => $this->getEmptyTabs(),
                'monthlyStats' => $this->getEmptyMonthlyStats(),
                'currentMonthStat' => $this->getEmptyStat(),
                'diffPct' => 0,
                'active' => 'all',
                'venue' => null
            ]);
        }

        $fieldIds = $venue->fields->pluck('id');

        // Query Bookings
        $query = Booking::whereIn('field_id', $fieldIds)
            ->with(['user', 'timeSlot', 'field'])
            ->orderByDesc('created_at');

        // Filter by Date
        if ($request->filled('date')) {
            $query->whereHas('timeSlot', function($q) use ($request) {
                $q->where('date', $request->date);
            });
        }

        // Filter by Field
        if ($request->filled('field_id')) {
            $query->where('field_id', $request->field_id);
        }

        // Filter by Search (User Name or Phone)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        $bookingsData = $query->get();

        // Mapping Bookings & Status
        $now = Carbon::now();
        $mappedBookings = collect();

        $counts = [
            'all' => 0,
            'Terjadwal' => 0,
            'Berlangsung' => 0,
            'Selesai' => 0,
            'Dibatalkan' => 0,
            'Menunggu' => 0,
            'Blokir' => 0
        ];

        foreach ($bookingsData as $b) {
            $ts = $b->timeSlot;
            $statusStr = 'Unknown';
            
            if ($b->status === 'cancelled') {
                $statusStr = 'Dibatalkan';
            } elseif ($b->status === 'pending') {
                $statusStr = 'Menunggu';
            } elseif ($b->status === 'completed') {
                $statusStr = 'Selesai';
            } elseif ($b->status === 'blocked') {
                $statusStr = 'Blokir';
            } elseif (in_array($b->status, ['confirmed', 'paid'])) {
                if (!$ts || !$ts->date) {
                    $statusStr = 'Terjadwal';
                } else {
                    $date = Carbon::parse($ts->date);
                    $start = Carbon::parse($ts->date->format('Y-m-d') . ' ' . $ts->start_time);
                    $end = Carbon::parse($ts->date->format('Y-m-d') . ' ' . $ts->end_time);

                    if ($end->isPast()) {
                        $statusStr = 'Selesai';
                    } elseif ($now->between($start, $end)) {
                        $statusStr = 'Berlangsung';
                    } else {
                        $statusStr = 'Terjadwal';
                    }
                }
            }

            $counts['all']++;
            if (isset($counts[$statusStr])) {
                $counts[$statusStr]++;
            }

            // Calculate duration in hours
            $dur = 0;
            if ($ts && $ts->start_time && $ts->end_time) {
                $dur = Carbon::parse($ts->start_time)->diffInHours(Carbon::parse($ts->end_time));
            }

            $mappedBookings->push([
                'id' => $b->id,
                'name' => $b->user ? $b->user->name : 'Unknown',
                'phone' => $b->user && $b->user->phone ? $b->user->phone : '-',
                'court' => $b->field ? $b->field->name : '-',
                'date' => $ts ? Carbon::parse($ts->date)->translatedFormat('d M Y') : '-',
                'time' => $ts ? Carbon::parse($ts->start_time)->format('H:i') . '–' . Carbon::parse($ts->end_time)->format('H:i') : '-',
                'dur' => $dur . ' jam',
                'total' => 'Rp ' . number_format($b->total_price, 0, ',', '.'),
                'status' => $statusStr,
                'raw_status' => $b->status
            ]);
        }

        // Apply Tab Filter
        $active = $request->get('status', 'all');
        if ($active !== 'all') {
            $mappedBookings = $mappedBookings->where('status', $active)->values();
        }

        $tabs = [
            ['key' => 'all', 'label' => 'Semua', 'count' => $counts['all']],
            ['key' => 'Menunggu', 'label' => 'Menunggu', 'count' => $counts['Menunggu']],
            ['key' => 'Terjadwal', 'label' => 'Terjadwal', 'count' => $counts['Terjadwal']],
            ['key' => 'Berlangsung', 'label' => 'Berlangsung', 'count' => $counts['Berlangsung']],
            ['key' => 'Selesai', 'label' => 'Selesai', 'count' => $counts['Selesai']],
            ['key' => 'Dibatalkan', 'label' => 'Dibatalkan', 'count' => $counts['Dibatalkan']],
        ];

        // 6 Months Stats
        $monthlyStats = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = $now->copy()->subMonths($i);
            
            // Query bookings for this month
            $baseQuery = Booking::whereIn('field_id', $fieldIds)
                ->whereHas('timeSlot', function($q) use ($month) {
                    $q->whereMonth('date', $month->month)
                      ->whereYear('date', $month->year);
                });

            $total = (clone $baseQuery)->count();
            $dibatalkan = (clone $baseQuery)->where('status', 'cancelled')->count();
            $selesai = (clone $baseQuery)->whereIn('status', ['completed', 'confirmed', 'paid'])->count();

            $monthlyStats[] = [
                'label'      => $month->translatedFormat('M'),
                'month_num'  => $month->month,
                'year'       => $month->year,
                'total'      => $total,      
                'selesai'    => $selesai,
                'dibatalkan' => $dibatalkan,
            ];
        }

        $currentMonthStat  = end($monthlyStats);
        $previousMonthStat = $monthlyStats[count($monthlyStats) - 2] ?? $currentMonthStat;

        $diffTotal = $currentMonthStat['total'] - $previousMonthStat['total'];
        $diffPct   = $previousMonthStat['total'] > 0
            ? round(($diffTotal / $previousMonthStat['total']) * 100)
            : ($diffTotal > 0 ? 100 : 0);

        return view('owner.bookings', [
            'bookings' => $mappedBookings,
            'tabs' => $tabs,
            'monthlyStats' => $monthlyStats,
            'currentMonthStat' => $currentMonthStat,
            'diffPct' => $diffPct,
            'active' => $active,
            'venue' => $venue
        ]);
    }

    private function getEmptyTabs()
    {
        return [
            ['key' => 'all', 'label' => 'Semua', 'count' => 0],
            ['key' => 'Menunggu', 'label' => 'Menunggu', 'count' => 0],
            ['key' => 'Terjadwal', 'label' => 'Terjadwal', 'count' => 0],
            ['key' => 'Berlangsung', 'label' => 'Berlangsung', 'count' => 0],
            ['key' => 'Selesai', 'label' => 'Selesai', 'count' => 0],
            ['key' => 'Dibatalkan', 'label' => 'Dibatalkan', 'count' => 0],
        ];
    }

    private function getEmptyMonthlyStats()
    {
        $now = Carbon::now();
        $stats = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = $now->copy()->subMonths($i);
            $stats[] = [
                'label'      => $month->translatedFormat('M'),
                'month_num'  => $month->month,
                'year'       => $month->year,
                'total'      => 0,      
                'selesai'    => 0,
                'dibatalkan' => 0,
            ];
        }
        return $stats;
    }

    private function getEmptyStat()
    {
        return [
            'label' => '', 'month_num' => 0, 'year' => 0, 'total' => 0, 'selesai' => 0, 'dibatalkan' => 0
        ];
    }

    public function export(Request $request)
    {
        $user = Auth::user();
        $venues = $user->venues()->with('fields')->get();
        $activeVenueId = session('active_venue_id');
        $venue = $activeVenueId ? ($venues->where('id', $activeVenueId)->first() ?? $venues->first()) : $venues->first();
        
        if (!$venue) {
            return back()->with('error', 'Belum ada venue.');
        }

        $fieldIds = $venue->fields->pluck('id');

        $query = Booking::whereIn('field_id', $fieldIds)
            ->with(['user', 'timeSlot', 'field'])
            ->orderByDesc('created_at');

        if ($request->filled('date')) {
            $query->whereHas('timeSlot', function($q) use ($request) {
                $q->where('date', $request->date);
            });
        }

        if ($request->filled('field_id')) {
            $query->where('field_id', $request->field_id);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        $bookings = $query->get();

        $filename = "data_pemesanan_" . date('Y-m-d_H-i-s') . ".csv";

        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = ['ID Booking', 'Nama Pemesan', 'Telepon', 'Lapangan', 'Tanggal', 'Jam', 'Durasi (Jam)', 'Total Harga (Rp)', 'Status Sistem'];

        $callback = function() use($bookings, $columns) {
            $file = fopen('php://output', 'w');
            
            // Tambahkan BOM agar Excel mengenali karakter dengan benar (opsional tapi disarankan)
            fputs($file, "\xEF\xBB\xBF");
            
            fputcsv($file, $columns, ';');

            foreach ($bookings as $b) {
                $ts = $b->timeSlot;
                $dur = 0;
                if ($ts && $ts->start_time && $ts->end_time) {
                    $dur = Carbon::parse($ts->start_time)->diffInHours(Carbon::parse($ts->end_time));
                }

                $row = [
                    $b->id,
                    $b->user ? $b->user->name : 'Unknown',
                    $b->user && $b->user->phone ? $b->user->phone : '-',
                    $b->field ? $b->field->name : '-',
                    $ts ? Carbon::parse($ts->date)->format('Y-m-d') : '-',
                    $ts ? Carbon::parse($ts->start_time)->format('H:i') . ' - ' . Carbon::parse($ts->end_time)->format('H:i') : '-',
                    $dur,
                    $b->total_price,
                    $b->status
                ];

                fputcsv($file, $row, ';');
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
