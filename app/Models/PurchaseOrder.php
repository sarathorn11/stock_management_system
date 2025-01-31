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
        'po_code',        // Purchase order code
        'supplier_id',    // Supplier ID
        'amount',         // Total amount
        'discount_perc',  // Discount percentage
        'discount',       // Discount amount
        'tax_perc',       // Tax percentage
        'tax',            // Tax amount
        'remarks',        // Remarks
        'status',         // Status of the purchase order
    ];

    /**
     * Define the relationship: A purchase order belongs to a supplier.
     */
    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    /**
     * Define the relationship: A purchase order has many PO items.
     */
    public function poItems()
    {
        return $this->hasMany(PoItem::class, 'po_id');
    }

    /**
     * Accessor to format the amount as currency.
     */
    public function getFormattedAmountAttribute()
    {
        return number_format($this->amount, 2);
    }

    /**
     * Scope to filter purchase orders by status.
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope to filter purchase orders by supplier.
     */
    public function scopeBySupplier($query, $supplierId)
    {
        return $query->where('supplier_id', $supplierId);
    }

    /**
     * Mutator to ensure status is always stored as an integer.
     */
    public function setStatusAttribute($value)
    {
        $this->attributes['status'] = (int)$value;
    }
}
