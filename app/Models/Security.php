<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Security extends Model
{
    use HasFactory;
    protected $table = 'tbl_data_security';
    protected $primaryKey = 'id';
    protected $guarded = [];
}
