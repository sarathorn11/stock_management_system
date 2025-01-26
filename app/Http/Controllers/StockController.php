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
        $perPage = $request->input('perPage', 10);
        $stocks = Stock::with('item')->paginate($perPage);
        return view('stocks.index', [
            'stocks' => $stocks,
            'perPage' => $perPage,
            'perPageOptions' => [5, 10, 25, 50]
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
}