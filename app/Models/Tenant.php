<?php

namespace App\Models;

use Laravel\Cashier\Billable;
use Stancl\Tenancy\Database\Models\Tenant as BaseTenant;
use Stancl\Tenancy\Contracts\TenantWithDatabase;
use Stancl\Tenancy\Database\Concerns\HasDatabase;
use Stancl\Tenancy\Database\Concerns\HasDomains;

/**
 * Modelo Tenant personalizado
 * 
 * Representa cada cliente/inquilino del sistema.
 * Cada tenant tiene su propia base de datos y subdominio.
 * Incluye funcionalidad de facturación con Stripe mediante Laravel Cashier.
 */
class Tenant extends BaseTenant implements TenantWithDatabase
{
    use HasDatabase, HasDomains, Billable;

    /**
     * Campos que se pueden asignar masivamente
     */
    protected $fillable = [
        'id',
        'name',      // Nombre del tenant
        'email',     // Email de contacto
        'plan',      // Plan de suscripción: 'basic', 'pro', 'enterprise'
    ];

    /**
     * Datos adicionales almacenados en JSON
     * Estos se guardan automáticamente en la columna 'data'
     */
    public static function getCustomColumns(): array
    {
        return [
            'id',
            'name',
            'email',
            'plan',
        ];
    }

    /**
     * Verificar si el tenant tiene una suscripción activa
     */
    public function hasActiveSubscription(): bool
    {
        return $this->subscribed('default');
    }

    /**
     * Obtener el nombre del plan de Stripe basado en el plan del tenant
     */
    public function getStripePriceId(): string
    {
        return match ($this->plan) {
            'basic' => config('services.stripe.price_basic'),
            'pro' => config('services.stripe.price_pro'),
            'enterprise' => config('services.stripe.price_enterprise'),
            default => config('services.stripe.price_basic'),
        };
    }
}
