<?php

use App\Http\Controllers\CaretakerController;
use App\Http\Controllers\TenantController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Root route: smart redirect based on authentication and role
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

// Protected routes (role-based access control)
Route::middleware(['auth'])->group(function () {

    // Tenant-only dashboard
    Route::middleware(['role:tenant'])->group(function () {
        Route::get('/tenant/dashboard', [TenantController::class, 'index'])->name('tenant.dashboard');
    });

    // Caretaker and landlord dashboard
    Route::middleware(['role:caretaker,landlord'])->group(function () {
        Route::get('/caretaker/dashboard', [CaretakerController::class, 'index'])->name('caretaker.dashboard');
    });
});

// Login, logout and password routes
require __DIR__.'/auth.php';