<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function adminLogin()
    {
        $title = 'Login';
        return view('admin.auth.login', [
            'title' => $title,
        ]);
    }

    public function processAdminLogin(Request $request)
    {
        $remember = false;
        if($request->has('remember')){
            $remember = true;
        }
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if(Auth::attempt($credentials, $remember)){
            $request->session()->regenerate();

            return to_route('admin.dashboard');
        }

        return back()->with([
            'message' => 'Email hoặc mật khẩu không đúng',
        ])->onlyInput('email');
    }

    public function processAdminLogout(Request $request)
    {
        if(Auth::check()){
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return to_route('admin.login');
        }
    }

    public function processClientLogout(Request $request)
    {
        if(Auth::check()){
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return to_route('client.index');
        }
    }

    public function clientLogin()
    {
        $title = 'Login';
        return view('client.auth.login', [
            'title' => $title,
        ]);
    }

    public function clientRegister() 
    {
        $title = 'Register';
        return view('client.auth.register', [
            'title' => $title,
        ]);
    }
}
