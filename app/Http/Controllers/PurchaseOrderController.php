<?php

namespace App\Http\Controllers;

use App\Models\PurchaseOrder; // Corrected model name to PascalCase
use App\Models\Supplier;
use Illuminate\Http\Request;

class PurchaseOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Set the number of records per page (you can adjust the value or make it dynamic)
        $perPage = $request->get('per_page', 10); // Default to 10 if not provided

        // Paginate the PurchaseOrder model
        $purchaseOrders = PurchaseOrder::paginate($perPage);

        // Pass the paginated result to the view
        return view('purchase_order.index', compact('purchaseOrders', 'perPage'));
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
    
        PurchaseOrder::create($request->all());
    
        return redirect()->route('purchase-order.index')->with('success', 'Purchase Order created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $purchaseOrder = PurchaseOrder::findOrFail($id);

        // Pass the ID when redirecting to the show route
        return view('purchase_order.show', compact('purchaseOrder'));

    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PurchaseOrder $purchaseOrder) // Ensure type hinting is correct
    {
        $suppliers = Supplier::all(); // Fetch suppliers for the dropdown
        return view('purchase-order.edit', compact('purchaseOrder', 'suppliers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PurchaseOrder $purchaseOrder) // Ensure type hinting is correct
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
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $ids = explode(',', $request->input('ids'));
    
        // Delete the purchase orders by IDs
        PurchaseOrder::whereIn('id', $ids)->delete();
    
        return redirect()->route('purchase-order.index')->with('success', 'Selected purchase orders deleted successfully.');
    }

}