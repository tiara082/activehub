<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\TimeSlot;

class CalendarController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $venue = $user->venues()->with('fields')->first();

        // Default to current month/year if not provided
        $month = $request->get('month', date('m'));
        $year = $request->get('year', date('Y'));
        
        $date = Carbon::createFromDate($year, $month, 1);
        $daysInMonth = $date->daysInMonth;
        // Day of week: 0 (Sunday) to 6 (Saturday)
        $firstDayOfWeek = $date->dayOfWeek;

        // Selected date for slot details. Default to today if today is in this month, else 1st of month.
        $selectedDateStr = $request->get('date');
        if (!$selectedDateStr) {
            $selectedDateStr = (date('Y-m') === sprintf("%04d-%02d", $year, $month)) 
                               ? date('Y-m-d') 
                               : $date->format('Y-m-d');
        }
        $selectedDate = Carbon::parse($selectedDateStr);

        // Fetch all timeslots for the venue's fields in this month with bookings
        $fieldIds = $venue ? $venue->fields->pluck('id') : [];
        
        $timeSlotsThisMonth = TimeSlot::whereIn('field_id', $fieldIds)
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->with(['bookings' => function($q) {
                // we care about paid, confirmed, pending, or blocked bookings
                $q->whereIn('status', ['paid', 'confirmed', 'pending', 'blocked']);
            }])
            ->get();

        // Group timeslots by date to determine daily status
        // A day can be: empty, partial, or booked.
        $startHour = $venue && $venue->open_time ? (int) Carbon::parse($venue->open_time)->format('H') : 7;
        $endHour = $venue && $venue->close_time ? (int) Carbon::parse($venue->close_time)->format('H') : 22;
        $endHour = max($startHour + 1, $endHour);
        $hoursRange = range($startHour, $endHour - 1);
        
        $totalFields = count($fieldIds);
        $totalPossibleSlotsPerDay = $totalFields * count($hoursRange);

        $dailyStats = [];
        foreach ($timeSlotsThisMonth as $ts) {
            // ts->date is cast to Carbon
            $d = $ts->date->format('Y-m-d');
            if (!isset($dailyStats[$d])) {
                $dailyStats[$d] = ['booked_count' => 0];
            }
            // Check if there is an active booking
            $hasActiveBooking = $ts->bookings->whereIn('status', ['paid', 'confirmed', 'pending', 'blocked'])->count() > 0;
            if ($hasActiveBooking) {
                $dailyStats[$d]['booked_count']++;
            }
        }

        $days = [];
        // empty slots before 1st day
        for ($i = 0; $i < $firstDayOfWeek; $i++) {
            $days[] = ['n' => '', 'empty' => true, 'type' => '', 'date' => ''];
        }

        for ($i = 1; $i <= $daysInMonth; $i++) {
            $dStr = sprintf("%04d-%02d-%02d", $year, $month, $i);
            
            $type = '';
            if ($dStr === $selectedDateStr) {
                $type = 'today'; // Highlighted in UI
            } else {
                if (isset($dailyStats[$dStr]) && $dailyStats[$dStr]['booked_count'] > 0) {
                    if ($totalPossibleSlotsPerDay > 0 && $dailyStats[$dStr]['booked_count'] >= $totalPossibleSlotsPerDay) {
                        $type = 'booked';
                    } else {
                        $type = 'partial';
                    }
                }
            }

            $days[] = [
                'n' => $i,
                'empty' => false,
                'type' => $type,
                'date' => $dStr
            ];
        }

        // --- PREPARE SLOTS FOR SELECTED DATE ---
        $slots = [];
        $hours = $hoursRange;

        // Get slots just for the selected date
        $timeSlotsToday = $timeSlotsThisMonth->filter(function($ts) use ($selectedDateStr) {
            return $ts->date->format('Y-m-d') === $selectedDateStr;
        });

        foreach ($hours as $h) {
            $timeStr = sprintf("%02d:00", $h);
            $fullTimeStr = sprintf("%02d:00:00", $h);
            
            $row = [$timeStr]; // first col is time
            
            if ($venue) {
                foreach ($venue->fields as $field) {
                    // find if this field has a booking at this time
                    $ts = $timeSlotsToday->where('field_id', $field->id)
                                         ->first(function($item) use ($fullTimeStr, $timeStr) {
                                            // Handle potential variations in time formatting from DB
                                            return $item->start_time === $fullTimeStr || $item->start_time === $timeStr;
                                         });
                    
                    $status = 'free'; // default
                    
                    if ($ts && $ts->bookings->count() > 0) {
                        // find first valid booking
                        $activeBooking = $ts->bookings->whereIn('status', ['paid', 'confirmed', 'pending', 'blocked'])->first();
                        if ($activeBooking) {
                            if ($activeBooking->status === 'pending') {
                                $status = 'pending';
                            } elseif ($activeBooking->status === 'blocked') {
                                $status = 'blocked';
                            } else {
                                $status = 'booked';
                            }
                        }
                    }
                    
                    $row[] = $status;
                }
            }
            $slots[] = $row;
        }

        $isFullDayBlocked = false;
        if (isset($dailyStats[$selectedDateStr]) && $totalPossibleSlotsPerDay > 0 && $dailyStats[$selectedDateStr]['booked_count'] >= $totalPossibleSlotsPerDay) {
            $isFullDayBlocked = true;
        }

        return view('owner.calendar', compact('venue', 'days', 'slots', 'selectedDate', 'date', 'isFullDayBlocked', 'startHour', 'endHour'));
    }

    public function blockFullDay(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'field_id' => 'required'
        ]);

        $user = Auth::user();
        $venue = $user->venues()->with('fields')->first();
        if (!$venue) {
            return back()->with('error', 'Venue tidak ditemukan.');
        }

        $date = Carbon::parse($request->date)->format('Y-m-d');
        
        $startHour = $venue->open_time ? (int) Carbon::parse($venue->open_time)->format('H') : 7;
        $endHour = $venue->close_time ? (int) Carbon::parse($venue->close_time)->format('H') : 22;
        $endHour = max($startHour + 1, $endHour);
        $hours = range($startHour, $endHour - 1);

        $fieldsToBlock = $request->field_id === 'all' 
            ? $venue->fields 
            : $venue->fields->where('id', $request->field_id);

        if ($fieldsToBlock->isEmpty()) {
            return back()->with('error', 'Lapangan tidak valid.');
        }

        foreach ($fieldsToBlock as $field) {
            foreach ($hours as $h) {
                $startStr = sprintf("%02d:00:00", $h);
                $endStr = sprintf("%02d:00:00", $h + 1);

                $ts = TimeSlot::firstOrCreate([
                    'field_id' => $field->id,
                    'date' => $date,
                    'start_time' => $startStr,
                    'end_time' => $endStr,
                ]);

                $hasActiveBooking = $ts->bookings()->whereIn('status', ['paid', 'confirmed', 'pending', 'blocked'])->exists();
                if (!$hasActiveBooking) {
                    $ts->bookings()->create([
                        'user_id' => $user->id,
                        'field_id' => $field->id,
                        'total_price' => 0,
                        'status' => 'blocked',
                        'is_public_match' => 0,
                    ]);
                }
            }
        }

        return back()->with('success', 'Hari ' . date('d F Y', strtotime($date)) . ' berhasil diblokir.');
    }

    public function unblockFullDay(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'field_id' => 'required'
        ]);

        $user = Auth::user();
        $venue = $user->venues()->with('fields')->first();
        if (!$venue) {
            return back()->with('error', 'Venue tidak ditemukan.');
        }

        $date = Carbon::parse($request->date)->format('Y-m-d');
        
        $fieldsToUnblock = $request->field_id === 'all'
            ? $venue->fields->pluck('id')
            : collect([$request->field_id]);

        $timeSlots = TimeSlot::where('date', $date)
            ->whereIn('field_id', $fieldsToUnblock)
            ->with('bookings')->get();
        foreach ($timeSlots as $ts) {
            foreach ($ts->bookings as $booking) {
                if ($booking->user_id === $user->id) {
                    $booking->delete();
                }
            }
        }

        return back()->with('success', 'Blokir untuk hari ' . date('d F Y', strtotime($date)) . ' berhasil dibuka.');
    }

    public function storeOfflineBooking(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'field_id' => 'required|exists:fields,id',
            'start_time' => 'required',
            'end_time' => 'required',
        ]);

        $user = Auth::user();
        $venue = $user->venues()->with('fields')->first();
        if (!$venue) return back()->with('error', 'Venue tidak ditemukan.');

        $field = $venue->fields->where('id', $request->field_id)->first();
        if (!$field) {
            return back()->with('error', 'Lapangan tidak valid.');
        }

        $date = Carbon::parse($request->date)->format('Y-m-d');
        $startHour = (int) explode(':', $request->start_time)[0];
        $endHour = (int) explode(':', $request->end_time)[0];

        if ($startHour >= $endHour) {
            return back()->with('error', 'Jam selesai harus lebih besar dari jam mulai.');
        }

        // Validate availability for all selected hours first
        $requestedSlots = [];
        for ($h = $startHour; $h < $endHour; $h++) {
            $startStr = sprintf("%02d:00:00", $h);
            $endStr = sprintf("%02d:00:00", $h + 1);

            $ts = TimeSlot::firstOrCreate([
                'field_id' => $field->id,
                'date' => $date,
                'start_time' => $startStr,
                'end_time' => $endStr,
            ]);

            $hasActiveBooking = $ts->bookings()->whereIn('status', ['paid', 'confirmed', 'pending', 'blocked'])->exists();
            if ($hasActiveBooking) {
                return back()->with('error', "Gagal! Jam $startStr - $endStr sudah dipesan atau diblokir.");
            }
            $requestedSlots[] = $ts;
        }

        // If all requested slots are available, create the bookings
        foreach ($requestedSlots as $ts) {
            $ts->bookings()->create([
                'user_id' => $user->id,
                'field_id' => $field->id,
                'total_price' => $field->price_per_hour,
                'status' => 'confirmed',
                'is_public_match' => 0,
            ]);
        }

        return back()->with('success', 'Booking offline berhasil ditambahkan.');
    }
}
