<?php

namespace App\Http\Controllers;

use App\Models\Receiving;
use Illuminate\Http\Request;

class ReceivingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Set the number of records per page (default is 10)
        $perPage = $request->get('per_page', 10);
        
        // Paginate the Receiving model
        $receivings = Receiving::paginate($perPage);
        
        // Pass the paginated result to the view
        return view('receiving.index', compact('receivings', 'perPage'));
    }

    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('receiving.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the form data
        $validated = $request->validate([
            'from_id' => 'required|string|max:255',
            'from_order' => 'required|in:1,2',
            'amount' => 'required|numeric|min:0',
            'discount_perc' => 'nullable|numeric|min:0',
            'discount' => 'nullable|numeric|min:0',
            'tax_perc' => 'nullable|numeric|min:0',
            'tax' => 'nullable|numeric|min:0',
            'stock_ids' => 'required|string|max:255',
            'remarks' => 'nullable|string|max:500',
        ]);
    
        // Store the data
        $receiving = new Receiving();
        $receiving->from_id = $request->from_id;
        $receiving->from_order = $request->from_order;
        $receiving->amount = $request->amount;
        $receiving->discount_perc = $request->discount_perc;
        $receiving->discount = $request->discount;
        $receiving->tax_perc = $request->tax_perc;
        $receiving->tax = $request->tax;
        $receiving->stock_ids = $request->stock_ids;
        $receiving->remarks = $request->remarks;
        $receiving->save();
    
        return redirect()->route('receiving.index')->with('success', 'Receiving added successfully!');
    }
    

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Find the receiving by its ID
        $receiving = Receiving::findOrFail($id);

        // Pass the receiving record to the view
        return view('receiving.show', compact('receiving'));
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Receiving $receiving)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Receiving $receiving)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Receiving $receiving)
    {
        //
    }
}