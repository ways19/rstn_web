<?php

use App\Http\Controllers\Controller;
use App\Modules\Content\Controllers\Public\DiklatRegistrationController;
use App\Modules\Content\Controllers\Public\DiklatAttendanceController;
use App\Modules\Content\Controllers\Admin\AdminDiklatAttendanceController;
use App\Modules\Content\Controllers\Admin\AdminBannerController;
use App\Modules\Content\Controllers\Admin\AdminDiklatDocumentationController;
use App\Modules\Content\Controllers\Admin\AdminDiklatProgramController;
use App\Modules\Content\Controllers\Admin\AdminDiklatRegistrationController;
use App\Modules\Content\Controllers\Admin\AdminFacilityController;
use App\Modules\Content\Controllers\Admin\AdminPageController;
use App\Modules\Content\Controllers\Admin\AdminPageSectionController;
use App\Modules\Content\Controllers\Admin\AdminPpidDocumentController;
use App\Modules\Content\Controllers\Admin\AdminPostController;
use App\Modules\Content\Controllers\Public\PublicInformationController;
use App\Modules\Content\Controllers\Public\PublicPostController;
use App\Modules\Ppid\Controllers\PublicPpidController;
use App\Modules\Ppid\Controllers\Admin\AdminPpidRequestController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Module Routes: Content (Berita, Edukasi PKRS, Hero Banners)
|--------------------------------------------------------------------------
*/

// Informasi
Route::get('/berita', [PublicPostController::class, 'news'])
    ->name('news');

Route::get('/berita/{slug}', [PublicPostController::class, 'newsDetail'])
    ->name('news.detail');

Route::get(
    '/rujukan-gawat-darurat',
    [PublicInformationController::class, 'emergencyReferral']
)->name('information.emergency-referral');

Route::get(
    '/alur-pendaftaran',
    [PublicInformationController::class, 'registrationFlow']
)->name('information.registration-flow');

Route::get(
    '/tata-tertib-jam-berkunjung',
    [PublicInformationController::class, 'visitingRules']
)->name('information.visiting-rules');

Route::get(
    '/faq',
    [PublicInformationController::class, 'faq']
)->name('information.faq');

// Halaman utama Diklat
Route::get(
    '/diklat',
    [PublicInformationController::class, 'training']
)->name('information.training');

// Detail program Pelatihan
Route::get(
    '/diklat/detail/{program}',
    [PublicInformationController::class, 'trainingDetail']
)->name('information.diklat.detail');

// Pratinjau Brosur Pelatihan (PDF Viewer / On-the-fly Image-to-PDF)
Route::get(
    '/diklat/brosur/{program}',
    [PublicInformationController::class, 'trainingBrochure']
)->name('information.diklat.brochure');

/*
|--------------------------------------------------------------------------
| Absensi Diklat - Publik
|--------------------------------------------------------------------------
*/

// Menampilkan formulir absensi peserta
Route::get(
    '/diklat/absensi/{program}',
    [DiklatAttendanceController::class, 'create']
)->name('information.diklat.attendance.create');

// Menyimpan absensi peserta
Route::post(
    '/diklat/absensi/{program}',
    [DiklatAttendanceController::class, 'store']
)->name('information.diklat.attendance.store');

/*
|--------------------------------------------------------------------------
| Pendaftaran Diklat - Publik
|--------------------------------------------------------------------------
*/

// Form pendaftaran
Route::get(
    '/diklat/pendaftaran/{program}',
    [DiklatRegistrationController::class, 'create']
)->name('information.diklat.registration.create');

// Simpan pendaftaran
Route::post(
    '/diklat/pendaftaran/{program}',
    [DiklatRegistrationController::class, 'store']
)->name('information.diklat.registration.store');

// Halaman Sukses Pendaftaran (Tanda Terima & Unduh Bukti PDF)
Route::get(
    '/diklat/pendaftaran/sukses/{registrationNumber}',
    [DiklatRegistrationController::class, 'success']
)->name('information.diklat.registration.success');

