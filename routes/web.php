<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\KatalogController;
use App\Http\Controllers\Admin\PosController;
use App\Http\Controllers\Admin\ReportController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Halaman utama: katalog Warung Bakso Pak Timan (pengunjung)
Route::get('/', [KatalogController::class, 'index'])->name('katalog.index');
Route::get('/menu/{id}', [KatalogController::class, 'show'])->name('katalog.show');

// Dashboard default Breeze (bisa dipakai untuk user biasa)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Route khusus admin (hanya role admin)
Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        // Dashboard admin
        Route::get('dashboard', [MenuController::class, 'adminDashboard'])
            ->name('dashboard');

        // Simpan target omzet bulanan dashboard
        Route::post('dashboard/target', [MenuController::class, 'updateTarget'])
            ->name('dashboard.target.update');

        // CRUD menu
        Route::resource('menus', MenuController::class);

        // POS kasir
        Route::get('pos', [PosController::class, 'index'])->name('pos.index');
        Route::post('pos', [PosController::class, 'store'])->name('pos.store');

        // Daftar order per tanggal (untuk laporan -> lihat invoice harian)
        Route::get('orders', [PosController::class, 'ordersByDate'])->name('pos.orders');

        // Invoice / detail order
        Route::get('orders/{order}/invoice', [PosController::class, 'invoice'])
            ->name('pos.invoice');

        // Laporan penjualan
        Route::get('reports/sales', [ReportController::class, 'sales'])->name('reports.sales');
    });

// Route profile bawaan Breeze
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Route auth Breeze (login, register, dll)
require __DIR__.'/auth.php';
