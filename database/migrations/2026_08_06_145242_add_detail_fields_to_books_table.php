<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('books', function (Blueprint $table) {
            $table->string('isbn')->nullable()->after('author');
            $table->string('publisher')->nullable()->after('isbn');
            $table->year('publication_year')->nullable()->after('publisher');
            $table->integer('pages')->nullable()->after('publication_year');
            $table->string('dimensions')->nullable()->after('pages'); // contoh: 15.5 x 23 cm
            $table->string('weight')->nullable()->after('dimensions');  // contoh: 350 gram
            $table->string('language')->default('Indonesia')->after('weight');
            $table->enum('cover_type', ['Soft Cover', 'Hard Cover'])->default('Soft Cover')->after('language');
        });
    }

    public function down(): void
    {
        Schema::table('books', function (Blueprint $table) {
            $table->dropColumn([
                'isbn',
                'publisher',
                'publication_year',
                'pages',
                'dimensions',
                'weight',
                'language',
                'cover_type'
            ]);
        });
    }
};
