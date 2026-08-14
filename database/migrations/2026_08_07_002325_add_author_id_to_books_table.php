<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('books', function (Blueprint $table) {
            // Menambahkan foreign key author_id yang terhubung ke id di tabel authors
            $table->foreignId('author_id')->nullable()->after('category_id')->constrained('authors')->onDelete('cascade');

            // Kolom string 'author' lama bisa dihapus/diabaikan
            $table->dropColumn('author');
        });
    }

    public function down(): void
    {
        Schema::table('books', function (Blueprint $table) {
            $table->dropForeign(['author_id']);
            $table->dropColumn('author_id');
            $table->string('author')->after('slug');
        });
    }
};
