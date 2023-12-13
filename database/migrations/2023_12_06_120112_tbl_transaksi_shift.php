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
        Schema::create('tbl_transaksi_shift_hd', function(Blueprint $table){
            $table->id();
            $table->string('kode_shift');
            $table->dateTime('tgl_input_shift');
            $table->dateTime('masa_berlaku_awal');
            $table->dateTime('masa_berlaku_akhir');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_transaksi_shift_hd');
    }
};
