<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Tabel Master Promo / Diskon
        Schema::create('promotions', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Contoh: "Diskon 15% Akhir Tahun", "Flash Sale 50%"
            $table->decimal('discount_percentage', 5, 2); // Nilai persen: 15.00, 50.00
            $table->boolean('is_active')->default(true); // Status aktif / non-aktif
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->timestamps();
        });

        // 2. Tabel Perantara (Pivot) antara Promo dan Buku
        Schema::create('book_promotion', function (Blueprint $table) {
            $table->id();
            $table->foreignId('book_id')->constrained('books')->onDelete('cascade');
            $table->foreignId('promotion_id')->constrained('promotions')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('book_promotion');
        Schema::dropIfExists('promotions');
    }
};
