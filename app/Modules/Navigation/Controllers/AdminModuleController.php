<?php

namespace App\Modules\Navigation\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AppModule;
use App\Models\Permission;
use App\Modules\Navigation\Requests\ModuleRequest;
use App\Modules\Navigation\Services\ModuleService;

class AdminModuleController extends Controller
{
    public function __construct(
        protected ModuleService $moduleService
    ) {}

    public function index()
    {
        $modules = $this->moduleService->getAllOrdered();
        $permissions = Permission::all()->groupBy('group');

        return view('admin.navigation.modules.index', compact('modules', 'permissions'));
    }

    public function edit(AppModule $module)
    {
        return view('admin.navigation.modules.edit', compact('module'));
    }

    public function update(ModuleRequest $request, AppModule $module)
    {
        $this->moduleService->updateModule($module, $request->validated());

        return redirect()->route('admin.modules.index')->with('success', "Modul {$module->name} berhasil diperbarui.");
    }

    public function toggle(AppModule $module)
    {
        $this->moduleService->toggleModule($module);

        $statusText = $module->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return back()->with('success', "Modul {$module->name} berhasil {$statusText}.");
    }
}
