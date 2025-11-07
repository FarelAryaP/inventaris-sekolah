<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.admin-login');
    }

    public function login(Request $request)
{
    $credentials = $request->only('username', 'password');
    if (Auth::guard('admin')->attempt($credentials)) {
        return response()->json([
            'success' => true,
            'redirect' => route('admin.dashboard')
        ]);
    }
    return response()->json([
        'success' => false,
        'message' => 'Username atau password salah.'
    ], 401);
}
    
    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect('/admin/login');
    }
}