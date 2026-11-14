<?php

namespace App\Modules\Content\Repositories;

use App\Models\PpidDocument;
use App\Modules\Common\Repositories\BaseRepository;
use App\Modules\Content\Contracts\PpidDocumentRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class PpidDocumentRepository extends BaseRepository implements PpidDocumentRepositoryInterface
{
    public function __construct(PpidDocument $model)
    {
        parent::__construct($model);
    }

    public function getActiveDocuments(): Collection
    {
        return $this->model
            ->where('is_active', true)
            ->with([
                'placements.section.page',
            ])
            ->orderBy('sort_order')
            ->orderBy('title')
            ->get();
    }

    public function getActiveDocumentsByMenu(string $menu): Collection
    {
        return $this->model
            ->where('is_active', true)
            ->whereHas('placements', function ($query) use ($menu) {
                $query->where('menu', $menu);
            })
            ->with([
                'placements.section.page',
            ])
            ->orderBy('sort_order')
            ->orderBy('title')
            ->get();
    }
}