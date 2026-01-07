<?php

namespace App\Http\Controllers;

use App\Models\Menu;

class KatalogController extends Controller
{
    // Halaman daftar semua menu
    public function index()
    {
        $menus = Menu::where('status', 'tersedia')
            ->orderBy('nama_menu')
            ->paginate(12);

        return view('katalog.index', compact('menus'));
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
