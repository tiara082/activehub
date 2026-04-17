<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fields', function (Blueprint $table) {
            $table->id();
            $table->foreignId('venue_id')->constrained('venues')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('name');
            $table->string('sport_type', 100)->nullable();
            $table->integer('price_per_hour');
            $table->integer('capacity')->nullable();
            $table->tinyInteger('is_indoor')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fields');
    }
};
