<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'author_id',
        'publisher_id', // GANTI 'publisher' MENJADI 'publisher_id'
        'title',
        'slug',
        'isbn',
        'publication_year',
        'pages',
        'dimensions',
        'weight',
        'language',
        'cover_type',
        'type',
        'file_pdf',
        'price',
        'stock',
        'discount_price',
        'cover_image',
        'description',
        'is_featured'
    ];

    public function author()
    {
        return $this->belongsTo(Author::class, 'author_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function publisher()
    {
        return $this->belongsTo(Publisher::class);
    }
    public function promotions()
    {
        return $this->belongsToMany(Promotion::class, 'book_promotion');
    }
    public function reviews()
    {
        return $this->hasMany(Review::class)->latest();
    }
}
