<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Modular Route Auto-Discovery
|--------------------------------------------------------------------------
|
| Otomatis memuat file routes.php dari setiap direktori modul di app/Modules/.
| Setiap modul mengelola rute publik dan CMS/admin miliknya sendiri secara independen.
|
*/

foreach (glob(app_path('Modules/*/routes.php')) as $moduleRouteFile) {
    require $moduleRouteFile;
}
