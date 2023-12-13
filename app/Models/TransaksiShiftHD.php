<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiShiftHD extends Model
{
    use HasFactory;
    protected $table = 'tbl_transaksi_shift_hd';
    protected $primaryKey = 'id';
    protected $fillable = [
        'kode_shift',
        'tgl_input_shift',
        'masa_berlaku_awal',
        'masa_berlaku_akhir',
    ];
}
