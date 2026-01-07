<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Menu;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function sales(Request $request)
    {
        // -----------------------------
        // 1. BACA FILTER & PRESET
        // -----------------------------
        $month  = $request->input('month', now()->format('m'));
        $year   = $request->input('year',  now()->format('Y'));
        $preset = $request->input('preset');          // 'today' | 'last7' | null

        $startDate = $request->input('start_date');   // optional
        $endDate   = $request->input('end_date');     // optional

        // range default = 1 bulan terpilih
        $monthStart = Carbon::createFromDate($year, (int)$month, 1)->startOfDay();
        $monthEnd   = (clone $monthStart)->endOfMonth();

        // range yang dipakai di filter atas (bisa di-override)
        if ($preset === 'today') {
            $start = Carbon::today()->startOfDay();
            $end   = Carbon::today()->endOfDay();
        } elseif ($preset === 'last7') {
            $start = Carbon::today()->subDays(6)->startOfDay();
            $end   = Carbon::today()->endOfDay();
        } else {
            $start = $monthStart->copy();
            $end   = $monthEnd->copy();

            if ($startDate) {
                $start = Carbon::parse($startDate)->startOfDay();
            }
            if ($endDate) {
                $end = Carbon::parse($endDate)->endOfDay();
            }
        }

        // -----------------------------
        // 2. OMZET HARI INI & BULAN INI
        // -----------------------------
        $today = Carbon::today();

        $todayTotal = Order::whereDate('order_date', $today)
            ->sum('grand_total');

        $monthlyTotal = Order::whereYear('order_date', $year)
            ->whereMonth('order_date', $month)
            ->sum('grand_total');

        $daysInMonth = $monthStart->daysInMonth;
        $monthlyAveragePerDay = $daysInMonth > 0
            ? (int) floor($monthlyTotal / $daysInMonth)
            : 0;

        // -----------------------------
        // 3. 7 HARI TERAKHIR
        // -----------------------------
        $last7Start = Carbon::today()->subDays(6)->startOfDay();
        $last7End   = Carbon::today()->endOfDay();

        $last7DaysTotal = Order::whereBetween('order_date', [$last7Start, $last7End])
            ->sum('grand_total');

        $last7DaysStats = Order::selectRaw('DATE(order_date) as date')
            ->selectRaw('COUNT(*) as transactions')
            ->selectRaw('SUM(grand_total) as total')
            ->selectRaw('AVG(grand_total) as avg_per_tx')
            ->whereBetween('order_date', [$last7Start, $last7End])
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        // -----------------------------
        // 4. DETAIL HARIAN BULAN TERPILIH
        // -----------------------------
        $dailySales = Order::selectRaw('DATE(order_date) as date')
            ->selectRaw('SUM(grand_total) as total')
            ->whereYear('order_date', $year)
            ->whereMonth('order_date', $month)
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        // -----------------------------
        // 5. RINGKASAN PER KATEGORI (BULAN INI)
        // -----------------------------
        $categorySummary = DB::table('order_items')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('menus', 'order_items.menu_id', '=', 'menus.id')
            ->whereBetween('orders.order_date', [$monthStart, $monthEnd])
            ->groupBy('menus.kategori')
            ->selectRaw('menus.kategori as category')
            ->selectRaw('SUM(order_items.qty) as qty')
            ->selectRaw('SUM(order_items.qty * order_items.price) as total')
            ->orderBy('total', 'desc')
            ->get();

        // -----------------------------
        // 6. TOP PRODUK (BULAN INI)
        // -----------------------------
        $topProducts = DB::table('order_items')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('menus', 'order_items.menu_id', '=', 'menus.id')
            ->whereBetween('orders.order_date', [$monthStart, $monthEnd])
            ->groupBy('order_items.menu_id', 'menus.nama_menu', 'menus.kategori')
            ->selectRaw('menus.nama_menu as menu_name')
            ->selectRaw('menus.kategori as category')
            ->selectRaw('SUM(order_items.qty) as qty')
            ->selectRaw('SUM(order_items.qty * order_items.price) as total')
            ->orderBy('qty', 'desc')
            ->limit(10)
            ->get();

        // -----------------------------
        // 7. KIRIM KE VIEW
        // -----------------------------
        return view('admin.reports.sales', [
            'todayTotal'           => $todayTotal,
            'monthlyTotal'         => $monthlyTotal,
            'dailySales'           => $dailySales,
            'month'                => $month,
            'year'                 => $year,
            'monthlyAveragePerDay' => $monthlyAveragePerDay,
            'last7DaysTotal'       => $last7DaysTotal,
            'last7DaysStats'       => $last7DaysStats,
            'categorySummary'      => $categorySummary,
            'topProducts'          => $topProducts,
        ]);
    }
}
