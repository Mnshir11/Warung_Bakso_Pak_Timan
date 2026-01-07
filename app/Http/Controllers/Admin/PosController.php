<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PosController extends Controller
{
    public function index()
    {
        $menus = Menu::where('status', 'tersedia')
            ->orderBy('nama_menu')
            ->get();

        // pesan error pembayaran (jika ada)
        $paymentError = session('payment_error');

        return view('admin.pos.index', compact('menus', 'paymentError'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'items'               => 'required|array',
            'items.*.menu_id'     => 'required|exists:menus,id',
            'items.*.qty'         => 'required|integer|min:1',
            'items.*.price'       => 'required|integer|min:0',
            'subtotal'            => 'required|integer|min:0',
            'discount'            => 'nullable|integer|min:0',
            'grand_total'         => 'required|integer|min:0',
            'paid_amount'         => 'required|integer|min:0',
            'payment_method'      => 'required|string',
        ]);

        $data['discount'] ??= 0;

        // Cek pembayaran cukup
        if ($data['paid_amount'] < $data['grand_total']) {
            return redirect()
                ->back()
                ->withInput()
                ->with('payment_error', 'Nominal pembayaran kurang dari total yang harus dibayar.');
        }

        // Simpan transaksi dan kembalikan $order
        $order = null;

        DB::transaction(function () use ($data, &$order) {
            $order = Order::create([
                'user_id'        => Auth::id(),
                'order_date'     => now(),
                'total_qty'      => collect($data['items'])->sum('qty'),
                'subtotal'       => $data['subtotal'],
                'discount'       => $data['discount'],
                'grand_total'    => $data['grand_total'],
                'payment_method' => $data['payment_method'],
                'paid_amount'    => $data['paid_amount'],
                'change_amount'  => $data['paid_amount'] - $data['grand_total'],
            ]);

            foreach ($data['items'] as $row) {
                $menu = Menu::findOrFail($row['menu_id']);

                OrderItem::create([
                    'order_id' => $order->id,
                    'menu_id'  => $menu->id,
                    'qty'      => $row['qty'],
                    'price'    => $row['price'],
                    'total'    => $row['qty'] * $row['price'],
                ]);

                $menu->decrement('stok', $row['qty']);
            }
        });

        // Setelah simpan, arahkan ke halaman invoice
        return redirect()
            ->route('admin.pos.invoice', $order->id)
            ->with('status', 'Transaksi berhasil disimpan.');
    }

    // ==== HALAMAN INVOICE SATU ORDER ====
    public function invoice(Order $order)
    {
        $order->load(['items.menu', 'user']);

        return view('admin.orders.invoice', compact('order'));
    }

    // ==== DAFTAR ORDER BERDASARKAN TANGGAL (UNTUK LAPORAN) ====
    public function ordersByDate(Request $request)
    {
        $date = $request->query('date'); // format Y-m-d dari laporan
        $parsedDate = $date ? \Carbon\Carbon::parse($date) : now();

        $orders = Order::with(['user'])
            ->whereDate('order_date', $parsedDate->toDateString())
            ->orderBy('order_date', 'asc')
            ->get();

        return view('admin.orders.index-by-date', [
            'orders'     => $orders,
            'date'       => $parsedDate,
        ]);
    }
}
