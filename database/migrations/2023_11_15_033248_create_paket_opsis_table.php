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
        Schema::create('paket_opsis', function (Blueprint $table) {
            $table->id('id_paket_opsi');
            $table->string('id_paket');
            $table->string('mulai_dari');
            $table->string('hingga_sampai');
            $table->string('harga_opsi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paket_opsis');
    }
};
