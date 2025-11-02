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
        Schema::create('create_hunting_bookings', function (Blueprint $table) {
            $table->id();
            $table->string('tour_name');
            $table->string('hunter_name');
            $table->foreignId('guide_id')->constrained('guides')->cascadeOnDelete();
            $table->date('date');
            $table->unsignedTinyInteger('participants_count');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('create_hunting_bookings');
    }
};
