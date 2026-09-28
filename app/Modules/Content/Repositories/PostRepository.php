<?php

namespace App\Modules\Content\Repositories;

use App\Models\Post;
use App\Modules\Common\Repositories\BaseRepository;
use App\Modules\Content\Contracts\PostRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class PostRepository extends BaseRepository implements PostRepositoryInterface
{
    public function __construct(Post $model)
    {
        parent::__construct($model);
    }

    public function getLatest(): Collection
    {
        return $this->model->latest()->get();
    }

    public function getLatestPublished(int $limit = 3): Collection
    {
        return $this->model->where('is_published', true)->latest()->take($limit)->get();
    }

    public function getFilteredPublished(?string $category = null): Collection
    {
        $query = $this->model->where('is_published', true)->latest();

        if ($category && $category !== 'semua') {
            $query->where('category', $category);
        }

        return $query->get();
    }

    public function getPopularPublished(int $limit = 3): Collection
    {
        return $this->model->where('is_published', true)->orderBy('views', 'desc')->take($limit)->get();
    }

    public function getRelatedPosts(int $excludeId, int $limit = 3): Collection
    {
        return $this->model->where('id', '!=', $excludeId)
            ->where('is_published', true)
            ->take($limit)
            ->get();
    }

    public function paginatePublished(int $perPage = 6, ?string $category = null, ?string $search = null): LengthAwarePaginator
    {
        $query = $this->model->where('is_published', true)->latest();

        if ($category && $category !== 'semua') {
            $query->where('category', $category);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('excerpt', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        return $query->paginate($perPage);
    }

    public function findBySlug(string $slug): ?Post
    {
        return $this->model->where('slug', $slug)->first();
    }

    public function incrementViews(Post $post): void
    {
        $post->increment('views');
    }
}
