<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BackOrder extends Model
{
    use HasFactory;

    protected $table = 'back_orders';

    protected $fillable = [
        'receiving_id',
        'po_id',
        'supplier_id',
        'bo_code',
        'amount',
        'discount_perc',
        'discount',
        'tax_perc',
        'tax',
        'remarks',
        'status',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            // Get the latest record
            $latest = static::latest('id')->first();

            // Extract number and increment
            $number = $latest ? ((int) substr($latest->bo_code, 3)) + 1 : 1;

            // Format as BO-00001
            $model->bo_code = 'BO-' . str_pad($number, 5, '0', STR_PAD_LEFT);
        });
    }

    // Define relationships
    public function receiving()
    {
        return $this->belongsTo(Receiving::class);
    }

    public function purchaseOrder()
    {
        return $this->belongsTo(PurchaseOrder::class, 'po_id');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function items()
    {
        return $this->hasMany(BoItem::class, 'bo_id');
    }

    // Define the inverse of the polymorphic relation
    public function receivings()
    {
        return $this->morphMany(Receiving::class, 'from');
    }
}
