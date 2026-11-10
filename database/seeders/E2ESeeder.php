<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Venue;
use App\Models\Field;
use App\Models\TimeSlot;
use Illuminate\Support\Facades\Hash;

class E2ESeeder extends Seeder
{
    public function run(): void
    {
        $owner = User::updateOrCreate(
            ['email' => 'e2e-owner@activehub.test'],
            [
                'name' => 'E2E Owner',
                'password' => Hash::make('owner123'),
                'role' => 'owner',
            ]
        );

        User::updateOrCreate(
            ['email' => 'e2e-user@activehub.test'],
            [
                'name' => 'E2E User',
                'password' => Hash::make('user123'),
                'role' => 'user',
            ]
        );

        $venue = Venue::firstOrCreate(
            ['name' => 'E2E Sports Center'],
            [
                'owner_id' => $owner->id,
                'sport_type' => 'Futsal',
                'location' => 'Malang',
                'city' => 'Malang',
                'price_per_hour' => 100000,
                'open_time' => '07:00',
                'close_time' => '22:00',
                'description' => 'Venue khusus pengujian E2E',
                'facilities' => ['Parkir', 'Toilet'],
            ]
        );

        $field = Field::firstOrCreate(
            [
                'venue_id' => $venue->id,
                'name' => 'E2E Futsal Field',
            ],
            [
                'sport_type' => 'Futsal',
                'price_per_hour' => 100000,
                'capacity' => 12,
                'is_indoor' => 1,
            ]
        );

        TimeSlot::firstOrCreate(
            [
                'field_id' => $field->id,
                'date' => now()->addDay()->toDateString(),
                'start_time' => '08:00',
            ],
            [
                'end_time' => '10:00',
            ]
        );
    }
}
