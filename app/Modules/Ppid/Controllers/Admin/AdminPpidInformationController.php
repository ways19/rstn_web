<?php

namespace App\Modules\Ppid\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PpidInformationRequest;

class AdminPpidInformationController extends Controller
{
    public function index()
    {
        $requests = PpidInformationRequest::latest()->get();

        return view(
            'admin.ppid.information.index',
            compact('requests')
        );
    }
}