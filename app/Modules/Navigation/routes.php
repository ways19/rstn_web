<?php

use App\Modules\Navigation\Controllers\AdminMenuController;
use App\Modules\Navigation\Controllers\AdminModuleController;
use App\Modules\Navigation\Controllers\AdminSettingController;
use App\Modules\Navigation\Controllers\AdminTabReferenceController;
use App\Modules\Navigation\Controllers\Public\PublicHomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Module Routes: Navigation & Site Settings
|--------------------------------------------------------------------------
*/

// Public Routes
Route::get('/', [PublicHomeController::class, 'home'])->name('home');
Route::get('/tentang-kami', [PublicHomeController::class, 'about'])->name('about');
Route::get('/sitemap.xml', [PublicHomeController::class, 'sitemap'])->name('sitemap');
Route::get('/robots.txt', [PublicHomeController::class, 'robots'])->name('robots');

// Admin CMS Routes
Route::prefix('admin')->middleware('auth')->name('admin.')->group(function () {
    Route::middleware('can:manage_settings')->group(function () {
        // Pengaturan Profil RS
        Route::get('settings', [AdminSettingController::class, 'index'])->name('settings.index');
        Route::post('settings', [AdminSettingController::class, 'update'])->name('settings.update');

        // Pengelolaan Modul Sistem
        Route::get('modules', [AdminModuleController::class, 'index'])->name('modules.index');
        Route::get('modules/{module}/edit', [AdminModuleController::class, 'edit'])->name('modules.edit');
        Route::put('modules/{module}', [AdminModuleController::class, 'update'])->name('modules.update');
        Route::post('modules/{module}/toggle', [AdminModuleController::class, 'toggle'])->name('modules.toggle');

        // Tab & Referensi Menu
        Route::get(
            'tab-references',
            [AdminTabReferenceController::class, 'index']
        )->name('tab-references.index');
        Route::post(
            'tab-references/groups',
            [AdminTabReferenceController::class, 'storeGroup']
        )->name('tab-references.groups.store');
        Route::put(
            'tab-references/{menu}',
            [AdminTabReferenceController::class, 'updateTab']
        )->name('tab-references.update');

        // Pengelolaan Menu Navigasi
        Route::get('menus', [AdminMenuController::class, 'index'])->name('menus.index');
        Route::get('menus/create', [AdminMenuController::class, 'create'])->name('menus.create');
        Route::post('menus', [AdminMenuController::class, 'store'])->name('menus.store');
        Route::get('menus/{menu}/edit', [AdminMenuController::class, 'edit'])->name('menus.edit');
        Route::put('menus/{menu}', [AdminMenuController::class, 'update'])->name('menus.update');
        Route::delete('menus/{menu}', [AdminMenuController::class, 'destroy'])->name('menus.destroy');
        Route::post('menus/{menu}/toggle', [AdminMenuController::class, 'toggle'])->name('menus.toggle');
    });
});
