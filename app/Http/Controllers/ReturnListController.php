<?php

namespace App\Http\Controllers;

use App\Models\ReturnList;
use App\Models\Stock;
use App\Models\Supplier;
use Illuminate\Http\Request;

class ReturnListController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 10);
        $return = ReturnList::with('item')->paginate($perPage);
        return view('stocks.index', [
            'return' => $return,
            'perPage' => $perPage,
            'perPageOptions' => [10, 20, 30, 50]
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $supplier = Supplier::all();
        $stock = Stock::all();
        return view('return.create', compact('supplier','stock'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //validate request
        $validated= $request->validate([
            'return_code' => 'required|string|max:255',
            'supplier_id' => 'required|exists:suppliers,id',
            'stock_id' => 'required|exists:stocks,id',
            'amount' => 'required|numeric|min:0',
            'remarks' => 'nullable|string',
        ]);
        //create a new return list
        ReturnList::create($validated);
        return redirect()->route('return.create')->with('success', 'Return list created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ReturnList $return)
    {
        $return->load('item');
        return view('return.show', compact('return')); // Ensure the view exists

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ReturnList $returnList)
    {
        $stock = Stock::all();
        $supplier = Supplier::all();
        return view('returns.edit', compact('return', 'supplier', 'stock')); // Ensure the view exists

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
        $validatedData = $request->validate([
            'return_code' => 'required|string|max:255',
            'supplier_id' => 'required|exists:suppliers,id',
            'stock_id' => 'required|exists:stocks,id',
            'amount' => 'required|numeric|min:0',
            'remarks' => 'nullable|string',
        ]);
        $return = ReturnList::findOrFail($id);
        $return->update($validatedData);
        return redirect()->route('return.index')->with('success', 'Return list updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Stock $return)
    {
        //
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
}
