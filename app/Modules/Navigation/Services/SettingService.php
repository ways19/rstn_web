<?php

namespace App\Modules\Navigation\Services;

use App\Modules\Navigation\Contracts\SettingRepositoryInterface;
use Illuminate\Support\Collection;

class SettingService
{
    public function __construct(
        protected SettingRepositoryInterface $settingRepository
    ) {}

    public function getAllSettings(): Collection
    {
        return $this->settingRepository->getAllKeyValue();
    }

    public function updateSettings(array $inputs): void
    {
        foreach ($inputs as $key => $val) {
            $this->settingRepository->set($key, $val);
        }
    }

    public function get(string $key, mixed $default = null): mixed
    {
        return $this->settingRepository->get($key, $default);
    }
}
