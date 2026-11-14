<?php

namespace App\Modules\Content\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DiklatProgram;

class AdminDiklatAttendanceController extends Controller
{
    /**
     * Menampilkan daftar program pelatihan beserta jumlah peserta hadir.
     */
    public function index()
    {
        $programs = DiklatProgram::withCount('attendances')
            ->whereRaw(
                "LOWER(TRIM(category)) = ?",
                ['pelatihan']
            )
            ->orderBy('sort_order')
            ->orderByDesc('id')
            ->get();

        return view(
            'admin.diklat.attendance.index',
            compact('programs')
        );
    }

    /**
     * Menampilkan rekap peserta yang mengikuti absensi suatu program.
     */
    public function show(DiklatProgram $program)
    {
        $category = strtolower(trim($program->category ?? ''));

        abort_unless($category === 'pelatihan', 404);

        $attendances = $program->attendances()
            ->orderByDesc('attended_at')
            ->paginate(20);

        $totalAttendances = $program->attendances()->count();

        return view(
            'admin.diklat.attendance.show',
            compact(
                'program',
                'attendances',
                'totalAttendances'
            )
        );
    }
}