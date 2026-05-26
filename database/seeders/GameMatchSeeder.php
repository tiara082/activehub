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
        // Pastikan user@activehub.com ada
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

        // Buat creator untuk match
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

        // Cari ata buat venue
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

        // Cari atau buat field
        $field = Field::firstOrCreate(
            ['venue_id' => $venue->id, 'name' => 'Lapangan 1 Test'],
            [
                'sport_type' => 'Futsal',
                'is_indoor' => 1,
                
                'price_per_hour' => 150000,
                'capacity' => 10,
            ]
        );

        // Buat timeslot besok
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

        // Buat GameMatch (Public Match)
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
        
        DB::table('match_participants')->insert([
            'match_id' => $match->id,
            'user_id' => $creator->id,
            'payment_status' => 'confirmed',
            'created_at' => now(),
            
        ]);
    }
}
