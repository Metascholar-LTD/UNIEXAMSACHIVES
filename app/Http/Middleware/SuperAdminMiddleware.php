<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SuperAdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated
        if (!auth()->check()) {
            return redirect()->route('frontend.login')
                ->with('error', 'Please login to access this area.');
        }

        // Check if user is super admin
        if (!auth()->user()->isSuperAdmin()) {
            abort(403, 'Unauthorized. Super Admin access required.');
        }

        return $next($request);
    }
}

