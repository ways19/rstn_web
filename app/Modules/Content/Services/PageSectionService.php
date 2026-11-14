<?php

namespace App\Modules\Content\Services;

use App\Models\PageSection;
use Illuminate\Database\Eloquent\Collection;

class PageSectionService
{
    public function getByPage(int $pageId): Collection
    {
        return PageSection::where('page_id', $pageId)
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();
    }

    public function createSection(array $data): PageSection
    {
        $parentId = $data['parent_id'] ?? null;

        // Jika tidak punya induk = Level 1
        // Jika punya induk = Level 2
        $level = 1;

        if ($parentId) {
            $parent = PageSection::findOrFail($parentId);

            // Kelompok informasi hanya boleh sampai Level 2
            if ((int) $parent->level >= 2) {
                throw new \InvalidArgumentException(
                    'Kelompok informasi tidak boleh memiliki Level 3.'
                );
            }

            $level = 2;
        }

        // Tentukan urutan otomatis agar informasi baru masuk paling bawah
        $sortOrder = PageSection::where('page_id', $data['page_id'])
            ->where('level', $level)
            ->when(
                $level === 2,
                fn ($query) => $query->where('parent_id', $parentId)
            )
            ->max('sort_order');

        $sortOrder = ($sortOrder ?? 0) + 1;

        return PageSection::create([
            'page_id' => $data['page_id'],
            'title' => $data['title'],
            'description' => $data['description'] ?? null,
            'level' => $level,
            'parent_id' => $parentId,
            'sort_order' => $sortOrder,
            'is_active' => $data['is_active'] ?? true,
        ]);
    }

    public function updateSection(PageSection $section, array $data): PageSection
    {
        $parentId = $data['parent_id'] ?? null;

        // Tanpa induk = Level 1
        // Dengan induk = Level 2
        $level = 1;

        if ($parentId) {
            $parent = PageSection::findOrFail($parentId);

            // Jangan sampai sebuah Level 2 menjadi induk Level 2 lainnya
            if (
                (int) $parent->level >= 2 ||
                $parent->id === $section->id
            ) {
                throw new \InvalidArgumentException(
                    'Induk informasi yang dipilih tidak valid.'
                );
            }

            $level = 2;
        }

        $section->update([
            'page_id' => $data['page_id'],
            'title' => $data['title'],
            'description' => $data['description'] ?? null,
            'level' => $level,
            'parent_id' => $parentId,
            'sort_order' => $data['sort_order'] ?? 0,
            'is_active' => $data['is_active'] ?? false,
        ]);

        return $section;
    }

    public function deleteSection(PageSection $section): bool
    {
        return $section->delete();
    }
}