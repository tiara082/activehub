<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FieldSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('fields')->insert([

            [
                'venue_id' => 1,
                'name' => 'Active Arena',
                'sport_type' => 'Futsal',
                'price_per_hour' => 150000,
                'capacity' => 14,
                'is_indoor' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'venue_id' => 1,
                'name' => 'Champion Field',
                'sport_type' => 'Mini Soccer',
                'price_per_hour' => 250000,
                'capacity' => 18,
                'is_indoor' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],

        ]);
    }
}