// Unduh Bukti Lembar Registrasi Diklat (PDF)
Route::get(
    '/diklat/pendaftaran/bukti/{registrationNumber}',
    [DiklatRegistrationController::class, 'downloadProof']
)->name('information.diklat.registration.proof');

// Lacak Pendaftaran Diklat (Pelacakan Tiket & Timeline Status)
Route::get(
    '/informasi/diklat/lacak',
    [DiklatRegistrationController::class, 'track']
)->name('information.diklat.track');

Route::post(
    '/informasi/diklat/lacak',
    [DiklatRegistrationController::class, 'track']
)->name('information.diklat.track.search');

Route::get('/diklat/lacak', fn() => redirect()->route('information.diklat.track'));

// Lihat status pendaftaran berdasarkan token
Route::get(
    '/diklat/pendaftaran/status/{token}',
    [DiklatRegistrationController::class, 'statusByToken']
)->name('information.diklat.registration.status');

// Konfirmasi penyelesaian program
Route::post(
    '/diklat/pendaftaran/status/{token}/konfirmasi-selesai',
    [DiklatRegistrationController::class, 'confirmCompletion']
)->name('information.diklat.registration.confirm-completion');

Route::get(
    '/informasi-publik',
    [PublicInformationController::class, 'publicInformation']
)->name('information.public');

// Detail dokumentasi kegiatan
Route::get(
    '/informasi/dokumentasi/{documentation}',
    [PublicInformationController::class, 'documentationDetail']
)->name('information.documentation.detail');

// Halaman riwayat pendaftaran Diklat
Route::get(
    '/diklat/riwayat',
    [DiklatRegistrationController::class, 'history']
)->name('information.diklat.registration.history');

// Mengambil data pendaftaran berdasarkan token yang tersimpan di browser
Route::post(
    '/diklat/riwayat/cari',
    [DiklatRegistrationController::class, 'historyLookup']
)->name('information.diklat.registration.history.lookup');


/*
|--------------------------------------------------------------------------
| Admin CMS Routes
|--------------------------------------------------------------------------
*/

