<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('authors', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('title')->nullable(); // Contoh: "Dosen & Peneliti Senior" atau "Penulis Best Seller"
            $table->string('photo')->nullable(); // Path foto profil
            $table->text('bio')->nullable();
            $table->boolean('is_featured')->default(false); // Flag untuk ditampilkan di section "Penulis Pilihan"
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('authors');
    }
};
