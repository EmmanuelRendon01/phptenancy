<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Middleware para verificar que el tenant tenga una suscripción activa
 */
class EnsureSubscriptionIsActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $tenant = tenancy()->tenant;

        if (!$tenant) {
            return redirect()->route('login');
        }

        // Verificar si el tenant tiene una suscripción activa
        if (!$tenant->hasActiveSubscription()) {
            return redirect()->route('tenant.subscription.required')
                ->with('warning', 'Necesitas una suscripción activa para acceder a esta función.');
        }

        return $next($request);
    }
}
