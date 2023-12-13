<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function halaman_dashboard(){
        return view('admin.pages.dashboard');
    }

    public function get_data_dashboard(){
        $dataUser = User::where('username','=', auth()->user()->username)->first();
        $totalUser = User::count();
        
        return response()->json([
            'dataUser' => $dataUser,
            'totalUser' => $totalUser
        ]);
    }
}
