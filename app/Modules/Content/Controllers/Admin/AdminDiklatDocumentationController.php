<?php

namespace App\Modules\Content\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DiklatDocumentation;
use App\Models\DiklatDocumentationPhoto;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class AdminDiklatDocumentationController extends Controller
{
    private function authorizePage(Page $page): void
    {
        abort_unless($page->slug === 'dokumentasi', 404);
    }

    public function store(Request $request, Page $page)
    {
        $this->authorizePage($page);

        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'category' => [
                'required',
                Rule::in(['orientasi', 'pelatihan', 'kunjungan']),
            ],
            'event_date' => ['required', 'date'],
            'location' => ['required', 'string', 'max:255'],
            'photos' => ['required', 'array', 'min:1'],
            'photos.*' => [
                'required',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],
            'description' => ['nullable', 'string', 'max:2000'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $data['is_active'] = $request->boolean('is_active');
        $uploadedPhotos = $request->file('photos');

        $documentation = DB::transaction(function () use ($data, $uploadedPhotos) {
            unset($data['photos']);

            $data['image_path'] = $uploadedPhotos[0]
                ->store('diklat-documentations', 'public');

            $documentation = DiklatDocumentation::create($data);

            foreach ($uploadedPhotos as $index => $photo) {
                DiklatDocumentationPhoto::create([
                    'diklat_documentation_id' => $documentation->id,
                    'image_path' => $index === 0
                        ? $documentation->image_path
                        : $photo->store('diklat-documentations', 'public'),
                    'sort_order' => $index,
                ]);
            }

            return $documentation;
        });

        return redirect()
            ->route('admin.pages.edit', $page)
            ->with('success', 'Dokumentasi berhasil ditambahkan.');
    }

    public function edit(
        Page $page,
        DiklatDocumentation $documentation
    ) {
        $this->authorizePage($page);

        return redirect()->to(
            route('admin.pages.edit', $page)
            . '?edit_dokumentasi=' . $documentation->id
        );
    }

    
    
    public function update(
        Request $request,
        Page $page,
        DiklatDocumentation $documentation
    ) {
        $this->authorizePage($page);

        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'category' => [
                'required',
                Rule::in(['orientasi', 'pelatihan', 'kunjungan']),
            ],
            'event_date' => ['required', 'date'],
            'location' => ['required', 'string', 'max:255'],
            'image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],
            'photos' => ['nullable', 'array'],
            'photos.*' => [
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],
            'delete_photos' => ['nullable', 'array'],
            'delete_photos.*' => ['required', 'integer', 'distinct'],
            'description' => ['nullable', 'string', 'max:2000'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $data['is_active'] = $request->boolean('is_active');
        $newCover = $request->file('image');
        $uploadedPhotos = $request->file('photos', []);
        $deletePhotoIds = $data['delete_photos'] ?? [];

        unset($data['image'], $data['photos'], $data['delete_photos']);

        // Simpan path foto utama lama sebelum data diperbarui.
        $oldCoverPath = $documentation->image_path;

        $newCoverPath = null;
        $uploadedPaths = [];
        $deletedPaths = [];

        try {
            DB::transaction(function () use (
                $documentation,
                $data,
                $newCover,
                $uploadedPhotos,
                $deletePhotoIds,
                &$newCoverPath,
                &$uploadedPaths,
                &$deletedPaths
            ) {
                $documentation->update($data);

                // Hapus foto galeri yang dipilih pengguna.
                if (!empty($deletePhotoIds)) {
                    $photosToDelete = $documentation->photos()
                        ->whereIn('id', $deletePhotoIds)
                        ->get();

                    foreach ($photosToDelete as $photo) {
                        $deletedPaths[] = $photo->image_path;
                        $photo->delete();
                    }
                }

                // Tambahkan foto galeri baru.
                $nextOrder = (int) $documentation->photos()
                    ->max('sort_order') + 1;

                foreach ($uploadedPhotos as $photo) {
                    $path = $photo->store(
                        'diklat-documentations',
                        'public'
                    );

                    $uploadedPaths[] = $path;

                    DiklatDocumentationPhoto::create([
                        'diklat_documentation_id' => $documentation->id,
                        'image_path' => $path,
                        'sort_order' => $nextOrder++,
                    ]);
                }

                // Ganti foto utama jika ada file baru.
                if ($newCover) {
                    $newCoverPath = $newCover->store(
                        'diklat-documentations',
                        'public'
                    );

                    $documentation->update([
                        'image_path' => $newCoverPath,
                    ]);
                }

                // Pastikan foto utama menunjuk ke file yang masih tersedia.
                $currentCoverPath = $documentation->fresh()->image_path;

                if (
                    !$currentCoverPath ||
                    !Storage::disk('public')->exists($currentCoverPath)
                ) {
                    $firstPhoto = $documentation->photos()
                        ->orderBy('sort_order')
                        ->value('image_path');

                    $documentation->update([
                        'image_path' => $firstPhoto,
                    ]);
                }
            });
        } catch (\Throwable $exception) {
            // Bersihkan file baru jika transaksi gagal.
            if ($newCoverPath) {
                Storage::disk('public')->delete($newCoverPath);
            }

            if (!empty($uploadedPaths)) {
                Storage::disk('public')->delete($uploadedPaths);
            }

            throw $exception;
        }

        // Hapus file galeri yang sudah tidak digunakan.
        foreach (array_unique($deletedPaths) as $path) {
            if (!$path) {
                continue;
            }

            $stillUsedByGallery = $documentation->photos()
                ->where('image_path', $path)
                ->exists();

            $stillUsedAsCover = $documentation->fresh()->image_path === $path;

            if (!$stillUsedByGallery && !$stillUsedAsCover) {
                Storage::disk('public')->delete($path);
            }
        }

        // Hapus foto utama lama jika sudah tidak dipakai.
        if (
            $oldCoverPath &&
            $oldCoverPath !== $documentation->fresh()->image_path
        ) {
            $stillUsedByGallery = $documentation->photos()
                ->where('image_path', $oldCoverPath)
                ->exists();

            if (!$stillUsedByGallery) {
                Storage::disk('public')->delete($oldCoverPath);
            }
        }

        return redirect()
            ->route('admin.pages.edit', $page)
            ->with('success', 'Dokumentasi berhasil diperbarui.');
    }



    public function destroy(
        Page $page,
        DiklatDocumentation $documentation
    ) {
        $this->authorizePage($page);

        $paths = $documentation->photos()
            ->pluck('image_path')
            ->push($documentation->image_path)
            ->filter()
            ->unique()
            ->values()
            ->all();

        DB::transaction(function () use ($documentation) {
            $documentation->photos()->delete();
            $documentation->delete();
        });

        foreach ($paths as $path) {
            Storage::disk('public')->delete($path);
        }

        return redirect()
            ->route('admin.pages.edit', $page)
            ->with('success', 'Dokumentasi berhasil dihapus.');
    }
}