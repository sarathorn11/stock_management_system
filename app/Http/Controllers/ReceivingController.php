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
        // Validate the request data
        $request->validate([
            'from_order' => 'required|in:1,2',
            'from_id' => 'required|integer',
            'amount' => 'required|numeric',
            'discount_perc' => 'nullable|numeric',
            'discount' => 'nullable|numeric',
            'tax_perc' => 'nullable|numeric',
            'tax' => 'nullable|numeric',
            'stock_ids' => 'nullable|json',
            'remarks' => 'nullable|string',
        ]);

        // Create a new receiving record
        Receiving::create([
            'from_order' => $request->input('from_order'),
            'from_id' => $request->input('from_id'),
            'amount' => $request->input('amount'),
            'discount_perc' => $request->input('discount_perc'),
            'discount' => $request->input('discount'),
            'tax_perc' => $request->input('tax_perc'),
            'tax' => $request->input('tax'),
            'stock_ids' => $request->input('stock_ids'),
            'remarks' => $request->input('remarks'),
        ]);

        // Redirect back with a success message
        return redirect()->route('receiving.index')
            ->with('success', 'Receiving record created successfully.');
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