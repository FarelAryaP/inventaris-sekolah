<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserAuthController extends Controller
{
    public function showLoginForm()
    {
        // Menampilkan halaman login siswa (yang memuat komponen Vue loginuser.vue)
        return view('auth.user-login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'nisn' => 'required',
            'password' => 'required',
        ]);

        // Login menggunakan guard "user"
        if (Auth::guard('user')->attempt([
            'nisn' => $request->nisn,
            'password' => $request->password,
        ])) {
            // Jika login berhasil
            return response()->json([
                'success' => true,
                'redirect' => route('user.dashboard'),
            ]);
        }

        // Jika gagal
        return response()->json([
            'success' => false,
            'message' => 'NISN atau password salah',
        ], 401);
    }

    public function logout(Request $request)
    {
        Auth::guard('user')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
