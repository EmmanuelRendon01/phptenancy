<?php

namespace App\Http\Controllers\Central;

use App\Http\Controllers\Controller;
use App\Models\Tenant;
use Illuminate\Http\Request;

/**
 * Controlador para gestionar suscripciones de Stripe
 */
class SubscriptionController extends Controller
{
    /**
     * Mostrar página de suscripción
     */
    public function index(Tenant $tenant)
    {
        return view('central.subscriptions.index', compact('tenant'));
    }

    /**
     * Crear sesión de Stripe Checkout
     */
    public function checkout(Request $request, Tenant $tenant)
    {
        $request->validate([
            'plan' => 'required|in:basic,pro,enterprise',
        ]);

        // Actualizar el plan del tenant
        $tenant->update(['plan' => $request->plan]);

        // Obtener el Price ID de Stripe según el plan
        $priceId = $tenant->getStripePriceId();

        // Crear sesión de Stripe Checkout
        return $tenant->newSubscription('default', $priceId)
            ->checkout([
                'success_url' => route('subscriptions.success', ['tenant' => $tenant->id]),
                'cancel_url' => route('subscriptions.cancel', ['tenant' => $tenant->id]),
            ]);
    }

    /**
     * Página de éxito después del pago
     */
    public function success(Tenant $tenant)
    {
        return view('central.subscriptions.success', compact('tenant'));
    }

    /**
     * Página de cancelación
     */
    public function cancel(Tenant $tenant)
    {
        return view('central.subscriptions.cancel', compact('tenant'));
    }

    /**
     * Redirigir al portal de cliente de Stripe
     */
    public function portal(Tenant $tenant)
    {
        return $tenant->redirectToBillingPortal(route('tenants.index'));
    }

    /**
     * Cancelar suscripción
     */
    public function cancelSubscription(Tenant $tenant)
    {
        $tenant->subscription('default')->cancel();

        return redirect()->route('tenants.index')
            ->with('success', 'Suscripción cancelada exitosamente.');
    }

    /**
     * Reanudar suscripción
     */
    public function resumeSubscription(Tenant $tenant)
    {
        $tenant->subscription('default')->resume();

        return redirect()->route('tenants.index')
            ->with('success', 'Suscripción reanudada exitosamente.');
    }
}
