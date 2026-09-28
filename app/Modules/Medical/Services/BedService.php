<?php

namespace App\Modules\Medical\Services;

use App\Models\Bed;
use App\Modules\Medical\Contracts\BedRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class BedService
{
    public function __construct(
        protected BedRepositoryInterface $bedRepository
    ) {}

    public function getAllOrdered(): Collection
    {
        return $this->bedRepository->getOrdered();
    }

    public function getTotalBedsCount(): int
    {
        return $this->bedRepository->getTotalBedsCount();
    }

    public function getAvailableBedsCount(): int
    {
        return $this->bedRepository->getAvailableBedsCount();
    }

    public function updateBeds(array $bedsData): void
    {
        foreach ($bedsData as $id => $data) {
            /** @var Bed|null $bed */
            $bed = $this->bedRepository->findById($id);
            if ($bed) {
                $total = (int) ($data['total'] ?? $bed->total);
                $occupied = (int) ($data['occupied'] ?? $bed->occupied);
                $available = max(0, $total - $occupied);

                $bed->update([
                    'total' => $total,
                    'occupied' => $occupied,
                    'available' => $available,
                ]);
            }
        }
    }
}
