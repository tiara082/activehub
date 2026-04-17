<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    /** GET /checkout/{booking} — halaman checkout */
    public function show($booking)
    {
        return view('checkout.show', compact('booking'));
    }

    /** POST /checkout/{booking}/pay — proses pembayaran */
    public function pay(Request $request, $booking)
    {
        $request->validate([
            'payment_method' => ['required', 'string'],
        ]);

        // TODO: proses payment

        return redirect()->route('home')->with('success', 'Pembayaran berhasil!');
    }
}
