<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Sale extends Model
{
    use HasFactory;
    protected $table = 'sales';
    protected $primaryKey = 'id';
    protected $keyType = 'int';
    public $incrementing = true;
    public $timestamps = true;
    protected $fillable = [
        'sales_code',
        'client',
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
            $number = $latest ? ((int) substr($latest->sales_code, 5)) + 1 : 1;

            // Format as SALE-00001
            $model->sales_code = 'SALE-' . str_pad($number, 5, '0', STR_PAD_LEFT);
        });
    }

    // Define the many-to-many relationship with Stock
    public function stocks()
    {
        return $this->belongsToMany(Stock::class, 'sale_item', 'sale_id', 'item_id');
    }
    // Define the one-to-many relationship with SaleItem
    public function saleItems()
    {
        return $this->hasMany(SaleItem::class, 'sale_id');
    }

    public function getFormattedAmountAttribute()
    {
        return number_format($this->amount, 2);
    }

    public function setAmountAttribute($value)
    {
        $this->attributes['amount'] = (float) $value;
    }

    public function getFormattedDateCreatedAttribute()
    {
        return $this->created_at ? Carbon::parse($this->created_at)->format('d-m-Y H:i:s') : null;
    }
}
