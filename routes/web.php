<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\TenantController;
use App\Http\Controllers\CaretakerController;

// 1. Root route: Smart redirect based on authentication and role
Route::get('/', function () {
    if (Auth::check()) {
        $role = Auth::user()->role;
        if ($role === 'tenant') {
            return redirect()->route('tenant.dashboard');
        }
        return redirect()->route('caretaker.dashboard');
    }
    return redirect()->route('login');
});

// 2. Protected Dashboard Routes (Step 3 RBAC)
Route::middleware(['auth'])->group(function () {

    // Tenant-only dashboard
    Route::middleware(['role:tenant'])->group(function () {
        Route::get('/tenant/dashboard', [TenantController::class, 'index'])->name('tenant.dashboard');
    });

    // Caretaker and Landlord dashboard & management
    Route::middleware(['role:caretaker,landlord'])->group(function () {
        Route::get('/caretaker/dashboard', [CaretakerController::class, 'index'])->name('caretaker.dashboard');
    });

});
Route::post('/logout', [App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'destroy'])
    ->name('logout')
    ->middleware('auth');

// 3. Include default authentication routes (login, logout, etc.)
require __DIR__.'/auth.php';