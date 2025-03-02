<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // If user is not logged in
        if (!Auth::check())
        {
            return redirect()->route('login');
        }

        $userRole = Auth::user()->role;
        // Admin user
        if ($userRole == 1){
            return $next($request);
        }
        elseif ($userRole == 0){
            return redirect()->route('dashboard');
        }
    }
}
