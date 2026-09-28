<?php

namespace App\Modules\Navigation\Services;

use App\Models\AppModule;
use App\Modules\Navigation\Contracts\ModuleRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class ModuleService
{
    public function __construct(
        protected ModuleRepositoryInterface $moduleRepository
    ) {}

    public function getAllOrdered(): Collection
    {
        return $this->moduleRepository->getOrdered();
    }

    public function updateModule(AppModule $module, array $data): AppModule
    {
        $module->update($data);
        return $module;
    }

    public function toggleModule(AppModule $module): bool
    {
        $module->is_active = ! $module->is_active;
        return $module->save();
    }
}
