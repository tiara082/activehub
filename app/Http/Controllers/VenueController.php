<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Venue;
use App\Models\Field;
use App\Models\Booking;

class VenueController extends Controller
{

     public function index()
    {
        // Data dummy sesuai struktur DB
        $venues = [
            (object) [
                'id' => 1,
                'name' => 'POLINEMAJOSS',
                'location' => 'Malang, Jawa Timur',
                'description' => 'LoremIpsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
                'fields_count' => 3
            ],
            (object) [
                'id' => 2,
                'name' => 'LAPANGAN SM',
                'location' => 'SUDIMORO',
                'description' => 'LoremIpsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
                'fields_count' => 4
            ],

        ];

        return view('venue.index', compact('venues'));
    }

    public function show($id)
    {
        // Data dummy venue
        $venues = [
            1 => (object) [
                'id' => 1,
                'name' => 'POLINEMAJOSS',
                'location' => 'Malang, Jawa Timur',
                'description' => 'LoremIpsum dolor sit amet, consectetur adipiscing elit.',
                'latitude' => -7.250445,
                'longitude' => 112.768845,
                'fields' => [
                    (object) ['id' => 1, 'name' => 'Futsal A', 'sport_type' => 'Futsal', 'price_per_hour' => 100000, 'capacity' => 10, 'is_indoor' => true],
                    (object) ['id' => 2, 'name' => 'Futsal B', 'sport_type' => 'Futsal', 'price_per_hour' => 100000, 'capacity' => 10, 'is_indoor' => false],
                    (object) ['id' => 3, 'name' => 'Mini Soccer', 'sport_type' => 'Mini Soccer', 'price_per_hour' => 150000, 'capacity' => 14, 'is_indoor' => false],
                ]
            ],
            2 => (object) [
                'id' => 2,
                'name' => 'LAPANGAN SM',
                'location' => 'SUDIMORO',
                'description' => 'LoremIpsum dolor sit amet, consectetur adipiscing elit.',
                'latitude' => -7.260445,
                'longitude' => 112.778845,
                'fields' => [
                    (object) ['id' => 4, 'name' => 'Futsal Premium', 'sport_type' => 'Futsal', 'price_per_hour' => 200000, 'capacity' => 10, 'is_indoor' => true],
                    (object) ['id' => 5, 'name' => 'Futsal Utama', 'sport_type' => 'Futsal', 'price_per_hour' => 180000, 'capacity' => 10, 'is_indoor' => true],
                    (object) ['id' => 6, 'name' => 'Mini Soccer 1', 'sport_type' => 'Mini Soccer', 'price_per_hour' => 250000, 'capacity' => 14, 'is_indoor' => false],
                    (object) ['id' => 7, 'name' => 'Mini Soccer 2', 'sport_type' => 'Mini Soccer', 'price_per_hour' => 250000, 'capacity' => 14, 'is_indoor' => false],
                ]
            ],
        ];


        $venue=$venues[$id];

        return view('venues.show', compact('venue'));
    }

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