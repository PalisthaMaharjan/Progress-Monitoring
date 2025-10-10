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
        Schema::create('towers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->onDelete('cascade');
            $table->string('tower_name');
            $table->string('tower_type'); // Suspension, Angle, Terminal, etc.
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->integer('foundation_progress')->default(0); // 0-100
            $table->integer('tower_erection_progress')->default(0); // 0-100
            $table->integer('stringing_progress')->default(0); // 0-100
            $table->text('problems')->nullable(); // Issues/problems description
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('towers');
    }
};
