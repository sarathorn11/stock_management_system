<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    use HasFactory;
    
    protected $table = 'purchase_orders'; // Explicit table definition

    // Define fillable attributes for mass assignment
    protected $fillable = [
        'po_code',        // Purchase order code
        'supplier_id',    // Supplier ID
        'amount',         // Total amount
        'discount_perc',  // Discount percentage
        'tax_perc',       // Tax percentage
        'remarks',        // Remarks
        'status',         // Status of the purchase order
    ];

    // Cast attributes to proper types
    protected $casts = [
        'discount_perc' => 'float',
        'tax_perc' => 'float',
        'amount' => 'float',
    ];

    /**
     * A purchase order belongs to a supplier.
     */
    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    /**
     * A purchase order has many PO items.
     */
    public function poItems()
    {
        return $this->hasMany(PoItem::class, 'po_id');
    }

    /**
     * Alias for poItems() to resolve "undefined relationship: items" error.
     */
    public function items()
    {
        return $this->hasMany(PoItem::class, 'po_id');
    }

    /**
     * Calculate and return the discount amount.
     */
    public function getDiscountAmountAttribute()
    {
        return ($this->amount * $this->discount_perc) / 100;
    }

    /**
     * Calculate and return the tax amount.
     */
    public function getTaxAmountAttribute()
    {
        return ($this->amount * $this->tax_perc) / 100;
    }

    /**
     * Calculate and return the grand total.
     */
    public function getGrandTotalAttribute()
    {
        return $this->amount - $this->discount_amount + $this->tax_amount;
    }

    /**
     * Format the amount as currency.
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
        $this->attributes['status'] = (int) $value;
    }
}
