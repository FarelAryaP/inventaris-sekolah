<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    protected function redirectTo($request)
    {
        if (!$request->expectsJson()) {
            // CUSTOM LOGIC: Jika request ke admin area
            if ($request->is('admin') || $request->is('admin/*')) {
                return route('admin.login');
            }
            
            // Selain itu, redirect ke user login  
            return route('login');
        }
    }
}
