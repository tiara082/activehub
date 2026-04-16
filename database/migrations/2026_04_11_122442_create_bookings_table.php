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
Schema::create('bookings', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->cascadeOnDelete();
    $table->foreignId('field_id')->constrained()->cascadeOnDelete();
    $table->foreignId('slot_id')->constrained('time_slots')->cascadeOnDelete();
    $table->enum('booking_type', ['private','public']);
    $table->integer('total_price');
    $table->enum('status', ['pending','confirmed','completed','cancelled'])->default('pending');
    $table->timestamp('created_at')->useCurrent();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
