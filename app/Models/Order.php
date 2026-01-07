<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'order_date',
        'total_qty',
        'subtotal',
        'discount',
        'grand_total',
        'payment_method',
        'paid_amount',
        'change_amount',
    ];

    protected $casts = [
        'order_date' => 'datetime',
    ];

    // Satu order punya banyak item
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Kasir / user yang membuat order
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
