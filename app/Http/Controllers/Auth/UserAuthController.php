<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;


class UserAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.user-login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'nisn' => 'required|numeric',
            'password' => 'required'
        ]);

        if (Auth::guard('user')->attempt($credentials)) {
            $request->session()->regenerate(); 
            return redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'nisn' => 'NISN atau password salah.',
        ])->withInput($request->except('password'));
    }
    public function logout(Request $request)
    {
        Auth::guard('user')->logout();

        return redirect('/login');
    }
}