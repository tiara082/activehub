<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

require_once base_path('vendor/midtrans/midtrans-php/Midtrans.php');

use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\CoreApi;

class BookingPaymentController extends Controller
{
    public function __construct()
    {
        Config::$serverKey    = config('midtrans.server_key');
        Config::$clientKey    = config('midtrans.client_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized  = config('midtrans.is_sanitized');
        Config::$is3ds        = config('midtrans.is_3ds');
    }

    /**
     * GET /payment/{booking} — halaman checkout
     */
    public function show(Booking $booking)
    {
        $this->authorizeBooking($booking);

        $booking->load(['field.venue', 'timeSlot', 'user']);

        return view('booking.index', compact('booking'));
    }

    /**
     * POST /payment/{booking}/snap — buat Snap token (untuk VA, GoPay, dll)
     */
    public function createSnap(Booking $booking)
    {
        $this->authorizeBooking($booking);

        $booking->load(['field.venue', 'timeSlot', 'user']);

        $orderId = 'BOOKING-' . $booking->id . '-' . time();

        $params = [
            'transaction_details' => [
                'order_id'     => $orderId,
                'gross_amount' => (int) $booking->total_price,
            ],
            'customer_details' => [
                'first_name' => Auth::user()->name,
                'email'      => Auth::user()->email,
                'phone'      => Auth::user()->phone ?? '',
            ],
            'item_details' => [
                [
                    'id'       => 'BOOKING-' . $booking->id,
                    'price'    => (int) $booking->total_price,
                    'quantity' => 1,
                    'name'     => 'Booking ' . ($booking->field->name ?? 'Lapangan') . ' - ' . ($booking->field->venue->name ?? ''),
                ],
            ],
        ];

        try {
            $snapToken = Snap::getSnapToken($params);

            $booking->update([
                'snap_token'        => $snapToken,
                'midtrans_order_id' => $orderId,
            ]);

            return response()->json([
                'snap_token' => $snapToken,
                'order_id'   => $orderId,
                'client_key' => config('midtrans.client_key'),
            ]);
        } catch (\Exception $e) {
            Log::error('Midtrans Snap Error (Booking): ' . $e->getMessage());
            return response()->json(['error' => 'Gagal membuat token pembayaran: ' . $e->getMessage()], 500);
        }
    }

    /**
     * POST /payment/{booking}/qris — buat QRIS via Core API
     */
    public function createQris(Booking $booking)
    {
        $this->authorizeBooking($booking);

        $booking->load(['field.venue', 'timeSlot', 'user']);

        $orderId = 'BOOKING-' . $booking->id . '-' . time();

        $params = [
            'payment_type' => 'qris',
            'transaction_details' => [
                'order_id'     => $orderId,
                'gross_amount' => (int) $booking->total_price,
            ],
            'customer_details' => [
                'first_name' => Auth::user()->name,
                'email'      => Auth::user()->email,
            ],
            'item_details' => [
                [
                    'id'       => 'BOOKING-' . $booking->id,
                    'price'    => (int) $booking->total_price,
                    'quantity' => 1,
                    'name'     => 'Booking ' . ($booking->field->name ?? 'Lapangan') . ' - ' . ($booking->field->venue->name ?? ''),
                ],
            ],
            'qris' => [
                'acquirer' => 'gopay',
            ],
        ];

        try {
            $response = CoreApi::charge($params);

            $qrUrl = null;
            if (isset($response->actions)) {
                foreach ($response->actions as $action) {
                    if ($action->name === 'generate-qr-code') {
                        $qrUrl = $action->url;
                        break;
                    }
                }
            }

            $booking->update([
                'midtrans_order_id' => $orderId,
                'payment_method'    => 'qris',
            ]);

            return response()->json([
                'order_id'     => $orderId,
                'qr_url'       => $qrUrl,
                'total_price'  => $booking->total_price,
                'redirect_url' => route('payment.qr', $booking->id) . '?order_id=' . $orderId . '&qr_url=' . urlencode($qrUrl),
            ]);
        } catch (\Exception $e) {
            Log::error('Midtrans QRIS Error: ' . $e->getMessage());
            return response()->json(['error' => 'Gagal membuat QRIS: ' . $e->getMessage()], 500);
        }
    }

    /**
     * GET /payment/{booking}/qr — halaman tampil QR QRIS
     */
    public function qr(Booking $booking, Request $request)
    {
        $this->authorizeBooking($booking);

        $booking->load(['field.venue', 'timeSlot']);

        $orderId = $request->query('order_id', $booking->midtrans_order_id);
        $qrUrl   = $request->query('qr_url');

        return view('booking.qr', compact('booking', 'orderId', 'qrUrl'));
    }

    /**
     * GET /payment/{booking}/status — cek status pembayaran (polling dari frontend)
     */
    public function checkStatus(Booking $booking, Request $request)
    {
        $this->authorizeBooking($booking);

        $orderId = $request->query('order_id', $booking->midtrans_order_id);

        if (!$orderId) {
            return response()->json(['status' => 'unknown']);
        }

        try {
            $status = \Midtrans\Transaction::status($orderId);

            $txStatus = $status->transaction_status ?? 'pending';

            // Jika sukses → update booking
            if (in_array($txStatus, ['capture', 'settlement'])) {
                $booking->update(['status' => 'confirmed']);
                return response()->json([
                    'status'       => 'paid',
                    'redirect_url' => route('payment.success', $booking->id),
                ]);
            }

            if (in_array($txStatus, ['deny', 'cancel', 'expire'])) {
                return response()->json(['status' => 'failed']);
            }

            return response()->json(['status' => $txStatus]);
        } catch (\Exception $e) {
            Log::error('Midtrans Status Check Error: ' . $e->getMessage());
            return response()->json(['status' => 'pending']);
        }
    }

    /**
     * GET /payment/{booking}/success — halaman sukses
     */
    public function success(Booking $booking)
    {
        $this->authorizeBooking($booking);

        $booking->load(['field.venue', 'timeSlot']);

        // Pastikan booking memang sudah confirmed
        if (!in_array($booking->status, ['confirmed', 'completed'])) {
            $booking->update(['status' => 'confirmed']);
        }

        return view('booking.success', compact('booking'));
    }

    /**
     * Pastikan hanya pemilik booking yang bisa akses
     */
    private function authorizeBooking(Booking $booking)
    {
        if ($booking->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }
    }
}
