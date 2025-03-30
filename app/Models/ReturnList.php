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

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            // Get the latest record
            $latest = static::latest('id')->first();

            // Extract number and increment
            $number = $latest ? ((int) substr($latest->return_code, 2)) + 1 : 1;

            // Format as R-00001
            $model->return_code = 'R-' . str_pad($number, 5, '0', STR_PAD_LEFT);
        });
    }

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
