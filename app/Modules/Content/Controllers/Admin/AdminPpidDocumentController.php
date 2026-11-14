<?php

namespace App\Modules\Content\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\PageSection;
use App\Models\PpidDocument;
use App\Modules\Content\Requests\PpidDocumentRequest;
use App\Modules\Content\Services\PpidDocumentService;

class AdminPpidDocumentController extends Controller
{
    public function __construct(
        protected PpidDocumentService $documentService
    ) {}

    public function index()
    {
        $documents = $this->documentService->getAll()
            ->sortBy([
                ['category', 'asc'],
                ['sort_order', 'asc'],
                ['title', 'asc'],
            ]);

        return view(
            'admin.content.ppid-documents.index',
            compact('documents')
        );
    }

    public function create()
    {
        $pages = Page::where('is_active', true)
            ->orderBy('title')
            ->get();

        $sections = PageSection::where('is_active', true)
            ->with('page')
            ->orderBy('page_id')
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        return view(
            'admin.content.ppid-documents.create',
            compact('pages', 'sections')
        );
    }

    public function store(PpidDocumentRequest $request)
    {
        $this->documentService->createDocument(
            $request->validated()
        );

        return redirect()
            ->route('admin.ppid-documents.index')
            ->with('success', 'Dokumen PPID berhasil ditambahkan.');
    }

    public function edit(PpidDocument $ppidDocument)
    {
        $pages = Page::where('is_active', true)
            ->orderBy('title')
            ->get();

        $sections = PageSection::where('is_active', true)
            ->with('page')
            ->orderBy('page_id')
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        $ppidDocument->load('placements');

        return view(
            'admin.content.ppid-documents.edit',
            compact(
                'ppidDocument',
                'pages',
                'sections'
            )
        );
    }

    public function update(
        PpidDocumentRequest $request,
        PpidDocument $ppidDocument
    ) {
        $this->documentService->updateDocument(
            $ppidDocument,
            $request->validated()
        );

        return redirect()
            ->route('admin.ppid-documents.index')
            ->with('success', 'Dokumen PPID berhasil diperbarui.');
    }

    public function destroy(PpidDocument $ppidDocument)
    {
        $this->documentService->deleteDocument($ppidDocument);

        return redirect()
            ->route('admin.ppid-documents.index')
            ->with('success', 'Dokumen PPID berhasil dihapus.');
    }
}
