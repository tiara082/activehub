<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Booking;
use Carbon\Carbon;

class BookingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // =========================
        // DATA BOOKING PER BULAN
        // =========================
        $monthsData = [

            ['month' => 1, 'count' => 3],
            ['month' => 2, 'count' => 5],
            ['month' => 3, 'count' => 4],
            ['month' => 4, 'count' => 8],
            ['month' => 5, 'count' => 6],
            ['month' => 6, 'count' => 10],

        ];

        // =========================
        // LOOPING SEEDER
        // =========================
        foreach ($monthsData as $data) {

            for ($i = 0; $i < $data['count']; $i++) {

                Booking::create([

                    // USER LOGIN
                    'user_id' => 3,

                    // SESUAIKAN DENGAN DATA DB KAMU
                    'field_id' => 1,
                    'time_slot_id' => 1,

                    // DATA BOOKING
                    'total_price' => rand(100000, 300000),

                    'status' => 'confirmed',

                    'is_public_match' => rand(0, 1),

                    // TANGGAL RANDOM PER BULAN
                    'created_at' => Carbon::create(
                        now()->year,
                        $data['month'],
                        rand(1, 28),
                        rand(8, 22),
                        0,
                        0
                    ),

                    'updated_at' => now(),

                ]);
            }
        }
    }
}