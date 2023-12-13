<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login_admin(){
        return view('admin.pages.login-admin');
    }

    public function authenticate_admin(Request $request){
        $credentials = $request->validate([
            'username'=>'required',
            'password'=>'required'
        ]);

        // dd($credentials);
        
        if (Auth::attempt($credentials)) {
            if (Auth::check()) {
                $request->session()->regenerate();
                return redirect()->intended('/dashboard');
            }else{
                return redirect()->intended('/login');
            }
        }

        return back()->with('loginError', 'Incorect data, please try again!');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
