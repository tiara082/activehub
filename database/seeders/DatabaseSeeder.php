<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // =========================
        // USER DUMMY
        // =========================
User::firstOrCreate(
    [
        'email' => 'user3@mail.com'
    ],

    [
        'name' => 'User 3',
        'password' => bcrypt('user1234'),
        'role' => 'user',
    ]
);

        // =========================
        // BOOKING SEEDER
        // =========================
        $this->call([
            BookingSeeder::class,
        ]);
    }
}