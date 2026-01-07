<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id',
        'menu_id',
        'qty',
        'price',
        'total',
    ];

    // Item milik satu order
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // Item mengacu ke satu menu
    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }
}
