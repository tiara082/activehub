<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{
    // halaman cart
    public function index()
{
    $cart = [
        [
            'id' => 1,
            'field_name' => 'Lapangan 1',
            'venue_name' => 'Samator Court',
            'date' => 'Senin, 13 Apr',
            'time' => '08:00 - 09:00',
            'type' => 'Indoor',
            'price' => 100000,
        ]
    ];

    // dummy agar layout tidak error
    $data = [
        'image' => 'images/sample.jpg',
        'location_name' => 'Malang',
        'description' => '-',
        'date' => '-',
        'time' => '-',
        'address' => '-',
        'slot_filled' => 0,
        'slot_total' => 0,
        'gender' => '-',
        'price' => 0,
        'bank_name' => '-',
        'account_number' => '-',
        'account_name' => '-',
        'id' => 1,
    ];

    return view('cart.index', compact('cart', 'data'));
}

    // tambah item ke cart
    public function add(Request $request)
    {
        $cart = session()->get('cart', []);

        $cart[] = [
            'id' => uniqid(),
            'field_name' => $request->field_name,
            'venue_name' => $request->venue_name,
            'date' => $request->date,
            'time' => $request->time,
            'price' => $request->price,
            'type' => $request->type,
        ];

        session()->put('cart', $cart);

        return response()->json([
            'success' => true,
            'count' => count($cart)
        ]);
    }

    // hapus cart
    public function remove($id)
    {
        $cart = session()->get('cart', []);

        $cart = array_filter($cart, function ($item) use ($id) {
            return $item['id'] !== $id;
        });

        session()->put('cart', $cart);

        return back();
    }
}