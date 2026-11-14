<?php

namespace App\Modules\Content\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\DiklatProgram;
use App\Models\DiklatRegistration;
use App\Modules\Content\Services\DiklatRegistrationPdfService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Storage;

class DiklatRegistrationController extends Controller
{
    /**
     * Mencari pendaftaran aktif milik peserta untuk program yang sama.
     */
    private function findActiveRegistration(
        DiklatProgram $program,
        string $email,
        string $phone
    ) {
        return DiklatRegistration::query()
            ->where('diklat_program_id', $program->id)
            ->whereRaw('LOWER(email) = ?', [strtolower(trim($email))])
            ->where('phone', trim($phone))
            ->whereNotIn('status', ['selesai', 'ditolak'])
            ->whereNotNull('access_token')
            ->latest('id')
            ->first();
    }

    /**
     * Menampilkan formulir pendaftaran.
     */
    public function create(DiklatProgram $program)
    {
        abort_unless($program->is_active, 404);

        if (!$program->requires_registration) {
            return redirect()
                ->route('information.diklat.detail', $program->id)
                ->with(
                    'info',
                    'Program ini tidak memerlukan pendaftaran online.'
                );
        }

        $category = strtolower(trim($program->category ?? ''));
        $isEducation = !in_array($category, ['pelatihan', 'orientasi']);

        if (
            !in_array($program->status, ['dibuka', 'terbatas']) ||
            (!$isEducation && $program->remaining_quota <= 0)
        ) {
            return redirect()
                ->route('information.education')
                ->with(
                    'error',
                    'Pendaftaran program ini sudah ditutup atau kuotanya penuh.'
                );
        }

        return view(
            'public.information.diklat-registration',
            compact('program')
        );
    }

