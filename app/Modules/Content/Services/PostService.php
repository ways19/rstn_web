<?php

namespace App\Modules\Content\Services;

use App\Models\Post;
use App\Modules\Content\Contracts\PostRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;

class PostService
{
    public function __construct(
        protected PostRepositoryInterface $postRepository
    ) {}

    public function getAllLatest(): Collection
    {
        return $this->postRepository->getLatest();
    }

    public function getLatestPublished(int $limit = 3): Collection
    {
        return $this->postRepository->getLatestPublished($limit);
    }

    public function getFilteredNews(?string $category = 'semua'): Collection
    {
        return $this->postRepository->getFilteredPublished($category);
    }

    public function getPopularNews(int $limit = 3): Collection
    {
        return $this->postRepository->getPopularPublished($limit);
    }

    public function getNewsDetailWithRelated(string $slug, int $relatedLimit = 3): array
    {
        $item = $this->findBySlug($slug);
        if (! $item) {
            abort(404);
        }

        $this->postRepository->incrementViews($item);
        $relatedNews = $this->postRepository->getRelatedPosts($item->id, $relatedLimit);

        return compact('item', 'relatedNews');
    }

    public function getPaginatedPublished(int $perPage = 6, ?string $category = null, ?string $search = null): LengthAwarePaginator
    {
        return $this->postRepository->paginatePublished($perPage, $category, $search);
    }

    public function findBySlug(string $slug): ?Post
    {
        return $this->postRepository->findBySlug($slug);
    }

    public function createPost(array $data): Post
    {
        /** @var Post $post */
        $post = $this->postRepository->create([
            'title' => $data['title'],
            'slug' => Str::slug($data['title']),
            'category' => $data['category'],
            'excerpt' => $data['excerpt'],
            'content' => $data['content'],
            'image' => $data['image'] ?: 'https://images.unsplash.com/photo-1519494026892-80bbd2d6fd0d?auto=format&fit=crop&w=800&q=80',
            'published_at' => $data['published_at'] ?: now(),
            'is_published' => $data['is_published'] ?? true,
        ]);

        return $post;
    }

    public function updatePost(Post $post, array $data): Post
    {
        $post->update([
            'title' => $data['title'],
            'slug' => Str::slug($data['title']),
            'category' => $data['category'],
            'excerpt' => $data['excerpt'],
            'content' => $data['content'],
            'image' => $data['image'] ?: $post->image,
            'published_at' => $data['published_at'] ?: $post->published_at,
            'is_published' => $data['is_published'] ?? false,
        ]);

        return $post;
    }

    public function deletePost(Post $post): bool
    {
        return $this->postRepository->delete($post->id);
    }
}
