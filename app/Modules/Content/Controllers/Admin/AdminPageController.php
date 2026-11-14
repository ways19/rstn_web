<?php

namespace App\Modules\Content\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\PageSection;
use App\Modules\Content\Requests\PageRequest;
use App\Modules\Content\Services\PageService;
use App\Modules\Content\Services\PpidDocumentService;
use App\Modules\Content\Services\PageSectionService;
use App\Models\AccreditationCertificate;
use App\Models\DiklatDocumentation;
use App\Models\Facility;
use App\Models\DiklatProgram;
use App\Models\DiklatGuideline;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class AdminPageController extends Controller
{
    public function __construct(
        protected PageService $pageService,
        protected PpidDocumentService $documentService,
        protected PageSectionService $sectionService
    ) {}

    public function index()
    {
        $pages = $this->pageService->getAll()
            ->sortBy(function ($page) {
                return match ($page->slug) {
                    'profil-ppid' => 1,
                    'sk-tim-ppid' => 2,
                    'struktur-ppid' => 3,
                    'tugas-fungsi-ppid' => 4,
                    'maklumat-pelayanan-informasi' => 5,
                    'informasi-berkala' => 6,
                    'informasi-serta-merta' => 7,
                    'informasi-setiap-saat' => 8,
                    'informasi-dikecualikan' => 9,
                    default => 99,
                };
            });

        $documents = $this->documentService->getAll()
            ->sortBy([
                ['category', 'asc'],
                ['sort_order', 'asc'],
                ['title', 'asc'],
            ]);

        $sections = PageSection::with('page')
            ->orderBy('page_id')
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        return view(
            'admin.content.pages.index',
            compact('pages', 'documents', 'sections')
        );
    }

    public function create()
    {
        return view('admin.content.pages.create');
    }

    public function store(PageRequest $request)
    {
        $data = $request->validated();

        $this->pageService->createPage($data);

        return redirect()
            ->route('admin.pages.index')
            ->with('success', 'Halaman berhasil ditambahkan.');
    }

    public function storeSection(Request $request, Page $page)
    {
        $data = $request->validate([
            'section_title' => ['required', 'string', 'max:255'],
            'parent_id' => ['nullable', 'integer', 'exists:page_sections,id'],
        ]);

        $this->sectionService->createSection([
            'page_id' => $page->id,
            'title' => $data['section_title'],
            'parent_id' => $data['parent_id'] ?? null,
            'sort_order' => 0,
            'is_active' => true,
        ]);

        return redirect()
            ->route('admin.pages.edit', $page)
            ->with('success', 'Induk informasi berhasil ditambahkan.');
    }

    public function storeInformation(Request $request, Page $page)
    {
        $data = $request->validate([
            'new_information.title' => ['required', 'string', 'max:255'],
            'new_information.section_id' => [
                'required',
                'integer',
                'exists:page_sections,id',
            ],
            'new_information.type' => [
                'required',
                'in:file,page,link',
            ],
            'new_information.file' => [
                'nullable',
                'file',
                'mimes:pdf',
                'max:10240',
            ],
            'new_information.page_id' => [
                'nullable',
                'integer',
                'exists:pages,id',
            ],
            'new_information.url' => [
                'nullable',
                'url',
                'max:255',
            ],
        ]);

        $information = $data['new_information'];

        $this->documentService->createDocument([
            'title' => $information['title'],
            'category' => 'PPID',
            'year' => 2026,
            'type' => $information['type'],
            'file_path' => $information['file'] ?? null,
            'page_id' => $information['page_id'] ?? null,
            'url' => $information['url'] ?? null,
            'page_section_id' => $information['section_id'],
            'is_active' => true,
            'sort_order' => 0,
        ]);

        return redirect()
            ->route('admin.pages.edit', $page)
            ->with('success', 'Informasi berhasil ditambahkan.');
    }

    

    public function edit(Page $page)
    {
        $sections = PageSection::where('page_id', $page->id)
            ->with([
                'children.placements.document',
                'placements.document',
            ])
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        $documents = $this->documentService->getAll()
            ->sortBy([
                ['sort_order', 'asc'],
                ['title', 'asc'],
            ]);

        $page->load(['accreditationCertificates', 'diklatGuidelines']);

        $diklatDocumentations = collect();

        if ($page->slug === 'dokumentasi') {
            $diklatDocumentations = DiklatDocumentation::orderByDesc('event_date')
                ->orderByDesc('created_at')
                ->get();
        }

        // Data fasilitas untuk halaman CMS.
        $facilities = collect();

        // Data program Diklat untuk halaman CMS.
        $diklatPrograms = collect();

        // Form utama selalu digunakan untuk menambah program baru.
        $isEditingDiklat = false;
        $diklatForm = null;

        if ($page->slug === 'pendidikan-pelatihan') {
            $diklatPrograms = DiklatProgram::orderByRaw("
                    CASE
                        WHEN LOWER(category) NOT IN ('pelatihan', 'orientasi') THEN 0
                        ELSE 1
                    END
                ")
                ->orderBy('sort_order')
                ->orderBy('id')
                ->get();
        }

        if ($page->slug === 'fasilitas') {
            $facilities = Facility::orderBy('sort_order')
                ->orderBy('id')
                ->get();
        }

        return view(
            'admin.content.pages.edit',
            compact(
                'page',
                'sections',
                'documents',
                'diklatDocumentations',
                'facilities',
                'diklatPrograms',
                'isEditingDiklat',
                'diklatForm'
            )
        );
    }

    public function update(PageRequest $request, Page $page)
    {
        $data = $request->validated();

        $this->pageService->updatePage($page, $data);

        return redirect()
            ->route('admin.pages.edit', $page)
            ->with('success', 'Halaman berhasil diperbarui.');
    }

    public function destroy(Page $page)
    {
        $this->pageService->deletePage($page);

        return redirect()
            ->route('admin.pages.index')
            ->with('success', 'Halaman berhasil dihapus.');
    }

    //AKREDITASI
    
   
    public function storeAccreditationCertificate(Request $request, Page $page)
    {
        abort_unless($page->slug === 'akreditasi', 404);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'source_type' => ['required', 'in:upload,link'],
            'file' => [
                'required_if:source_type,upload',
                'nullable',
                'file',
                'mimes:jpg,jpeg,png,webp,pdf,doc,docx',
                'max:10240',
            ],
            'external_url' => [
                'required_if:source_type,link',
                'nullable',
                'url',
                'max:2048',
            ],
            'certificate_date' => ['nullable', 'date'],
            'description' => ['nullable', 'string', 'max:1000'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $path = null;
        $externalUrl = null;

        if ($validated['source_type'] === 'upload') {
            $path = $request->file('file')
                ->store('accreditation-certificates', 'public');
        } else {
            $externalUrl = $validated['external_url'];
        }

        AccreditationCertificate::create([
            'page_id' => $page->id,
            'title' => $validated['title'],
            'file_path' => $path,
            'external_url' => $externalUrl,
            'certificate_date' => $validated['certificate_date'] ?? null,
            'description' => $validated['description'] ?? null,
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()
            ->route('admin.pages.edit', $page)
            ->with('success', 'Sertifikat akreditasi berhasil disimpan.');
    }

    public function updateAccreditationCertificate(
        Request $request,
        Page $page,
        AccreditationCertificate $certificate
    ) {
        abort_unless($page->slug === 'akreditasi', 404);
        abort_unless($certificate->page_id === $page->id, 404);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'source_type' => ['required', 'in:upload,link'],
            'file' => [
                $certificate->file_path ? 'nullable' : 'required_if:source_type,upload',
                'nullable',
                'file',
                'mimes:jpg,jpeg,png,webp,pdf,doc,docx',
                'max:10240',
            ],
            'external_url' => [
                'required_if:source_type,link',
                'nullable',
                'url',
                'max:2048',
            ],
            'certificate_date' => ['nullable', 'date'],
            'description' => ['nullable', 'string', 'max:1000'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $path = $certificate->file_path;
        $externalUrl = $certificate->external_url;

        if ($validated['source_type'] === 'upload') {
            if ($request->hasFile('file')) {
                if ($certificate->file_path) {
                    Storage::disk('public')->delete($certificate->file_path);
                }

                $path = $request->file('file')
                    ->store('accreditation-certificates', 'public');
            }

            $externalUrl = null;
        } else {
            if ($certificate->file_path) {
                Storage::disk('public')->delete($certificate->file_path);
            }

            $path = null;
            $externalUrl = $validated['external_url'];
        }

        $certificate->update([
            'title' => $validated['title'],
            'file_path' => $path,
            'external_url' => $externalUrl,
            'certificate_date' => $validated['certificate_date'] ?? $certificate->certificate_date,
            'description' => $validated['description'] ?? null,
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()
            ->route('admin.pages.edit', $page)
            ->with('success', 'Sertifikat akreditasi berhasil diperbarui.');
    }

    public function destroyAccreditationCertificate(
        Page $page,
        AccreditationCertificate $certificate
    ) {
        abort_unless($page->slug === 'akreditasi', 404);
        abort_unless($certificate->page_id === $page->id, 404);

        if ($certificate->file_path) {
            Storage::disk('public')->delete($certificate->file_path);
        }
        $certificate->delete();

        return redirect()
            ->route('admin.pages.edit', $page)
            ->with('success', 'Sertifikat berhasil dihapus.');
    }

    public function storeDiklatGuideline(Request $request, Page $page)
    {
        abort_unless($page->slug === 'pendidikan-pelatihan', 404);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'source_type' => ['required', 'in:upload,link'],
            'file' => [
                'required_if:source_type,upload',
                'nullable',
                'file',
                'mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,zip,rar',
                'max:10240',
            ],
            'external_url' => ['required_if:source_type,link', 'nullable', 'string', 'max:1000'],
            'file_type' => ['nullable', 'string', 'max:20'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $path = null;
        $externalUrl = null;
        $fileType = strtolower($request->input('file_type') ?: 'pdf');

        if ($request->input('source_type') === 'upload' && $request->hasFile('file')) {
            $file = $request->file('file');
            $path = $file->store('diklat-guidelines', 'public');
            $fileType = strtolower($file->getClientOriginalExtension() ?: 'pdf');
        } else {
            $externalUrl = $validated['external_url'] ?? null;
            if ($externalUrl && !preg_match('#^https?://#i', $externalUrl) && $externalUrl !== '#') {
                $externalUrl = 'https://' . $externalUrl;
            }
        }

        $page->diklatGuidelines()->create([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'file_path' => $path,
            'external_url' => $externalUrl,
            'file_type' => $fileType,
            'sort_order' => (int) ($validated['sort_order'] ?? 0),
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()
            ->route('admin.pages.edit', ['page' => $page, 'tab' => 'guidelines'])
            ->with('success', 'Berkas & pedoman berhasil ditambahkan.');
    }

    public function updateDiklatGuideline(Request $request, Page $page, DiklatGuideline $guideline)
    {
        abort_unless($page->slug === 'pendidikan-pelatihan', 404);
        abort_unless($guideline->page_id === $page->id, 404);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'source_type' => ['required', 'in:upload,link'],
            'file' => [
                $guideline->file_path ? 'nullable' : 'required_if:source_type,upload',
                'nullable',
                'file',
                'mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,zip,rar',
                'max:10240',
            ],
            'external_url' => ['required_if:source_type,link', 'nullable', 'string', 'max:1000'],
            'file_type' => ['nullable', 'string', 'max:20'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $path = $guideline->file_path;
        $externalUrl = $guideline->external_url;
        $fileType = $guideline->file_type;

        if ($request->input('source_type') === 'upload') {
            if ($request->hasFile('file')) {
                if ($guideline->file_path) {
                    Storage::disk('public')->delete($guideline->file_path);
                }
                $file = $request->file('file');
                $path = $file->store('diklat-guidelines', 'public');
                $fileType = strtolower($file->getClientOriginalExtension() ?: 'pdf');
            }
            $externalUrl = null;
        } else {
            if ($guideline->file_path) {
                Storage::disk('public')->delete($guideline->file_path);
            }
            $path = null;
            $externalUrl = $validated['external_url'] ?? null;
            if ($externalUrl && !preg_match('#^https?://#i', $externalUrl) && $externalUrl !== '#') {
                $externalUrl = 'https://' . $externalUrl;
            }
            if ($request->filled('file_type')) {
                $fileType = strtolower($request->input('file_type'));
            }
        }

        $guideline->update([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'file_path' => $path,
            'external_url' => $externalUrl,
            'file_type' => $fileType ?: 'pdf',
            'sort_order' => (int) ($validated['sort_order'] ?? 0),
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()
            ->route('admin.pages.edit', ['page' => $page, 'tab' => 'guidelines'])
            ->with('success', 'Berkas & pedoman berhasil diperbarui.');
    }

    public function destroyDiklatGuideline(Page $page, DiklatGuideline $guideline)
    {
        abort_unless($page->slug === 'pendidikan-pelatihan', 404);
        abort_unless($guideline->page_id === $page->id, 404);

        if ($guideline->file_path) {
            Storage::disk('public')->delete($guideline->file_path);
        }
        $guideline->delete();

        return redirect()
            ->route('admin.pages.edit', ['page' => $page, 'tab' => 'guidelines'])
            ->with('success', 'Berkas & pedoman berhasil dihapus.');
    }
}
