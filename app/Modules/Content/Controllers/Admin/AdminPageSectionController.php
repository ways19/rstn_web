<?php

namespace App\Modules\Content\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\PageSection;
use App\Modules\Content\Requests\PageSectionRequest;
use App\Modules\Content\Services\PageSectionService;
use Illuminate\Http\Request;

class AdminPageSectionController extends Controller
{
    public function __construct(
        protected PageSectionService $sectionService
    ) {}

    public function create()
    {
        $pages = Page::where('is_active', true)
            ->orderBy('title')
            ->get();

        $sections = PageSection::where('level', 1)
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        return view(
            'admin.content.page-sections.create',
            compact('pages', 'sections')
        );
    }

    public function store(PageSectionRequest $request)
    {
        $this->sectionService->createSection(
            $request->validated()
        );

        return redirect()
            ->route('admin.pages.index', ['tab' => 'sections'])
            ->with('success', 'Section berhasil ditambahkan.');
    }

    public function reorder(Request $request)
    {
        $data = $request->validate([
            'page_id' => ['required', 'integer', 'exists:pages,id'],
            'section_ids' => ['required', 'array'],
            'section_ids.*' => ['integer', 'exists:page_sections,id'],
        ]);

        foreach ($data['section_ids'] as $index => $sectionId) {
            PageSection::where('id', $sectionId)
                ->where('page_id', $data['page_id'])
                ->where('level', 1)
                ->update([
                    'sort_order' => $index + 1,
                ]);
        }

        return response()->json([
            'success' => true,
        ]);
    }

    public function edit(PageSection $pageSection)
    {
        $pages = Page::where('is_active', true)
            ->orderBy('title')
            ->get();

        $pageSection->load([
            'page',
            'placements.document',
        ]);

        return view(
            'admin.content.page-sections.edit',
            compact('pageSection', 'pages')
        );
    }

    public function update(
        PageSectionRequest $request,
        PageSection $pageSection
    ) {
        $this->sectionService->updateSection(
            $pageSection,
            $request->validated()
        );

        return redirect()
            ->route('admin.pages.index', ['tab' => 'sections'])
            ->with('success', 'Section berhasil diperbarui.');
    }

    public function destroy(PageSection $pageSection)
    {
        $this->sectionService->deleteSection($pageSection);

        return redirect()
            ->route('admin.pages.index', ['tab' => 'sections'])
            ->with('success', 'Section berhasil dihapus.');
    }
}
