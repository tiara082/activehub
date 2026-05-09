<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FieldController extends Controller
{
    /** GET /fields */
    public function index(Request $request)
    {
        return view('fields.index');
    }

    /** GET /fields/{id} */
    public function show($id)
    {
        $fields = [
            1 => (object) [
                'id' => 1,
                'name' => 'Futsal A',
                'venue_name' => 'POLINEMAJOSS',
                'venue_id' => 1,
                'sport_type' => 'Futsal',
                'price_per_hour' => 100000,
                'capacity' => 10,
                'is_indoor' => true,
                'description' => 'Lorem ipsum dolor sit amet.'
            ],

            2 => (object) [
                'id' => 2,
                'name' => 'Futsal B',
                'venue_name' => 'POLINEMAJOSS',
                'venue_id' => 1,
                'sport_type' => 'Futsal',
                'price_per_hour' => 100000,
                'capacity' => 10,
                'is_indoor' => false,
                'description' => 'Lorem ipsum dolor sit amet.'
            ],
        ];

        // ambil field berdasarkan id
        $field = $fields[$id] ?? null;

        // kalau tidak ada
        if (!$field) {
            abort(404);
        }

        return view('fields.show', compact('field'));
    }
}