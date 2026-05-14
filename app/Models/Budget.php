<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Budget extends Model
{
    use HasFactory;

    // Mass assignment protection
    protected $fillable = [
        'user_id', 
        'payment_category_id', 
        'amount', 
        'month'
    ];

    /**
     * Relasi Balik ke User.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke Kategori Utama.
     * Digunakan untuk menampilkan nama kategori (misal: "Kebutuhan Pokok") di progress bar.
     */
    public function category()
    {
        return $this->belongsTo(PaymentCategory::class, 'payment_category_id')->withTrashed();
    }
}
