<?php

namespace App\Modules\Medical\Contracts;

use App\Modules\Common\Contracts\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

interface BedRepositoryInterface extends BaseRepositoryInterface
{
    public function getOrdered(): Collection;

    public function getTotalBedsCount(): int;

    public function getAvailableBedsCount(): int;
}
