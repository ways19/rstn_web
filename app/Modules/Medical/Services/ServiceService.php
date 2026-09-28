<?php

namespace App\Modules\Medical\Services;

use App\Models\Service;
use App\Modules\Medical\Contracts\ServiceRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;

class ServiceService
{
    public function __construct(
        protected ServiceRepositoryInterface $serviceRepository
    ) {}

    public function getAllOrdered(): Collection
    {
        return $this->serviceRepository->getOrdered();
    }

    public function getActiveOrdered(): Collection
    {
        return $this->serviceRepository->getActiveOrdered();
    }

    public function getByCategory(string $category = 'semua'): Collection
    {
        return $this->serviceRepository->getByCategory($category);
    }

    public function findBySlug(string $slug): ?Service
    {
        return $this->serviceRepository->findBySlug($slug);
    }

    public function getServiceDetailWithRelated(string $slug, int $relatedLimit = 3): array
    {
        $service = $this->findBySlug($slug);
        if (! $service) {
            abort(404);
        }

        $relatedServices = $this->serviceRepository->getRelatedServices($service->id, $relatedLimit);

        return compact('service', 'relatedServices');
    }

    public function createService(array $data): Service
    {
        $facilities = ! empty($data['facilities_text'])
            ? array_filter(array_map('trim', explode("\n", $data['facilities_text'])))
            : [];

        /** @var Service $service */
        $service = $this->serviceRepository->create([
            'title' => $data['title'],
            'slug' => Str::slug($data['title']),
            'category' => $data['category'],
            'tag' => $data['tag'] ?? null,
            'excerpt' => $data['excerpt'],
            'description' => $data['description'],
            'facilities' => $facilities,
            'image' => $data['image'] ?: 'https://images.unsplash.com/photo-1516549655169-df83a0774514?auto=format&fit=crop&w=800&q=80',
            'order' => $data['order'] ?? 0,
            'is_active' => $data['is_active'] ?? true,
        ]);

        return $service;
    }

    public function updateService(Service $service, array $data): Service
    {
        $facilities = ! empty($data['facilities_text'])
            ? array_filter(array_map('trim', explode("\n", $data['facilities_text'])))
            : [];

        $service->update([
            'title' => $data['title'],
            'slug' => Str::slug($data['title']),
            'category' => $data['category'],
            'tag' => $data['tag'] ?? null,
            'excerpt' => $data['excerpt'],
            'description' => $data['description'],
            'facilities' => $facilities,
            'image' => $data['image'] ?: $service->image,
            'order' => $data['order'] ?? 0,
            'is_active' => $data['is_active'] ?? false,
        ]);

        return $service;
    }

    public function deleteService(Service $service): bool
    {
        return $this->serviceRepository->delete($service->id);
    }
}
