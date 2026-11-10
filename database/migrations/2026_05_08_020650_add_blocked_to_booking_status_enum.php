
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (DB::getDriverName() === 'mysql') {
            DB::statement("
                ALTER TABLE bookings
                MODIFY status ENUM(
                    'pending',
                    'confirmed',
                    'completed',
                    'cancelled',
                    'blocked'
                ) NOT NULL DEFAULT 'pending'
            ");
        } elseif (DB::getDriverName() === 'pgsql') {
            DB::statement('ALTER TABLE bookings DROP CONSTRAINT IF EXISTS bookings_status_check');

            DB::statement("
                ALTER TABLE bookings
                ADD CONSTRAINT bookings_status_check
                CHECK (status::text = ANY (
                    ARRAY['pending','confirmed','completed','cancelled','blocked']::text[]
                ))
            ");
        }
    }

    public function down(): void
    {
        if (DB::getDriverName() === 'mysql') {
            DB::statement("
                ALTER TABLE bookings
                MODIFY status ENUM(
                    'pending',
                    'confirmed',
                    'completed',
                    'cancelled'
                ) NOT NULL DEFAULT 'pending'
            ");
        } elseif (DB::getDriverName() === 'pgsql') {
            DB::statement('ALTER TABLE bookings DROP CONSTRAINT IF EXISTS bookings_status_check');

            DB::statement("
                ALTER TABLE bookings
                ADD CONSTRAINT bookings_status_check
                CHECK (status::text = ANY (
                    ARRAY['pending','confirmed','completed','cancelled']::text[]
                ))
            ");
        }
    }
};
