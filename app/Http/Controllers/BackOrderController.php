<?php

namespace App\Http\Controllers;

use App\Models\BackOrder;
use Illuminate\Http\Request;

class BackOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 10);
        $searchQuery = $request->input('query', '');

        $backOrders = BackOrder::with([
                'supplier:id,name',
                'items.item',
                'purchaseOrder:po_code'
            ])
            ->withCount('items')
            ->when($searchQuery, function($query, $searchQuery) {
                return $query->where('bo_code', 'like', '%' . $searchQuery . '%')
                             ->orWhere('created_at', 'like', '%' . $searchQuery . '%')
                             ->orWhereHas('supplier', function($q) use ($searchQuery) {
                                 $q->where('name', 'like', '%' . $searchQuery . '%');
                             });
            })
            ->orderBy('created_at', 'desc')
            ->paginate($perPage)
            ->through(function ($backOrder) {
                $backOrder->supplier = $backOrder->supplier->name;
                return $backOrder;
            });

        return view('backorder.index', [
            'backOrders' => $backOrders,
            'perPage' => $perPage,
            'perPageOptions' => [10, 20, 30, 50]
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(BackOrder $backOrder)
    {
        $backOrder->load(['supplier', 'items', 'purchaseOrder']);
        return view('backorder.show', compact('backOrder'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BackOrder $backOrder)
    {
        $backOrder->load(['supplier', 'items', 'purchaseOrder']);
        // return view('backorder.edit', compact('backOrder'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BackOrder $backOrder)
    {
        $request->validate([
            'bo_code' => 'required|string|max:255',
            'status' => 'required|integer',
            // Add other validation rules as needed
        ]);

        $backOrder->update($request->all());

        return redirect()->route('back-order.index')->with('success', 'Back order updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BackOrder $backOrder)
    {
        $backOrder->delete();
        return redirect()->route('back-order.index')->with('success', 'Back order deleted successfully.');
    }
}
