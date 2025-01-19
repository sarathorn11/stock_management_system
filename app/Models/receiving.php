<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Receiving extends Model
{
    use HasFactory;

    // Table associated with the model
    protected $table = 'receiving_list';

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

    // If you have foreign relationships, you can define them here
    public function form()
    {
        return $this->belongsTo(Form::class, 'from_id'); // Example: Assumes 'Form' is another model
    }

    // Additional methods or logic can go here
}
