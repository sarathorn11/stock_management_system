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

    // Define the many-to-many relationship with Stock
    public function stocks()
    {
        return $this->belongsToMany(Stock::class, 'sale_item', 'sale_id', 'item_id');
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
