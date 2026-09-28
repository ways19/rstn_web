<?php

namespace App\Modules\Content\Contracts;

use App\Modules\Common\Contracts\BaseRepositoryInterface;
use App\Models\Post;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface PostRepositoryInterface extends BaseRepositoryInterface
{
    public function getLatest(): Collection;

    public function getLatestPublished(int $limit = 3): Collection;

    public function getFilteredPublished(?string $category = null): Collection;

    public function getPopularPublished(int $limit = 3): Collection;

    public function getRelatedPosts(int $excludeId, int $limit = 3): Collection;

    public function paginatePublished(int $perPage = 6, ?string $category = null, ?string $search = null): LengthAwarePaginator;

    public function findBySlug(string $slug): ?Post;

    public function incrementViews(Post $post): void;
}
