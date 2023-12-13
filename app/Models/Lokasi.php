<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lokasi extends Model
{
    use HasFactory;

    protected $table = 'tbl_lokasi';
    protected $primaryKey = 'id';
    protected $fillable = [
        'kode_lokasi',
        'nama_lokasi',
        'latitude',
        'longitude',
        'radius',
    ];
}
