<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Field;
use App\Models\TimeSlot;
use Illuminate\Support\Carbon;

class FieldSeeder extends Seeder
{
    public function run(): void
    {
        // =============================
        // POLINEMA (venue_id = 9, owner_id = 3)
        // =============================

        // Lapangan yang sudah ada: 22 (Futsal), 23 (Basket), 24 (Futsal)

        // Tambah lapangan baru di Polinema
        $poliBadminton = Field::create([
            'venue_id'       => 9,
            'name'           => 'Lapangan D - Badminton',
            'sport_type'     => 'Badminton',
            'price_per_hour' => 60000,
            'capacity'       => 4,
            'is_indoor'      => 1,
        ]);

        $poliVoli = Field::create([
            'venue_id'       => 9,
            'name'           => 'Lapangan E - Voli',
            'sport_type'     => 'Voli',
            'price_per_hour' => 80000,
            'capacity'       => 12,
            'is_indoor'      => 0,
        ]);

        $poliTennis = Field::create([
            'venue_id'       => 9,
            'name'           => 'Lapangan F - Tenis',
            'sport_type'     => 'Tenis',
            'price_per_hour' => 100000,
            'capacity'       => 4,
            'is_indoor'      => 0,
        ]);

        // =============================
        // ZONA SM (venue_id = 13, owner_id = 10)
        // =============================

        // Lapangan yang sudah ada: 31 (Futsal), 32 (Basket), 33 (Futsal)

        $zonaBadminton = Field::create([
            'venue_id'       => 13,
            'name'           => 'Lapangan D - Badminton',
            'sport_type'     => 'Badminton',
            'price_per_hour' => 55000,
            'capacity'       => 4,
            'is_indoor'      => 1,
        ]);

        $zonaMiniSoccer = Field::create([
            'venue_id'       => 13,
            'name'           => 'Lapangan E - Mini Soccer',
            'sport_type'     => 'Mini Soccer',
            'price_per_hour' => 200000,
            'capacity'       => 14,
            'is_indoor'      => 0,
        ]);

        $zonaFutsal3 = Field::create([
            'venue_id'       => 13,
            'name'           => 'Lapangan F - Futsal VIP',
            'sport_type'     => 'Futsal',
            'price_per_hour' => 180000,
            'capacity'       => 12,
            'is_indoor'      => 1,
        ]);

        // =============================
        // TIME SLOTS - Generate 7 hari ke depan
        // =============================

        $newFields = [$poliBadminton, $poliVoli, $poliTennis, $zonaBadminton, $zonaMiniSoccer, $zonaFutsal3];
        $timeRanges = [
            ['07:00', '09:00'],
            ['09:00', '11:00'],
            ['11:00', '13:00'],
            ['13:00', '15:00'],
            ['15:00', '17:00'],
            ['17:00', '19:00'],
            ['19:00', '21:00'],
        ];

        $today = Carbon::today();

        foreach ($newFields as $field) {
            for ($day = 0; $day < 7; $day++) {
                $date = $today->copy()->addDays($day)->format('Y-m-d');

                foreach ($timeRanges as $range) {
                    TimeSlot::create([
                        'field_id'   => $field->id,
                        'date'       => $date,
                        'start_time' => $range[0],
                        'end_time'   => $range[1],
                    ]);
                }
            }
        }

        // Time slots untuk lapangan lama yang belum punya hari ini
        $existingFieldIds = [22, 23, 24, 31, 32, 33];
        foreach ($existingFieldIds as $fid) {
            for ($day = 0; $day < 7; $day++) {
                $date = $today->copy()->addDays($day)->format('Y-m-d');

                $exists = TimeSlot::where('field_id', $fid)->where('date', $date)->exists();
                if (!$exists) {
                    foreach ($timeRanges as $range) {
                        TimeSlot::create([
                            'field_id'   => $fid,
                            'date'       => $date,
                            'start_time' => $range[0],
                            'end_time'   => $range[1],
                        ]);
                    }
                }
            }
        }
    }
}
