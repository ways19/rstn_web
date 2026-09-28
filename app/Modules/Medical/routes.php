<?php

use App\Modules\Medical\Controllers\AdminBedController;
use App\Modules\Medical\Controllers\AdminDoctorController;
use App\Modules\Medical\Controllers\AdminServiceController;
use App\Modules\Medical\Controllers\Public\PublicMedicalController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Module Routes: Medical (Layanan, Dokter, Kamar Inap)
|--------------------------------------------------------------------------
*/

// Public Routes
Route::get('/layanan', [PublicMedicalController::class, 'services'])->name('services');
Route::get('/layanan/{slug}', [PublicMedicalController::class, 'serviceDetail'])->name('services.detail');
Route::get('/dokter', [PublicMedicalController::class, 'doctors'])->name('doctors');
Route::get('/dokter/{id}', [PublicMedicalController::class, 'doctorDetail'])->name('doctors.detail');
Route::get('/informasi-publik', [PublicMedicalController::class, 'information'])->name('information');

// Admin CMS Routes
Route::prefix('admin')->middleware('auth')->name('admin.')->group(function () {
    // Ketersediaan Bed Kamar Inap
    Route::middleware('can:manage_beds')->group(function () {
        Route::get('beds', [AdminBedController::class, 'index'])->name('beds.index');
        Route::post('beds', [AdminBedController::class, 'update'])->name('beds.update');
    });

    // Master Layanan RS & Poliklinik
    Route::middleware('can:manage_services')->group(function () {
        Route::resource('services', AdminServiceController::class);
    });

    // Master Dokter & Jadwal Praktik
    Route::middleware('can:manage_doctors')->group(function () {
        Route::resource('doctors', AdminDoctorController::class);
    });
});
