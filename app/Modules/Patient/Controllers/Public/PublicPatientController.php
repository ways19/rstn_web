<?php

namespace App\Modules\Patient\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Modules\Medical\Services\DoctorService;
use App\Modules\Patient\Requests\StorePublicComplaintRequest;
use App\Modules\Patient\Requests\StorePublicRegistrationRequest;
use App\Modules\Patient\Services\ComplaintService;
use App\Modules\Patient\Services\RegistrationService;

class PublicPatientController extends Controller
{
    public function __construct(
        protected RegistrationService $registrationService,
        protected DoctorService $doctorService,
        protected ComplaintService $complaintService
    ) {}

    /**
     * Form Pendaftaran Pasien Online
     */
    public function registration()
    {
        $clinics = [
            'Poli Penyakit Dalam',
            'Poli Anak',
            'Poli Kebidanan & Kandungan (Obgyn)',
            'Poli Bedah',
            'Poli Jantung & Pembuluh Darah',
            'Poli Mata',
            'Poli Saraf',
            'Poli THT-KL',
            'Poli Gigi & Mulut'
        ];
        $doctors = $this->doctorService->getActiveOrdered();

        return view('public.patient.registration.index', compact('clinics', 'doctors'));
    }

    /**
     * Proses Simpan Pendaftaran Online Pasien
     */
    public function storeRegistration(StorePublicRegistrationRequest $request)
    {
        $reg = $this->registrationService->registerPatient($request->validated());

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'data' => $reg,
            ]);
        }

        return redirect()->route('registration')->with('registration_success', $reg);
    }

    /**
     * Halaman Kontak & Pengaduan
     */
    public function contact()
    {
        return view('public.patient.contact.index');
    }

    /**
     * Proses Simpan Aduan / Saran Masyarakat
     */
    public function storeComplaint(StorePublicComplaintRequest $request)
    {
        $this->complaintService->createComplaint($request->validated());

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Pengaduan berhasil dikirim.',
            ]);
        }

        return back()->with('complaint_success', true);
    }
}
