<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;
    protected $table = 'stocks';
    protected $primaryKey = 'id';
    protected $keyType = 'int';
    public $incrementing = true;
    public $timestamps = false;
    protected $fillable = [
        'item_id',
        'quantity',
        'unit',
        'price',
        'total',
        'type',
        'date_created',
    ];

    /**
     * Relationship with the Item model.
     * A stock entry belongs to a single item.
     */
    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id');
    }

    /**
     * Accessor for formatted price.
     * @return string
     */
    public function getFormattedPriceAttribute()
    {
        return number_format($this->price, 2);
    }

    /**
     * Accessor for formatted total.
     * @return string
     */
    public function getFormattedTotalAttribute()
    {
        return number_format($this->total, 2);
    }

    /**
     * Mutator for setting the price.
     * Ensures the price is always stored as a float.
     * @param mixed $value
     */
    public function setPriceAttribute($value)
    {
        $this->attributes['price'] = (float) $value;
    }

    /**
     * Mutator for setting the total.
     * Ensures the total is always stored as a float.
     * @param mixed $value
     */
    public function setTotalAttribute($value)
    {
        $this->attributes['total'] = (float) $value;
    }

    public function getFormattedDateCreatedAttribute()
    {
        if ($this->attributes['date_created']) {
            return \Carbon\Carbon::parse($this->attributes['date_created'])->format('d-m-Y') . ' ' . now()->format('H:i:s');
        }
        return null;
    }
}
