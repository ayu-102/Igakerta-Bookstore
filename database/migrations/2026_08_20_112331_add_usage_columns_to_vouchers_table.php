<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('vouchers', function (Blueprint $table) {
            $table->integer('usage_limit')->nullable()->default(null)->after('min_purchase'); // Kuota maksimal (misal: 100x)
            $table->integer('used_count')->default(0)->after('usage_limit'); // Jumlah yang sudah dipakai
        });
    }

    public function down(): void
    {
        Schema::table('vouchers', function (Blueprint $table) {
            $table->dropColumn(['usage_limit', 'used_count']);
        });
    }
};
