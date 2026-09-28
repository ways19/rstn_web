<?php

namespace App\Modules\Dashboard\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Dashboard\Services\DashboardService;

class AdminDashboardController extends Controller
{
    public function __construct(
        protected DashboardService $dashboardService
    ) {}

    public function index()
    {
        $data = $this->dashboardService->getDashboardData();
        return view('admin.dashboard.index', $data);
    }
}
