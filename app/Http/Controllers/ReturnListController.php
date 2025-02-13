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
    public function create()
{
    $stocks = Stock::all();

    $suppliers = DB::table('suppliers as s')
        ->select('s.id as supplier_id', 's.name as supplier_name')
        ->selectRaw("JSON_ARRAYAGG(
            JSON_OBJECT(
                'item_id', i.id,
                'item_name', i.name,
                'item_cost', i.cost,
                'stocks', IFNULL((
                    SELECT JSON_ARRAYAGG(
                        JSON_OBJECT('stock_id', st.id)
                    ) FROM stocks AS st WHERE st.item_id = i.id
                ), JSON_ARRAY())
            )
        ) AS items")
        ->join('items as i', 's.id', '=', 'i.supplier_id')
        ->groupBy('s.id', 's.name')
        ->get();

    // Decode JSON for easier handling in Blade
    foreach ($suppliers as $sup) {
        $sup->items = json_decode($sup->items);
    }

    return view('return.create', compact('stocks', 'suppliers'));
}

    // public function create()
    // {
    //     $stocks = Stock::all();
    //     $suppliers = DB::table('suppliers as s')
    //         ->select('s.id as supplier_id', 's.name as supplier_name')
    //         ->selectRaw("JSON_ARRAYAGG(
    //             JSON_OBJECT(
    //                 'item_id', i.id,
    //                 'item_name', i.name,
    //                 'item_cost', i.cost,
    //                 'stock_id', st.id  
    //             )
    //         ) AS items")
    //         ->join('items as i', 's.id', '=', 'i.supplier_id')
    //         ->leftJoin('stocks as st', 'i.id', '=', 'st.item_id')  
    //         ->groupBy('s.id', 's.name')
    //         ->get();

    //     foreach ($suppliers as $sup) {
    //         $sup->items = json_decode($sup->items);  // Decode the JSON string
    //     }

    //     return view('return.create', compact('stocks', 'suppliers'));
    // }




    

    

    // public function create()
    // {
    //     $stocks = Stock::all();   

    //     $suppliers = DB::table('suppliers as s')
    //         ->select('s.id as supplier_id', 's.name as supplier_name')
    //         ->selectRaw("JSON_ARRAYAGG(
    //             JSON_OBJECT(
    //                 'item_id', i.id,
    //                 'item_name', i.name,
    //                 'item_cost', i.cost,

    //                 'stock_price', (SELECT MAX(price) FROM stocks WHERE stocks.item_id = i.id)
    //             )
    //         ) AS items")
    //         ->join('items as i', 's.id', '=', 'i.supplier_id')
    //         ->groupBy('s.id', 's.name')
    //         ->get();
    //      foreach ($suppliers as $sup) {
    //         $sup->items = json_decode($sup->items);  // Decode the JSON string
    //     }

    //     return view('return.create', compact('stocks', 'suppliers'));
    // }

    public function store(Request $request)
    {
        $latestReturn = ReturnList::latest()->first();
        $nextNumber = $latestReturn ? ((int) substr($latestReturn->return_code, -3)) + 1 : 1;
        $returnCode = 'RC-' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

         ReturnList::create([
            'return_code' => $returnCode,
            'supplier_id' => $request->supplier_id,
            'stock_id' => $request->stock_id,
            'amount' => $request->amount,
            'remarks' => $request->remarks,
        ]);

        return redirect()->route('return.index')->with('success', 'Return list created successfully!');
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
