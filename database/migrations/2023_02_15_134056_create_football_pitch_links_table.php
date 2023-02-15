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
        Schema::create('football_pitch_links', function (Blueprint $table) {
            $table->id();
            $table->foreignId('from_football_pitch_id')->constrained('football_pitches');
            $table->foreignId('to_football_pitch_id')->constrained('football_pitches');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('football_pitch_links');
    }
};
