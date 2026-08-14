<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('category'); // e.g. Rekomendasi, Tips Membaca, Wawancara, Berita
            $table->string('thumbnail')->nullable();
            $table->text('excerpt'); // Cuplikan singkat untuk kartu artikel
            $table->longText('content'); // Isi lengkap artikel
            $table->string('author_name')->default('Tim IGAKERTA');
            $table->integer('read_time')->default(3); // Estimasi menit baca
            $table->boolean('is_featured')->default(false); // Untuk highlight di Hero
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
