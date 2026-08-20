<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Voucher extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'user_id',
        'title',
        'description',
        'type',
        'amount',
        'min_purchase',
        'usage_limit', // Tambahkan ini
        'used_count',  // Tambahkan ini
        'expiry_date',
        'is_active',
    ];

    protected $casts = [
        'expiry_date' => 'date',
        'is_active' => 'boolean',
    ];

    public function getIsExpiredAttribute()
    {
        if (!$this->expiry_date) {
            return false;
        }

        // Dianggap expired jika HARI INI sudah MELEWATI tanggal expiry_date
        return Carbon::parse($this->expiry_date)->endOfDay()->isPast();
    }
}
