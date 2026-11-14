<?php

namespace App\Modules\Content\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Facility;
use App\Models\Page;
use App\Models\FacilityPhoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class AdminFacilityController extends Controller
{
    private function authorizePage(Page $page): void
    {
        abort_unless($page->slug === 'fasilitas', 404);
    }

   
    public function store(Request $request, Page $page)
    {
        $this->authorizePage($page);

        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'category' => [
                'nullable',
                'in:Multimedia & Dokumentasi,Pembelajaran & Diskusi,Literatur & Referensi,Fasilitas Pendukung',
            ],
            'description' => ['nullable', 'string', 'max:2000'],
            'caption' => ['nullable', 'string', 'max:255'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'label' => ['nullable', 'string', 'max:100'],
            'link_url' => ['nullable', 'url', 'max:2048'],
            'link_label' => ['nullable', 'string', 'max:100'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')
                ->store('facilities', 'public');
        }

        unset($data['image']);

        $data['sort_order'] = $data['sort_order'] ?? 0;
        $data['is_active'] = $request->boolean('is_active');

        Facility::create($data);

        return redirect()
            ->route('admin.pages.edit', $page)
            ->with('success', 'Fasilitas berhasil ditambahkan.');
    }


    public function edit(Page $page, Facility $facility)
    {
        $this->authorizePage($page);

        return redirect()->to(
            route('admin.pages.edit', $page)
            . '?edit_fasilitas=' . $facility->id
        );
    }

    
    
    public function update(
        Request $request,
        Page $page,
        Facility $facility
    ) {
        $this->authorizePage($page);

        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'category' => [
                'nullable',
                'in:Multimedia & Dokumentasi,Pembelajaran & Diskusi,Literatur & Referensi,Fasilitas Pendukung',
            ],
            'description' => ['nullable', 'string', 'max:2000'],
            'caption' => ['nullable', 'string', 'max:255'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'photos' => ['nullable', 'array'],
            'photos.*' => ['image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'delete_photos' => ['nullable', 'array'],
            'delete_photos.*' => ['integer'],
            'label' => ['nullable', 'string', 'max:100'],
            'link_url' => ['nullable', 'url', 'max:2048'],
            'link_label' => ['nullable', 'string', 'max:100'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $oldImagePath = $facility->image_path;
        $newImagePath = null;
        $uploadedGalleryPaths = [];

        try {
            // Simpan foto utama baru jika dipilih.
            if ($request->hasFile('image')) {
                $newImagePath = $request->file('image')
                    ->store('facilities', 'public');

                $data['image_path'] = $newImagePath;
            }

            unset($data['image']);

            $data['sort_order'] = $data['sort_order'] ?? 0;
            $data['is_active'] = $request->boolean('is_active');

            DB::transaction(function () use (
                $facility,
                $data,
                $request,
                &$uploadedGalleryPaths
            ) {
                $facility->update($data);

                // Hapus foto galeri yang dipilih, hanya milik fasilitas ini.
                $deleteIds = $request->input('delete_photos', []);

                if (!empty($deleteIds)) {
                    $photosToDelete = $facility->photos()
                        ->whereIn('id', $deleteIds)
                        ->get();

                    foreach ($photosToDelete as $photo) {
                        $photo->delete();

                        // File fisik dihapus setelah transaksi berhasil.
                    }

                    // Simpan path untuk dibersihkan setelah transaksi.
                    $request->attributes->set(
                        'deleted_gallery_paths',
                        array_merge(
                            $request->attributes->get('deleted_gallery_paths', []),
                            $photosToDelete->pluck('image_path')->all()
                        )
                    );
                }

                // Tambahkan foto galeri baru.
                $nextOrder = (int) $facility->photos()->max('sort_order') + 1;

                foreach ($request->file('photos', []) as $file) {
                    $path = $file->store('facilities/gallery', 'public');

                    $uploadedGalleryPaths[] = $path;

                    $facility->photos()->create([
                        'image_path' => $path,
                        'sort_order' => $nextOrder++,
                    ]);
                }
            });

            // Hapus file lama hanya setelah database berhasil diperbarui.
            if (
                $newImagePath
                && $oldImagePath
                && $oldImagePath !== $newImagePath
            ) {
                Storage::disk('public')->delete($oldImagePath);
            }

            Storage::disk('public')->delete(
                $request->attributes->get('deleted_gallery_paths', [])
            );
        } catch (\Throwable $e) {
            // Bersihkan file baru jika proses gagal.
            if ($newImagePath) {
                Storage::disk('public')->delete($newImagePath);
            }

            if (!empty($uploadedGalleryPaths)) {
                Storage::disk('public')->delete($uploadedGalleryPaths);
            }

            throw $e;
        }

        return redirect()
            ->route('admin.pages.edit', $page)
            ->with('success', 'Fasilitas berhasil diperbarui.');
    }



    public function destroy(Page $page, Facility $facility)
    {
        $this->authorizePage($page);

        $imagePath = $facility->image_path;

        $facility->delete();

        if ($imagePath) {
            Storage::disk('public')->delete($imagePath);
        }

        return redirect()
            ->route('admin.pages.edit', $page)
            ->with('success', 'Fasilitas berhasil dihapus.');
    }
}