<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FieldController extends Controller
{
    /** GET /fields — daftar lapangan (public) */
    public function index(Request $request)
    {
        return view('fields.index');
    }

    /** GET /fields/{field} — detail lapangan (public) */
    public function show($field, $id)
    {
        return view('fields.show', compact('field'));
        $fields = [
            1 => (object) ['id' => 1, 'name' => 'Futsal A', 'venue_name' => 'POLINEMAJOSS', 'venue_id' => 1, 'sport_type' => 'Futsal', 'price_per_hour' => 100000, 'capacity' => 10, 'is_indoor' => true, 'description' => 'LOrem ipsum dolor sit amet.'],
            2 => (object) ['id' => 2, 'name' => 'Futsal B', 'venue_name' => 'POLINEMAJOSS', 'venue_id' => 1, 'sport_type' => 'Futsal', 'price_per_hour' => 100000, 'capacity' => 10, 'is_indoor' => false, 'description' => 'LOrem ipsum dolor sit amet'],
            3 => (object) ['id' => 3, 'name' => 'Mini Soccer', 'venue_name' => 'POLINEMAJOSS', 'venue_id' => 1, 'sport_type' => 'Mini Soccer', 'price_per_hour' => 150000, 'capacity' => 14, 'is_indoor' => false, 'description' => 'LOrem ipsum dolor sit amet.'],
            4 => (object) ['id' => 4, 'name' => 'Futsal Premium', 'venue_name' => 'LAPANGAN SM', 'venue_id' => 2, 'sport_type' => 'Futsal', 'price_per_hour' => 200000, 'capacity' => 10, 'is_indoor' => true, 'description' => 'LOrem ipsum dolor sit amet.'],
        ];


        return view('fields.show', compact('field'));
    }
}



