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
        Schema::create('tower_legs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tower_id')->constrained()->onDelete('cascade');
            $table->string('leg_name'); // A, B, C, D
            $table->string('kitta_no');
            $table->string('owner');
            $table->decimal('amount', 10, 2);
            $table->string('remarks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tower_legs');
    }
};
