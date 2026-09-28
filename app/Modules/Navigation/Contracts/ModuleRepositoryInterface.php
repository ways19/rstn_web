<?php

namespace App\Modules\Navigation\Contracts;

use App\Modules\Common\Contracts\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

interface ModuleRepositoryInterface extends BaseRepositoryInterface
{
    public function getOrdered(): Collection;
}
