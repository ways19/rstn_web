<?php

namespace App\Modules\Content\Services;

use App\Models\Page;
use App\Modules\Content\Contracts\PageRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PageService
{
    public function __construct(
        protected PageRepositoryInterface $pageRepository
    ) {}

    public function getAll(): Collection
    {
        return $this->pageRepository->all();
    }

    public function findBySlug(string $slug): ?Page
    {
        return $this->pageRepository->findBySlug($slug);
    }

    public function createPage(array $data): Page
    {
        /** @var Page $page */
        $fileAttachment = null;

        // Jika ada file yang di-upload, simpan ke storage
        if (
            !empty($data['file_attachment']) &&
            $data['file_attachment'] instanceof \Illuminate\Http\UploadedFile
        ) {
            $fileAttachment = $data['file_attachment']->store('pages', 'public');
        }

        $page = $this->pageRepository->create([
            'title' => $data['title'],
            'slug' => $data['slug'],
            'category' => $data['category'],
            'description' => $data['description'] ?? null,
            'content' => $data['content'],
            'file_attachment' => $fileAttachment,
            'is_active' => $data['is_active'] ?? true,
        ]);

        return $page;
    }

    public function updatePage(Page $page, array $data): Page
    {
        $fileAttachment = $page->file_attachment;

        // Jika ada file baru yang di-upload
        if (!empty($data['file_attachment']) && $data['file_attachment'] instanceof \Illuminate\Http\UploadedFile) {

            // Hapus file lama jika sebelumnya adalah file lokal
            if (
                $page->file_attachment &&
                !Str::startsWith($page->file_attachment, ['http://', 'https://'])
            ) {
                Storage::disk('public')->delete($page->file_attachment);
            }

            // Simpan file baru
            $fileAttachment = $data['file_attachment']->store('pages', 'public');
        }

        $page->update([
            'title' => $data['title'],
            'slug' => $data['slug'],
            'category' => $data['category'],
            'description' => $data['description'] ?? null,
            'content' => $data['content'],
            'file_attachment' => $fileAttachment,
            'is_active' => $data['is_active'] ?? false,
        ]);

        return $page;
    }

    public function deletePage(Page $page): bool
    {
        // Hapus file lokal jika halaman dihapus
        if (
            $page->file_attachment &&
            !Str::startsWith($page->file_attachment, ['http://', 'https://'])
        ) {
            Storage::disk('public')->delete($page->file_attachment);
        }

        return $this->pageRepository->delete($page->id);
    }
}