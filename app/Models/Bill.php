<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    protected $fillable = ['user_id', 'name', 'amount', 'due_date', 'is_paid', 'paid_at', 'month'];
    protected $casts = [
        'due_date' => 'date',
        'is_paid' => 'boolean',
        'paid_at' => 'datetime'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
