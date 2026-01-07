<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MenuController extends Controller
{
    /**
     * INDEX: dipakai untuk 2 route
     * - /                  -> katalog user
     * - /admin/menus       -> daftar menu admin
     */
    public function index()
    {
        // Jika route yang memanggil adalah admin.menus.index
        if (request()->routeIs('admin.menus.index')) {
            $menus = Menu::orderBy('created_at', 'desc')->get();

            return view('admin.menus.index', compact('menus'));
        }

        // Kalau route yang memanggil adalah katalog user (/)
        $menus = Menu::where('status', 'tersedia')->paginate(12);

        return view('katalog.index', compact('menus'));
    }

    /**
     * Dashboard admin.
     */
    public function adminDashboard()
    {
        // Statistik menu
        $totalMenu    = Menu::count();
        $menuTersedia = Menu::where('status', 'tersedia')->count();
        $menuHabis    = Menu::where('status', 'habis')->count();

        $categoryStats = Menu::selectRaw('kategori, COUNT(*) as total')
            ->groupBy('kategori')
            ->get();

        // Statistik penjualan
        $today = Carbon::today();

        $todaySales = Order::whereDate('order_date', $today)
            ->sum('grand_total');

        $last7Sales = Order::whereBetween('order_date', [
                $today->copy()->subDays(6),
                $today->copy()->endOfDay(),
            ])
            ->sum('grand_total');

        $todayOrdersCount = Order::whereDate('order_date', $today)->count();
        $last7OrdersCount = Order::whereBetween('order_date', [
                $today->copy()->subDays(6),
                $today->copy()->endOfDay(),
            ])->count();

        // Menu terlaris 7 hari terakhir
        $topMenus = DB::table('order_items')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('menus', 'order_items.menu_id', '=', 'menus.id')
            ->whereBetween('orders.order_date', [
                $today->copy()->subDays(6),
                $today->copy()->endOfDay(),
            ])
            ->groupBy('order_items.menu_id', 'menus.nama_menu', 'menus.kategori')
            ->selectRaw('menus.nama_menu, menus.kategori, SUM(order_items.qty) as qty')
            ->orderByDesc('qty')
            ->limit(5)
            ->get();

        // ===== DATA UNTUK DIAGRAM PENJUALAN HARIAN (7 HARI TERAKHIR) =====
        $start = $today->copy()->subDays(6);

        $dailyChartRaw = Order::selectRaw('DATE(order_date) as date, SUM(grand_total) as total')
            ->whereBetween('order_date', [$start->copy()->startOfDay(), $today->copy()->endOfDay()])
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->keyBy('date');

        $dailyChartLabels = [];
        $dailyChartData   = [];

        for ($d = $start->copy(); $d->lte($today); $d->addDay()) {
            $key = $d->toDateString();
            $dailyChartLabels[] = $d->format('d M');
            $dailyChartData[]   = isset($dailyChartRaw[$key]) ? (int) $dailyChartRaw[$key]->total : 0;
        }

        // ===== TARGET OMZET BULANAN & HARIAN UNTUK DIAGRAM =====
        // Ambil target bulanan dari session, default 15.000.000
        $targetMonthly = (int) session('dashboard_target_monthly', 15000000);

        // Jumlah hari di bulan berjalan
        $daysInMonth = Carbon::now()->daysInMonth;
        $dailyTarget = $daysInMonth > 0 ? intdiv($targetMonthly, $daysInMonth) : 0;

        // Data garis target untuk chart (panjang sama dengan jumlah label harian)
        $targetData = array_fill(0, count($dailyChartLabels), $dailyTarget);

        return view('admin.dashboard', [
            'totalMenu'        => $totalMenu,
            'menuTersedia'     => $menuTersedia,
            'menuHabis'        => $menuHabis,
            'categoryStats'    => $categoryStats,
            'todaySales'       => $todaySales,
            'last7Sales'       => $last7Sales,
            'todayOrdersCount' => $todayOrdersCount,
            'last7OrdersCount' => $last7OrdersCount,
            'topMenus'         => $topMenus,
            'dailyChartLabels' => $dailyChartLabels,
            'dailyChartData'   => $dailyChartData,
            'targetData'       => $targetData,
            'dailyTarget'      => $dailyTarget,
            'targetMonthly'    => $targetMonthly,
        ]);
    }

    /**
     * Simpan target omzet bulanan dashboard.
     */
    public function updateTarget(Request $request)
    {
        $data = $request->validate([
            'target_monthly' => 'required|integer|min:0',
        ]);

        // Simpan sementara di session (bisa nanti dipindah ke tabel settings)
        session(['dashboard_target_monthly' => $data['target_monthly']]);

        return redirect()->route('admin.dashboard')
            ->with('status', 'Target omzet bulanan diperbarui.');
    }

    /**
     * Tampilkan form tambah menu (admin).
     */
    public function create()
    {
        return view('admin.menus.create');
    }

    /**
     * Simpan menu baru (admin).
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_menu' => 'required|string|max:255',
            'harga'     => 'required|integer',
            'deskripsi' => 'nullable|string',
            'kategori'  => 'required|in:bakso,mie,minuman',
            'stok'      => 'required|integer',
            'status'    => 'required|in:tersedia,habis',
            'foto'      => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('menus', 'public');
        }

        Menu::create($data);

        return redirect()->route('admin.menus.index')
            ->with('success', 'Menu berhasil ditambahkan.');
    }

    /**
     * Detail menu untuk user/admin.
     */
    public function show(Menu $menu)
    {
        // Untuk user: detail katalog
        if (request()->routeIs('menu.show')) {
            return view('katalog.detail', compact('menu'));
        }

        // Untuk admin (route admin.menus.show jika dipakai)
        return view('admin.menus.show', compact('menu'));
    }

    /**
     * Form edit menu (admin).
     */
    public function edit(Menu $menu)
    {
        return view('admin.menus.edit', compact('menu'));
    }

    /**
     * Update menu (admin).
     */
    public function update(Request $request, Menu $menu)
    {
        $data = $request->validate([
            'nama_menu' => 'required|string|max:255',
            'harga'     => 'required|integer',
            'deskripsi' => 'nullable|string',
            'kategori'  => 'required|in:bakso,mie,minuman',
            'stok'      => 'required|integer',
            'status'    => 'required|in:tersedia,habis',
            'foto'      => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('menus', 'public');
        }

        $menu->update($data);

        return redirect()->route('admin.menus.index')
            ->with('success', 'Menu berhasil diperbarui.');
    }

    /**
     * Hapus menu (admin).
     */
    public function destroy(Menu $menu)
    {
        $menu->delete();

        return redirect()->route('admin.menus.index')
            ->with('success', 'Menu berhasil dihapus.');
    }
}
