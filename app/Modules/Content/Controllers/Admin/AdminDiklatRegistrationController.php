<?php

namespace App\Modules\Content\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DiklatRegistration;
use App\Models\DiklatProgram;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class AdminDiklatRegistrationController extends Controller
{
    /**
     * Menampilkan daftar pendaftar program pendidikan.
     */
    public function index()
    {
        $registrations = DiklatRegistration::with('program')
            ->whereHas('program', function ($query) {
                $query->whereRaw(
                    "LOWER(TRIM(category)) NOT IN (?, ?)",
                    ['pelatihan', 'orientasi']
                );
            })
            ->latest()
            ->get();

        return view(
            'admin.diklat.registrations.education.index',
            compact('registrations')
        );
    }


    
    /**
     * Menampilkan detail satu pendaftar program pendidikan.
     */
    public function show(DiklatRegistration $registration)
    {
        $registration->load('program');

        $category = strtolower(
            trim($registration->program?->category ?? '')
        );

        abort_if(
            !$registration->program ||
            in_array($category, ['pelatihan', 'orientasi']),
            404
        );

        return view(
            'admin.diklat.registrations.education.show',
            compact('registration')
        );
    }


    
    public function update(Request $request, DiklatRegistration $registration)
    {
        $validated = $request->validate([
            'status' => [
                'required',
                'in:diajukan,diverifikasi,diproses,selesai,ditolak',
            ],
            'admin_notes' => ['nullable', 'string', 'max:5000'],
            'admin_internal_notes' => ['nullable', 'string', 'max:5000'],
        ]);

        $registration->load('program');

        $category = strtolower(trim($registration->program?->category ?? ''));

        abort_if(
            !$registration->program ||
            in_array($category, ['pelatihan', 'orientasi']),
            404
        );

        DB::transaction(function () use ($registration, $validated) {
            $oldStatus = $registration->status;

            $registration->update([
                'status' => $validated['status'],
                'admin_notes' => $validated['admin_notes'] ?? null,
                'admin_internal_notes' => $validated['admin_internal_notes'] ?? null,
            ]);

            if ($oldStatus !== $validated['status']) {
                $registration->histories()->create([
                    'changed_by' => Auth::id(),
                    'old_status' => $oldStatus,
                    'new_status' => $validated['status'],
                    'public_note' => $validated['admin_notes'] ?? null,
                    'internal_note' => $validated['admin_internal_notes'] ?? null,
                ]);
            }
        });

        return back()->with('success', 'Perubahan pendaftaran berhasil disimpan.');
    }

    
    /**
     * Menampilkan daftar pendaftar program pelatihan.
     */
    public function trainingIndex(Request $request)
    {
        $selectedProgram = $request->query('program');
        $selectedStatus = $request->query('status');
        $search = $request->query('search');

        // Ambil seluruh program kategori Pelatihan.
        $programs = DiklatProgram::query()
            ->whereRaw("LOWER(TRIM(category)) = ?", ['pelatihan'])
            ->withCount('registrations')
            ->orderBy('name')
            ->get();

        // Ambil pendaftar berdasarkan program yang dipilih.
        $registrations = DiklatRegistration::with('program')
            ->whereHas('program', function ($query) {
                $query->whereRaw(
                    "LOWER(TRIM(category)) = ?",
                    ['pelatihan']
                );
            })
            ->when($selectedProgram, function ($query) use ($selectedProgram) {
                $query->where('diklat_program_id', $selectedProgram);
            })
            ->when($selectedStatus, function ($query) use ($selectedStatus) {
                $query->where('status', $selectedStatus);
            })
            ->when($search, function ($query) use ($search) {
                $query->where(function ($subQuery) use ($search) {
                    $subQuery->where('full_name', 'like', "%{$search}%")
                        ->orWhere('registration_number', 'like', "%{$search}%")
                        ->orWhere('institution', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->get();

        return view(
            'admin.diklat.registrations.training.index',
            compact(
                'registrations',
                'programs',
                'selectedProgram',
                'selectedStatus',
                'search'
            )
        );
    }


    /**
     * Menampilkan detail pendaftar program pelatihan.
     */
    public function trainingShow(DiklatRegistration $registration)
    {
        $registration->load('program');

        $category = strtolower(
            trim($registration->program?->category ?? '')
        );

        abort_if(
            !$registration->program || $category !== 'pelatihan',
            404
        );

        return view(
            'admin.diklat.registrations.training.show',
            compact('registration')
        );
    }

    /**
     * Memperbarui status dan catatan pendaftaran pelatihan.
     */
    public function trainingUpdate(
        Request $request,
        DiklatRegistration $registration
    ) {
        $validated = $request->validate([
            'status' => [
                'required',
                'in:diajukan,diverifikasi,diproses,selesai,ditolak',
            ],
            'admin_notes' => ['nullable', 'string', 'max:5000'],
            'admin_internal_notes' => ['nullable', 'string', 'max:5000'],
        ]);

        $registration->load('program');

        $category = strtolower(
            trim($registration->program?->category ?? '')
        );

        abort_if(
            !$registration->program || $category !== 'pelatihan',
            404
        );

        DB::transaction(function () use ($registration, $validated) {
            $oldStatus = $registration->status;

            $registration->update([
                'status' => $validated['status'],
                'admin_notes' => $validated['admin_notes'] ?? null,
                'admin_internal_notes' => $validated['admin_internal_notes'] ?? null,
            ]);

            if ($oldStatus !== $validated['status']) {
                $registration->histories()->create([
                    'changed_by' => Auth::id(),
                    'old_status' => $oldStatus,
                    'new_status' => $validated['status'],
                    'public_note' => $validated['admin_notes'] ?? null,
                    'internal_note' => $validated['admin_internal_notes'] ?? null,
                ]);
            }
        });

        return redirect()
            ->route('admin.diklat.registrations.training.show', $registration)
            ->with('success', 'Perubahan pendaftaran pelatihan berhasil disimpan.');
    }


    /**
     * Menampilkan bukti pembayaran pendaftaran pelatihan berbayar.
     */
    public function previewPaymentProof(DiklatRegistration $registration)
    {
        $path = $registration->payment_proof_path;

        abort_if(
            !$path || !Storage::disk('local')->exists($path),
            404,
            'Bukti pembayaran tidak ditemukan.'
        );

        $extension = strtolower(pathinfo($path, PATHINFO_EXTENSION));

        $mimeType = match ($extension) {
            'jpg', 'jpeg' => 'image/jpeg',
            'png' => 'image/png',
            default => 'application/pdf',
        };

        while (ob_get_level() > 0) {
            ob_end_clean();
        }

        return response()->file(
            Storage::disk('local')->path($path),
            [
                'Content-Type' => $mimeType,
                'Content-Disposition' => 'inline; filename="Bukti-Pembayaran-' . $registration->registration_number . '.' . $extension . '"',
                'X-Content-Type-Options' => 'nosniff',
            ]
        );
    }

    /**
     * Menampilkan preview surat permohonan praktik.
     */
    public function previewApplicationLetter(DiklatRegistration $registration)
    {
        $registration->load('program');

        $category = strtolower(
            trim($registration->program?->category ?? '')
        );

        abort_if(
            !$registration->program ||
            in_array($category, ['pelatihan', 'orientasi']),
            404
        );

        $path = $registration->application_letter_path;

        abort_if(
            !$path || !Storage::disk('local')->exists($path),
            404,
            'Dokumen surat permohonan tidak ditemukan.'
        );

        return Storage::disk('local')->response(
            $path,
            'Surat-Permohonan-' . $registration->registration_number . '.pdf',
            [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline',
                'X-Content-Type-Options' => 'nosniff',
            ]
        );
    }

    /**
     * Menampilkan atau mengunduh dokumen persyaratan pendukung.
     */
    public function previewDocument(DiklatRegistration $registration, string $type, ?int $index = null)
    {
        $fieldMap = [
            'surat-permohonan' => ['path' => 'application_letter_path', 'title' => 'Surat-Permohonan'],
            'daftar-peserta' => ['path' => 'participant_list_path', 'title' => 'Daftar-Peserta'],
            'pas-foto' => ['path' => 'id_photo_path', 'title' => 'Pas-Foto'],
            'asuransi' => ['path' => 'insurance_proof_path', 'title' => 'Bukti-Asuransi'],
            'berkas-str' => ['path' => 'str_file_path', 'title' => 'Berkas-STR'],
            'surat-tugas' => ['path' => 'assignment_letter_path', 'title' => 'Surat-Tugas'],
            'bukti-pembayaran' => ['path' => 'payment_proof_path', 'title' => 'Bukti-Pembayaran'],
        ];

        abort_unless(isset($fieldMap[$type]), 404);

        if ($type === 'pas-foto') {
            $photos = $registration->id_photos;
            if (!empty($photos)) {
                $idx = $index !== null ? (int) $index : 0;
                $path = $photos[$idx] ?? $photos[0] ?? null;
            } else {
                $path = $registration->id_photo_path;
            }
        } else {
            $path = $registration->{$fieldMap[$type]['path']};
        }

        abort_if(!$path || !Storage::disk('local')->exists($path), 404, 'Berkas dokumen tidak ditemukan.');

        $extension = strtolower(pathinfo($path, PATHINFO_EXTENSION));
        $mimeType = match ($extension) {
            'jpg', 'jpeg' => 'image/jpeg',
            'png' => 'image/png',
            'webp' => 'image/webp',
            'doc' => 'application/msword',
            'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'xls' => 'application/vnd.ms-excel',
            'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            default => 'application/pdf',
        };

        while (ob_get_level() > 0) {
            ob_end_clean();
        }

        $photoSuffix = ($type === 'pas-foto' && $index !== null) ? '-' . ($index + 1) : '';

        return response()->file(
            Storage::disk('local')->path($path),
            [
                'Content-Type' => $mimeType,
                'Content-Disposition' => 'inline; filename="' . $fieldMap[$type]['title'] . $photoSuffix . '-' . $registration->registration_number . '.' . $extension . '"',
                'X-Content-Type-Options' => 'nosniff',
            ]
        );
    }

}