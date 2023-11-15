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
        Schema::create('potongan_masifs', function (Blueprint $table) {
            $table->id('id_potongan_masif');
            $table->bigInteger('id_paket');
            $table->string('potongan');
            $table->string('jumlah_dari');
            $table->string('jumlah_sampai');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('potongan_masifs');
    }
};
