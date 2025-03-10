<?php

namespace App\Http\Controllers;

use App\Models\ReturnList;
use App\Models\Stock;
use App\Models\Supplier;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReturnListController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 10);
        $return = ReturnList::with('supplier')->paginate($perPage);
        return view('return.index', [
            'returns' => $return,
            'perPage' => $perPage,
            'perPageOptions' => [10, 20, 30, 50]
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $return = ReturnList::with('supplier')->findOrFail($id);

        // Get stocks based on stock_ids
        $stocks = Stock::whereIn('id', json_decode($return->stock_ids) ?? [])->with('item')->get();

        return view('return.show', compact('return', 'stocks'));

    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Stock $return)
    {
        $return->delete();

        // Redirect to the stock list with a success message
        return redirect()->route('return.index')->with('success', 'Return list deleted successfully.');
    }
    public function deleteSelected(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:return_lists,id',
        ]);
        ReturnList::whereIn('id', $request->ids)->delete();
        // ReturnList::destroy($request->ids);
        return response()->json(['message' => 'Return list deleted successfully.', 'success' => true]);
    }

     /**
     * Search for return loist by item or unit.
     */
    public function search(Request $request)
    {
        $search = $request->input('search');
        $returns = ReturnList::where('return_code', 'like', "%$search%")
            ->whereHas('supplier', function ($q) use ($search) {
                $q->where('supplier_id', 'LIKE', "%{$search}%");  
            })
            ->whereHas('stock', function ($q) use ($search) {
                $q->where('stock_id', 'LIKE', "%{$search}%");  
            })
            ->orWhere('amount', 'like', "%{$search}%")
            ->orWhere('remarks', 'like', "%{$search}%")
            ->paginate(10);
            return response()->json(['returns' => $returns]);

    }

    public function create()
    {
        $suppliers = Supplier::all(); // Fetch suppliers for the dropdown
        $items = collect(); // Default empty collection for items

        return view('return.create', compact('suppliers', 'items'));
    }

    public function store(Request $request)
    {
        try {
        $request->validate([
            'supplier_id' => 'required|exists:suppliers,id', // Ensure supplier exists
            'remarks' => 'nullable|string', // Remarks are optional
            'items' => 'required|array',
            'items.*.item.id' => 'required|exists:items,id',
            'items.*.item.cost' => 'required|numeric|min:0',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        // Generate the next Return code
        $lastReturn = ReturnList::orderBy('id', 'desc')->first(); // Get the last ReturnList by ID
        if ($lastReturn) {
            $lastCode = $lastReturn->return_code;
            // Extract the numeric part of the PO code
            $lastNumber = (int) substr($lastCode, 1); // Assumes format is "R-XXXXX"
            $nextNumber = $lastNumber + 1; // Increment by 1

            // Check if the nextNumber already exists in the database
            $existingCodes = ReturnList::pluck('return_code')->toArray();
            while (in_array('R' . str_pad($nextNumber, 5, '0', STR_PAD_LEFT), $existingCodes)) {
                $nextNumber++; // Increment until we find a unique code
            }

            $returnCode = 'R' . str_pad($nextNumber, 5, '0', STR_PAD_LEFT); // Format as PO-00001, PO-00002, etc.
        } else {
            $returnCode = 'R00001'; // Default if no POs exist
        }

        $stockIds = []; // To store newly created stock IDs
        $amount = 0; // To store the total amount

        // 1️⃣ **Create Stocks First**
        foreach ($request->items as $item) {
            $total = $item['item']['cost'] * $item['quantity'];
            $stock = Stock::create([
                'item_id' => $item['item']['id'],
                'quantity' => -$item['quantity'], // Reduce stock
                'price' => $item['item']['cost'],
                'total' => $total,
                'type' => 2, // Return type
            ]);

            $stockIds[] = $stock->id; // Collect stock IDs
            $amount += $total; // Add to the total amount
        }

        // 2️⃣ **Create Return List After Stocks**
        $return = ReturnList::create([
            'return_code' => $returnCode,
            'supplier_id' => $request->supplier_id,
            'stock_ids' => json_encode($stockIds), // Store as JSON array
            'amount' => $amount,
            'remarks' => $request->remarks,
        ]);

        session()->flash('success', 'Return created successfully!');
        return response()->json([
            'redirect' => route('return.index'),
            'message' => 'Return created successfully!'
        ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Internal Server Error', 'details' => $e->getMessage()], 500);
        }
    }
    public function getItemsBySupplier(Request $request)
    {
        // Ensure that the supplier exists and get the related items
        $supplier = Supplier::with('items')->findOrFail($request->supplier_id);

        return response()->json($supplier);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // Retrieve the existing return record
        $return = ReturnList::findOrFail($id);

        // Retrieve the items and stock associated with the return
        $items = Item::where('supplier_id', $return->supplier_id)->get();  // You may need to set up the correct relationship in the model
        $stocks = Stock::whereIn('id', json_decode($return->stock_ids) ?? [])->with('item')->get();

        // Return view with the existing return and items
        return view('return.edit', compact('return', 'stocks', 'items'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            // Validate the incoming request
            $request->validate([
                'supplier_id' => 'required|exists:suppliers,id', // Ensure supplier exists
                'remarks' => 'nullable|string', // Remarks are optional
                'items' => 'required|array',
                'items.*.item.id' => 'required|exists:items,id',
                'items.*.item.cost' => 'required|numeric|min:0',
                'items.*.quantity' => 'required|integer|min:1',
            ]);

            // Retrieve the existing return record
            $return = ReturnList::findOrFail($id);

            // Prepare the stock IDs and total amount
            $stockIds = [];
            $amount = 0;

            // 1️⃣ **Delete Previous Stocks if Necessary**
            // This step ensures that the stocks from the previous return are properly handled
            $existingStockIds = json_decode($return->stock_ids, true);
            if (!empty($existingStockIds)) {
                Stock::whereIn('id', $existingStockIds)->delete(); // Remove previous stocks
            }

            // 2️⃣ **Create New Stocks**
            foreach ($request->items as $item) {
                $total = $item['item']['cost'] * $item['quantity'];
                $stock = Stock::create([
                    'item_id' => $item['item']['id'],
                    'quantity' => -$item['quantity'], // Reduce stock
                    'price' => $item['item']['cost'],
                    'total' => $total,
                    'type' => 2, // Return type
                ]);

                $stockIds[] = $stock->id; // Collect stock IDs
                $amount += $total; // Add to the total amount
            }

            // 3️⃣ **Update Return List with New Data**
            $return->update([
                'supplier_id' => $request->supplier_id,
                'stock_ids' => json_encode($stockIds),
                'amount' => $amount,
                'remarks' => $request->remarks,
            ]);

            session()->flash('success', 'Return updated successfully!');
            return response()->json([
                'redirect' => route('return.index'),
                'message' => 'Return updated successfully!'
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Internal Server Error', 'details' => $e->getMessage()], 500);
        }
    }
}
