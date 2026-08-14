<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('books', function (Blueprint $table) {
            // Menambahkan kolom baru tanpa menghapus data lama
            $table->enum('type', ['physical', 'ebook'])->default('physical')->after('author');
            $table->string('file_pdf')->nullable()->after('type');
        });
    }

    public function down(): void
    {
        Schema::table('books', function (Blueprint $table) {
            // Untuk rollback jika diperlukan
            $table->dropColumn(['type', 'file_pdf']);
        });
    }
};
