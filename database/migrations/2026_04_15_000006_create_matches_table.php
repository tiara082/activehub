<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('matches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained('bookings')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('creator_id')->constrained('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->integer('total_players')->nullable();
            $table->integer('price_per_person')->nullable();
            $table->enum('gender_preference', ['mixed', 'male', 'female'])->default('mixed');
            $table->enum('status', ['open', 'full', 'finished', 'cancelled'])->default('open');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('matches');
    }
};
