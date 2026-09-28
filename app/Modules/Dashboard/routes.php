<?php

use App\Modules\Dashboard\Controllers\AdminDashboardController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Module Routes: Dashboard
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->middleware('auth')->name('admin.')->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
});
