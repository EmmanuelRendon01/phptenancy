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
        return 'Bienvenido al tenant: ' . tenant('id');
    });

});
