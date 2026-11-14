<?php

namespace App\Modules\Content\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\DiklatAttendance;
use App\Models\DiklatProgram;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class DiklatAttendanceController extends Controller
{
    /**
     * Menampilkan halaman absensi.
     */
    public function create(DiklatProgram $program)
    {
        abort_unless(
            strtolower(trim($program->category ?? '')) === 'pelatihan'
                && $program->is_active,
            404
        );

        abort_unless(!$program->requires_registration, 404);

        $now = now();

        $isOpen = $program->start_at
            && $program->end_at
            && $now->greaterThanOrEqualTo($program->start_at)
            && $now->lessThan($program->end_at);

        return view(
            'public.information.diklat-attendance',
            compact('program', 'isOpen')
        );
    }

    /**
     * Menyimpan absensi peserta.
     */
    public function store(Request $request, DiklatProgram $program)
    {
        abort_unless(
            strtolower(trim($program->category ?? '')) === 'pelatihan'
                && $program->is_active,
            404
        );

        abort_unless(!$program->requires_registration, 404);

        $now = now();

        if (
            !$program->start_at ||
            !$program->end_at ||
            $now->lessThan($program->start_at) ||
            $now->greaterThanOrEqualTo($program->end_at)
        ) {
            throw ValidationException::withMessages([
                'attendance' => 'Absensi belum dibuka atau sudah ditutup.',
            ]);
        }

        $data = $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'institution' => ['required', 'string', 'max:255'],
        ]);

        $normalizedName = Str::lower(
            preg_replace('/\s+/', ' ', trim($data['full_name']))
        );

        $normalizedInstitution = Str::lower(
            preg_replace('/\s+/', ' ', trim($data['institution']))
        );
        
        $identityKey = hash(
            'sha256',
            $normalizedName . '|' . $normalizedInstitution
        );

        try {
            DiklatAttendance::create([
                'diklat_program_id' => $program->id,
                'full_name' => trim($data['full_name']),
                'institution' => trim($data['institution']),
                'identity_key' => $identityKey,
                'attended_at' => now(),
            ]);
        } catch (QueryException $exception) {
            if (
                str_contains(
                    $exception->getMessage(),
                    'diklat_attendance_unique_participant'
                ) ||
                str_contains(
                    $exception->getMessage(),
                    'UNIQUE constraint failed'
                )
            ) {
                throw ValidationException::withMessages([
                    'full_name' => 'Nama dan instansi ini sudah tercatat mengikuti absensi program ini.',
                ]);
            }

            throw $exception;
        }

        return redirect()
            ->route('information.education')
            ->with('success', 'Absensi berhasil dicatat. Terima kasih telah hadir.');
    }
}
