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
        Schema::table('towers', function (Blueprint $table) {
            $table->renameColumn('conductor_progress', 'stringing_progress');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('towers', function (Blueprint $table) {
            $table->renameColumn('stringing_progress', 'conductor_progress');
        });
    }
};
