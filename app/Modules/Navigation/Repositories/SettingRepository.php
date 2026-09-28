<?php

namespace App\Modules\Navigation\Repositories;

use App\Models\Setting;
use App\Modules\Common\Repositories\BaseRepository;
use App\Modules\Navigation\Contracts\SettingRepositoryInterface;
use Illuminate\Support\Collection;

class SettingRepository extends BaseRepository implements SettingRepositoryInterface
{
    public function __construct(Setting $model)
    {
        parent::__construct($model);
    }

    public function getAllKeyValue(): Collection
    {
        return $this->model->all()->pluck('value', 'key');
    }

    public function set(string $key, mixed $value, string $group = 'general'): void
    {
        Setting::set($key, $value, $group);
    }

    public function get(string $key, mixed $default = null): mixed
    {
        return Setting::get($key, $default);
    }
}
