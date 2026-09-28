<?php

namespace App\Modules\Patient\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Registration;
use App\Modules\Patient\Requests\UpdateRegistrationStatusRequest;
use App\Modules\Patient\Services\RegistrationService;
use Illuminate\Http\Request;

class AdminRegistrationController extends Controller
{
    public function __construct(
        protected RegistrationService $registrationService
    ) {}

    public function index(Request $request)
    {
        $status = $request->query('status');
        $registrations = $this->registrationService->getFilteredRegistrations($status, 15);
        return view('admin.patient.registrations.index', compact('registrations', 'status'));
    }

    public function updateStatus(UpdateRegistrationStatusRequest $request, Registration $registration)
    {
        $status = $request->validated('status');
        $this->registrationService->updateStatus($registration, $status);

        return back()->with('success', "Status antrean {$registration->queue_number} diubah menjadi {$status}.");
    }
}
