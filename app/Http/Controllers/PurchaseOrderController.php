<?php

namespace App\Http\Controllers;

use App\Models\purchase_order; // Corrected model name to PascalCase
use App\Models\Supplier;
use Illuminate\Http\Request;

class PurchaseOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $purchaseOrders = purchase_order::all(); // Use PascalCase for model name
        return view('purchase_order.index', compact('purchaseOrders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $suppliers = Supplier::all(); // Fetch suppliers for the dropdown
        return view('purchase_order.create', compact('suppliers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'po_code' => 'required|unique:purchase_orders,po_code', // Use correct table name
            'supplier_id' => 'required|exists:suppliers,id',
            'amount' => 'required|numeric|min:0',
            'status' => 'required|integer|in:0,1,2',
            'remarks' => 'nullable|string', // Add validation for remarks
        ]);
    
        purchase_order::create($request->all());
    
        return redirect()->route('purchase-order.index')->with('success', 'Purchase Order created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(purchase_order $purchaseOrder) // Ensure type hinting is correct
    {
        return view('purchase-order.show', compact('purchaseOrder'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(purchase_order $purchaseOrder) // Ensure type hinting is correct
    {
        $suppliers = Supplier::all(); // Fetch suppliers for the dropdown
        return view('purchase-order.edit', compact('purchaseOrder', 'suppliers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, purchase_order $purchaseOrder) // Ensure type hinting is correct
    {
        $request->validate([
            'po_code' => 'required|unique:purchase_orders,po_code,' . $purchaseOrder->id, // Use correct table name
            'supplier_id' => 'required|exists:suppliers,id',
            'amount' => 'required|numeric|min:0',
            'status' => 'required|integer|in:0,1,2',
        ]);

        $purchaseOrder->update($request->all());

        return redirect()->route('purchase-order.index')->with('success', 'Purchase Order updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(purchase_order $purchaseOrder) // Ensure type hinting is correct
    {
        $purchaseOrder->delete();

        return redirect()->route('purchase-order.index')->with('success', 'Purchase Order deleted successfully!');
    }
}