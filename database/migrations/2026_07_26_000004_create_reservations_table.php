<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('guest_id')->constrained()->onDelete('cascade');
            $table->foreignId('room_id')->constrained()->onDelete('cascade');
            $table->enum('tipe_reservasi', ['Menginap', 'Transit'])->default('Menginap');
            $table->dateTime('check_in');
            $table->dateTime('check_out');
            $table->enum('status', ['Pending', 'Confirmed', 'Checked-in', 'Checked-out', 'Cancelled'])->default('Pending');
            $table->decimal('total_harga', 12, 2);
            $table->string('sumber_booking')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
