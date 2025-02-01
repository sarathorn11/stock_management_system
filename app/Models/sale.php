<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        'stock_id',
        'remarks',
        'date_created',
    ];

    public function stock()
    {
        return $this->belongsTo(Stock::class, 'stock_id');
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
        if ($this->attributes['date_created']) {
            return \Carbon\Carbon::parse($this->attributes['date_created'])->format('d-m-Y') . ' ' . now()->format('H:i:s');
        }
        return null;
    }
}
