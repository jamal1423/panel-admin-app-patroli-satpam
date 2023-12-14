<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatScan extends Model
{
    use HasFactory;
    protected $table = 'tbl_riwayat_scan';
    protected $primaryKey = 'id';
    protected $fillable = [
        'tgl_scan',
        'kode_shift',
        'employeeID',
        'kode_lokasi',
        'distance',
        'status',
    ];
}
