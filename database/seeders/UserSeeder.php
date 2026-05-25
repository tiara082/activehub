<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ─── OWNERS ──────────────────────────────────────────────────────────
        $owners = [
            [
                'name' => 'Aulia Resty Azizah',
                'email' => 'auliaresty@gmail.com',
                'phone' => '081233445566',
                'password' => Hash::make('aulia123'),
                'role' => 'owner',
                'gender' => 'female',
            ],
            [
                'name' => 'Rangga Aditya',
                'email' => 'ranggaaditya@gmail.com',
                'phone' => '085677889900',
                'password' => Hash::make('rangga123'),
                'role' => 'owner',
                'gender' => 'male',
            ],
            [
                'name' => 'Nadhira Aurelia',
                'email' => 'nadhiraaurelia@gmail.com',
                'phone' => '081322334455',
                'password' => Hash::make('nadhira123'),
                'role' => 'owner',
                'gender' => 'female',
            ],
            [
                'name' => 'Dimas Anggara',
                'email' => 'dimasanggara@gmail.com',
                'phone' => '081299887766',
                'password' => Hash::make('dimas123'),
                'role' => 'owner',
                'gender' => 'male',
            ],
            [
                'name' => 'Kirana Larasati',
                'email' => 'kiranalarasati@gmail.com',
                'phone' => '089655443322',
                'password' => Hash::make('kirana123'),
                'role' => 'owner',
                'gender' => 'female',
            ],
            [
                'name' => 'Kevin Sanjaya',
                'email' => 'kevinsanjaya@gmail.com',
                'phone' => '081122334499',
                'password' => Hash::make('kevin123'),
                'role' => 'owner',
                'gender' => 'male',
            ],
            [
                'name' => 'Sarah Amalia',
                'email' => 'sarahamalia@gmail.com',
                'phone' => '085711223344',
                'password' => Hash::make('sarah123'),
                'role' => 'owner',
                'gender' => 'female',
            ],
            [
                'name' => 'Reza Rahadian',
                'email' => 'rezarahadian@gmail.com',
                'phone' => '087855661122',
                'password' => Hash::make('reza123'),
                'role' => 'owner',
                'gender' => 'male',
            ],
            [
                'name' => 'Tari Pratiwi',
                'email' => 'taripratiwi@gmail.com',
                'phone' => '081344556677',
                'password' => Hash::make('tari123'),
                'role' => 'owner',
                'gender' => 'female',
            ],
            [
                'name' => 'Gilang Dirga',
                'email' => 'gilangdirga@gmail.com',
                'phone' => '081266778899',
                'password' => Hash::make('gilang123'),
                'role' => 'owner',
                'gender' => 'male',
            ],
            [
                'name' => 'Maya Septiani',
                'email' => 'mayaseptiani@gmail.com',
                'phone' => '089511223344',
                'password' => Hash::make('maya123'),
                'role' => 'owner',
                'gender' => 'female',
            ],
            [
                'name' => 'Dika Pratama',
                'email' => 'dikapratama@gmail.com',
                'phone' => '085612345678',
                'password' => Hash::make('dika123'),
                'role' => 'owner',
                'gender' => 'male',
            ],
            [
                'name' => 'Siska Nirmala',
                'email' => 'siskanirmala@gmail.com',
                'phone' => '081234567890',
                'password' => Hash::make('siska123'),
                'role' => 'owner',
                'gender' => 'female',
            ],
            [
                'name' => 'Arya Bima',
                'email' => 'aryabima@gmail.com',
                'phone' => '081398765432',
                'password' => Hash::make('arya123'),
                'role' => 'owner',
                'gender' => 'male',
            ],
            [
                'name' => 'Tiara Andini',
                'email' => 'tiaraandini@gmail.com',
                'phone' => '087812349876',
                'password' => Hash::make('tiara123'),
                'role' => 'owner',
                'gender' => 'female',
            ],
        ];

        foreach ($owners as $ownerData) {
            User::updateOrCreate(
                ['email' => $ownerData['email']],
                $ownerData
            );
        }

        // ─── USERS / PLAYERS ──────────────────────────────────────────────────
        $users = [
            [
                'name' => 'Rizky Pratama',
                'email' => 'rizkypratama@gmail.com',
                'phone' => '081287654321',
                'password' => Hash::make('rizky123'),
                'role' => 'user',
                'gender' => 'male',
            ],
            [
                'name' => 'Dewi Lestari',
                'email' => 'dewilestari@gmail.com',
                'phone' => '085712345678',
                'password' => Hash::make('dewi123'),
                'role' => 'user',
                'gender' => 'female',
            ],
            [
                'name' => 'Budi Santoso',
                'email' => 'budisantoso@gmail.com',
                'phone' => '081398765432',
                'password' => Hash::make('budi123'),
                'role' => 'user',
                'gender' => 'male',
            ],
            [
                'name' => 'Siti Aminah',
                'email' => 'sitiaminah@gmail.com',
                'phone' => '089611223344',
                'password' => Hash::make('siti123'),
                'role' => 'user',
                'gender' => 'female',
            ],
            [
                'name' => 'Hendra Wijaya',
                'email' => 'hendrawijaya@gmail.com',
                'phone' => '081122334455',
                'password' => Hash::make('hendra123'),
                'role' => 'user',
                'gender' => 'male',
            ],
            [
                'name' => 'Putri Maharani',
                'email' => 'putrimaharani@gmail.com',
                'phone' => '085699887766',
                'password' => Hash::make('putri123'),
                'role' => 'user',
                'gender' => 'female',
            ],
            [
                'name' => 'Agus Setiawan',
                'email' => 'agussetiawan@gmail.com',
                'phone' => '081244556677',
                'password' => Hash::make('agus123'),
                'role' => 'user',
                'gender' => 'male',
            ],
            [
                'name' => 'Ayu Wandira',
                'email' => 'ayuwandira@gmail.com',
                'phone' => '087855667788',
                'password' => Hash::make('ayu123'),
                'role' => 'user',
                'gender' => 'female',
            ],
            [
                'name' => 'Fajar Nugroho',
                'email' => 'fajarnugroho@gmail.com',
                'phone' => '089533445566',
                'password' => Hash::make('fajar123'),
                'role' => 'user',
                'gender' => 'male',
            ],
            [
                'name' => 'Dian Ratnasari',
                'email' => 'dianratnasari@gmail.com',
                'phone' => '081377889900',
                'password' => Hash::make('dian123'),
                'role' => 'user',
                'gender' => 'female',
            ],
        ];

        foreach ($users as $userData) {
            User::updateOrCreate(
                ['email' => $userData['email']],
                $userData
            );
        }
    }
}
