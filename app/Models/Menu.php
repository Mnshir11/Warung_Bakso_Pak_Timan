<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $fillable = [
        'nama_menu',
        // 'slug',            // kalau belum ada kolomnya, hapus dulu
        'harga',
        'deskripsi',
        'kategori',
        'foto',
        'stok',
        'status',
    ];

    // HAPUS method ini kalau masih ada
    // public function getRouteKeyName(): string
    // {
    //     return 'slug';
    // }
}
