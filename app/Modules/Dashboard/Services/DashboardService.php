<?php

namespace App\Modules\Dashboard\Services;

use App\Modules\Content\Contracts\PostRepositoryInterface;
use App\Modules\Medical\Contracts\BedRepositoryInterface;
use App\Modules\Medical\Contracts\DoctorRepositoryInterface;
use App\Modules\Medical\Contracts\ServiceRepositoryInterface;
use App\Modules\Patient\Contracts\ComplaintRepositoryInterface;
use App\Modules\Patient\Contracts\RegistrationRepositoryInterface;

class DashboardService
{
    public function __construct(
        protected RegistrationRepositoryInterface $registrationRepository,
        protected ComplaintRepositoryInterface $complaintRepository,
        protected ServiceRepositoryInterface $serviceRepository,
        protected DoctorRepositoryInterface $doctorRepository,
        protected PostRepositoryInterface $postRepository,
        protected BedRepositoryInterface $bedRepository
    ) {}

    public function getDashboardData(): array
    {
        $stats = [
            'total_registrations' => $this->registrationRepository->countTotal(),
            'pending_registrations' => $this->registrationRepository->countPending(),
            'total_complaints' => $this->complaintRepository->countTotal(),
            'new_complaints' => $this->complaintRepository->countNew(),
            'total_doctors' => $this->doctorRepository->countActive(),
            'total_services' => $this->serviceRepository->all()->count(),
            'total_posts' => $this->postRepository->all()->count(),
            'available_beds' => $this->bedRepository->getAvailableBedsCount(),
            'total_beds' => $this->bedRepository->getTotalBedsCount(),
        ];

        $latestRegistrations = $this->registrationRepository->getLatest(5);
        $latestComplaints = $this->complaintRepository->getLatest(5);

        return compact('stats', 'latestRegistrations', 'latestComplaints');
    }
}
