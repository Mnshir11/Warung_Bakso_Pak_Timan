<?php

namespace App\Http\Controllers;

use App\Models\Menu;

class KatalogController extends Controller
{
    // Halaman daftar semua menu
    public function index()
    {
        // Menu yang tersedia dengan pagination
        $menus = Menu::where('status', 'tersedia')
            ->orderBy('nama_menu')
            ->paginate(12);

        // Top 5 menu terjual dalam 7 hari terakhir
        $topMenus = Menu::getTopMenus(7, 3);

        // Get array of top menu IDs untuk highlight di grid
        $topMenuIds = $topMenus->pluck('id')->toArray();

        return view('katalog.index', compact('menus', 'topMenus', 'topMenuIds'));
    }

    // Halaman detail satu menu (pakai id)
    public function show(int $id)
    {
        $menu = Menu::where('id', $id)->firstOrFail();

        if ($menu->status !== 'tersedia') {
            abort(404);
        }

        return view('katalog.show', compact('menu'));
    }
}
