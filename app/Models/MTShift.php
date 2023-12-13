<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MTShift extends Model
{
    use HasFactory;

    protected $table = 'tbl_mt_shift';
    protected $primaryKey = 'id';
    protected $fillable = [
        'kode_shift',
        'nama_shift',
        'jam_masuk',
        'jam_pulang',
    ];
}
