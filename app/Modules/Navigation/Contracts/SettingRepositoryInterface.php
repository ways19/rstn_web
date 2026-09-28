<?php

namespace App\Modules\Navigation\Contracts;

use App\Modules\Common\Contracts\BaseRepositoryInterface;
use Illuminate\Support\Collection;

interface SettingRepositoryInterface extends BaseRepositoryInterface
{
    public function getAllKeyValue(): Collection;

    public function set(string $key, mixed $value, string $group = 'general'): void;

    public function get(string $key, mixed $default = null): mixed;
}
