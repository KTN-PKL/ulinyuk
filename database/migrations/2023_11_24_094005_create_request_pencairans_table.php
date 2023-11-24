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
        Schema::create('request_pencairans', function (Blueprint $table) {
            $table->id('id_request_pencariran');
            $table->bigInteger('id_mitra');
            $table->bigInteger('id_admin')->nullable();
            $table->string('status_pencairan');
            $table->string('nominal_awal');
            $table->string('nominal_akhir');
            $table->string('nominal_request');
            $table->string('bukti_pencairan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('request_pencairans');
    }
};
