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
        Schema::create('jam_bukas', function (Blueprint $table) {
            $table->id('id_jam_buka');
            $table->bigInteger('id_wisata');
            $table->string('hari');
            $table->string('buka');
            $table->string('tutup')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jam_bukas');
    }
};
