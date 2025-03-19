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
        // Validate the request
        $request->validate([
            'sales_code' => 'required|string|max:255',
            'client' => 'required|string|max:255',
            'amount' => 'required|numeric',
            'stock_id' => 'required|exists:stocks,id',
            'remarks' => 'nullable|string',
        ]);
    
        // Update the sale
        $sale->update([
            'sales_code' => $request->sales_code,
            'client' => $request->client,
            'amount' => $request->amount,
            'remarks' => $request->remarks,
        ]);
    
        // Sync the selected stock
        $sale->stocks()->sync([$request->stock_id]);
    
        // Redirect with success message
        return redirect()->route('sales.show', $sale->id)->with('success', 'Sale updated successfully.');
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
