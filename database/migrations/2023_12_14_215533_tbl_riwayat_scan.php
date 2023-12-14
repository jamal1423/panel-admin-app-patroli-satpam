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
        Schema::create('tbl_riwayat_can', function(Blueprint $table){
            $table->id();
            $table->dateTime('tgl_scan');
            $table->string('kode_shift');
            $table->string('employeeID');
            $table->string('kode_lokasi');
            $table->double('distance');
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_riwayat_can');
    }
};
