
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            if (!Schema::hasColumn('reviews', 'rating_clean')) {
                $table->integer('rating_clean')->nullable();
            }

            if (!Schema::hasColumn('reviews', 'rating_condition')) {
                $table->integer('rating_condition')->nullable();
            }

            if (!Schema::hasColumn('reviews', 'rating_comms')) {
                $table->integer('rating_comms')->nullable();
            }

            if (!Schema::hasColumn('reviews', 'updated_at')) {
                $table->timestamp('updated_at')->nullable();
            }
        });
    }

    public function down(): void
    {
        // Keep existing database data safe.
    }
};
