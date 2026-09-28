<?php

namespace App\Modules\Content\Repositories;

use App\Models\Page;
use App\Modules\Common\Repositories\BaseRepository;
use App\Modules\Content\Contracts\PageRepositoryInterface;

class PageRepository extends BaseRepository implements PageRepositoryInterface
{
    public function __construct(Page $model)
    {
        parent::__construct($model);
    }

    public function findBySlug(string $slug): ?Page
    {
        return $this->model->where('slug', $slug)->first();
    }
}
