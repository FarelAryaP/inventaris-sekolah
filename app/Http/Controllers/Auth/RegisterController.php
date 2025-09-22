<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'nisn' => 'required|unique:users,nisn',
            'password' => 'required|min:8|confirmed', 
        ]);

        User::create([
            'nisn' => $request->nisn,
            'password' => Hash::make($request->password),
        ]);

        return redirect('/login')->with('success', 'Registrasi berhasil, silahkan login.');
    }
}
