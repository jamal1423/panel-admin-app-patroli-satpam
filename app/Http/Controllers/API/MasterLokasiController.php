<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Lokasi;
use Illuminate\Http\Request;

class MasterLokasiController extends Controller
{
    public function data_master_lokasi(){
        $mtLokasi = Lokasi::all();
        return response()->json($mtLokasi);
    }
}
