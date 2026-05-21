<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\GameMatch;
use App\Models\MatchParticipant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

require_once base_path('vendor/midtrans/midtrans-php/Midtrans.php');

use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Notification;

class PaymentController extends Controller
{
    public function __construct()
    {
        Config::$serverKey    = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized  = config('midtrans.is_sanitized');
        Config::$is3ds        = config('midtrans.is_3ds');
    }

    /**
     * POST /payment/match — buat Snap token
     * - is_creator=true  → bayar FULL harga lapangan
     * - is_creator=false → bayar price_per_person
     */
    public function createMatchPayment(Request $request)
    {
        $request->validate([
            'match_id'   => ['required', 'exists:matches,id'],
            'is_creator' => ['nullable', 'boolean'],
        ]);

        $match     = GameMatch::with(['booking', 'booking.field', 'booking.field.venue'])->findOrFail($request->match_id);
        $user      = Auth::user();
        $isCreator = $request->boolean('is_creator', false);
        $orderId   = 'MATCH-' . $match->id . '-' . $user->id . '-' . time();

        // Tentukan jumlah bayar
        if ($isCreator) {
            // Pembuat bayar full harga lapangan
            $amount      = $match->booking->field->price_per_hour ?? 0;
            $itemName    = 'Booking Lapangan - ' . ($match->booking->field->name ?? '');
            $itemDesc    = 'Pembayaran penuh untuk booking lapangan';
        } else {
            // Joiner bayar per orang
            $amount      = $match->price_per_person ?? 0;
            $itemName    = $match->title ?? 'Public Match';
            $itemDesc    = 'Biaya patungan (' . $match->total_players . ' orang)';
        }

        if ($amount <= 0) {
            return response()->json(['error' => 'Tidak perlu pembayaran'], 400);
        }

        $params = [
            'transaction_details' => [
                'order_id'     => $orderId,
                'gross_amount' => $amount,
            ],
            'customer_details' => [
                'first_name' => $user->name,
                'email'      => $user->email,
                'phone'      => $user->phone ?? '',
            ],
            'item_details' => [
                [
                    'id'       => 'MATCH-' . $match->id,
                    'price'    => $amount,
                    'quantity' => 1,
                    'name'     => $itemName,
                ],
            ],
        ];

        try {
            $snapToken = Snap::getSnapToken($params);

            return response()->json([
                'snap_token' => $snapToken,
                'order_id'   => $orderId,
                'amount'     => $amount,
                'is_creator' => $isCreator,
            ]);
        } catch (\Exception $e) {
            Log::error('Midtrans Snap Error: ' . $e->getMessage());

            return response()->json(['error' => 'Gagal membuat token pembayaran'], 500);
        }
    }

    /**
     * POST /payment/match/finish — redirect setelah pembayaran sukses
     */
    public function matchFinish(Request $request)
    {
        $orderId = $request->order_id;
        $matchId = $request->match_id;

        if ($matchId) {
            $match = GameMatch::findOrFail($matchId);

            $exists = MatchParticipant::where('match_id', $match->id)
                ->where('user_id', Auth::id())
                ->exists();

            if (!$exists) {
                MatchParticipant::create([
                    'match_id'       => $match->id,
                    'user_id'        => Auth::id(),
                    'payment_status' => 'confirmed',
                ]);
            }

            return redirect()->route('matches.show', $match->id)
                ->with('success', 'Pembayaran berhasil! Kamu sudah bergabung di match ini.');
        }

        return redirect()->route('matches.index')->with('success', 'Pembayaran berhasil!');
    }

    /**
     * POST /payment/notification — callback dari Midtrans
     */
    public function notification(Request $request)
    {
        try {
            $notif = new Notification();

            $orderId     = $notif->order_id;
            $transaction = $notif->transaction_status;
            $fraudStatus = $notif->fraud_status;

            Log::info('Midtrans Notification', [
                'order_id'           => $orderId,
                'transaction_status' => $transaction,
                'fraud_status'      => $fraudStatus,
            ]);

            if ($transaction == 'capture' || $transaction == 'settlement') {
                if ($fraudStatus == 'accept' || $transaction == 'settlement') {
                    $this->handleSuccessPayment($orderId);
                }
            } elseif ($transaction == 'pending') {
                $this->handlePendingPayment($orderId);
            } elseif ($transaction == 'deny' || $transaction == 'cancel' || $transaction == 'expire') {
                $this->handleFailedPayment($orderId);
            }

            return response()->json(['status' => 'ok']);
        } catch (\Exception $e) {
            Log::error('Midtrans Notification Error: ' . $e->getMessage());

            return response()->json(['status' => 'error'], 500);
        }
    }

    /**
     * POST /payment/match/join — join match tanpa bayar (jika price_per_person = 0)
     */
    public function joinMatch(Request $request)
    {
        $request->validate([
            'match_id' => ['required', 'exists:matches,id'],
        ]);

        $match = GameMatch::findOrFail($request->match_id);
        $user  = Auth::user();

        $exists = MatchParticipant::where('match_id', $match->id)
            ->where('user_id', $user->id)
            ->exists();

        if ($exists) {
            return response()->json(['error' => 'Kamu sudah bergabung di match ini'], 400);
        }

        MatchParticipant::create([
            'match_id'       => $match->id,
            'user_id'        => $user->id,
            'payment_status' => ($match->price_per_person > 0) ? 'pending' : 'confirmed',
        ]);

        return response()->json(['success' => 'Berhasil bergabung!']);
    }

    private function handleSuccessPayment(string $orderId)
    {
        // Handle MATCH-{matchId}-{userId}-{time}
        if (preg_match('/^MATCH-(\d+)-(\d+)-/', $orderId, $matches)) {
            $matchId = $matches[1];
            $userId  = $matches[2];

            MatchParticipant::updateOrCreate(
                ['match_id' => $matchId, 'user_id' => $userId],
                ['payment_status' => 'confirmed']
            );
        }

        // Handle BOOKING-{bookingId}-{time}
        if (preg_match('/^BOOKING-(\d+)-/', $orderId, $matches)) {
            $bookingId = $matches[1];
            \App\Models\Booking::where('id', $bookingId)
                ->update(['status' => 'confirmed']);
        }
    }

    private function handlePendingPayment(string $orderId)
    {
        if (preg_match('/^MATCH-(\d+)-(\d+)-/', $orderId, $matches)) {
            $matchId = $matches[1];
            $userId  = $matches[2];

            MatchParticipant::updateOrCreate(
                ['match_id' => $matchId, 'user_id' => $userId],
                ['payment_status' => 'pending']
            );
        }

        // Handle BOOKING-{bookingId}-{time} — tetap pending
        if (preg_match('/^BOOKING-(\d+)-/', $orderId, $matches)) {
            $bookingId = $matches[1];
            \App\Models\Booking::where('id', $bookingId)
                ->update(['status' => 'pending']);
        }
    }

    private function handleFailedPayment(string $orderId)
    {
        if (preg_match('/^MATCH-(\d+)-(\d+)-/', $orderId, $matches)) {
            $matchId = $matches[1];
            $userId  = $matches[2];

            MatchParticipant::where('match_id', $matchId)
                ->where('user_id', $userId)
                ->update(['payment_status' => 'rejected']);
        }

        // Handle BOOKING-{bookingId}-{time} — batalkan booking
        if (preg_match('/^BOOKING-(\d+)-/', $orderId, $matches)) {
            $bookingId = $matches[1];
            \App\Models\Booking::where('id', $bookingId)
                ->update(['status' => 'cancelled']);
        }
    }
}
