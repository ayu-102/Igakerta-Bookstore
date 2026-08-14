<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'discount_percentage',
        'is_active',
        'start_date',
        'end_date'
    ];

    // Relasi Banyak Buku dalam 1 Promo
    public function books()
    {
        return $this->belongsToMany(Book::class, 'book_promotion');
    }
}
