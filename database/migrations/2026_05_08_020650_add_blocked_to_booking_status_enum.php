<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            // Because modifying ENUMs can be tricky in some Postgres setups,
            // we first drop the existing check constraint for this enum if we know the name
            // Or we can just use raw SQL to drop the constraint.
            // In Laravel 11, we can often just do:
            // $table->enum('status', ['pending', 'confirmed', 'completed', 'cancelled', 'blocked'])->default('pending')->change();
        });
        
        // Raw SQL is safer for PostgreSQL CHECK constraints on Enums
        // Laravel typically names it {table}_{column}_check
        \Illuminate\Support\Facades\DB::statement('ALTER TABLE bookings DROP CONSTRAINT IF EXISTS bookings_status_check');
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE bookings ADD CONSTRAINT bookings_status_check CHECK (status::text = ANY (ARRAY['pending'::character varying, 'confirmed'::character varying, 'completed'::character varying, 'cancelled'::character varying, 'blocked'::character varying]::text[]))");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        \Illuminate\Support\Facades\DB::statement('ALTER TABLE bookings DROP CONSTRAINT IF EXISTS bookings_status_check');
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE bookings ADD CONSTRAINT bookings_status_check CHECK (status::text = ANY (ARRAY['pending'::character varying, 'confirmed'::character varying, 'completed'::character varying, 'cancelled'::character varying]::text[]))");
    }
};
