<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    use HasFactory;

    protected $fillable = [
        'item',
        'amount',
        'description',
        'date',
        'is_paid',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
