<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Venue;
use App\Models\Field;
use App\Models\Booking;

class VenueController extends Controller
{
    public function store(Request $request)
    {
        // 1️⃣ Validasi
        $request->validate([
            'name' => 'required',
            'city' => 'required',
            'price' => 'required|numeric',
        ]);

        // 2️⃣ Simpan Venue
        $venue = Venue::create([
            'name' => $request->name,
            'location' => $request->city,
            'description' => 'Default description',
        ]);

        // 3️⃣ Buat Field otomatis (biar sesuai ERD)
        $field = Field::create([
            'venue_id' => $venue->id,
            'name' => 'Lapangan A',
            'sport_type' => 'Futsal',
            'price_per_hour' => $request->price,
            'capacity' => 10,
            'is_indoor' => true,
        ]);

        // 4️⃣ Buat Booking otomatis (SIMULASI)
        $booking = Booking::create([
            'user_id' => 1, // sementara (anggap login user id=1)
            'field_id' => $field->id,
            'time_slot_id' => 1, // dummy dulu
            'total_price' => $field->price_per_hour,
            'status' => 'pending',
            'is_public_match' => false,
        ]);

        // 5️⃣ Redirect ke checkout (pakai booking ID!)
        return redirect('/checkout/' . $booking->id);
    }
}