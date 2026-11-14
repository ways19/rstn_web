<?php

namespace App\Modules\Navigation\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;

class AdminTabReferenceController extends Controller
{
    public function index()
    {
        $groups = Menu::where('location', 'public')
            ->whereNull('parent_id')
            ->with([
                'children' => function ($query) {
                    $query->where('is_active', true)
                        ->orderBy('order');
                },
                'children.page',
            ])
            ->orderBy('order')
            ->get();

        return view(
            'admin.navigation.tab-references.index',
            compact('groups')
        );
    }

    public function storeGroup(Request $request)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
        ]);

        Menu::create([
            'location' => 'public',
            'parent_id' => null,
            'title' => $data['title'],
            'url' => '#',
            'route_name' => null,
            'icon' => null,
            'target' => '_self',
            'permission_name' => null,
            'order' => (Menu::where('location', 'public')
                ->whereNull('parent_id')
                ->max('order') ?? 0) + 1,
            'is_active' => true,
        ]);

        return redirect()
            ->route('admin.tab-references.index')
            ->with('success', 'Kelompok menu berhasil ditambahkan.');
    }

    public function updateTab(Request $request, Menu $menu)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'order' => ['required', 'integer', 'min:1'],
            'slug' => ['nullable', 'string', 'max:255'],
            'page_id' => ['nullable', 'exists:pages,id'],
            'url' => ['nullable', 'string', 'max:2048'],
        ]);

        $pageId = $data['page_id'] ?? null;

        if ($pageId) {
            $page = \App\Models\Page::findOrFail($pageId);

            $url = '/' . ltrim($page->slug, '/');
        } else {
            $url = $data['url'] ?? null;

            if ($url === '') {
                $url = null;
            }
        }

        $menu->update([
            'title' => $data['title'],
            'order' => $data['order'],
            'page_id' => $pageId,
            'url' => $url,
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()
            ->route('admin.tab-references.index')
            ->with('success', 'Tab menu berhasil diperbarui.');
    }
}