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
        Schema::create('mitras', function (Blueprint $table) {
            $table->id('id_mitra');
            $table->string('id_user');
            $table->string('pj');
            $table->string('nama_rekening');
            $table->string('bank');
            $table->string('jenis');
            $table->string('rekening');
            $table->text('deskripsi_mitra');
            $table->string('balance')->default('0');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mitras');
    }
};
