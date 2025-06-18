<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'saving_id',
        'amount',
        'type',
        'note'
    ];

    public function savings()
    {
        return $this->belongsTo(Saving::class, 'saving_id');
    }

}
