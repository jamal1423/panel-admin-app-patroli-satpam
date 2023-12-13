<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiShiftDT extends Model
{
    use HasFactory;
    protected $table = 'tbl_transaksi_shift_dt';
    protected $primaryKey = 'id';
    protected $fillable = [
        'idTransaksiHD',
        'employeeID',
        'kode_lokasi',
        'keterangan',
    ];
}
