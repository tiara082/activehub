<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('venues', function (Blueprint $table) {
            $table->string('sport_type')->nullable()->after('name');
            $table->string('city')->nullable()->after('location');
            $table->string('photo_url')->nullable()->after('description');
            $table->integer('price_per_hour')->default(0)->after('photo_url');
        });
    }

    public function down(): void
    {
        Schema::table('venues', function (Blueprint $table) {
            $table->dropColumn(['sport_type', 'city', 'photo_url', 'price_per_hour']);
        });
    }
};