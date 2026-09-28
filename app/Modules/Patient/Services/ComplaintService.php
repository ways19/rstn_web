<?php

namespace App\Modules\Patient\Services;

use App\Models\Complaint;
use App\Modules\Patient\Contracts\ComplaintRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class ComplaintService
{
    public function __construct(
        protected ComplaintRepositoryInterface $complaintRepository
    ) {}

    public function getPaginatedComplaints(int $perPage = 15): LengthAwarePaginator
    {
        return $this->complaintRepository->paginateLatest($perPage);
    }

    public function getLatestComplaints(int $limit = 5): Collection
    {
        return $this->complaintRepository->getLatest($limit);
    }

    public function countTotal(): int
    {
        return $this->complaintRepository->countTotal();
    }

    public function countNew(): int
    {
        return $this->complaintRepository->countNew();
    }

    public function replyComplaint(Complaint $complaint, array $data): bool
    {
        return $complaint->update($data);
    }

    public function createComplaint(array $data): Complaint
    {
        $ticketNumber = 'TKT-' . date('Ymd') . '-' . rand(1000, 9999);

        /** @var Complaint $complaint */
        $complaint = $this->complaintRepository->create(array_merge($data, [
            'ticket_number' => $ticketNumber,
            'status' => 'baru',
        ]));

        return $complaint;
    }
}
