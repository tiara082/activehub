<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Venue;
use App\Models\PublicMatch;

class VenueSeeder extends Seeder
{
    public function run(): void
    {
        $v1 = Venue::create([
            'owner_id'       => 3,
            'name'           => 'Darmo Sports',
            'sport_type'     => 'Futsal',
            'location'       => 'Jl. Sawojajar No.1',
            'city'           => 'Malang',
            'price_per_hour' => 100000,
            'open_time'      => '08:00',
            'close_time'     => '22:00',
            'description'    => 'Lapangan futsal indoor berkualitas',
            'facilities'     => json_encode(['Parkir', 'Toilet', 'Kantin']),
        ]);

        $v2 = Venue::create([
            'owner_id'       => 3,
            'name'           => 'Galaxy Court',
            'sport_type'     => 'Badminton',
            'location'       => 'Jl. Merjosari No.5',
            'city'           => 'Malang',
            'price_per_hour' => 80000,
            'open_time'      => '07:00',
            'close_time'     => '21:00',
            'description'    => 'Lapangan badminton standar nasional',
            'facilities'     => json_encode(['Parkir', 'Toilet', 'Shower']),
        ]);

        PublicMatch::create([
            'venue_id'        => $v1->id,
            'title'           => 'Night Futsal',
            'sport_type'      => 'Futsal',
            'city'            => 'Malang',
            'scheduled_at'    => now()->addDays(3)->setTime(20, 0),
            'max_players'     => 12,
            'current_players' => 8,
        ]);

        PublicMatch::create([
            'venue_id'        => $v2->id,
            'title'           => 'Morning Badminton',
            'sport_type'      => 'Badminton',
            'city'            => 'Malang',
            'scheduled_at'    => now()->addDays(4)->setTime(8, 0),
            'max_players'     => 8,
            'current_players' => 5,
        ]);
    }
}