<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.user-login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'nisn' => 'required',
            'password' => 'required'
        ]);

        $user = User::where('nisn', $credentials['nisn'])->first();

        if ($user && Hash::check($credentials['password'], $user->password)) {
            Auth::guard('user')->login($user);
            return redirect()->intended('/user/dashboard');
        }

        return back()->withErrors([
            'nisn' => 'NISN atau password salah.',
        ]);
    }

    public function logout()
    {
        Auth::guard('user')->logout();
        return redirect('/login');
    }
}
