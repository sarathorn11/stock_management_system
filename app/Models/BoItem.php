<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BoItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_id',
        'quantity',
        'price',
        'unit',
        'total',
    ];

    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id');
    }
}
