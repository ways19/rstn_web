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

/*
|--------------------------------------------------------------------------
| Halaman Akses & Unduh Banner Gambar Diklat
|--------------------------------------------------------------------------
*/
Route::get('/unduh-banner', function () {
    $banners = [
        [
            'title' => 'Pelatihan Bantuan Hidup Dasar (BHD)',
            'filename' => 'banner-bhd.jpg',
            'desc' => 'Simulasi CPR dan penanganan gawat darurat dengan manikin medis.',
        ],
        [
            'title' => 'Pelatihan Pencegahan dan Pengendalian Infeksi (PPI)',
            'filename' => 'banner-pelatihan-ppi.jpg',
            'desc' => 'Praktik cuci tangan steril, APD, dan aseptik klinis di laboratorium.',
        ],
        [
            'title' => 'Sosialisasi Pencegahan dan Pengendalian Infeksi (PPI)',
            'filename' => 'banner-sosialisasi-ppi.jpg',
            'desc' => 'Sosialisasi dan presentasi pedoman pencegahan infeksi di auditorium.',
        ],
    ];

    $html = '<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Unduh Banner Diklat</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: "Poppins", sans-serif; }
        body { background: #f8fafc; color: #1e293b; padding: 40px 20px; }
        .container { max-width: 1000px; margin: 0 auto; }
        .header { margin-bottom: 28px; }
        h1 { font-size: 24px; font-weight: 700; color: #0f172a; margin-bottom: 6px; }
        p.subtitle { color: #64748b; font-size: 14px; }
        .grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(290px, 1fr)); gap: 24px; }
        .card { background: #fff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.06); border: 1px solid #e2e8f0; display: flex; flex-direction: column; }
        .card img { width: 100%; height: 185px; object-fit: cover; display: block; border-bottom: 1px solid #e2e8f0; }
        .card-body { padding: 18px; display: flex; flex-direction: column; flex-grow: 1; justify-content: space-between; gap: 14px; }
        .card-title { font-size: 15px; font-weight: 600; color: #0f172a; line-height: 1.4; }
        .card-desc { font-size: 13px; color: #64748b; line-height: 1.5; margin-top: 4px; }
        .btn-wrap { display: flex; gap: 8px; }
        .btn { flex: 1; display: inline-flex; align-items: center; justify-content: center; gap: 8px; background: #0284c7; color: white; padding: 10px 14px; border-radius: 8px; text-decoration: none; font-size: 13px; font-weight: 500; transition: background 0.15s; }
        .btn:hover { background: #0369a1; }
        .btn-outline { flex: 1; display: inline-flex; align-items: center; justify-content: center; background: #f1f5f9; color: #334155; padding: 10px 14px; border-radius: 8px; text-decoration: none; font-size: 13px; font-weight: 500; transition: background 0.15s; }
        .btn-outline:hover { background: #e2e8f0; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Unduh Banner Diklat & Pelatihan</h1>
            <p class="subtitle">Silakan unduh atau buka gambar di bawah ini untuk kemudian diunggah melalui formulir CMS admin.</p>
        </div>
        <div class="grid">';

    foreach ($banners as $b) {
        $assetUrl = asset('images/diklat/' . $b['filename']);
        $downloadUrl = url('/unduh-banner/file/' . $b['filename']);
        $html .= '
            <div class="card">
                <a href="' . $assetUrl . '" target="_blank" title="Klik untuk memperbesar">
                    <img src="' . $assetUrl . '" alt="' . e($b['title']) . '">
                </a>
                <div class="card-body">
                    <div>
                        <h3 class="card-title">' . e($b['title']) . '</h3>
                        <p class="card-desc">' . e($b['desc']) . '</p>
                    </div>
                    <div class="btn-wrap">
                        <a href="' . $downloadUrl . '" class="btn">
                            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                            Unduh
                        </a>
                        <a href="' . $assetUrl . '" target="_blank" class="btn-outline">
                            Buka Tab Baru
                        </a>
                    </div>
                </div>
            </div>';
    }

    $html .= '
        </div>
    </div>
</body>
</html>';

    return response($html);
});

Route::get('/unduh-banner/file/{filename}', function ($filename) {
    $cleanName = basename($filename);
    $path = public_path('images/diklat/' . $cleanName);
    if (!file_exists($path)) {
        abort(404);
    }
    return response(file_get_contents($path), 200, [
        'Content-Type' => 'image/jpeg',
        'Content-Disposition' => 'attachment; filename="' . $cleanName . '"',
        'Content-Length' => filesize($path),
    ]);
});

