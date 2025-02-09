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
    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }
    // public function stock()
    // {
    //     return $this->belongsTo(Stock::class, 'stock_id');
    // }
}
