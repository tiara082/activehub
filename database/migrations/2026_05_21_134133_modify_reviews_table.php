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
        Schema::table('reviews', function (Blueprint $table) {
            $table->renameColumn('rating', 'rating_main');
            
            $table->foreignId('booking_id')->nullable()->after('field_id')->constrained('bookings')->nullOnDelete();
            
            $table->integer('rating_clean')->nullable()->after('rating');
            $table->integer('rating_condition')->nullable()->after('rating_clean');
            $table->integer('rating_comms')->nullable()->after('rating_condition');
            
            $table->timestamp('updated_at')->nullable()->after('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            $table->renameColumn('rating_main', 'rating');
            
            $table->dropForeign(['booking_id']);
            $table->dropColumn(['booking_id', 'rating_clean', 'rating_condition', 'rating_comms', 'updated_at']);
        });
    }
};
