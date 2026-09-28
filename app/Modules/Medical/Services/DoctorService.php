<?php

namespace App\Modules\Medical\Services;

use App\Models\Doctor;
use App\Modules\Medical\Contracts\DoctorRepositoryInterface;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Collection;

class DoctorService
{
    public function __construct(
        protected DoctorRepositoryInterface $doctorRepository
    ) {}

    public function getAllOrdered(): EloquentCollection
    {
        return $this->doctorRepository->getOrdered();
    }

    public function getActiveOrdered(): EloquentCollection
    {
        return $this->doctorRepository->getActiveOrdered();
    }

    public function getSpecialities(): Collection
    {
        return $this->doctorRepository->getSpecialities();
    }

    public function getDoctorDetail(int|string $id): Doctor
    {
        /** @var Doctor|null $doctor */
        $doctor = $this->doctorRepository->findById($id);
        if (! $doctor) {
            abort(404);
        }

        return $doctor;
    }

    public function countActive(): int
    {
        return $this->doctorRepository->countActive();
    }

    public function createDoctor(array $data): Doctor
    {
        /** @var Doctor $doctor */
        $doctor = $this->doctorRepository->create([
            'name' => $data['name'],
            'speciality' => $data['speciality'],
            'sub_speciality' => $data['sub_speciality'] ?? null,
            'poli' => $data['poli'],
            'schedule' => $data['schedule'],
            'days' => $data['days'] ?? ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'],
            'experience' => $data['experience'] ?? null,
            'education' => $data['education'] ?? null,
            'photo' => $data['photo'] ?: 'https://images.unsplash.com/photo-1622253692010-333f2da6031d?auto=format&fit=crop&w=600&q=80',
            'order' => $data['order'] ?? 0,
            'is_active' => $data['is_active'] ?? true,
        ]);

        return $doctor;
    }

    public function updateDoctor(Doctor $doctor, array $data): Doctor
    {
        $doctor->update([
            'name' => $data['name'],
            'speciality' => $data['speciality'],
            'sub_speciality' => $data['sub_speciality'] ?? null,
            'poli' => $data['poli'],
            'schedule' => $data['schedule'],
            'days' => $data['days'] ?? $doctor->days,
            'experience' => $data['experience'] ?? null,
            'education' => $data['education'] ?? null,
            'photo' => $data['photo'] ?: $doctor->photo,
            'order' => $data['order'] ?? 0,
            'is_active' => $data['is_active'] ?? false,
        ]);

        return $doctor;
    }

    public function deleteDoctor(Doctor $doctor): bool
    {
        return $this->doctorRepository->delete($doctor->id);
    }
}
