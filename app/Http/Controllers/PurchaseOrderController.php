<?php

namespace App\Http\Controllers;

use App\Models\purchase_order;
use Illuminate\Http\Request;

class PurchaseOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Fetch all purchase orders with their related items
        // $purchase_orders = purchase_order::get();
    
        // Ensure the view exists and use the correct variable name
        return view('purchase_order.index');
    }
    
    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('purchase_order.create');
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
    public function show(purchase_order $purchase_order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(purchase_order $purchase_order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, purchase_order $purchase_order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(purchase_order $purchase_order)
    {
        //
    }
}
