<?php

namespace App\Modules\Navigation\Services;

use App\Models\Menu;
use App\Modules\Navigation\Contracts\MenuRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class MenuService
{
    public function __construct(
        protected MenuRepositoryInterface $menuRepository
    ) {}

    public function getTreeByLocation(string $location = 'public'): Collection
    {
        return $this->menuRepository->getTreeByLocation($location);
    }

    public function getParentsByLocation(string $location = 'public', ?int $excludeId = null): Collection
    {
        return $this->menuRepository->getParentsByLocation($location, $excludeId);
    }

    public function getStats(): array
    {
        return $this->menuRepository->getStats();
    }

    public function createMenu(array $data): Menu
    {
        /** @var Menu $menu */
        $menu = $this->menuRepository->create($data);
        return $menu;
    }

    public function updateMenu(Menu $menu, array $data): Menu
    {
        // Prevent setting self as parent
        if (isset($data['parent_id']) && $data['parent_id'] == $menu->id) {
            $data['parent_id'] = null;
        }

        $menu->update($data);
        return $menu;
    }

    public function deleteMenu(Menu $menu): bool
    {
        return $this->menuRepository->delete($menu->id);
    }

    public function toggleMenu(Menu $menu): bool
    {
        $menu->is_active = ! $menu->is_active;
        return $menu->save();
    }
}
