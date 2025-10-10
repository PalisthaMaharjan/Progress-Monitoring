<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update existing records that have "Address not specified" to empty string
        DB::table('towers')->where('address', 'Address not specified')->update(['address' => '']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert back to "Address not specified" if needed
        DB::table('towers')->where('address', '')->update(['address' => 'Address not specified']);
    }
};