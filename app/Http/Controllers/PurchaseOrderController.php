<?php

namespace App\Http\Controllers;

use App\Models\PurchaseOrder;
use App\Models\Supplier;
use App\Models\Item;
use App\Models\PoItem;
use App\Models\Receiving;
use Illuminate\Http\Request;

class PurchaseOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 10); // Get per page input
        $query = $request->get('query'); // Get search input

        $purchaseOrders = PurchaseOrder::with('supplier')
            ->when($query, function ($q) use ($query) {
                $q->where('po_code', 'LIKE', "%$query%")
                    ->orWhere('amount', 'LIKE', "%{$query}%")
                    ->orWhereHas('supplier', function ($supplierQuery) use ($query) {
                        $supplierQuery->where('name', 'LIKE', "%{$query}%"); // Replace 'name' with the actual field you want to search in the supplier table
                    });
            })
            ->orderBy('id', 'desc')
            ->paginate($perPage); // Apply pagination

        return view('purchase_order.index', compact('purchaseOrders', 'perPage'));
    }

    // public function index(Request $request)
    // {
    //     $perPage = $request->get('per_page', 10); 
    //     $query = $request->get('query');  

    //     $purchaseOrders = PurchaseOrder::with('supplier')
    //         ->when($query, function ($q) use ($query) {
    //             $q->where('po_code', 'LIKE', "%$query%")   
    //               ->orWhere('amount', 'LIKE', "%{$query}%");
    //         })
    //         ->orderBy('id', 'desc')
    //         ->paginate($perPage);

    //     return view('purchase_order.index', compact('purchaseOrders', 'perPage'));
    // }    


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $suppliers = Supplier::all(); // Fetch suppliers for the dropdown
        $items = collect(); // Default empty collection for items
        return view('purchase_order.create', compact('items', 'suppliers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'supplier_id' => 'required|exists:suppliers,id', // Ensure supplier exists
            'remarks' => 'nullable|string', // Remarks are optional
            'discount_perc' => 'nullable|numeric|min:0|max:100', // Discount percentage (0-100)
            'tax_perc' => 'nullable|numeric|min:0|max:100', // Tax percentage (0-100)
            'item_id' => 'required|array', // Ensure items are provided
            'qty' => 'required|array', // Ensure quantities are provided
            'unit' => 'required|array', // Ensure units are provided
            'price' => 'required|array', // Ensure prices are provided
            'total' => 'required|array', // Ensure totals are provided
        ]);

        // Generate the next PO code
        // $lastPO = PurchaseOrder::orderBy('id', 'desc')->first(); // Get the last PO by ID
        // if ($lastPO) {
        //     $lastCode = $lastPO->po_code;
        //     // Extract the numeric part of the PO code
        //     $lastNumber = (int) substr($lastCode, 3); // Assumes format is "PO-XXXXX"
        //     $nextNumber = $lastNumber + 1; // Increment by 1

        //     // Check if the nextNumber already exists in the database
        //     $existingCodes = PurchaseOrder::pluck('po_code')->toArray();
        //     while (in_array('PO-' . str_pad($nextNumber, 5, '0', STR_PAD_LEFT), $existingCodes)) {
        //         $nextNumber++; // Increment until we find a unique code
        //     }

        //     $poCode = 'PO-' . str_pad($nextNumber, 5, '0', STR_PAD_LEFT); // Format as PO-00001, PO-00002, etc.
        // } else {
        //     $poCode = 'PO-00001'; // Default if no POs exist
        // }

        // Calculate subtotal, discount, tax, and grand total
        $subtotal = array_sum($request->input('total'));
        $discountPerc = $request->input('discount_perc', 0);
        $taxPerc = $request->input('tax_perc', 0);
        $discount = ($subtotal * $discountPerc) / 100;
        $tax = ($subtotal * $taxPerc) / 100;
        $grandTotal = $subtotal - $discount + $tax;

        // Create the purchase order
        $purchaseOrder = PurchaseOrder::create([
            // 'po_code' => $poCode, // Use the generated PO code
            'supplier_id' => $request->input('supplier_id'),
            'remarks' => $request->input('remarks', ''),
            'discount_perc' => $discountPerc,
            'discount' => $discount,
            'tax_perc' => $taxPerc,
            'tax' => $tax,
            'subtotal' => $subtotal,
            // 'grand_total' => $grandTotal,
            'amount' => $grandTotal,
        ]);

        // Attach items to the purchase order using the PoItem model
        foreach ($request->input('item_id') as $index => $itemId) {
            $quantity = $request->input('qty')[$index];
            $price = $request->input('price')[$index];
            $unit = $request->input('unit')[$index];
            $total = $request->input('total')[$index];

            PoItem::create([
                'po_id' => $purchaseOrder->id, // Link to the created purchase order
                'item_id' => $itemId, // Item ID
                'quantity' => $quantity, // Quantity
                'price' => $price, // Price per unit
                'total' => $total, // Total cost (quantity * price)
            ]);
        }

        return redirect()->route('purchase-order.index')->with('success', 'Purchase Order created successfully!');
    }
    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $purchaseOrder = PurchaseOrder::with(['supplier', 'items'])->findOrFail($id);
        return view('purchase_order.show', compact('purchaseOrder'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $purchaseOrder = PurchaseOrder::with(['supplier', 'items.item'])->findOrFail($id);
        $suppliers = Supplier::all(); // Fetch all suppliers for the dropdown
        $items = Item::all(); // Fetch all items for the dropdown
        return view('purchase_order.edit', compact('purchaseOrder', 'suppliers', 'items'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PurchaseOrder $purchaseOrder)
    {
        // Validate the request data
        $request->validate([
            'supplier_id' => 'required|exists:suppliers,id', // Ensure supplier exists
            'remarks' => 'nullable|string', // Remarks are optional
            'discount_perc' => 'nullable|numeric|min:0|max:100', // Discount percentage (0-100)
            'tax_perc' => 'nullable|numeric|min:0|max:100', // Tax percentage (0-100)
            'item_id' => 'required|array', // Ensure items are provided
            'qty' => 'required|array', // Ensure quantities are provided
            'unit' => 'required|array', // Ensure units are provided
            'price' => 'required|array', // Ensure prices are provided
            'total' => 'required|array', // Ensure totals are provided
        ]);

        // Generate the next PO code
        // $lastPO = PurchaseOrder::orderBy('id', 'desc')->first(); // Get the last PO by ID
        // if ($lastPO) {
        //     $lastCode = $lastPO->po_code;
        //     // Extract the numeric part of the PO code
        //     $lastNumber = (int) substr($lastCode, 3); // Assumes format is "PO-XXXXX"
        //     $nextNumber = $lastNumber + 1; // Increment by 1

        //     // Check if the nextNumber already exists in the database
        //     $existingCodes = PurchaseOrder::pluck('po_code')->toArray();
        //     while (in_array('PO-' . str_pad($nextNumber, 5, '0', STR_PAD_LEFT), $existingCodes)) {
        //         $nextNumber++; // Increment until we find a unique code
        //     }

        //     $poCode = 'PO-' . str_pad($nextNumber, 5, '0', STR_PAD_LEFT); // Format as PO-00001, PO-00002, etc.
        // } else {
        //     $poCode = 'PO-00001'; // Default if no POs exist
        // }

        // Calculate subtotal, discount, tax, and grand total
        $subtotal = array_sum($request->input('total'));
        $discountPerc = $request->input('discount_perc', 0);
        $taxPerc = $request->input('tax_perc', 0);
        $discount = ($subtotal * $discountPerc) / 100;
        $tax = ($subtotal * $taxPerc) / 100;
        $grandTotal = $subtotal - $discount + $tax;

        // Create the purchase order
        $purchaseOrder->update([
            // 'po_code' => $poCode, // Use the generated PO code
            'supplier_id' => $request->input('supplier_id'),
            'remarks' => $request->input('remarks', ''),
            'discount_perc' => $discountPerc,
            'discount' => $discount,
            'tax_perc' => $taxPerc,
            'tax' => $tax,
            'subtotal' => $subtotal,
            // 'grand_total' => $grandTotal,
            'amount' => $grandTotal,
        ]);

        // Delete existing items for the purchase order
        $purchaseOrder->items()->delete();

        // Attach items to the purchase order using the PoItem model
        foreach ($request->input('item_id') as $index => $itemId) {
            $quantity = $request->input('qty')[$index];
            $price = $request->input('price')[$index];
            $unit = $request->input('unit')[$index];
            $total = $request->input('total')[$index];

            PoItem::create([
                'po_id' => $purchaseOrder->id, // Link to the created purchase order
                'item_id' => $itemId, // Item ID
                'quantity' => $quantity, // Quantity
                'price' => $price, // Price per unit
                'total' => $total, // Total cost (quantity * price)
            ]);
        }

        return redirect()->route('purchase-order.index')->with('success', 'Purchase Order created successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id = null)
    {
        // Check if bulk deletion is requested
        if ($request->has('ids')) {
            $ids = $request->input('ids');

            // Validate the IDs
            if (empty($ids)) {
                return redirect()->route('purchase-order.index')->with('error', 'No purchase orders selected for deletion.');
            }

            // Delete the selected purchase orders
            PurchaseOrder::whereIn('id', $ids)->delete();

            return redirect()->route('purchase-order.index')->with('success', 'Selected purchase orders deleted successfully.');
        }

        // Handle single deletion
        if ($id) {
            $purchaseOrder = PurchaseOrder::findOrFail($id);
            $purchaseOrder->delete();
            return redirect()->route('purchase-order.index')->with('success', 'purchase orders deleted successfully.');
        }

        // return redirect()->route('purchase-order.index')->with('success', 'Selected purchase orders deleted successfully.');
    }
    public function receive($id, Request $request)
    {
        // Find the purchase order and eager load items with their related item details
        $purchaseOrder = PurchaseOrder::with('items.item')->findOrFail($id);

        // Handle POST request (process the receive action)
        if ($request->isMethod('POST')) {
            try {
                // Check if the purchase order is already received
                if ($purchaseOrder->status === 'received') {
                    return redirect()->route('purchase-order.index')
                        ->with('error', 'This purchase order has already been received.');
                }

                // Prepare data for the receiving record
                $data = [
                    'from_id' => $purchaseOrder->id,
                    'from_type' => PurchaseOrder::class, // Ensure this is included
                    'from_order' => 1, // 1 = Purchase Order
                    'amount' => $purchaseOrder->amount,
                    'discount_perc' => $purchaseOrder->discount_perc,
                    'discount' => $purchaseOrder->discount_amount,
                    'tax_perc' => $purchaseOrder->tax_perc,
                    'tax' => $purchaseOrder->tax_amount,
                    'stock_ids' => $purchaseOrder->items->isNotEmpty()
                        ? json_encode($purchaseOrder->items->mapWithKeys(function ($item) {
                            return [
                                $item->item_id => [
                                    'quantity' => $item->quantity,
                                    'unit' => $item->item->unit, // Access unit from the item relationship
                                    'name' => $item->item->name, // Access name from the item relationship
                                    'cost' => $item->item->cost, // Access cost from the item relationship
                                ],
                            ];
                        }))
                        : null,
                    'remarks' => $purchaseOrder->remarks,
                ];

                \Log::info('Creating receiving record:', $data); // Log the data

                // Create a new receiving record
                $receiving = Receiving::create($data);

                // Update the purchase order status to "received"
                $purchaseOrder->update(['status' => 'received']);

                // Redirect back with a success message
                return redirect()->route('purchase-order.index')
                    ->with('success', 'Purchase order received successfully.');
            } catch (\Exception $e) {
                // Log the error for debugging
                \Log::error('Error receiving purchase order: ' . $e->getMessage(), [
                    'purchase_order_id' => $id,
                    'error' => $e->getTraceAsString(),
                ]);

                // Redirect back with an error message
                return redirect()->route('purchase-order.index')
                    ->with('error', 'An error occurred while receiving the purchase order: ' . $e->getMessage());
            }
        }
    }
}
