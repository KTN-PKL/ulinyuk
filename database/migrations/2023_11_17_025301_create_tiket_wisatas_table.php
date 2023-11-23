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
        Schema::create('tiket_wisatas', function (Blueprint $table) {
            $table->id('id_tiket_wisata');
            $table->bigInteger('id_user');
            $table->bigInteger('id_pemesanan');
            $table->bigInteger('id_paket');
            $table->string('kode_tiket')->unique();
            $table->string('status_tiket_wisata');
            $table->string('qr');
            $table->string('jenis_tiket');
            $table->string('was_reschedule')->default('0');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tiket_wisatas');
    }
};
