<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturnList extends Model
{
    use HasFactory;
    protected $table = 'return_lists';

    protected $fillable = [
        'return_code',
        'supplier_id',
        'stock_ids',
        'amount',
        'remarks',
    ];

    protected $casts = [
        'stock_ids' => 'array', // Automatically converts JSON string to array
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    public function stocks()
    {
        return Stock::whereIn('id', $this->stock_ids ?? [])->get();
    }

    public function items()
    {
        return Item::whereIn('id', $this->stocks()->pluck('item_id')->toArray())->get();
    }
}
