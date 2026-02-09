<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('notes', function (Blueprint $table) {
            // Drop foreign key if it exists
            try {
                $table->dropForeign(['user_id']);
            } catch (\Exception $e) {
                // Ignore if it doesn't exist
            }

            if (Schema::hasColumn('notes', 'user_id')) {
                $table->dropColumn('user_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('notes', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable();
        });
    }
};
