<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique();

            // Data Pemesan & Alamat
            $table->string('recipient_name');
            $table->string('phone_number');
            $table->text('address_detail');
            $table->string('city');
            $table->string('province');
            $table->string('postal_code');

            // Pengiriman & Pembayaran
            $table->string('shipping_method')->default('Reguler (JNE REG)');
            $table->decimal('shipping_cost', 12, 2)->default(15000);
            $table->string('payment_method');
            $table->text('notes')->nullable();

            // Total Rincian
            $table->decimal('subtotal', 12, 2);
            $table->decimal('discount', 12, 2)->default(0);
            $table->decimal('grand_total', 12, 2);

            // Status Pesanan (pending, paid, shipped, completed, cancelled)
            $table->string('status')->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
