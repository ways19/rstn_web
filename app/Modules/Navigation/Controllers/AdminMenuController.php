<?php

namespace App\Modules\Navigation\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Page;
use App\Models\Permission;
use App\Modules\Navigation\Requests\MenuRequest;
use App\Modules\Navigation\Services\MenuService;
use Illuminate\Http\Request;

class AdminMenuController extends Controller
{
    public function __construct(
        protected MenuService $menuService
    ) {}

    public function index(Request $request)
    {
        $location = $request->query('location', 'public');
        if (! in_array($location, ['public', 'admin'])) {
            $location = 'public';
        }

        $menus = $this->menuService->getTreeByLocation($location);
        $stats = $this->menuService->getStats();

        return view('admin.navigation.menus.index', compact('menus', 'location', 'stats'));
    }

    public function create(Request $request)
    {
        $location = $request->query('location', 'public');
        $parents = $this->menuService->getParentsByLocation($location);
        $permissions = Permission::all();
        $pages = Page::orderBy('title')->get();

        return view('admin.navigation.menus.create', compact(
            'location',
            'parents',
            'permissions',
            'pages'
        ));
    }

    public function store(MenuRequest $request)
    {
        $menu = $this->menuService->createMenu($request->validated());

        return redirect()->route('admin.menus.index', ['location' => $menu->location])
            ->with('success', "Menu {$menu->title} berhasil ditambahkan.");
    }

    public function edit(Menu $menu)
    {
        $parents = $this->menuService->getParentsByLocation($menu->location, $menu->id);
        $permissions = Permission::all();
        $pages = Page::orderBy('title')->get();

        return view('admin.navigation.menus.edit', compact(
            'menu',
            'parents',
            'permissions',
            'pages'
        ));
    }

    public function update(MenuRequest $request, Menu $menu)
    {
        $this->menuService->updateMenu($menu, $request->validated());

        return redirect()->route('admin.menus.index', ['location' => $menu->location])
            ->with('success', "Menu {$menu->title} berhasil diperbarui.");
    }

    public function destroy(Menu $menu)
    {
        $location = $menu->location;
        $title = $menu->title;
        $this->menuService->deleteMenu($menu);

        return redirect()->route('admin.menus.index', ['location' => $location])
            ->with('success', "Menu {$title} dan seluruh sub-menunya berhasil dihapus.");
    }

    public function toggle(Menu $menu)
    {
        $this->menuService->toggleMenu($menu);

        $statusText = $menu->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return back()->with('success', "Menu {$menu->title} berhasil {$statusText}.");
    }
}
