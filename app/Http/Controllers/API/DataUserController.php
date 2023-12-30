<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class DataUserController extends Controller
{
    public function data_user($employeeID){
        $dataUser = User::where('employeeID','=',$employeeID)->first();
        return response()->json($dataUser);
    }
}