    /**
     * Menyimpan pengajuan pendaftaran.
     */
    public function store(Request $request, DiklatProgram $program)
    {
        abort_unless($program->is_active, 404);

        if (!$program->requires_registration) {
            return redirect()
                ->route('information.diklat.detail', $program->id)
                ->with(
                    'info',
                    'Program ini tidak memerlukan pendaftaran online.'
                );
        }

        $category = strtolower(trim($program->category ?? ''));
        $isEducation = !in_array($category, ['pelatihan', 'orientasi']);

        // Validasi dasar yang digunakan semua kategori.
        $rules = [
            'full_name' => ['required', 'string', 'max:255'],
            'institution' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:25'],
            'email' => ['required', 'email', 'max:255'],
            'purpose' => ['nullable', 'string', 'max:3000'],
        ];

        $messages = [
            'full_name.required' => 'Nama lengkap wajib diisi.',
            'institution.required' => 'Instansi asal wajib diisi.',
            'phone.required' => 'Nomor HP/WhatsApp wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',

            'study_program.required' => 'Program studi wajib diisi.',
            'education_level.required' => 'Jenjang pendidikan wajib dipilih.',
            'education_level.in' => 'Jenjang pendidikan yang dipilih tidak valid.',
            
            'practice_start_date.required' => 'Tanggal mulai wajib diisi.',
            'practice_end_date.required' => 'Tanggal selesai wajib diisi.',
            'practice_end_date.after_or_equal' => 'Tanggal selesai tidak boleh sebelum tanggal mulai.',

            'application_letter.required' => 'Surat Permohonan wajib diunggah.',
            'application_letter.file' => 'File surat yang diunggah tidak valid.',
            'application_letter.mimes' => 'Surat Permohonan harus berformat PDF.',
            'application_letter.max' => 'Ukuran surat maksimal 5 MB.',
        ];

        // Field tambahan khusus pendidikan/praktik klinis.
        $hasPhotoArray = is_array($request->file('id_photo'));

        if ($isEducation) {
            $rules = array_merge($rules, [
                'study_program' => ['required', 'string', 'max:255'],
                'education_level' => [
                    'required',
                    'in:SMA/SMK,Akademi/Diploma,Diploma IV/Strata I',
                ],
                'practice_type' => ['nullable', 'string', 'max:100'],
                'practice_start_date' => ['required', 'date'],
                'practice_end_date' => [
                    'required',
                    'date',
                    'after_or_equal:practice_start_date',
                ],
                'profession' => ['nullable', 'string', 'max:255'],
                'position' => ['nullable', 'string', 'max:255'],
                'application_letter' => [
                    'required',
                    'file',
                    'mimes:pdf',
                    'max:5120',
                ],
                'participant_list' => [
                    'required',
                    'file',
                    'mimes:pdf,doc,docx,xls,xlsx',
                    'max:5120',
                ],
                'id_photo' => $hasPhotoArray
                    ? ['required', 'array', 'min:1']
                    : ['required', 'file', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
                'id_photo.*' => [
                    'file',
                    'mimes:jpg,jpeg,png,webp',
                    'max:5120',
                ],
            ]);

            $messages = array_merge($messages, [
                'participant_list.required' => 'Daftar nama calon mahasiswa & NIM wajib diunggah.',
                'participant_list.file' => 'Berkas daftar nama mahasiswa tidak valid.',
                'participant_list.mimes' => 'Daftar nama mahasiswa harus berformat PDF, Word (.doc/.docx), atau Excel (.xls/.xlsx).',
                'participant_list.max' => 'Ukuran berkas daftar nama mahasiswa maksimal 5 MB.',
                'id_photo.required' => 'Pas foto formal berlatar warna dengan seragam almamater wajib diunggah.',
                'id_photo.file' => 'Berkas pas foto tidak valid.',
                'id_photo.mimes' => 'Pas foto harus berformat JPG, JPEG, PNG, atau WEBP.',
                'id_photo.max' => 'Ukuran berkas pas foto maksimal 5 MB.',
                'id_photo.*.file' => 'Salah satu berkas pas foto tidak valid.',
                'id_photo.*.mimes' => 'Setiap pas foto harus berformat JPG, JPEG, PNG, atau WEBP.',
                'id_photo.*.max' => 'Ukuran setiap pas foto maksimal 5 MB.',
            ]);
        } else {
            // Field khusus pelatihan / nakes
            $rules = array_merge($rules, [
                'str_number' => ['nullable', 'string', 'max:100'],
                'str_file' => [
                    'nullable',
                    'file',
                    'mimes:pdf,jpg,jpeg,png',
                    'max:5120',
                ],
                'satusehat_id' => ['nullable', 'string', 'max:100'],
                'assignment_letter' => [
                    'nullable',
                    'file',
                    'mimes:pdf,jpg,jpeg,png',
                    'max:5120',
                ],
                'id_photo' => $hasPhotoArray
                    ? ['nullable', 'array']
                    : ['nullable', 'file', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
                'id_photo.*' => [
                    'file',
                    'mimes:jpg,jpeg,png,webp',
                    'max:5120',
                ],
            ]);

            $messages = array_merge($messages, [
                'str_file.file' => 'Berkas STR tidak valid.',
                'str_file.mimes' => 'Berkas STR harus berformat PDF, JPG, atau PNG.',
                'str_file.max' => 'Ukuran berkas STR maksimal 5 MB.',
                'assignment_letter.file' => 'Surat tugas/rekomendasi tidak valid.',
                'assignment_letter.mimes' => 'Surat tugas/rekomendasi harus berformat PDF, JPG, atau PNG.',
                'assignment_letter.max' => 'Ukuran surat tugas/rekomendasi maksimal 5 MB.',
                'id_photo.file' => 'Berkas pas foto tidak valid.',
                'id_photo.mimes' => 'Pas foto harus berformat JPG, JPEG, PNG, atau WEBP.',
                'id_photo.max' => 'Ukuran berkas pas foto maksimal 5 MB.',
                'id_photo.*.file' => 'Salah satu berkas pas foto tidak valid.',
                'id_photo.*.mimes' => 'Setiap pas foto harus berformat JPG, JPEG, PNG, atau WEBP.',
                'id_photo.*.max' => 'Ukuran setiap pas foto maksimal 5 MB.',
            ]);
        }

        // Bukti pembayaran wajib untuk pelatihan berbayar.
        $requiresPayment = !$isEducation && (bool) $program->is_paid;

        if ($requiresPayment) {
            $rules['payment_proof'] = [
                'required',
                'file',
                'mimes:jpg,jpeg,png,pdf',
                'max:5120',
            ];
            $rules['payment_sender_name'] = ['required', 'string', 'max:255'];
            $rules['payment_sender_account_number'] = ['required', 'string', 'max:100'];
            $rules['payment_sender_bank'] = ['nullable', 'string', 'max:100'];

            $messages['payment_proof.required'] = 'Bukti pembayaran wajib diunggah.';
            $messages['payment_proof.file'] = 'File bukti pembayaran tidak valid.';
            $messages['payment_proof.mimes'] = 'Bukti pembayaran harus berformat JPG, PNG, atau PDF.';
            $messages['payment_proof.max'] = 'Ukuran bukti pembayaran maksimal 5 MB.';
            $messages['payment_sender_name.required'] = 'Nama pemilik rekening pengirim wajib diisi.';
            $messages['payment_sender_account_number.required'] = 'Nomor rekening pengirim wajib diisi.';
        }

        $validated = $request->validate($rules, $messages);

        $activeRegistration = $this->findActiveRegistration(
            $program,
            $validated['email'],
            $validated['phone']
        );

        if ($activeRegistration) {
            return redirect()->route(
                'information.diklat.registration.success',
                ['registrationNumber' => $activeRegistration->registration_number]
            )->with(
                'info',
                'Kamu sudah memiliki pendaftaran aktif untuk program ini. Berikut tanda terima bukti pengajuan Anda.'
            );
        }

        $applicationLetterPath = null;
        $participantListPath = null;
        $insuranceProofPath = null;
        $idPhotoPaths = [];
        $strFilePath = null;
        $assignmentLetterPath = null;
        $paymentProofPath = null;

        try {
            $registration = DB::transaction(function () use (
                $program,
                $validated,
                $isEducation,
                $request,
                $requiresPayment,
                &$applicationLetterPath,
                &$participantListPath,
                &$insuranceProofPath,
                &$idPhotoPaths,
                &$strFilePath,
                &$assignmentLetterPath,
                &$paymentProofPath
            ) {
                $lockedProgram = DiklatProgram::whereKey($program->id)
                    ->lockForUpdate()
                    ->firstOrFail();

                $category = strtolower(trim($lockedProgram->category ?? ''));

                $lockedIsEducation = !in_array(
                    $category,
                    ['pelatihan', 'orientasi']
                );

                if (
                    !$lockedProgram->is_active ||
                    !in_array($lockedProgram->status, ['dibuka', 'terbatas']) ||
                    (!$lockedIsEducation && $lockedProgram->remaining_quota <= 0)
                ) {
                    throw ValidationException::withMessages([
                        'program' => 'Pendaftaran program ini sudah ditutup atau kuotanya penuh.',
                    ]);
                }

                do {
                    $number = 'DKL-' . now()->format('Ymd') . '-'
                        . Str::upper(Str::random(6));
                } while (
                    DiklatRegistration::where('registration_number', $number)->exists()
                );

                $accessToken = Str::random(64);

                $data = [
                    'diklat_program_id' => $lockedProgram->id,
                    'registration_number' => $number,
                    'access_token' => $accessToken,
                    'full_name' => $validated['full_name'],
                    'institution' => $validated['institution'],
                    'phone' => $validated['phone'],
                    'email' => $validated['email'],
                    'purpose' => $validated['purpose'] ?? null,
                    'status' => 'diajukan',
                ];

                if ($isEducation && $lockedIsEducation) {
                    $data = array_merge($data, [
                        'study_program' => $validated['study_program'],
                        'education_level' => $validated['education_level'],
                        'practice_type' => $validated['practice_type'] ?? null,
                        'practice_start_date' => $validated['practice_start_date'],
                        'practice_end_date' => $validated['practice_end_date'],
                        'profession' => $validated['profession'] ?? null,
                        'position' => $validated['position'] ?? null,
                    ]);

                    if ($request->hasFile('application_letter')) {
                        $applicationLetterPath = $request->file('application_letter')
                            ->store('diklat/application-letters', 'local');
                        $data['application_letter_path'] = $applicationLetterPath;
                    }

                    if ($request->hasFile('participant_list')) {
                        $participantListPath = $request->file('participant_list')
                            ->store('diklat/participant-lists', 'local');
                        $data['participant_list_path'] = $participantListPath;
                    }

                    if ($request->hasFile('insurance_proof')) {
                        $insuranceProofPath = $request->file('insurance_proof')
                            ->store('diklat/insurance-proofs', 'local');
                        $data['insurance_proof_path'] = $insuranceProofPath;
                    }
                } else {
                    $data['practice_start_date'] = $lockedProgram->start_at?->toDateString();
                    $data['practice_end_date'] = $lockedProgram->end_at?->toDateString();
                    $data['str_number'] = $validated['str_number'] ?? null;
                    $data['satusehat_id'] = $validated['satusehat_id'] ?? null;

                    if ($request->hasFile('str_file')) {
                        $strFilePath = $request->file('str_file')
                            ->store('diklat/str-files', 'local');
                        $data['str_file_path'] = $strFilePath;
                    }

                    if ($request->hasFile('assignment_letter')) {
                        $assignmentLetterPath = $request->file('assignment_letter')
                            ->store('diklat/assignment-letters', 'local');
                        $data['assignment_letter_path'] = $assignmentLetterPath;
                    }
                }

                // Simpan pas foto (mendukung single atau banyak foto sekaligus)
                if ($request->hasFile('id_photo')) {
                    $uploadedPhotos = $request->file('id_photo');
                    $uploadedPhotos = is_array($uploadedPhotos) ? $uploadedPhotos : [$uploadedPhotos];
                    foreach ($uploadedPhotos as $photo) {
                        if ($photo && $photo->isValid()) {
                            $idPhotoPaths[] = $photo->store('diklat/id-photos', 'local');
                        }
                    }
                    if (!empty($idPhotoPaths)) {
                        $data['id_photo_path'] = count($idPhotoPaths) > 1
                            ? json_encode($idPhotoPaths)
                            : $idPhotoPaths[0];
                    }
                }

                if ($requiresPayment && !$lockedIsEducation && $lockedProgram->is_paid) {
                    $paymentProofPath = $request->file('payment_proof')
                        ->store('diklat/payment-proofs', 'local');

                    if (!$paymentProofPath) {
                        throw new \RuntimeException(
                            'Gagal menyimpan bukti pembayaran.'
                        );
                    }

                    $data['payment_proof_path'] = $paymentProofPath;
                    $data['payment_sender_name'] = $validated['payment_sender_name'] ?? null;
                    $data['payment_sender_account_number'] = $validated['payment_sender_account_number'] ?? null;
                    $data['payment_sender_bank'] = $validated['payment_sender_bank'] ?? null;
                }

                return DiklatRegistration::create($data);
            });
        } catch (\Throwable $e) {
            $disk = Storage::disk('local');
            if ($applicationLetterPath) $disk->delete($applicationLetterPath);
            if ($participantListPath) $disk->delete($participantListPath);
            if ($insuranceProofPath) $disk->delete($insuranceProofPath);
            foreach ($idPhotoPaths as $photoPath) {
                if ($photoPath) $disk->delete($photoPath);
            }
            if ($strFilePath) $disk->delete($strFilePath);
            if ($assignmentLetterPath) $disk->delete($assignmentLetterPath);
            if ($paymentProofPath) $disk->delete($paymentProofPath);

            throw $e;
        }

        return redirect()->route(
            'information.diklat.registration.success',
            ['registrationNumber' => $registration->registration_number]
        )->with('success', 'Pendaftaran program Diklat berhasil dikirim!');
    }

    /**
     * Halaman konfirmasi pengajuan berhasil (Tanda Terima & Unduh Bukti PDF).
     */
    public function success(string $registrationNumber)
    {
        $registration = DiklatRegistration::with('program')
            ->where('registration_number', $registrationNumber)
            ->firstOrFail();

        return view(
            'public.information.diklat-registration-success',
            compact('registration')
        );
    }

    /**
     * Unduh / cetak lembar bukti pendaftaran resmi berformat PDF.
     */
    public function downloadProof(string $registrationNumber, DiklatRegistrationPdfService $pdfService)
    {
        $registration = DiklatRegistration::with('program')
            ->where('registration_number', $registrationNumber)
            ->orWhere('access_token', $registrationNumber)
            ->firstOrFail();

        $pdfContent = $pdfService->generate($registration);
        $filename = 'Bukti-Pendaftaran-' . $registration->registration_number . '.pdf';

        return response($pdfContent, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Content-Length' => strlen($pdfContent),
        ]);
    }

    /**
     * Halaman Lacak Pendaftaran Diklat Publik (Pencarian Tiket & Timeline Status).
     */
    public function track(Request $request)
    {
        $ticketNumber = trim($request->input('nomor', $request->input('ticket_number', '')));
        $registration = null;
        $searched = false;

        if (!empty($ticketNumber)) {
            $searched = true;
            $registration = DiklatRegistration::with('program')
                ->where('registration_number', $ticketNumber)
                ->orWhere('access_token', $ticketNumber)
                ->first();
        }

        return view(
            'public.information.diklat-track',
            compact('ticketNumber', 'registration', 'searched')
        );
    }

    /**
     * Menampilkan status pendaftaran berdasarkan token akses (diarahkan ke bukti pendaftaran sukses).
     */
    public function statusByToken(string $token)
    {
        $registration = DiklatRegistration::where('access_token', $token)->first();
        if ($registration) {
            return redirect()->route('information.diklat.registration.success', [
                'registrationNumber' => $registration->registration_number
            ]);
        }
        return redirect()->route('information.diklat.track', ['nomor' => $token]);
    }

    /**
     * Konfirmasi penyelesaian pendaftaran Diklat.
     */
    public function confirmCompletion(string $token)
    {
        $registration = DiklatRegistration::where('access_token', $token)
            ->firstOrFail();

        // Konfirmasi hanya tersedia jika admin sudah menyatakan selesai.
        if ($registration->status !== 'selesai') {
            return back()->with(
                'error',
                'Pendaftaran belum dinyatakan selesai oleh admin.'
            );
        }

        // Jangan menimpa tanggal konfirmasi yang sudah tersimpan.
        if (!$registration->completion_confirmed_at) {
            $registration->completion_confirmed_at = now();
            $registration->save();
        }

        return redirect()
            ->route('information.diklat.registration.create', [
                'program' => $registration->diklat_program_id
            ])
            ->with(
                'success',
                'Penyelesaian program berhasil dikonfirmasi. Silakan mengisi formulir pendaftaran kembali.'
            );
    }
    
    /**
     * Menampilkan halaman riwayat pendaftaran.
     */
    public function history()
    {
        return view('public.information.diklat-registration-history');
    }

    /**
     * Mencari riwayat pendaftaran berdasarkan token yang tersimpan
     * pada browser peserta.
     */
    public function historyLookup(Request $request)
    {
        $validated = $request->validate([
            'tokens' => ['required', 'array', 'max:100'],
            'tokens.*' => ['required', 'string', 'size:64'],
        ]);

        $registrations = DiklatRegistration::with('program')
            ->whereIn('access_token', array_unique($validated['tokens']))
            ->latest('id')
            ->get()
            ->map(function ($registration) {
                return [
                    'token' => $registration->access_token,
                    'registration_number' => $registration->registration_number,
                    'program_name' => $registration->program?->title
                        ?? $registration->program?->name
                        ?? 'Program Diklat',
                    'full_name' => $registration->full_name,
                    'status' => $registration->status,
                    'completion_confirmed' => !is_null(
                        $registration->completion_confirmed_at
                    ),
                    'status_url' => route(
                        'information.diklat.registration.status',
                        $registration->access_token
                    ),
                ];
            })
            ->values();

        return response()->json([
            'registrations' => $registrations,
        ]);
    }
}
