<?php
namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Stock;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('query');
        $perPage = $request->input('perPage', 10); // Default to 10 if no value provided

        $sales = Sale::with('stocks') // Eager load the stocks relationship
            ->when($query, function ($queryBuilder) use ($query) {
                return $queryBuilder->where(function ($q) use ($query) {
                    $q->where('sales_code', 'LIKE', "%{$query}%")
                    ->orWhere('amount', 'LIKE', "%{$query}%")
                    ->orWhere('client', 'LIKE', "%{$query}%");
                });
            })
            ->orderBy('id', 'desc')
            ->paginate($perPage);

        return view('sales.index', [
            'sales' => $sales,
            'query' => $query,
            'perPage' => $perPage,
            'perPageOptions' => [10, 20, 30, 50] // Options for number of items per page
        ]);
    }

    public function create()
    {
        $stocks = Stock::all();
        $items = Item::all();
        return view('sales.create', compact('stocks', 'items'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'client' => 'required|string|max:255',
            'remarks' => 'nullable|string|max:500',
            'item_id' => 'required|array', // Ensure items are provided
            'qty' => 'required|array', // Ensure quantities are provided
            'price' => 'required|array', // Ensure prices are provided
            'total' => 'required|array', // Ensure totals are provided
        ]);

        $amount = $validated['total'];
        $totalAmount = 0;
        foreach ($amount as $value) {
            $totalAmount += $value; // Sum up the total amounts
        }
        $validated['amount'] = $totalAmount; // Set the total amount


        // Create the Sale
        $sale = Sale::create([
            'client' => $validated['client'],
            'amount' => $validated['amount'],
            'remarks' => $validated['remarks'],
        ]);

        // create sale items
        // Attach items to the purchase order using the PoItem model
        foreach ($request->input('item_id') as $index => $itemId) {
            $quantity = $request->input('qty')[$index];
            $price = $request->input('price')[$index];
            $total = $request->input('total')[$index];

            SaleItem::create([
                'sale_id' => $sale->id, // Link to the created purchase order
                'item_id' => $itemId, // Item ID
                'quantity' => $quantity, // Quantity
                'price' => $price, // Price per unit
                'total' => $total, // Total cost (quantity * price)
            ]);
        }

        return redirect()->route('sales.index')->with('success', 'Sale created successfully.');
    }

    public function show(Sale $sale)
    {
        $sale->load('stocks'); // Eager load the 'stocks' relationship
        return view('sales.show', compact('sale'));
    }

    public function edit(Sale $sale)
    {
        $stocks = Stock::all();
        $items = Item::all();
        $sale->load('stocks'); // Eager load the 'stocks' relationship
        return view('sales.edit', compact('sale', 'stocks', 'items'));
    }


    public function update(Request $request, Sale $sale)
    {
        // Validate the request
        $request->validate([
            'client' => 'required|string|max:255',
            'remarks' => 'nullable|string|max:500',
            'item_id' => 'required|array', // Ensure items are provided
            'qty' => 'required|array', // Ensure quantities are provided
            'price' => 'required|array', // Ensure prices are provided
            'total' => 'required|array', // Ensure totals are provided
        ]);
    
        $amount = $request->input('total');
        $totalAmount = 0;
        foreach ($amount as $value) {
            $totalAmount += $value; // Sum up the total amounts
        }
        $request->merge(['amount' => $totalAmount]); // Set the total amount in the request
        // Update the sale
        $sale->update([
            'client' => $request->client,
            'amount' => $request->amount,
            'remarks' => $request->remarks,
        ]);
    
        // Update the sale items
        // First, delete existing items
        SaleItem::where('sale_id', $sale->id)->delete();
        // Then, create new items
        foreach ($request->input('item_id') as $index => $itemId) {
            $quantity = $request->input('qty')[$index];
            $price = $request->input('price')[$index];
            $total = $request->input('total')[$index];

            SaleItem::create([
                'sale_id' => $sale->id, // Link to the created purchase order
                'item_id' => $itemId, // Item ID
                'quantity' => $quantity, // Quantity
                'price' => $price, // Price per unit
                'total' => $total, // Total cost (quantity * price)
            ]);
        }
        
    
        // Redirect with success message
        return redirect()->route('sales.index')->with('success', 'Sale updated successfully.');
    }


    public function destroy(Request $request, $id = null)
{
    // Check if bulk deletion is requested
    if ($request->has('ids')) {
        $ids = $request->input('ids');

        // Validate the IDs
        if (empty($ids)) {
            return redirect()->route('sales.index')->with('error', 'No sales selected for deletion.');
        }

        // Delete the selected sales
        Sale::whereIn('id', $ids)->delete();

        return redirect()->route('sales.index')->with('success', 'Selected sales deleted successfully.');
    }

    // Handle single deletion
    if ($id) {
        $sale = Sale::findOrFail($id);
        $sale->delete();
        return redirect()->route('sales.index')->with('success', 'Sale deleted successfully.');
    }

    // If no sale or IDs are provided, return an error
    return redirect()->route('sales.index')->with('error', 'No sales selected for deletion.');
}
    

    public function search(Request $request)
    {
        $query = $request->input('query');
        $sales = Sale::with('stock')
            ->where('sales_code', 'LIKE', "%{$query}%")
            ->orWhere('client', 'LIKE', "%{$query}%")
            ->paginate(10);

        return response()->json(['sales' => $sales]);
    }
}
