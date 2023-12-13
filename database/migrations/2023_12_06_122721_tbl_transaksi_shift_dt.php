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
        Schema::create('tbl_transaksi_shift_dt', function(Blueprint $table){
            $table->id();
            $table->integer('idTransaksiHD');
            $table->string('employeeID');
            $table->string('kode_lokasi');
            $table->string('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_transaksi_shift_dt');
    }
};
