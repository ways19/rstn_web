<?php

namespace App\Modules\Ppid\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PpidInformationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminPpidRequestController extends Controller
{
    public function index()
    {
        $requests = PpidInformationRequest::latest()->get();

        return view(
            'admin.ppid.requests.index',
            compact('requests')
        );
    }

    public function show(PpidInformationRequest $ppidInformationRequest)
    {
        return view(
            'admin.ppid.requests.show',
            [
                'request' => $ppidInformationRequest,
            ]
        );
    }

    /**
     * Preview dokumen identitas pemohon PPID.
     * PDF ditampilkan langsung, sedangkan JPG/PNG dikonversi
     * sementara menjadi PDF tanpa menyimpan file hasil konversi.
     */
    public function previewIdentityDocument(
        PpidInformationRequest $ppidInformationRequest
    ) {
        $path = $ppidInformationRequest->identity_file;

        abort_if(
            !$path || !Storage::disk('public')->exists($path),
            404,
            'Dokumen identitas tidak ditemukan.'
        );

        $filePath = Storage::disk('public')->path($path);
        $mimeType = Storage::disk('public')->mimeType($path);

        abort_unless(
            in_array($mimeType, [
                'image/jpeg',
                'image/png',
                'application/pdf',
            ]),
            415,
            'Format dokumen tidak didukung.'
        );

        // Jika file asli PDF, tampilkan langsung.
        if ($mimeType === 'application/pdf') {
            return response()->file($filePath, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="dokumen-identitas.pdf"',
                'X-Content-Type-Options' => 'nosniff',
            ]);
        }

        // Jika file JPG/PNG, konversi sementara menjadi PDF.
        $imageSize = getimagesize($filePath);

        abort_if(
            !$imageSize,
            422,
            'Dokumen gambar tidak dapat dibaca.'
        );

        [$imageWidth, $imageHeight] = $imageSize;

        // Tentukan orientasi halaman berdasarkan ukuran gambar.
        $isLandscape = $imageWidth > $imageHeight;

        $pageWidth = $isLandscape ? 297 : 210;
        $pageHeight = $isLandscape ? 210 : 297;

        // Sisakan margin 10 mm.
        $margin = 10;

        $maxWidth = $pageWidth - (2 * $margin);
        $maxHeight = $pageHeight - (2 * $margin);

        // Pertahankan rasio gambar agar tidak terdistorsi.
        $ratio = min(
            $maxWidth / $imageWidth,
            $maxHeight / $imageHeight
        );

        $renderWidth = $imageWidth * $ratio;
        $renderHeight = $imageHeight * $ratio;

        // Posisikan gambar di tengah halaman.
        $x = ($pageWidth - $renderWidth) / 2;
        $y = ($pageHeight - $renderHeight) / 2;

        $pdf = new \FPDF(
            $isLandscape ? 'L' : 'P',
            'mm',
            'A4'
        );

        $pdf->AddPage();

        $pdf->Image(
            $filePath,
            $x,
            $y,
            $renderWidth,
            $renderHeight
        );

        // Ambil hasil PDF sebagai string tanpa menyimpannya ke disk.
        $pdfContent = $pdf->Output('S');

        return response($pdfContent, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="dokumen-identitas.pdf"',
            'Content-Length' => strlen($pdfContent),
            'X-Content-Type-Options' => 'nosniff',
        ]);
    }
   
    public function update(
        Request $request,
        PpidInformationRequest $ppidInformationRequest
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

        $ppidInformationRequest->update([
            'status' => $validated['status'],
            'admin_note' => $validated['admin_note'] ?? null,
        ]);

        return redirect()
            ->route(
                'admin.ppid.requests.show',
                $ppidInformationRequest
            )
            ->with(
                'success',
                'Status permohonan berhasil diperbarui.'
            );
    }
}