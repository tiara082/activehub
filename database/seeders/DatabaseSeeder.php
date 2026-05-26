<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // Pastikan user ada
        User::firstOrCreate(
            ['email' => 'user3@mail.com'],
            ['name' => 'User 3', 'password' => bcrypt('user1234'), 'role' => 'user']
        );

        $this->call([
            UserSeeder::class,
            FieldSeeder::class,
            BookingSeeder::class,
            GameMatchSeeder::class,
        ]);
    }
}

