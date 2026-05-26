<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Venue;
use App\Models\Field;
use App\Models\TimeSlot;
use App\Models\Booking;
use App\Models\GameMatch;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class GameMatchSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Pastikan user default ada
        $user = User::firstOrCreate(
            ['email' => 'user@activehub.com'],
            [
                'name' => 'ActiveHub User',
                'password' => Hash::make('password'),
                'role' => 'user',
                'phone' => '08123456789',
                'gender' => 'male',
            ]
        );

        $creator = User::firstOrCreate(
            ['email' => 'creator@activehub.com'],
            [
                'name' => 'Match Creator',
                'password' => Hash::make('password'),
                'role' => 'user',
                'phone' => '08123456780',
                'gender' => 'male',
            ]
        );

        // Cari atau buat venue utama
        $venue = Venue::firstOrCreate(
            ['name' => 'Venue Public Match Test'],
            [
                'owner_id' => $creator->id,
                'description' => 'Test Venue',
                'location' => 'Jl. Test No 1',
                'latitude' => '-6.200000',
                'longitude' => '106.816666',
                'open_time' => '08:00:00',
                'close_time' => '22:00:00',
            ]
        );

        // Cari atau buat field utama
        $field = Field::firstOrCreate(
            ['venue_id' => $venue->id, 'name' => 'Lapangan 1 Test'],
            [
                'sport_type' => 'Futsal',
                'is_indoor' => 1,
                'price_per_hour' => 150000,
                'capacity' => 10,
            ]
        );

        // Buat timeslot besok untuk match default
        $timeSlot = TimeSlot::firstOrCreate(
            [
                'field_id' => $field->id, 
                'date' => Carbon::tomorrow()->format('Y-m-d'),
                'start_time' => '19:00:00',
                'end_time' => '20:00:00'
            ]
        );

        // Hapus match dan booking terkait timeslot ini jika ada
        DB::table('bookings')->where('time_slot_id', $timeSlot->id)->delete();

        // Buat Booking oleh creator
        $booking = Booking::create([
            'user_id' => $creator->id,
            'field_id' => $field->id,
            'time_slot_id' => $timeSlot->id,
            'total_price' => $field->price_per_hour,
            'status' => 'confirmed',
            'is_public_match' => 1,
        ]);

        // Buat GameMatch (Public Match) default
        $match = GameMatch::create([
            'booking_id' => $booking->id,
            'creator_id' => $creator->id,
            'title' => 'Main Futsal Santai Besok',
            'description' => 'Ayo join main santai bareng!',
            'total_players' => 10,
            'price_per_person' => 15000,
            'gender_preference' => 'mixed',
            'status' => 'open',
        ]);
        
        DB::table('match_participants')->updateOrInsert(
            ['match_id' => $match->id, 'user_id' => $creator->id],
            ['payment_status' => 'confirmed', 'created_at' => now()]
        );


        // ==========================================
        // 2. SEED 5 PUBLIC MATCH BARU LAINNYA
        // ==========================================

        // Ambil User yang sudah dibuat di UserSeeder
        $userDewi = User::where('email', 'dewilestari@gmail.com')->first() ?: User::create([
            'name' => 'Dewi Lestari', 'email' => 'dewilestari@gmail.com', 'password' => Hash::make('password'), 'role' => 'user', 'gender' => 'female', 'phone' => '085712345678'
        ]);

        $userBudi = User::where('email', 'budisantoso@gmail.com')->first() ?: User::create([
            'name' => 'Budi Santoso', 'email' => 'budisantoso@gmail.com', 'password' => Hash::make('password'), 'role' => 'user', 'gender' => 'male', 'phone' => '081398765432'
        ]);

        $userRizky = User::where('email', 'rizkypratama@gmail.com')->first() ?: User::create([
            'name' => 'Rizky Pratama', 'email' => 'rizkypratama@gmail.com', 'password' => Hash::make('password'), 'role' => 'user', 'gender' => 'male', 'phone' => '081287654321'
        ]);

        $userSiti = User::where('email', 'sitiaminah@gmail.com')->first() ?: User::create([
            'name' => 'Siti Aminah', 'email' => 'sitiaminah@gmail.com', 'password' => Hash::make('password'), 'role' => 'user', 'gender' => 'female', 'phone' => '089611223344'
        ]);

        $userHendra = User::where('email', 'hendrawijaya@gmail.com')->first() ?: User::create([
            'name' => 'Hendra Wijaya', 'email' => 'hendrawijaya@gmail.com', 'password' => Hash::make('password'), 'role' => 'user', 'gender' => 'male', 'phone' => '081122334455'
        ]);

        // Daftar Match Baru yang akan dibuat
        $extraMatches = [
            [
                'creator' => $userDewi,
                'sport_type' => 'Badminton',
                'title' => 'Main Badminton Ganda Campuran',
                'description' => 'Cari partner ganda campuran buat main santai besok pagi. Siapa saja boleh gabung, level pemula/intermediate welcome!',
                'total_players' => 4,
                'price_per_person' => 15000,
                'gender_preference' => 'mixed',
                'time' => '09:00:00',
                'end_time' => '11:00:00',
                'date_offset' => 1 // besok
            ],
            [
                'creator' => $userBudi,
                'sport_type' => 'Basket',
                'title' => 'Basket 3on3 Sore Hari',
                'description' => 'Main santai 3on3 di sore hari. Lapangan outdoor bersih dan nyaman. Kurang 3 orang lagi!',
                'total_players' => 6,
                'price_per_person' => 20000,
                'gender_preference' => 'male',
                'time' => '16:00:00',
                'end_time' => '18:00:00',
                'date_offset' => 2 // lusa
            ],
            [
                'creator' => $userRizky,
                'sport_type' => 'Futsal',
                'title' => 'Futsal Fun Match Malam',
                'description' => 'Ayo gabung main futsal fun match. Lapangan interlock indoor premium, patungan murah meriah saja.',
                'total_players' => 10,
                'price_per_person' => 25000,
                'gender_preference' => 'male',
                'time' => '20:00:00',
                'end_time' => '22:00:00',
                'date_offset' => 1 // besok
            ],
            [
                'creator' => $userSiti,
                'sport_type' => 'Voli',
                'title' => 'Voli Fun Santai Pemula',
                'description' => 'Main voli bareng sore hari untuk cari keringat dan teman baru. Tidak memandang skill, yang penting seru!',
                'total_players' => 12,
                'price_per_person' => 10000,
                'gender_preference' => 'mixed',
                'time' => '15:00:00',
                'end_time' => '17:00:00',
                'date_offset' => 3 // 3 hari lagi
            ],
            [
                'creator' => $userHendra,
                'sport_type' => 'Mini Soccer',
                'title' => 'Mini Soccer Weekend Friendly',
                'description' => 'Main santai mini soccer akhir pekan ini. Lapangan rumput sintetis standar FIFA. Wajib bawa jersey cadangan.',
                'total_players' => 14,
                'price_per_person' => 35000,
                'gender_preference' => 'mixed',
                'time' => '16:00:00',
                'end_time' => '18:00:00',
                'date_offset' => 4 // 4 hari lagi
            ],
        ];

        foreach ($extraMatches as $em) {
            // Cari field yang sesuai dengan sport_type
            $fieldItem = Field::where('sport_type', $em['sport_type'])->first();

            // Jika tidak ada, buat field baru pada venue public match test
            if (!$fieldItem) {
                $fieldItem = Field::create([
                    'venue_id' => $venue->id,
                    'name' => 'Lapangan ' . $em['sport_type'] . ' Test',
                    'sport_type' => $em['sport_type'],
                    'is_indoor' => 1,
                    'price_per_hour' => 120000,
                    'capacity' => $em['total_players'],
                ]);
            }

            $dateStr = Carbon::today()->addDays($em['date_offset'])->format('Y-m-d');

            // Cari atau buat timeslot
            $slotItem = TimeSlot::firstOrCreate([
                'field_id' => $fieldItem->id,
                'date' => $dateStr,
                'start_time' => $em['time'],
                'end_time' => $em['end_time']
            ]);

            // Hapus booking/match lama di timeslot ini jika ada
            DB::table('bookings')->where('time_slot_id', $slotItem->id)->delete();

            // Buat Booking
            $book = Booking::create([
                'user_id' => $em['creator']->id,
                'field_id' => $fieldItem->id,
                'time_slot_id' => $slotItem->id,
                'total_price' => $fieldItem->price_per_hour * 2, // 2 jam
                'status' => 'confirmed',
                'is_public_match' => 1,
            ]);

            // Buat GameMatch
            $newMatch = GameMatch::create([
                'booking_id' => $book->id,
                'creator_id' => $em['creator']->id,
                'title' => $em['title'],
                'description' => $em['description'],
                'total_players' => $em['total_players'],
                'price_per_person' => $em['price_per_person'],
                'gender_preference' => $em['gender_preference'],
                'status' => 'open',
            ]);

            // Daftarkan creator ke match
            DB::table('match_participants')->updateOrInsert(
                ['match_id' => $newMatch->id, 'user_id' => $em['creator']->id],
                ['payment_status' => 'confirmed', 'created_at' => now()]
            );
        }
    }
}
