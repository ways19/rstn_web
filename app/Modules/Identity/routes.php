<?php

use App\Modules\Identity\Controllers\AdminAuthController;
use App\Modules\Identity\Controllers\AdminRoleController;
use App\Modules\Identity\Controllers\AdminUserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Module Routes: Identity & RBAC
|--------------------------------------------------------------------------
*/

// Auth & Captcha Public Routes
Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('login');
Route::get('/captcha/refresh', [AdminAuthController::class, 'refreshCaptcha'])->name('captcha.refresh');

Route::prefix('admin')->group(function () {
    // Admin Auth Actions
    Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

    // Admin User & Role Management (RBAC)
    Route::middleware('auth')->name('admin.')->group(function () {
        Route::middleware('can:manage_users')->group(function () {
            Route::resource('users', AdminUserController::class);
            Route::resource('roles', AdminRoleController::class);
        });
    });
});
