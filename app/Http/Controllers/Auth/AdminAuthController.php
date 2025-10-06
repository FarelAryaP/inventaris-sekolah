<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    /**
     * Tampilkan form login admin
     */
    public function showLoginForm()
    {
        return view('auth.admin-login');
    }

    /**
     * Proses login admin
     */
    public function login(Request $request)
    {
        // validasi input
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string'
        ]);

        // coba login pakai guard admin
        if (Auth::guard('admin')->attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            // kalo mau response json untuk Vue
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'redirect' => '/admin/dashboard'
                ]);
            }

            // kalo form biasa (blade)
            return redirect()->intended('/admin/dashboard');
        }

        // kalau gagal login
        if ($request->expectsJson()) {
            return response()->json([
                'success' => false,
                'message' => 'Username atau password salah.'
            ], 401);
        }

        return back()->withErrors([
            'username' => 'Username atau password salah.',
        ]);
    }

    /**
     * Proses logout admin
     */
    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/admin/login');
    }
}
