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

    // Rutas de suscripción
    Route::prefix('subscriptions')->name('subscriptions.')->group(function () {
        Route::get('/{tenant}', [\App\Http\Controllers\Central\SubscriptionController::class, 'index'])->name('index');
        Route::post('/{tenant}/checkout', [\App\Http\Controllers\Central\SubscriptionController::class, 'checkout'])->name('checkout');
        Route::get('/{tenant}/success', [\App\Http\Controllers\Central\SubscriptionController::class, 'success'])->name('success');
        Route::get('/{tenant}/cancel', [\App\Http\Controllers\Central\SubscriptionController::class, 'cancel'])->name('cancel');
        Route::get('/{tenant}/portal', [\App\Http\Controllers\Central\SubscriptionController::class, 'portal'])->name('portal');
        Route::post('/{tenant}/cancel-subscription', [\App\Http\Controllers\Central\SubscriptionController::class, 'cancelSubscription'])->name('cancel-subscription');
        Route::post('/{tenant}/resume-subscription', [\App\Http\Controllers\Central\SubscriptionController::class, 'resumeSubscription'])->name('resume-subscription');
    });
});
