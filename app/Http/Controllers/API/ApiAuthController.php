<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiAuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'employeeID'=>'required',
            'password'=>'required'
        ]);

        if(Auth::attempt($credentials)){
            if (Auth::check()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Login Successfully',
                ]);
            }else{
                return response()->json([
                'success' => false,
                'message' => 'Invalid to Login, Please try again!',
                ], 401);
            }
        } else{
            $message = 'Invalid to Login, Please try again!';
            return response()->json($message, 401);
        }
    }
}
