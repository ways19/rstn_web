<?php

namespace App\Modules\Content\Contracts;

use App\Modules\Common\Contracts\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

interface BannerRepositoryInterface extends BaseRepositoryInterface
{
    public function getOrdered(): Collection;

    public function getActiveOrdered(): Collection;
}
