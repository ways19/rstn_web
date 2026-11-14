<?php

use App\Modules\Ppid\Controllers\PublicPpidController;
use Illuminate\Support\Facades\Route;
use App\Modules\Content\Controllers\Public\PublicInformationController;
use App\Modules\Content\Controllers\Public\DiklatRegistrationController;




Route::prefix('ppid')->name('ppid.')->group(function () {

    // Profil PPID
    Route::get('/profil', [PublicPpidController::class, 'profileMain'])->name('profile');
    Route::get('/profil/sk-tim', [PublicPpidController::class, 'profileTeam'])->name('profile.team');
    Route::get('/profil/struktur', [PublicPpidController::class, 'profileStructure'])->name('profile.structure');
    Route::get('/profil/tugas-fungsi', [PublicPpidController::class, 'profileDuties'])->name('profile.duties');
    Route::get('/profil/maklumat', [PublicPpidController::class, 'profileStatement'])->name('profile.statement');
    Route::get(
    '/cek-tiket-keberatan',
    [PublicPpidController::class, 'checkObjectionTicket']
)->name('objection.check-ticket');

   // Informasi Publik
    Route::get('/informasi', function () {
        return redirect()->route('ppid.information.periodic');
    })->name('information');

    Route::get('/informasi/berkala', [PublicPpidController::class, 'informationPeriodic'])->name('information.periodic');
    Route::get('/informasi/serta-merta', [PublicPpidController::class, 'informationImmediate'])->name('information.immediate');
    Route::get('/informasi/setiap-saat', [PublicPpidController::class, 'informationAnytime'])->name('information.anytime');
    Route::get('/informasi/dikecualikan', [PublicPpidController::class, 'informationExcluded'])->name('information.excluded');

    // Detail Dokumen PPID
    Route::get('/dokumen/{ppidDocument}', [PublicPpidController::class, 'documentDetail'])->name('document.detail');

    // Permohonan Informasi
    Route::get('/permohonan', function () {
        return redirect()->route('ppid.request.information');
    })->name('request');

    Route::get('/permohonan/permintaan', [PublicPpidController::class, 'requestInformation'])
        ->name('request.information');

    Route::post('/permohonan/permintaan', [PublicPpidController::class, 'submitInformationRequest'])
        ->name('request.information.submit');

    Route::get('/permohonan/berhasil/{ticketNumber}', [PublicPpidController::class, 'requestSuccess'])
        ->name('request.success');

    Route::get('/permohonan/keberatan', [PublicPpidController::class, 'requestObjection'])
        ->name('request.objection');

    Route::post('/permohonan/keberatan', [PublicPpidController::class, 'submitObjection'])
        ->name('request.objection.submit');

    Route::get('/permohonan/lacak', [PublicPpidController::class, 'requestTrack'])
        ->name('request.track');

    Route::get('/permohonan/statistik', [PublicPpidController::class, 'requestStatistics'])
        ->name('request.statistics');
});

// Pendidikan & Pelatihan (Diklat)
    Route::prefix('informasi')->name('information.')->group(function () {

        // Profil Diklat
        Route::get('/diklat', [PublicInformationController::class, 'training'])
            ->name('training');
        
        // Detail pelatihan tanpa pendaftaran
        Route::get(
            '/diklat/detail/{program}',
            [PublicInformationController::class, 'trainingDetail']
        )->name('information.diklat.detail');

        // Submenu Diklat
        Route::get('/pendidikan-pelatihan', [PublicInformationController::class, 'education'])
            ->name('education');

        // Unduh Pedoman / Berkas Diklat
        Route::get(
            '/pendidikan-pelatihan/pedoman/{guideline}/unduh',
            [PublicInformationController::class, 'downloadGuideline']
        )->name('diklat.guideline.download');

        // Pendaftaran Online Diklat
        Route::get(
            '/pendidikan-pelatihan/daftar/{program}',
            [DiklatRegistrationController::class, 'create']
        )->name('diklat.registration.create');

        Route::post(
            '/pendidikan-pelatihan/daftar/{program}',
            [DiklatRegistrationController::class, 'store']
        )->name('diklat.registration.store');

        Route::get(
            '/pendidikan-pelatihan/berhasil/{registrationNumber}',
            [DiklatRegistrationController::class, 'success']
        )->name('diklat.registration.success');

        Route::get(
            '/pendidikan-pelatihan/status/{token}',
            [DiklatRegistrationController::class, 'statusByToken']
        )->name('diklat.registration.status');

        Route::get('/fasilitas', [PublicInformationController::class, 'facilities'])
            ->name('facilities');

        Route::get('/akreditasi', [PublicInformationController::class, 'accreditation'])
            ->name('accreditation');

        Route::get('/dokumentasi', [PublicInformationController::class, 'documentation'])
            ->name('documentation');

    });
    
