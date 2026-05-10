<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TimeSlotSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('time_slots')->insert([

            [
                'field_id' => 1,
                'start_time' => '08:00',
                'end_time' => '10:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'field_id' => 1,
                'start_time' => '19:00',
                'end_time' => '21:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'field_id' => 2,
                'start_time' => '16:00',
                'end_time' => '18:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],

        ]);
    }
}