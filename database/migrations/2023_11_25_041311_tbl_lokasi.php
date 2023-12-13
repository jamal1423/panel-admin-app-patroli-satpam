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
        Schema::create('tbl_lokasi', function (Blueprint $table){
            $table->id();
            $table->string('kode_lokasi')->unique();
            $table->string('nama_lokasi');
            $table->double('latitude');
            $table->double('longitude');
            $table->double('radius');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_lokasi');
    }
};
