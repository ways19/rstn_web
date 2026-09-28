<?php

namespace App\Modules\Medical\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Modules\Medical\Services\BedService;
use App\Modules\Medical\Services\DoctorService;
use App\Modules\Medical\Services\ServiceService;
use Illuminate\Http\Request;

class PublicMedicalController extends Controller
{
    public function __construct(
        protected ServiceService $serviceService,
        protected DoctorService $doctorService,
        protected BedService $bedService
    ) {}

    /**
     * Layanan Poliklinik & Medis RS
     */
    public function services(Request $request)
    {
        $category = $request->query('kategori', 'semua');
        $services = $this->serviceService->getByCategory($category);

        return view('public.medical.services.index', compact('services', 'category'));
    }

    /**
     * Detail Layanan Medis
     */
    public function serviceDetail(string $slug)
    {
        $data = $this->serviceService->getServiceDetailWithRelated($slug, 3);
        return view('public.medical.services.detail', $data);
    }

    /**
     * Jadwal & Direktori Dokter Spesialis
     */
    public function doctors(Request $request)
    {
        $doctors = $this->doctorService->getActiveOrdered();
        $specialities = $this->doctorService->getSpecialities();

        return view('public.medical.doctors.index', compact('doctors', 'specialities'));
    }

    /**
     * Detail Profil Dokter
     */
    public function doctorDetail(int|string $id)
    {
        $doctor = $this->doctorService->getDoctorDetail($id);
        return view('public.medical.doctors.detail', compact('doctor'));
    }

    /**
     * Ketersediaan Tempat Tidur & Kamar Inap
     */
    public function information()
    {
        $beds = $this->bedService->getAllOrdered();
        return view('public.medical.beds.index', compact('beds'));
    }
}