Route::prefix('admin')
    ->middleware('auth')
    ->name('admin.')
    ->group(function () {

        // Berita & Edukasi PKRS
        Route::middleware('can:manage_posts')->group(function () {
            Route::resource('posts', AdminPostController::class);
        });

        // Hero Slider Banner Beranda
        Route::middleware('can:manage_banners')->group(function () {
            Route::resource('banners', AdminBannerController::class);
        });

        // Halaman & Konten PPID
        Route::middleware('can:manage_pages')->group(function () {
            Route::resource('pages', AdminPageController::class);

            // Sertifikat akreditasi
            Route::post(
                'pages/{page}/accreditation-certificates',
                [AdminPageController::class, 'storeAccreditationCertificate']
            )->name('pages.accreditation-certificates.store');

            Route::put(
                'pages/{page}/accreditation-certificates/{certificate}',
                [AdminPageController::class, 'updateAccreditationCertificate']
            )->name('pages.accreditation-certificates.update');

            Route::delete(
                'pages/{page}/accreditation-certificates/{certificate}',
                [AdminPageController::class, 'destroyAccreditationCertificate']
            )->name('pages.accreditation-certificates.destroy');

            // Berkas & Pedoman Diklat
            Route::post(
                'pages/{page}/diklat-guidelines',
                [AdminPageController::class, 'storeDiklatGuideline']
            )->name('pages.diklat-guidelines.store');

            Route::put(
                'pages/{page}/diklat-guidelines/{guideline}',
                [AdminPageController::class, 'updateDiklatGuideline']
            )->name('pages.diklat-guidelines.update');

            Route::delete(
                'pages/{page}/diklat-guidelines/{guideline}',
                [AdminPageController::class, 'destroyDiklatGuideline']
            )->name('pages.diklat-guidelines.destroy');

            // Dokumentasi Diklat
            Route::post(
                'pages/{page}/diklat-documentations',
                [AdminDiklatDocumentationController::class, 'store']
            )->name('pages.diklat-documentations.store');

            Route::put(
                'pages/{page}/diklat-documentations/{documentation}',
                [AdminDiklatDocumentationController::class, 'update']
            )->name('pages.diklat-documentations.update');

            Route::delete(
                'pages/{page}/diklat-documentations/{documentation}',
                [AdminDiklatDocumentationController::class, 'destroy']
            )->name('pages.diklat-documentations.destroy');

            Route::get(
                'pages/{page}/diklat-documentations/{documentation}/edit',
                [AdminDiklatDocumentationController::class, 'edit']
            )->name('pages.diklat-documentations.edit');

            // CRUD Fasilitas Diklat
            Route::post(
                'pages/{page}/facilities',
                [AdminFacilityController::class, 'store']
            )->name('pages.facilities.store');

            Route::put(
                'pages/{page}/facilities/{facility}',
                [AdminFacilityController::class, 'update']
            )->name('pages.facilities.update');

            Route::delete(
                'pages/{page}/facilities/{facility}',
                [AdminFacilityController::class, 'destroy']
            )->name('pages.facilities.destroy');

            Route::get(
                'pages/{page}/facilities/{facility}/edit',
                [AdminFacilityController::class, 'edit']
            )->name('pages.facilities.edit');

            /*
            |--------------------------------------------------------------------------
            | Admin Pendaftaran Diklat
            |--------------------------------------------------------------------------
            */

            // Pendaftaran Pendidikan
            Route::get(
                'diklat/pendaftaran-pendidikan',
                [AdminDiklatRegistrationController::class, 'index']
            )->name('diklat.registrations.education.index');

            Route::get(
                'diklat/pendaftaran-pendidikan/{registration}',
                [AdminDiklatRegistrationController::class, 'show']
            )->name('diklat.registrations.education.show');

            Route::match(
                ['post', 'put', 'patch'],
                'diklat/pendaftaran-pendidikan/{registration}',
                [AdminDiklatRegistrationController::class, 'update']
            )->name('diklat.registrations.education.update');

            Route::get(
                'diklat/pendaftaran-pendidikan/{registration}/surat-permohonan',
                [AdminDiklatRegistrationController::class, 'previewApplicationLetter']
            )->name('diklat.registrations.education.application-letter');

            // Pendaftaran Pelatihan
            Route::get(
                'diklat/pendaftaran-pelatihan',
                [AdminDiklatRegistrationController::class, 'trainingIndex']
            )->name('diklat.registrations.training.index');

            Route::get(
                'diklat/pendaftaran-pelatihan/{registration}',
                [AdminDiklatRegistrationController::class, 'trainingShow']
            )->name('diklat.registrations.training.show');

            Route::put(
                'diklat/pendaftaran-pelatihan/{registration}',
                [AdminDiklatRegistrationController::class, 'trainingUpdate']
            )->name('diklat.registrations.training.update');

            Route::get(
                'diklat/pendaftaran-pelatihan/{registration}/bukti-pembayaran',
                [AdminDiklatRegistrationController::class, 'previewPaymentProof']
            )->name('diklat.registrations.training.payment-proof');

            Route::get(
                'diklat/pendaftaran/{registration}/dokumen/{type}/{index?}',
                [AdminDiklatRegistrationController::class, 'previewDocument']
            )->name('diklat.registrations.document');

            // CRUD Program Diklat
            Route::post(
                'pages/{page}/diklat-programs',
                [AdminDiklatProgramController::class, 'store']
            )->name('pages.diklat-programs.store');

            Route::get(
                'pages/{page}/diklat-programs/{program}/edit',
                [AdminDiklatProgramController::class, 'edit']
            )->name('pages.diklat-programs.edit');

            Route::put(
                'pages/{page}/diklat-programs/{program}',
                [AdminDiklatProgramController::class, 'update']
            )->name('pages.diklat-programs.update');

            Route::delete(
                'pages/{page}/diklat-programs/{program}',
                [AdminDiklatProgramController::class, 'destroy']
            )->name('pages.diklat-programs.destroy');

            /*
            |--------------------------------------------------------------------------
            | Admin Absensi Diklat
            |--------------------------------------------------------------------------
            */

            // Rekap absensi seluruh program
            Route::get(
                'diklat/absensi',
                [AdminDiklatAttendanceController::class, 'index']
            )->name('diklat.attendances.index');

            // Rekap absensi berdasarkan program
            Route::get(
                'diklat/absensi/{program}',
                [AdminDiklatAttendanceController::class, 'show']
            )->name('diklat.attendances.show');

            // Section & informasi halaman
            Route::post(
                'pages/{page}/sections',
                [AdminPageController::class, 'storeSection']
            )->name('pages.sections.store');

            Route::post(
                'pages/{page}/information',
                [AdminPageController::class, 'storeInformation']
            )->name('pages.information.store');

            // Pengaturan urutan section
            Route::post(
                'page-sections/reorder',
                [AdminPageSectionController::class, 'reorder']
            )->name('page-sections.reorder');

            Route::resource(
                'page-sections',
                AdminPageSectionController::class
            )->except(['index', 'show']);

            // Dokumen PPID
            Route::resource(
                'ppid-documents',
                AdminPpidDocumentController::class
            );

            // Permohonan informasi PPID
            Route::get(
                'ppid/permohonan',
                [
                    \App\Modules\Ppid\Controllers\Admin\AdminPpidRequestController::class,
                    'index'
                ]
            )->name('ppid.requests.index');

            Route::get(
                'ppid/admin-permohonan',
                [
                    \App\Modules\Ppid\Controllers\Admin\AdminPpidInformationController::class,
                    'index'
                ]
            )->name('ppid.information.index');

            Route::get(
                'ppid/permohonan/{ppidInformationRequest}',
                [
                    \App\Modules\Ppid\Controllers\Admin\AdminPpidRequestController::class,
                    'show'
                ]
            )->name('ppid.requests.show');

            // Preview dokumen identitas pemohon
            Route::get(
                'ppid/permohonan/{ppidInformationRequest}/dokumen-identitas',
                [
                    \App\Modules\Ppid\Controllers\Admin\AdminPpidRequestController::class,
                    'previewIdentityDocument'
                ]
            )->name('ppid.requests.identity-document');

            Route::patch(
                'ppid/permohonan/{ppidInformationRequest}',
                [
                    \App\Modules\Ppid\Controllers\Admin\AdminPpidRequestController::class,
                    'update'
                ]
            )->name('ppid.requests.update');
        });

        // Pengajuan Keberatan PPID
        Route::get(
            'ppid/keberatan',
            [
                \App\Modules\Ppid\Controllers\Admin\AdminPpidObjectionController::class,
                'index'
            ]
        )->name('ppid.objections.index');

        Route::get(
            'ppid/keberatan/{ppidObjection}',
            [
                \App\Modules\Ppid\Controllers\Admin\AdminPpidObjectionController::class,
                'show'
            ]
        )->name('ppid.objections.show');

        Route::patch(
            'ppid/keberatan/{ppidObjection}',
            [
                \App\Modules\Ppid\Controllers\Admin\AdminPpidObjectionController::class,
                'update'
            ]
        )->name('ppid.objections.update');
    });

// Aduan
Route::get(
    '/aduan/pengaduan-online-pasien',
    [PublicInformationController::class, 'onlineComplaint']
)->name('aduan.pengaduan.online.pasien');

Route::post(
    '/aduan/pengaduan-online-pasien',
    [PublicInformationController::class, 'storeComplaint']
)->name('aduan.pengaduan.online.pasien');

Route::get(
    '/aduan/lapor-benturan-kepentingan',
    [PublicInformationController::class, 'conflictOfInterest']
)->name('aduan.lapor.benturan.kepentingan');

Route::get(
    '/aduan/whistle-blowing-system-wbs',
    [PublicInformationController::class, 'whistleblowing']
)->name('aduan.whistle.blowing.system');

Route::get(
    '/aduan/saluran-kontak-pengaduan',
    [PublicInformationController::class, 'complaintContacts']
)->name('aduan.saluran.kontak.pengaduan');
