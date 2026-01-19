<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyBySubdomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

/*
|--------------------------------------------------------------------------
| Tenant Routes
|--------------------------------------------------------------------------
|
| Rutas para cada tenant. Estas rutas se activan cuando accedes
| a un subdominio como: tenant1.localhost:8000
|
*/

Route::middleware([
    'web',
    InitializeTenancyBySubdomain::class,  // Usa subdominios: tenant1.localhost
    PreventAccessFromCentralDomains::class,
])->group(function () {

    // Página principal del tenant
    Route::get('/', function () {
        return view('tenant.dashboard');
    })->name('tenant.dashboard');

    // Rutas protegidas por suscripción
    Route::middleware(['subscribed'])->group(function () {

        // Gestión de Categorías
        Route::get('/categories', \App\Livewire\Tenant\CategoryManager::class)
            ->name('tenant.categories');

        // Gestión de Productos
        Route::get('/products', \App\Livewire\Tenant\ProductManager::class)
            ->name('tenant.products');
    });

    // Página de suscripción requerida
    Route::get('/subscription-required', function () {
        return view('tenant.subscription-required');
    })->name('tenant.subscription.required');

});

