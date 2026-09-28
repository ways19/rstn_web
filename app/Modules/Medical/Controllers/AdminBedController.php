<?php

namespace App\Modules\Medical\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Medical\Requests\UpdateBedRequest;
use App\Modules\Medical\Services\BedService;

class AdminBedController extends Controller
{
    public function __construct(
        protected BedService $bedService
    ) {}

    public function index()
    {
        $beds = $this->bedService->getAllOrdered();
        return view('admin.medical.beds.index', compact('beds'));
    }

    public function update(UpdateBedRequest $request)
    {
        $this->bedService->updateBeds($request->input('beds', []));
        return redirect()->route('admin.beds.index')->with('success', 'Ketersediaan tempat tidur berhasil diperbarui.');
    }
}
