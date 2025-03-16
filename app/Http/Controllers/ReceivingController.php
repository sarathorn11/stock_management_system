<?php

namespace App\Http\Controllers;

use App\Models\BackOrder;
use App\Models\BoItem;
use App\Models\PurchaseOrder;
use App\Models\Receiving;
use App\Models\Stock;
use Illuminate\Http\Request;

class ReceivingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Set the number of records per page (default is 10)
        $perPage = $request->get('per_page', 10);

        // Paginate the Receiving model
        $receivings = Receiving::paginate($perPage);

        // Pass the paginated result to the view
        return view('receiving.index', compact('receivings', 'perPage'));
    }

    /**
     * Show the form for creating a new resource.
     */
    // public function create()
    // {
    //     return view('receiving.create');
    // }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'from_order' => 'required|in:1,2',
            'from_id' => 'required|integer',
            'amount' => 'required|numeric',
            'discount_perc' => 'nullable|numeric',
            'discount' => 'nullable|numeric',
            'tax_perc' => 'nullable|numeric',
            'tax' => 'nullable|numeric',
            'stock_ids' => 'nullable|json',
            'remarks' => 'nullable|string',
        ]);

        // Create a new receiving record
        Receiving::create([
            'from_order' => $request->input('from_order'),
            'from_id' => $request->input('from_id'),
            'amount' => $request->input('amount'),
            'discount_perc' => $request->input('discount_perc'),
            'discount' => $request->input('discount'),
            'tax_perc' => $request->input('tax_perc'),
            'tax' => $request->input('tax'),
            'stock_ids' => $request->input('stock_ids'),
            'remarks' => $request->input('remarks'),
        ]);

        // Redirect back with a success message
        return redirect()->route('receiving.index')
            ->with('success', 'Receiving record created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Find the receiving by its ID
        $receiving = Receiving::findOrFail($id);

        // Pass the receiving record to the view
        return view('receiving.show', compact('receiving'));
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Receiving $receiving)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Receiving $receiving)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Receiving $receiving)
    {
        //
    }

    // Show the create form for receiving (from PO or BO)
    public function create($type, $orderId)
    {
        if ($type === 'po') {
            $order = PurchaseOrder::with(['supplier','items'])->findOrFail($orderId);
        } elseif ($type === 'bo') {
            $order = BackOrder::with(['supplier','items', 'purchaseOrder'])->findOrFail($orderId);
        } else {
            abort(404, "Invalid order type.");
        }

        return view('receiving.create', compact('order', 'type'));
    }

    public function createReciving(Request $request, $type, $orderId)
    {
        $request->validate([
            'remarks' => 'nullable|string', // Remarks are optional
            'discount_perc' => 'nullable|numeric|min:0|max:100', // Discount percentage (0-100)
            'tax_perc' => 'nullable|numeric|min:0|max:100', // Tax percentage (0-100)
            'item_id' => 'required|array', // Ensure items are provided
            'qty' => 'required|array', // Ensure quantities are provided
            'oqty' => 'required|array', // Ensure quantities are provided
            'price' => 'required|array', // Ensure prices are provided
            'total' => 'required|array', // Ensure totals are provided
        ]);

        // Calculate subtotal, discount, tax, and grand total
        $subtotal = array_sum($request->input('total'));
        $discountPerc = $request->input('discount_perc', 0);
        $taxPerc = $request->input('tax_perc', 0);
        $discount = ($subtotal * $discountPerc) / 100;
        $tax = ($subtotal * $taxPerc) / 100;
        // $grandTotal = $subtotal - $discount + $tax;

        $order = [];
        $purchaseOrder = [];
        if ($type === 'po') {
            $order = PurchaseOrder::findOrFail($orderId);
        } elseif ($type === 'bo') {
            $order = BackOrder::findOrFail($orderId);
            $purchaseOrder = PurchaseOrder::findOrFail($order->po_id);
        } else {
            abort(404, "Invalid order type.");
        }

        $stockIds = []; // To store newly created stock IDs
        $amount = 0; // To store the total amount
        $backOrders = []; // To store the back orders

        // Attach items to the purchase order using the PoItem model
        foreach ($request->input('item_id') as $index => $itemId) {
            $quantity = $request->input('qty')[$index];
            $oquantity = $request->input('oqty')[$index];
            $price = $request->input('price')[$index];
            $total = $request->input('total')[$index];
            if ($quantity < $oquantity) {
                $backOrders[] = [
                    'item_id' => $itemId,
                    'quantity' => $oquantity - $quantity,
                    'price' => $price,
                    'total' => $price * ($oquantity - $quantity),
                ];
            }
            $stock = Stock::create([
                'item_id' => $itemId,
                'quantity' => $quantity, // Reduce stock
                'price' => $price,
                'total' => $total,
                'type' => 1, // Return type
            ]);

            $stockIds[] = $stock->id; // Collect stock IDs
            $amount += $total; // Add to the total amount
        }

        $data = [
            'from_id' => $order->id,
            'from_type' => $type === 'po' ? PurchaseOrder::class : BackOrder::class, // Ensure this is included
            'from_order' => $type === 'po' ? 1 : 2, // 1 = Purchase Order (PO), 2 = Back Order (BO)
            'amount' => $amount,
            'discount_perc' => $discountPerc,
            'discount' => $discount,
            'tax_perc' => $taxPerc,
            'tax' => $tax,
            'stock_ids' => json_encode($stockIds),
            'remarks' => $request->input('remarks', ''),
        ];

        $receiving = Receiving::create($data);

        if (!empty($backOrders)) {
            $backOrder = BackOrder::create([
                'po_id' => $type === 'po' ? $order->id : $order->po_id,
                'receiving_id' => $receiving->id,
                'supplier_id' => $order->supplier_id,
                'remarks' => $request->input('remarks', ''),
                'discount_perc' => $discountPerc,
                'discount' => $discount,
                'tax_perc' => $taxPerc,
                'tax' => $tax,
                'subtotal' => array_sum(array_column($backOrders, 'total')),
                'amount' => array_sum(array_column($backOrders, 'total')),
            ]);
            foreach ($backOrders as $backOrderItem) {
                $dataBackOrder = [
                    'bo_id' => $backOrder->id,
                    'item_id' => $backOrderItem['item_id'],
                    'quantity' => $backOrderItem['quantity'],
                    'price' => $backOrderItem['price'],
                    'total' => $backOrderItem['total'],
                ];
                BoItem::create($dataBackOrder);
            }

            $order->status = 1;
            $order->save();
        }else {
            $order->status = 2;
            $order->save();
            if ($type === 'bo') {
                $purchaseOrder->status = 2;
                $purchaseOrder->save();
            }
        }

        return redirect()->route('receiving.index')->with('success', 'Receiving record created successfully.');
    }
}
