<?php

namespace App\Modules\Content\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DiklatProgram;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class AdminDiklatProgramController extends Controller
{
    private function authorizePage(Page $page): void
    {
        abort_unless($page->slug === 'pendidikan-pelatihan', 404);
    }

    /**
     * Simpan gambar yang diunggah dan konversi otomatis ke format WebP
     * dengan lebar maksimal proporsional agar hemat ruang penyimpanan hosting.
     */
    private function storeAsWebp(UploadedFile $file, string $directory, int $maxWidth = 1200, int $quality = 80): string
    {
        $mime = $file->getMimeType();
        $extension = strtolower($file->getClientOriginalExtension());

        // Jika dokumen adalah PDF atau server tidak mendukung fungsi imagewebp, simpan file asli
        if ($extension === 'pdf' || $mime === 'application/pdf' || ! function_exists('imagewebp')) {
            return $file->store($directory, 'public');
        }

        $sourcePath = $file->getRealPath();
        $image = match (true) {
            in_array($mime, ['image/jpeg', 'image/jpg', 'image/pjpeg']) || in_array($extension, ['jpg', 'jpeg']) => @imagecreatefromjpeg($sourcePath),
            in_array($mime, ['image/png', 'image/x-png']) || $extension === 'png' => @imagecreatefrompng($sourcePath),
            $mime === 'image/webp' || $extension === 'webp' => function_exists('imagecreatefromwebp') ? @imagecreatefromwebp($sourcePath) : null,
            default => null,
        };

        if (! $image) {
            return $file->store($directory, 'public');
        }

        $origWidth = imagesx($image);
        $origHeight = imagesy($image);

        if ($origWidth > $maxWidth && $origWidth > 0 && $origHeight > 0) {
            $newWidth = $maxWidth;
            $newHeight = (int) round(($origHeight / $origWidth) * $newWidth);
            $resized = imagecreatetruecolor($newWidth, $newHeight);
            imagealphablending($resized, false);
            imagesavealpha($resized, true);
            $transparent = imagecolorallocatealpha($resized, 0, 0, 0, 127);
            imagefilledrectangle($resized, 0, 0, $newWidth, $newHeight, $transparent);
            imagecopyresampled($resized, $image, 0, 0, 0, 0, $newWidth, $newHeight, $origWidth, $origHeight);
            imagedestroy($image);
            $image = $resized;
        } else {
            imagepalettetotruecolor($image);
            imagealphablending($image, true);
            imagesavealpha($image, true);
        }

        $filename = Str::random(40) . '.webp';
        $relativePath = trim($directory, '/') . '/' . $filename;
        $fullPath = Storage::disk('public')->path($relativePath);

        $dir = dirname($fullPath);
        if (! is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        $saved = imagewebp($image, $fullPath, $quality);
        imagedestroy($image);

        if (! $saved) {
            return $file->store($directory, 'public');
        }

        return $relativePath;
    }

    private function sanitizeProgramInputs(Request $request): void
    {
        $merge = [];

        if ($request->filled('fee')) {
            $cleanFee = preg_replace('/[^0-9]/', '', (string) $request->input('fee'));
            $merge['fee'] = $cleanFee !== '' ? (int) $cleanFee : null;
        }

        foreach (['start_at', 'end_at'] as $dateField) {
            if ($request->filled($dateField)) {
                $merge[$dateField] = preg_replace(
                    '/:(st|nd|rd|th)$/i',
                    ':00',
                    trim((string) $request->input($dateField))
                );
            }
        }

        if (! empty($merge)) {
            $request->merge($merge);
        }
    }

    public function store(Request $request, Page $page)
    {
        $this->authorizePage($page);
        $this->sanitizeProgramInputs($request);

        $needsQuota = $request->input('category') === 'Pelatihan'
            && $request->boolean('requires_registration');

        $data = $request->validate([
            'category' => ['required', Rule::in(['Pendidikan', 'Pelatihan'])],
            'name' => ['required', 'string', 'max:255'],
            'target' => ['nullable', 'string', 'max:5000'],
            'target_description' => ['nullable', 'string'],
            'description' => ['nullable', 'string', 'max:5000'],
            'objectives' => ['nullable', 'string'],
            'materials' => ['nullable', 'string'],
            'requirements' => ['nullable', 'string'],
            'facilities' => ['nullable', 'string'],
            'skp_points' => ['nullable', 'string', 'max:100'],
            'contact_person' => ['nullable', 'string', 'max:255'],
            'flyer_image' => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp,pdf', 'max:5120'],
            'image' => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp', 'max:1024'],

            // Informasi pelaksanaan untuk kedua kategori
            'method' => ['nullable', Rule::in(['Luring', 'Daring', 'Hybrid'])],
            'location' => ['nullable', 'string', 'max:255'],
            'schedule' => ['nullable', 'string', 'max:1000'],
            'duration' => ['nullable', 'string', 'max:255'],
            'start_at' => ['nullable', 'date'],
            'end_at' => [
                'nullable',
                'date',
                Rule::when(
                    $request->filled('start_at'),
                    ['after_or_equal:start_at']
                ),
            ],

            // Pengaturan pendaftaran untuk kedua kategori
            'requires_registration' => ['required', 'boolean'],
            'requires_assignment_letter' => ['nullable', 'boolean'],
            'requires_str_file' => ['nullable', 'boolean'],
            'requires_id_photo' => ['nullable', 'boolean'],

            // Kuota dan status hanya wajib jika pendaftaran diperlukan
            'quota' => [
                'nullable',
                Rule::requiredIf($needsQuota),
                'integer',
                'min:0',
            ],
            'status' => [
                'nullable',
                Rule::requiredIf($needsQuota),
                Rule::in(['dibuka', 'terbatas', 'penuh', 'ditutup']),
            ],

            // Pengaturan biaya dan sasaran peserta
            'is_paid' => ['nullable', 'boolean'],
            'fee' => [
                'nullable',
                Rule::requiredIf(fn () => $request->boolean('requires_registration') && $request->boolean('is_paid')),
                'integer',
                'min:0',
            ],
            'payment_bank_name' => ['nullable', Rule::requiredIf(fn () => $request->boolean('requires_registration') && $request->boolean('is_paid')), 'string', 'max:100'],
            'payment_account_number' => ['nullable', Rule::requiredIf(fn () => $request->boolean('requires_registration') && $request->boolean('is_paid')), 'string', 'max:50'],
            'payment_account_name' => ['nullable', Rule::requiredIf(fn () => $request->boolean('requires_registration') && $request->boolean('is_paid')), 'string', 'max:255'],
            'participant_target' => [
                'nullable',
                Rule::in(['publik', 'internal', 'keduanya']),
            ],

            'is_active' => ['nullable', 'boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ], [
            'flyer_image.max' => 'Ukuran berkas brosur / flyer maksimal 5 MB.',
            'flyer_image.mimes' => 'Format brosur / flyer harus berupa PDF, JPG, JPEG, PNG, atau WEBP.',
            'image.max' => 'Ukuran gambar / banner kartu program maksimal 5 MB.',
            'image.mimes' => 'Format gambar / banner kartu program harus berupa JPG, JPEG, PNG, atau WEBP.',
        ]);

        // Sasaran diselaraskan dari Deskripsi Sasaran
        if (!empty($data['target_description'])) {
            $data['target'] = $data['target_description'];
        }

        // Pengaturan pelaksanaan khusus kategori Pendidikan.
        if ($data['category'] === 'Pendidikan') {
            $data['method'] = $data['method'] ?? 'Luring';
            $data['location'] = $data['location'] ?? 'RSUD R.A.A Tjokronegoro';
            $data['schedule'] = !empty($data['schedule']) ? $data['schedule'] : 'Sesuai pengajuan dan persetujuan rumah sakit';
            $data['duration'] = !empty($data['duration']) ? $data['duration'] : 'Sesuai ketentuan program dan institusi mitra';
            $data['participant_target'] = 'publik';
            $data['requires_registration'] = true;
            $data['quota'] = 0;
            $data['remaining_quota'] = 0;
            $data['status'] = 'dibuka';
            $data['is_paid'] = false;
            $data['fee'] = null;
            $data['payment_bank_name'] = null;
            $data['payment_account_number'] = null;
            $data['payment_account_name'] = null;
        } else {
            // Normalisasi pilihan pendaftaran.
            $data['requires_registration'] = $request->boolean(
                'requires_registration'
            );
            $data['requires_assignment_letter'] = $request->boolean('requires_assignment_letter', true);
            $data['requires_str_file'] = $request->boolean('requires_str_file', false);
            $data['requires_id_photo'] = $request->boolean('requires_id_photo', false);

            if ($needsQuota) {
                $data['quota'] = (int) ($data['quota'] ?? 0);
                $data['remaining_quota'] = $data['quota'];
                $data['status'] = $data['status'] ?? 'dibuka';

                if ($data['quota'] === 0 && in_array($data['status'], ['dibuka', 'terbatas'])) {
                    $data['status'] = 'penuh';
                }
            } else {
                // Kegiatan tanpa pendaftaran atau non-quota tidak menggunakan kuota.
                $data['quota'] = 0;
                $data['remaining_quota'] = 0;
                $data['status'] = 'dibuka';
            }

            // Normalisasi pengaturan biaya: Jika tanpa pendaftaran, kegiatan selalu gratis / tanpa biaya.
            if (! $data['requires_registration']) {
                $data['is_paid'] = false;
                $data['fee'] = null;
                $data['payment_bank_name'] = null;
                $data['payment_account_number'] = null;
                $data['payment_account_name'] = null;
            } else {
                $data['is_paid'] = $request->boolean('is_paid');
                $data['fee'] = $data['is_paid']
                    ? $data['fee']
                    : null;

                if (! $data['is_paid']) {
                    $data['payment_bank_name'] = null;
                    $data['payment_account_number'] = null;
                    $data['payment_account_name'] = null;
                }
            }
        }

        $data['participant_target'] =
            $data['participant_target'] ?? 'publik';

        $data['is_active'] = $request->boolean('is_active');
        $data['sort_order'] = $data['sort_order'] ?? 0;

        // Jika mode 1 hari dipilih, tanggal selesai disamakan dengan tanggal mulai
        if ($request->input('date_mode') === 'single' && ! empty($data['start_at'])) {
            $data['end_at'] = $data['start_at'];
        }

        if (! empty($data['start_at'])) {
            $data['start_at'] = \Carbon\Carbon::parse($data['start_at'])->startOfDay();
        }
        if (! empty($data['end_at'])) {
            $data['end_at'] = \Carbon\Carbon::parse($data['end_at'])->endOfDay();
        }
        $data['duration'] = $data['duration'] ?? null;

        if ($request->hasFile('flyer_image')) {
            $data['flyer_image'] = $this->storeAsWebp($request->file('flyer_image'), 'diklat/flyers', 1600, 82);
        }
        if ($request->hasFile('image')) {
            $data['image'] = $this->storeAsWebp($request->file('image'), 'diklat/images', 1200, 80);
        }

        DiklatProgram::create($data);

        return redirect()
            ->route('admin.pages.edit', $page)
            ->with('success', 'Program Diklat berhasil ditambahkan.');
    }

    public function edit(Page $page, DiklatProgram $program)
    {
        $this->authorizePage($page);

        return redirect()->to(
            route('admin.pages.edit', $page)
            . '?edit_diklat_program=' . $program->id
            . '#diklat-program'
        );
    }

   
    public function update(
        Request $request,
        Page $page,
        DiklatProgram $program
    ) {
        $this->authorizePage($page);
        $this->sanitizeProgramInputs($request);

        // Kuota hanya diperlukan untuk Pelatihan yang memerlukan pendaftaran.
        $needsQuota = $request->input('category') === 'Pelatihan'
            && $request->boolean('requires_registration');

        $data = $request->validate([
            'category' => [
                'required',
                Rule::in(['Pendidikan', 'Pelatihan']),
            ],
            'name' => ['required', 'string', 'max:255'],
            'target' => ['nullable', 'string', 'max:5000'],
            'target_description' => ['nullable', 'string'],
            'description' => ['nullable', 'string', 'max:5000'],
            'objectives' => ['nullable', 'string'],
            'materials' => ['nullable', 'string'],
            'requirements' => ['nullable', 'string'],
            'facilities' => ['nullable', 'string'],
            'skp_points' => ['nullable', 'string', 'max:100'],
            'contact_person' => ['nullable', 'string', 'max:255'],
            'flyer_image' => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp,pdf', 'max:5120'],
            'image' => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp', 'max:1024'],
            'remove_flyer_image' => ['nullable', 'boolean'],
            'delete_image' => ['nullable', 'boolean'],

            // Informasi pelaksanaan
            'method' => [
                'nullable',
                Rule::in(['Luring', 'Daring', 'Hybrid']),
            ],
            'location' => ['nullable', 'string', 'max:255'],
            'schedule' => ['nullable', 'string', 'max:1000'],
            'duration' => ['nullable', 'string', 'max:255'],
            'start_at' => ['nullable', 'date'],
            'end_at' => [
                'nullable',
                'date',
                Rule::when(
                    $request->filled('start_at'),
                    ['after_or_equal:start_at']
                ),
            ],

            // Pengaturan pendaftaran
            'requires_registration' => ['required', 'boolean'],
            'requires_assignment_letter' => ['nullable', 'boolean'],
            'requires_str_file' => ['nullable', 'boolean'],
            'requires_id_photo' => ['nullable', 'boolean'],

            // Kuota hanya wajib untuk Pelatihan dengan pendaftaran.
            'quota' => [
                'nullable',
                Rule::requiredIf($needsQuota),
                'integer',
                'min:0',
            ],
            'status' => [
                'nullable',
                Rule::requiredIf($needsQuota),
                Rule::in(['dibuka', 'terbatas', 'penuh', 'ditutup']),
            ],

            // Biaya dan sasaran peserta
            'is_paid' => ['nullable', 'boolean'],
            'fee' => [
                'nullable',
                Rule::requiredIf(fn () => $request->boolean('requires_registration') && $request->boolean('is_paid')),
                'integer',
                'min:0',
            ],
            'payment_bank_name' => ['nullable', Rule::requiredIf(fn () => $request->boolean('requires_registration') && $request->boolean('is_paid')), 'string', 'max:100'],
            'payment_account_number' => ['nullable', Rule::requiredIf(fn () => $request->boolean('requires_registration') && $request->boolean('is_paid')), 'string', 'max:50'],
            'payment_account_name' => ['nullable', Rule::requiredIf(fn () => $request->boolean('requires_registration') && $request->boolean('is_paid')), 'string', 'max:255'],
            'participant_target' => [
                'nullable',
                Rule::in(['publik', 'internal', 'keduanya']),
            ],

            // Publikasi
            'is_active' => ['nullable', 'boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ], [
            'flyer_image.max' => 'Ukuran berkas brosur / flyer maksimal 5 MB.',
            'flyer_image.mimes' => 'Format brosur / flyer harus berupa PDF, JPG, JPEG, PNG, atau WEBP.',
            'image.max' => 'Ukuran gambar / banner kartu program maksimal 5 MB.',
            'image.mimes' => 'Format gambar / banner kartu program harus berupa JPG, JPEG, PNG, atau WEBP.',
        ]);

        // Sasaran diselaraskan dari Deskripsi Sasaran
        if (!empty($data['target_description'])) {
            $data['target'] = $data['target_description'];
        }

        // Pengaturan pelaksanaan khusus kategori Pendidikan.
        if ($data['category'] === 'Pendidikan') {
            $data['method'] = $data['method'] ?? 'Luring';
            $data['location'] = $data['location'] ?? 'RSUD R.A.A Tjokronegoro';
            $data['schedule'] = !empty($data['schedule']) ? $data['schedule'] : 'Sesuai pengajuan dan persetujuan rumah sakit';
            $data['duration'] = !empty($data['duration']) ? $data['duration'] : 'Sesuai ketentuan program dan institusi mitra';
            $data['participant_target'] = 'publik';
            $data['requires_registration'] = true;
            $data['quota'] = 0;
            $data['remaining_quota'] = 0;
            $data['status'] = 'dibuka';
            $data['is_paid'] = false;
            $data['fee'] = null;
            $data['payment_bank_name'] = null;
            $data['payment_account_number'] = null;
            $data['payment_account_name'] = null;
        } else {
            // Normalisasi pendaftaran.
            $data['requires_registration'] = $request->boolean(
                'requires_registration'
            );
            $data['requires_assignment_letter'] = $request->boolean('requires_assignment_letter');
            $data['requires_str_file'] = $request->boolean('requires_str_file');
            $data['requires_id_photo'] = $request->boolean('requires_id_photo');

            // Pengaturan kuota.
            if ($needsQuota) {
                $data['quota'] = (int) ($data['quota'] ?? 0);
                $registeredCount = $program->registrations()
                    ->where('status', '!=', 'ditolak')
                    ->count();
                $data['remaining_quota'] = max(0, $data['quota'] - $registeredCount);
                $data['status'] = $data['status'] ?? 'dibuka';

                if ($data['remaining_quota'] === 0 && in_array($data['status'], ['dibuka', 'terbatas'])) {
                    $data['status'] = 'penuh';
                } elseif ($data['remaining_quota'] > 0 && $data['status'] === 'penuh') {
                    $data['status'] = 'dibuka';
                }
            } else {
                $data['quota'] = 0;
                $data['remaining_quota'] = 0;
                $data['status'] = 'dibuka';
            }

            // Normalisasi biaya: jika tanpa pendaftaran, kegiatan selalu gratis / tanpa biaya.
            if (! $data['requires_registration']) {
                $data['is_paid'] = false;
                $data['fee'] = null;
                $data['payment_bank_name'] = null;
                $data['payment_account_number'] = null;
                $data['payment_account_name'] = null;
            } else {
                $data['is_paid'] = $request->boolean('is_paid');

                $data['fee'] = $data['is_paid']
                    ? $data['fee']
                    : null;

                if (! $data['is_paid']) {
                    $data['payment_bank_name'] = null;
                    $data['payment_account_number'] = null;
                    $data['payment_account_name'] = null;
                }
            }
        }

        // Sasaran peserta.
        $data['participant_target'] =
            $data['participant_target'] ?? 'publik';

        // Checkbox tidak dicentang berarti nonaktif.
        $data['is_active'] = $request->boolean('is_active');

        // Pertahankan urutan lama jika tidak diisi.
        $data['sort_order'] = $data['sort_order'] ?? $program->sort_order;

        // Jika mode 1 hari dipilih, tanggal selesai disamakan dengan tanggal mulai
        if ($request->input('date_mode') === 'single' && ! empty($data['start_at'])) {
            $data['end_at'] = $data['start_at'];
        }

        if (! empty($data['start_at'])) {
            $data['start_at'] = \Carbon\Carbon::parse($data['start_at'])->startOfDay();
        }
        if (! empty($data['end_at'])) {
            $data['end_at'] = \Carbon\Carbon::parse($data['end_at'])->endOfDay();
        }
        $data['duration'] = $data['duration'] ?? null;

        // Penanganan hapus brosur/foto lama jika diminta
        if ($request->boolean('remove_flyer_image')) {
            if ($program->flyer_image && Storage::disk('public')->exists($program->flyer_image)) {
                Storage::disk('public')->delete($program->flyer_image);
            }
            $data['flyer_image'] = null;
        }

        if ($request->boolean('delete_image')) {
            if ($program->image && Storage::disk('public')->exists($program->image)) {
                Storage::disk('public')->delete($program->image);
            }
            $data['image'] = null;
        }

        // Simpan brosur/foto baru jika diunggah
        if ($request->hasFile('flyer_image')) {
            if ($program->flyer_image && Storage::disk('public')->exists($program->flyer_image)) {
                Storage::disk('public')->delete($program->flyer_image);
            }
            $data['flyer_image'] = $this->storeAsWebp($request->file('flyer_image'), 'diklat/flyers', 1600, 82);
        }

        if ($request->hasFile('image')) {
            if ($program->image && Storage::disk('public')->exists($program->image)) {
                Storage::disk('public')->delete($program->image);
            }
            $data['image'] = $this->storeAsWebp($request->file('image'), 'diklat/images', 1200, 80);
        }

        unset($data['delete_image'], $data['remove_flyer_image']);

        // Simpan perubahan satu kali.
        $program->update($data);

        return redirect()
            ->route('admin.pages.edit', $page)
            ->with('success', 'Program Diklat berhasil diperbarui.');
    }

    public function destroy(Page $page, DiklatProgram $program)
    {
        $this->authorizePage($page);

        $jumlahPendaftar = $program->registrations()->count();
        $jumlahAbsensi = $program->attendances()->count();

        // Cegah penghapusan jika masih ada data terkait.
        if ($jumlahPendaftar > 0 || $jumlahAbsensi > 0) {
            $pesan = 'Program Diklat tidak dapat dihapus karena masih memiliki ';

            $detail = [];

            if ($jumlahPendaftar > 0) {
                $detail[] = $jumlahPendaftar . ' data pendaftaran';
            }

            if ($jumlahAbsensi > 0) {
                $detail[] = $jumlahAbsensi . ' data absensi';
            }

            return redirect()
                ->route('admin.pages.edit', $page)
                ->with('error', $pesan . implode(' dan ', $detail) . '.');
        }

        if ($program->flyer_image && Storage::disk('public')->exists($program->flyer_image)) {
            Storage::disk('public')->delete($program->flyer_image);
        }

        if ($program->image && Storage::disk('public')->exists($program->image)) {
            Storage::disk('public')->delete($program->image);
        }

        $program->delete();

        return redirect()
            ->route('admin.pages.edit', $page)
            ->with('success', 'Program Diklat berhasil dihapus.');
    }
}