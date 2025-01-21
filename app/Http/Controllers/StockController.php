<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use Illuminate\Http\Request;

class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Fetch all stock records
        $stocks = Stock::all();
        return view('stocks.index', compact('stocks')); // Adjust to your view
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Show a form to create a new stock record
        return view('stocks.create'); // Adjust to your view
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the incoming data
        $validated = $request->validate([
            'item_id' => 'required|integer',
            'quantity' => 'required|integer',
            'unit' => 'nullable|string|max:250',
            'price' => 'required|numeric',
            'total' => 'required|numeric',
            'type' => 'required|integer|in:1,2',
        ]);

        // Create a new stock record
        Stock::create($validated);

        // Redirect to the stock list with a success message
        return redirect()->route('stocks.index')->with('success', 'Stock added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Stock $stock)
    {
        // Display details of a specific stock record
        return view('stocks.show', compact('stock')); // Adjust to your view
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Stock $stock)
    {
        // Show the edit form for a specific stock record
        return view('stocks.edit', compact('stock')); // Adjust to your view
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Stock $stock)
    {
        // Validate the incoming data
        $validated = $request->validate([
            'item_id' => 'required|integer',
            'quantity' => 'required|integer',
            'unit' => 'nullable|string|max:250',
            'price' => 'required|numeric',
            'total' => 'required|numeric',
            'type' => 'required|integer|in:1,2',
        ]);

        // Update the stock record
        $stock->update($validated);

        // Redirect to the stock list with a success message
        return redirect()->route('stocks.index')->with('success', 'Stock updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Stock $stock)
    {
        // Delete the stock record
        $stock->delete();

        // Redirect to the stock list with a success message
        return redirect()->route('stocks.index')->with('success', 'Stock deleted successfully.');
    }

    public function search(Stock $stock)
    {
        $query = request('query');
        $stocks = Stock::where('item_id', 'LIKE', "%{$query}%")
            ->orWhere('unit', 'LIKE', "%{$query}%")
            ->paginate(10);

        return view('stocks.index', compact('stocks'));
    }
}
