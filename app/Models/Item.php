<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;
    protected $table = 'items';  // Specify the table name

    // Specify the attributes that are mass assignable
    protected $fillable = ['name', 'description', 'supplier_id', 'cost', 'unit', 'status'];

    /**
     * Get the supplier that owns the item.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id', 'id');
    }
}
