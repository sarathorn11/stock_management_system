<?php
namespace App\Http\Controllers;

use App\Models\Sale;
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
        return view('sales.create', compact('stocks'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'sales_code' => 'required|string|max:255',
            'client' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'stock_ids' => 'required|array',
            'remarks' => 'nullable|string|max:500',
        ]);

        // Create the Sale
        $sale = Sale::create($validated);

        // Attach the selected stock IDs to the Sale (many-to-many relationship)
        $sale->stocks()->attach($validated['stock_ids']);

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
        return view('sales.edit', compact('sale', 'stocks'));
    }


    public function update(Request $request, Sale $sale)
    {
        $validated = $request->validate([
            'sales_code' => 'required|string|max:255',
            'client' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'stock_ids' => 'required|array', // Ensure it's an array of stock IDs
            'stock_ids.*' => 'exists:stocks,id', // Validate each stock_id in the array
            'remarks' => 'nullable|string|max:500',
        ]);

        // Update the sale
        $sale->update($validated);

        // Sync the stocks for the sale (this will replace the previous stocks)
        $sale->stocks()->sync($validated['stock_ids']);

        return redirect()->route('sales.index')->with('success', 'Sale updated successfully.');
    }


    public function destroy(Sale $sale)
    {
        $sale->delete();

        return redirect()->route('sales.index')->with('success', 'Sale deleted successfully.');
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
