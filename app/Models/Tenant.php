<?php

namespace App\Models;

use Stancl\Tenancy\Database\Models\Tenant as BaseTenant;
use Stancl\Tenancy\Contracts\TenantWithDatabase;
use Stancl\Tenancy\Database\Concerns\HasDatabase;
use Stancl\Tenancy\Database\Concerns\HasDomains;

/**
 * Modelo Tenant personalizado
 * 
 * Representa cada cliente/inquilino del sistema.
 * Cada tenant tiene su propia base de datos y subdominio.
 */
class Tenant extends BaseTenant implements TenantWithDatabase
{
    use HasDatabase, HasDomains;

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
}
