<?php

namespace App\Modules\Navigation\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Navigation\Services\SettingService;
use Illuminate\Http\Request;

class AdminSettingController extends Controller
{
    public function __construct(
        protected SettingService $settingService
    ) {}

    public function index()
    {
        $settings = $this->settingService->getAllSettings();
        return view('admin.navigation.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $inputs = $request->except(['_token']);
        $this->settingService->updateSettings($inputs);

        return back()->with('success', 'Pengaturan situs rumah sakit berhasil disimpan.');
    }
}
