<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Central\TenantController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // CRUD de Tenants (solo usuarios autenticados)
    Route::resource('tenants', TenantController::class);
});
