<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class sales extends Model
{
    use HasFactory;
    protected $fillable = [
        'sales_code',
        'client',
        'amount',
        'stock_id',
        'remarks',
    ];
    public function stock()
    {
        return $this->belongsTo(Stock::class, 'stock_id');
    }
}
