<?php

use App\Modules\Content\Controllers\AdminBannerController;
use App\Modules\Content\Controllers\AdminPostController;
use App\Modules\Content\Controllers\Public\PublicPostController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Module Routes: Content (Berita, Edukasi PKRS, Hero Banners)
|--------------------------------------------------------------------------
*/

// Public Routes
Route::get('/berita', [PublicPostController::class, 'news'])->name('news');
Route::get('/berita/{slug}', [PublicPostController::class, 'newsDetail'])->name('news.detail');

// Admin CMS Routes
Route::prefix('admin')->middleware('auth')->name('admin.')->group(function () {
    // Berita & Edukasi PKRS
    Route::middleware('can:manage_posts')->group(function () {
        Route::resource('posts', AdminPostController::class);
    });

    // Hero Slider Banners Beranda
    Route::middleware('can:manage_banners')->group(function () {
        Route::resource('banners', AdminBannerController::class);
    });
});
