<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\MTShift;
use Illuminate\Http\Request;

class MasterShiftController extends Controller
{
    public function data_master_shift(){
        $mtShift = MTShift::all();
        return response()->json($mtShift);
    }
}
