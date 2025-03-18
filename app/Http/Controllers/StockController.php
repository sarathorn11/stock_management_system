<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use App\Models\Item;
use Illuminate\Http\Request;

class StockController extends Controller
{
    /**
     * Display a listing of the stocks.
     */

     public function index(Request $request)
{
    $query = $request->input('query');
    $perPage = $request->input('perPage', 10);

    // Validate perPage input
    $perPageOptions = [10, 20, 30, 50];
    if (!in_array($perPage, $perPageOptions)) {
        $perPage = 10;
    }

    // Build the query
    $stocks = Stock::with('item')
        ->when($query, function ($queryBuilder) use ($query) {
            return $queryBuilder->where(function ($q) use ($query) {
                $q->whereHas('item', function ($subQuery) use ($query) {
                    $subQuery->where('name', 'LIKE', "%{$query}%")
                             ->orWhere('unit', 'LIKE', "%{$query}%"); // Search for unit in the item table
                })->orWhere('price', 'LIKE', "%{$query}%")
                  ->orWhere('quantity', 'LIKE', "%{$query}%")
                  ->orWhere('total', 'LIKE', "%{$query}%")
                  ->orWhere('type', 'LIKE', "%{$query}%");
            });
        })
        ->selectRaw('item_id, 
                     SUM(CASE WHEN type = 1 THEN quantity ELSE 0 END) - 
                     SUM(CASE WHEN type = 2 THEN quantity ELSE 0 END) as total_quantity')
        ->groupBy('item_id')
        ->orderBy('item_id', 'desc')
        ->paginate($perPage);

    return view('stocks.index', [
        'stocks' => $stocks,
        'query' => $query,
        'perPage' => $perPage,
        'perPageOptions' => $perPageOptions
    ]);
}

    /**
     * Show the form for creating a new stock record.
     */
    public function create()
    {
        // Fetch all items for the dropdown selection
        $items = Item::all();
        return view('stocks.create', compact('items')); // Ensure the view exists
    }

    /**
     * Store a newly created stock record in storage.
     */
    public function store(Request $request)
    {
        // Validate the incoming data
        $validated = $request->validate([
            'item_id' => 'required|exists:items,id', // Ensure the item exists
            'quantity' => 'required|integer|min:0',
            'unit' => 'nullable|string|max:250',
            'price' => 'required|numeric|min:0',
            'total' => 'required|numeric|min:0',
            'type' => 'required|integer|in:1,2',
            'date_created' => 'nullable|date', // Allow null if not provided
        ]);

        // If date_created is not provided, default it to the current timestamp
        $validated['date_created'] = $validated['date_created'] ?? now();

        // Create a new stock record
        Stock::create($validated);

        // Redirect to the stock list with a success message
        return redirect()->route('stocks.index')->with('success', 'Stock added successfully.');
    }

    /**
     * Display the specified stock record.
     */
    public function show(Stock $stock)
    {
        // Ensure the related item is loaded
        $stock->load('item');
        return view('stocks.show', compact('stock')); // Ensure the view exists
    }

    /**
     * Show the form for editing the specified stock record.
     */
    public function edit(Stock $stock)
    {
        // Fetch all items for the dropdown selection
        $items = Item::all();
        return view('stocks.edit', compact('stock', 'items')); // Ensure the view exists
    }

    /**
     * Update the specified stock record in storage.
     */
    public function update(Request $request, Stock $stock)
    {
        // Validate the incoming data
        $validated = $request->validate([
            'item_id' => 'required|exists:items,id', // Ensure the item exists
            'quantity' => 'required|integer|min:0',
            'unit' => 'nullable|string|max:250',
            'price' => 'required|numeric|min:0',
            'total' => 'required|numeric|min:0',
            'type' => 'required|integer|in:1,2',
            'date_created' => 'nullable|date', // Allow null if not provided
        ]);

        // If date_created is provided in the request, we use it. Otherwise, we preserve the existing one.
        $validated['date_created'] = $request->has('date_created') ? $validated['date_created'] : $stock->date_created;

        // Update the stock record
        $stock->update($validated);

        // Redirect to the stock list with a success message
        return redirect()->route('stocks.index')->with('success', 'Stock updated successfully.');
    }

    /**
     * Remove the specified stock record from storage.
     */
    public function destroy(Stock $stock)
    {
        // Delete the stock record
        $stock->delete();

        // Redirect to the stock list with a success message
        return redirect()->route('stocks.index')->with('success', 'Stock deleted successfully.');
    }

    /**
     * Search for stocks by item or unit.
     */
    public function search(Request $request)
    {
        $query = $request->input('query');
        $stocks = Stock::with('item')
            ->whereHas('item', function ($q) use ($query) {
                $q->where('item_id', 'LIKE', "%{$query}%"); // Search by item_id
            })
            ->orWhere('unit', 'LIKE', "%{$query}%")
            ->paginate(10);

        return response()->json(['stocks' => $stocks]);
    }
    public function deleteMultiple(Request $request)
    {
        $ids = $request->input('ids');

        // Validate input
        if (empty($ids)) {
            return response()->json(['error' => 'No stocks selected.'], 400);
        }

        // Delete the selected stocks
        Stock::whereIn('item_id', $ids)->delete();

        return response()->json(['success' => 'Selected stocks deleted successfully.']);
    }
}
