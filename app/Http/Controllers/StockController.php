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
    public function index()
    {
        // Fetch all stock records with their related item
        $stocks = Stock::with('item')->get();
        return view('stocks.index', compact('stocks')); // Ensure the view exists
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
            'date_created' => 'required|date',
        ]);

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
            'date_created' => 'required|date',
        ]);

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
                $q->where('name', 'LIKE', "%{$query}%");
            })
            ->orWhere('unit', 'LIKE', "%{$query}%")
            ->paginate(10);

        return view('stocks.index', compact('stocks')); // Ensure the view exists
    }
}
