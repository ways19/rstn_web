<?php

namespace App\Modules\Patient\Services;

use App\Models\Registration;
use App\Modules\Patient\Contracts\RegistrationRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class RegistrationService
{
    public function __construct(
        protected RegistrationRepositoryInterface $registrationRepository
    ) {}

    public function getFilteredRegistrations(?string $status = null, int $perPage = 15): LengthAwarePaginator
    {
        return $this->registrationRepository->paginateWithFilter($status, $perPage);
    }

    public function getLatestRegistrations(int $limit = 5): Collection
    {
        return $this->registrationRepository->getLatest($limit);
    }

    public function countTotal(): int
    {
        return $this->registrationRepository->countTotal();
    }

    public function countPending(): int
    {
        return $this->registrationRepository->countPending();
    }

    public function updateStatus(Registration $registration, string $status): bool
    {
        return $registration->update(['status' => $status]);
    }

    public function registerPatient(array $data): Registration
    {
        $prefix = str_contains($data['clinic'] ?? '', 'Anak') ? 'B-' : 'A-';
        $queueNumber = $prefix . rand(10, 99);

        // Pastikan nomor antrean unik untuk tanggal kunjungan
        while (Registration::where('queue_number', $queueNumber)->whereDate('visit_date', $data['visit_date'])->exists()) {
            $queueNumber = $prefix . rand(10, 99);
        }

        /** @var Registration $registration */
        $registration = $this->registrationRepository->create(array_merge($data, [
            'queue_number' => $queueNumber,
            'status' => 'terdaftar',
        ]));

        return $registration;
    }
}
