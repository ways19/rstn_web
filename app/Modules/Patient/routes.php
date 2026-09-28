<?php

use App\Modules\Patient\Controllers\AdminComplaintController;
use App\Modules\Patient\Controllers\AdminRegistrationController;
use App\Modules\Patient\Controllers\Public\PublicPatientController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Module Routes: Patient (Pendaftaran Online & Aduan Masyarakat)
|--------------------------------------------------------------------------
*/

// Public Routes
Route::get('/pendaftaran-online', [PublicPatientController::class, 'registration'])->name('registration');
Route::post('/pendaftaran-online', [PublicPatientController::class, 'storeRegistration'])->name('registration.store');
Route::get('/kontak', [PublicPatientController::class, 'contact'])->name('contact');
Route::post('/kontak', [PublicPatientController::class, 'storeComplaint'])->name('complaint.store');

// Admin CMS Routes
Route::prefix('admin')->middleware('auth')->name('admin.')->group(function () {
    // Pendaftaran Pasien & Antrean Online
    Route::middleware('can:manage_registrations')->group(function () {
        Route::get('registrations', [AdminRegistrationController::class, 'index'])->name('registrations.index');
        Route::patch('registrations/{registration}/status', [AdminRegistrationController::class, 'updateStatus'])->name('registrations.status');
    });

    // Saran & Aduan Masyarakat
    Route::middleware('can:manage_complaints')->group(function () {
        Route::get('complaints', [AdminComplaintController::class, 'index'])->name('complaints.index');
        Route::get('complaints/{complaint}', [AdminComplaintController::class, 'show'])->name('complaints.show');
        Route::post('complaints/{complaint}/reply', [AdminComplaintController::class, 'reply'])->name('complaints.reply');
    });
});
