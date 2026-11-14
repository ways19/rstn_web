<?php

namespace App\Modules\Medical\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Modules\Medical\Requests\ServiceRequest;
use App\Modules\Medical\Services\ServiceService;

class AdminServiceController extends Controller
{
    public function __construct(
        protected ServiceService $serviceService
    ) {}

    public function index()
    {
        $services = $this->serviceService->getAllOrdered();
        return view('admin.medical.services.index', compact('services'));
    }

    public function create()
    {
        return view('admin.medical.services.create');
    }

    public function store(ServiceRequest $request)
    {
        $data = $request->validated();
        $data['is_active'] = $request->boolean('is_active', true);

        if ($request->hasFile('image_360_file')) {
            $path = $request->file('image_360_file')->store('services-360', 'public');
            $data['image'] = '/storage/' . $path;
            $data['image_360'] = '/storage/' . $path;
        } elseif (! empty($data['image'])) {
            $data['image_360'] = $data['image'];
        }

        $this->serviceService->createService($data);

        return redirect()->route('admin.services.index')->with('success', 'Layanan berhasil ditambahkan.');
    }

    public function edit(Service $service)
    {
        return view('admin.medical.services.edit', compact('service'));
    }

    public function update(ServiceRequest $request, Service $service)
    {
        $data = $request->validated();
        $data['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('image_360_file')) {
            $path = $request->file('image_360_file')->store('services-360', 'public');
            $data['image'] = '/storage/' . $path;
            $data['image_360'] = '/storage/' . $path;
        } elseif (! empty($data['image'])) {
            $data['image_360'] = $data['image'];
        }

        $this->serviceService->updateService($service, $data);

        return redirect()->route('admin.services.index')->with('success', 'Layanan berhasil diperbarui.');
    }

    public function destroy(Service $service)
    {
        $this->serviceService->deleteService($service);
        return redirect()->route('admin.services.index')->with('success', 'Layanan berhasil dihapus.');
    }
}
