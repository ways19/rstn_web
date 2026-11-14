<?php

namespace App\Modules\Medical\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Modules\Medical\Requests\DoctorRequest;
use App\Modules\Medical\Services\DoctorService;
use Illuminate\Support\Facades\Storage;

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

        $photoSource = $request->input('photo_source', 'upload');

        if ($photoSource === 'upload' && $request->hasFile('photo_file')) {
            $data['photo'] = $request->file('photo_file')->store('doctors', 'public');
        } elseif ($photoSource === 'url') {
            $rawUrl = $request->input('photo_url') ?: $request->input('photo');
            $data['photo'] = Doctor::formatPhotoUrl($rawUrl);
        } else {
            // Jika upload dipilih tapi tidak ada file yang dipilih, fallback ke photo_url / photo jika ada
            $rawUrl = $request->input('photo_url') ?: $request->input('photo');
            $data['photo'] = Doctor::formatPhotoUrl($rawUrl);
        }

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

        $currentRawPhoto = $doctor->getRawOriginal('photo');
        $photoSource = $request->input('photo_source', 'upload');

        if ($photoSource === 'upload') {
            if ($request->hasFile('photo_file')) {
                // Hapus berkas foto lokal lama jika ada di storage
                if ($currentRawPhoto && !str_starts_with($currentRawPhoto, 'http') && !str_starts_with($currentRawPhoto, '/') && Storage::disk('public')->exists($currentRawPhoto)) {
                    Storage::disk('public')->delete($currentRawPhoto);
                }
                $data['photo'] = $request->file('photo_file')->store('doctors', 'public');
            } else {
                // Tetap gunakan foto yang lama
                $data['photo'] = $currentRawPhoto;
            }
        } elseif ($photoSource === 'url') {
            $rawUrl = $request->input('photo_url') ?: $request->input('photo');
            $newUrl = Doctor::formatPhotoUrl($rawUrl);
            if ($newUrl && $currentRawPhoto && $newUrl !== $currentRawPhoto) {
                // Jika beralih ke URL dan foto lama adalah file lokal, bersihkan file lama
                if (!str_starts_with($currentRawPhoto, 'http') && !str_starts_with($currentRawPhoto, '/') && Storage::disk('public')->exists($currentRawPhoto)) {
                    Storage::disk('public')->delete($currentRawPhoto);
                }
            }
            $data['photo'] = $newUrl ?: $currentRawPhoto;
        }

        $this->doctorService->updateDoctor($doctor, $data);

        return redirect()->route('admin.doctors.index')->with('success', 'Data dokter berhasil diperbarui.');
    }

    public function destroy(Doctor $doctor)
    {
        $currentRawPhoto = $doctor->getRawOriginal('photo');
        if ($currentRawPhoto && !str_starts_with($currentRawPhoto, 'http') && !str_starts_with($currentRawPhoto, '/') && Storage::disk('public')->exists($currentRawPhoto)) {
            Storage::disk('public')->delete($currentRawPhoto);
        }

        $this->doctorService->deleteDoctor($doctor);
        return redirect()->route('admin.doctors.index')->with('success', 'Data dokter berhasil dihapus.');
    }
}
