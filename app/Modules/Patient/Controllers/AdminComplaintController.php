<?php

namespace App\Modules\Patient\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use App\Modules\Patient\Requests\ReplyComplaintRequest;
use App\Modules\Patient\Services\ComplaintService;

class AdminComplaintController extends Controller
{
    public function __construct(
        protected ComplaintService $complaintService
    ) {}

    public function index()
    {
        $complaints = $this->complaintService->getPaginatedComplaints(15);
        return view('admin.patient.complaints.index', compact('complaints'));
    }

    public function show(Complaint $complaint)
    {
        return view('admin.patient.complaints.show', compact('complaint'));
    }

    public function reply(ReplyComplaintRequest $request, Complaint $complaint)
    {
        $this->complaintService->replyComplaint($complaint, $request->validated());

        return back()->with('success', 'Tanggapan pengaduan berhasil disimpan.');
    }
}
