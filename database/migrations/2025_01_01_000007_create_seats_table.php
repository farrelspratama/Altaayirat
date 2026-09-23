<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('seats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('plane_id')->constrained('planes')->cascadeOnDelete();
            $table->foreignId('class_id')->constrained('classes')->cascadeOnDelete();
            $table->string('seat_number', 5); // misal A01, B12
            $table->enum('status', ['tersedia', 'dipesan', 'tidak_tersedia'])->default('tersedia');
            $table->timestamps();

            // satu pesawat tidak boleh punya dua kursi dengan nomor sama
            $table->unique(['plane_id', 'seat_number']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('seats');
    }
};
