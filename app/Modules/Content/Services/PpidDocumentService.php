<?php

namespace App\Modules\Content\Services;

use App\Models\PpidDocument;
use App\Modules\Content\Contracts\PpidDocumentRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class PpidDocumentService
{
    public function __construct(
        protected PpidDocumentRepositoryInterface $documentRepository
    ) {}

    public function getAll(): Collection
    {
        return $this->documentRepository->all();
    }

    public function getActiveDocuments(): Collection
    {
        return $this->documentRepository->getActiveDocuments();
    }

    public function getActiveDocumentsByMenu(string $menu): Collection
    {
        return $this->documentRepository->getActiveDocumentsByMenu($menu);
    }

    public function createDocument(array $data): PpidDocument
    {
        /*
        |--------------------------------------------------------------------------
        | Upload file
        |--------------------------------------------------------------------------
        */

        if (
            !empty($data['file_path']) &&
            $data['file_path'] instanceof UploadedFile
        ) {
            $data['file_path'] = $data['file_path']->store(
                'ppid-documents',
                'public'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Create document
        |--------------------------------------------------------------------------
        */

        $document = $this->documentRepository->create([
            'title' => $data['title'],
            'category' => $data['category'] ?? 'PPID',
            'year' => $data['year'] ?? 2026,
            'type' => $data['type'],
            'url' => $data['url'] ?? null,
            'file_path' => $data['file_path'] ?? null,
            'page_id' => $data['page_id'] ?? null,
            'description' => $data['description'] ?? null,
            'is_active' => $data['is_active'] ?? true,
            'sort_order' => $data['sort_order'] ?? 0,
        ]);

        /*
        |--------------------------------------------------------------------------
        | Save document placement
        |--------------------------------------------------------------------------
        */

        if (!empty($data['page_section_id'])) {
            $document->placements()->create([
                'page_section_id' => $data['page_section_id'],
                'sort_order' => $data['sort_order'] ?? 0,
            ]);
        }

        return $document;
    }

    public function updateDocument(
        PpidDocument $document,
        array $data
    ): PpidDocument {
        /*
        |--------------------------------------------------------------------------
        | Upload file baru
        |--------------------------------------------------------------------------
        */

        if (
            !empty($data['file_path']) &&
            $data['file_path'] instanceof UploadedFile
        ) {
            /*
            | Hapus file lama jika ada
            */
            if ($document->file_path) {
                Storage::disk('public')->delete(
                    $document->file_path
                );
            }

            /*
            | Simpan file baru
            */
            $data['file_path'] = $data['file_path']->store(
                'ppid-documents',
                'public'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Update document
        |--------------------------------------------------------------------------
        */

        $document->update([
            'title' => $data['title'],
            'category' => $data['category'] ?? $document->category,
            'year' => $data['year'] ?? $document->year,
            'type' => $data['type'],
            'url' => $data['url'] ?? null,
            'file_path' => $data['file_path'] ?? $document->file_path,
            'page_id' => $data['page_id'] ?? null,
            'description' => $data['description'] ?? null,
            'is_active' => $data['is_active'] ?? false,
            'sort_order' => $data['sort_order'] ?? 0,
        ]);

        /*
        |--------------------------------------------------------------------------
        | Update document placements
        |--------------------------------------------------------------------------
        | Satu dokumen dapat ditempatkan pada beberapa Induk Informasi.
        */

        $document->placements()->delete();

        $sectionIds = $data['page_section_ids'] ?? [];

        foreach ($sectionIds as $sectionId) {
            $document->placements()->create([
                'page_section_id' => $sectionId,
                'sort_order' => $data['sort_order'] ?? 0,
            ]);
        }

        return $document;
    }

    public function deleteDocument(PpidDocument $document): bool
    {
        /*
        |--------------------------------------------------------------------------
        | Hapus file
        |--------------------------------------------------------------------------
        */

        if ($document->file_path) {
            Storage::disk('public')->delete(
                $document->file_path
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Hapus document
        |--------------------------------------------------------------------------
        |
        | Placement ikut terhapus karena foreign key
        | menggunakan cascadeOnDelete().
        |
        */

        return $this->documentRepository->delete(
            $document->id
        );
    }
}