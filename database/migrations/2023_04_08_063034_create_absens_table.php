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
        Schema::create('absens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->date('date_absensi');
            $table->time('time_in');
            $table->time('time_out')->nullable();
            $table->string('photo_in');
            $table->string('photo_out')->nullable();
            $table->string('location_in');
            $table->string('location_out')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('absens');
    }
};
