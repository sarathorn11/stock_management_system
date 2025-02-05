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
        $perPage = $request->input('perPage', 10);
        $sales = Sale::with('stock')->when($query, function ($queryBuilder) use ($query) { 
            return $queryBuilder->where('sales_code', 'LIKE', "%{$query}%")
                ->orWhere('client', 'LIKE', "%{$query}%");
            })
            ->orderBy('id', 'desc')
            ->paginate($perPage);

        return view('sales.index', [
            'sales' => $sales,
            'query' => $query,
            'perPage' => $perPage,
            'perPageOptions' => [10, 20, 30, 50]
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
            'stock_id' => 'required|exists:stocks,id',
            'remarks' => 'nullable|string|max:500',
        ]);
        Sale::create($validated);
        return redirect()->route('sales.index')->with('success', 'Sale added successfully.');
    }


    public function show(Sale $sale)
    {
        $sale->load('stock');
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
            'stock_id' => 'required|exists:stocks,id',
            'remarks' => 'nullable|string|max:500',
        ]);
        $sale->update($validated);

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
