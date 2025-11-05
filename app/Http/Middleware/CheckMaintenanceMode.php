<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\SystemSetting;
use App\Models\SystemMaintenanceLog;
use Illuminate\Support\Facades\View;

class CheckMaintenanceMode
{
    /**
     * Routes that should be accessible during maintenance
     */
    private array $exemptRoutes = [
        'frontend.login',
        'login',
        'logout',
        'super-admin.*', // Super admin routes are always accessible
    ];

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Super admins bypass maintenance mode
        if (auth()->check() && auth()->user()->isSuperAdmin()) {
            return $next($request);
        }

        // Check if current route is exempt
        foreach ($this->exemptRoutes as $exemptRoute) {
            if ($request->routeIs($exemptRoute)) {
                return $next($request);
            }
        }

        // Check if system is in maintenance mode
        $maintenanceMode = SystemSetting::getMaintenanceMode();

        if ($maintenanceMode) {
            // Get active maintenance log
            $activeMaintenance = SystemMaintenanceLog::active()->first();

            if ($request->expectsJson()) {
                return response()->json([
                    'error' => 'System is currently under maintenance.',
                    'message' => $activeMaintenance?->description ?? 'Please try again later.',
                    'status' => 'maintenance',
                    'estimated_completion' => $activeMaintenance?->scheduled_end?->toIso8601String(),
                ], 503);
            }

            return response()->view('errors.maintenance', [
                'maintenance' => $activeMaintenance,
            ], 503);
        }

        // Check for active maintenance (even if not in full maintenance mode)
        $activeMaintenance = SystemMaintenanceLog::active()
            ->where('display_banner', true)
            ->first();

        if ($activeMaintenance) {
            View::share('active_maintenance', $activeMaintenance);
        }

        return $next($request);
    }
}

