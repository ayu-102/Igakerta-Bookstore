<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vouchers', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('title');
            $table->text('description')->nullable();
            $table->enum('type', ['fixed', 'percentage'])->default('fixed'); // fixed = nominal rupiah, percentage = %
            $table->decimal('amount', 12, 2); // nominal potongan (cth: 10000 atau 10 untuk 10%)
            $table->decimal('min_purchase', 12, 2)->default(0); // minimal total belanja
            $table->date('expiry_date')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vouchers');
    }
};
