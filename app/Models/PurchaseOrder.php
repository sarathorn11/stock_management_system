<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    use HasFactory;
    protected $table = 'purchase_orders';  // Specify the table name

    // Define the fillable attributes for mass assignment
    protected $fillable = [
        'po_code', // Purchase order code
        'supplier_id', // Supplier ID
        'amount', // Total amount
        'discount_perc', // Discount percentage
        'discount', // Discount amount
        'tax_perc', // Tax percentage
        'tax', // Tax amount
        'remarks', // Remarks
        'status', // Status of the purchase order
    ];

    // Define the relationship: A purchase order belongs to a supplier
    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    // Define the relationship: A purchase order has many po_items
    public function poItems()
    {
        return $this->hasMany(PoItem::class, 'po_id');
    }
}
