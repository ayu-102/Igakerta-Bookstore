<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('testimonials', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nama pembaca/pembeli
            $table->string('role')->nullable(); // Contoh: "Mahasiswa Untirta" / "Peneliti"
            $table->string('avatar')->nullable(); // Foto avatar pembaca
            $table->text('quote'); // Isi ulasan/kata pembaca
            $table->unsignedTinyInteger('rating')->default(5); // Rating bintang (1-5)
            $table->boolean('is_active')->default(true); // Flag tampil/sembunyi
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('testimonials');
    }
};
