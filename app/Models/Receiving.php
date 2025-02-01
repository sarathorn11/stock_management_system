<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Receiving extends Model
{
    use HasFactory;

    // Table associated with the model
    protected $table = 'receivings';

    // The attributes that are mass assignable
    protected $fillable = [
        'from_id',
        'from_order',
        'amount',
        'discount_perc',
        'discount',
        'tax_perc',
        'tax',
        'stock_ids',
        'remarks',
    ];

    // Polymorphic relation to 'from' (supplier, vendor, etc.)
    public function from()
    {
        return $this->morphTo(__FUNCTION__, 'from_order', 'from_id');
    }

    // Relationship for stock items (many-to-many)
    public function stockItems()
    {
        return $this->belongsToMany(StockItem::class, 'receiving_stock_item', 'receiving_id', 'stock_item_id');
    }

    // Additional methods or logic can go here
}
