<?php

namespace App\Modules\Ppid\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PpidObjection;
use Illuminate\Http\Request;

class AdminPpidObjectionController extends Controller
{
    public function index()
    {
        $objections = PpidObjection::latest()->get();

        return view(
            'admin.ppid.objections.index',
            compact('objections')
        );
    }

    public function show(PpidObjection $ppidObjection)
    {
        return view(
            'admin.ppid.objections.show',
            [
                'objection' => $ppidObjection,
            ]
        );
    }

    public function update(
        Request $request,
        PpidObjection $ppidObjection
    ) {
        $validated = $request->validate([
            'status' => [
                'required',
                'in:diajukan,diverifikasi,diproses,selesai,ditolak',
            ],
            'admin_note' => [
                'nullable',
                'string',
            ],
        ]);

        $ppidObjection->update([
            'status' => $validated['status'],
            'admin_note' => $validated['admin_note'] ?? null,
        ]);

        return redirect()
            ->route(
                'admin.ppid.objections.show',
                $ppidObjection
            )
            ->with(
                'success',
                'Status pengajuan keberatan berhasil diperbarui.'
            );
    }
}