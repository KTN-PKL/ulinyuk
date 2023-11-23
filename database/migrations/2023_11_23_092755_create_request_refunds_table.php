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
        Schema::create('request_refunds', function (Blueprint $table) {
            $table->id('id_request_refund');
            $table->bigInteger('id_tiket');
            $table->string('jenis_tiket');
            $table->string('nama_pemilik_rekening');
            $table->string('bank_tujuan');
            $table->string('no_rekening_tujuan');
            $table->string('whatsapp');
            $table->string('alasan');
            $table->string('bukti_refund')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('request_refunds');
    }
};
