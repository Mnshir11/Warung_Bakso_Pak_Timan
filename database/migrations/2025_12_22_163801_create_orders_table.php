<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            // kasir yang membuat transaksi (boleh null kalau belum pakai user)
            $table->foreignId('user_id')
                  ->nullable()
                  ->constrained()
                  ->nullOnDelete();

            // waktu transaksi
            $table->dateTime('order_date');

            // ringkasan qty & nominal
            $table->integer('total_qty');
            $table->integer('subtotal');
            $table->integer('discount')->default(0);
            $table->integer('grand_total');

            // pembayaran
            $table->string('payment_method')->default('cash');
            $table->integer('paid_amount')->default(0);
            $table->integer('change_amount')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
