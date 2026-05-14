<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentMethod extends Model
{
    use HasFactory, SoftDeletes;

    // 'type' dihapus, diganti dengan foreign key 'payment_category_id'
    protected $fillable = ['payment_category_id', 'name', 'sort_order', 'is_active'];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    public function category()
    {
        return $this->belongsTo(PaymentCategory::class, 'payment_category_id')->withTrashed();
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
