<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Menu extends Model
{
    protected $fillable = [
        'nama_menu',
        'harga',
        'deskripsi',
        'kategori',
        'foto',
        'stok',
        'status',
    ];

    // Relationship ke order items
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Method untuk mendapatkan top menu berdasarkan jumlah terjual
    public static function getTopMenus($days = 7, $limit = 5)
    {
        return self::select(
                'menus.id',
                'menus.nama_menu',
                'menus.harga',
                'menus.deskripsi',
                'menus.kategori',
                'menus.foto',
                'menus.stok',
                'menus.status',
                'menus.created_at',
                'menus.updated_at',
                DB::raw('SUM(order_items.qty) as total_terjual')
            )
            ->join('order_items', 'menus.id', '=', 'order_items.menu_id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.order_date', '>=', now()->subDays($days))
            ->groupBy(
                'menus.id',
                'menus.nama_menu',
                'menus.harga',
                'menus.deskripsi',
                'menus.kategori',
                'menus.foto',
                'menus.stok',
                'menus.status',
                'menus.created_at',
                'menus.updated_at'
            )
            ->orderByDesc('total_terjual')
            ->limit($limit)
            ->get();
    }
}
