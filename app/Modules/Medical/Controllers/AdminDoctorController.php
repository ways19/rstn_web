<?php

namespace App\Modules\Medical\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Modules\Medical\Requests\DoctorRequest;
use App\Modules\Medical\Services\DoctorService;

class AdminDoctorController extends Controller
{
    public function __construct(
        protected DoctorService $doctorService
    ) {}

    public function index()
    {
        $doctors = $this->doctorService->getAllOrdered();
        return view('admin.medical.doctors.index', compact('doctors'));
    }

    public function create()
    {
        return view('admin.medical.doctors.create');
    }

    public function store(DoctorRequest $request)
    {
        $data = $request->validated();
        $data['is_active'] = $request->boolean('is_active', true);

        $this->doctorService->createDoctor($data);

        return redirect()->route('admin.doctors.index')->with('success', 'Data dokter berhasil ditambahkan.');
    }

    public function edit(Doctor $doctor)
    {
        return view('admin.medical.doctors.edit', compact('doctor'));
    }

    public function update(DoctorRequest $request, Doctor $doctor)
    {
        $data = $request->validated();
        $data['is_active'] = $request->boolean('is_active');

        $this->doctorService->updateDoctor($doctor, $data);

        return redirect()->route('admin.doctors.index')->with('success', 'Data dokter berhasil diperbarui.');
    }

    public function destroy(Doctor $doctor)
    {
        $this->doctorService->deleteDoctor($doctor);
        return redirect()->route('admin.doctors.index')->with('success', 'Data dokter berhasil dihapus.');
    }
}
