<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleItem extends Model
{
    use HasFactory;
    protected $table = 'sale_item';

    protected $fillable = [
        'sale_id',
        'item_id',
        'quantity',
        'price',
        'total',
    ];

    /**
     * Get the sale that owns the sale_item.
     */
    public function sale()
    {
        return $this->belongsTo(Sale::class, 'sale_id');
    }

    /**
     * Get the item that owns the sale_item.
     */
    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id');
    }
}
