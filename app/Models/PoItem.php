<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PoItem extends Model
{
    use HasFactory;
    protected $table = 'po_items';  // Specify the table name

    // Define the fillable attributes for mass assignment
    protected $fillable = [
        'po_id', // Purchase Order ID
        'item_id', // Item ID
        'quantity', // Quantity of the item
        'price', // Price per unit
        'unit', // Unit of measurement
        'total', // Total cost (quantity * price)
    ];

    /**
     * Get the purchase order that owns the po_item.
     */
    public function purchaseOrder()
    {
        return $this->belongsTo(PurchaseOrder::class, 'po_id');
    }

    /**
     * Get the item that owns the po_item.
     */
    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id');
    }
}
