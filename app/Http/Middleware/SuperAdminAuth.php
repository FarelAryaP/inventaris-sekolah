<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class SuperAdminAuth
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('admin.login')
                           ->withErrors(['error' => 'Please login to access admin panel.']);
        }

        $admin = Auth::guard('admin')->user();
        if ($admin->id_role != 1) {
            return redirect()->route('admin.dashboard')
                           ->withErrors(['error' => 'Access Denied. Only Super Admin can access this feature.']);
        }

        return $next($request);
    }
}