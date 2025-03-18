<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
    $query = $request->input('query');
    $perPage = $request->input('perPage', 10);

    $suppliers = Supplier::when($query, function ($queryBuilder) use ($query) {
            return $queryBuilder->where(function ($q) use ($query) {
                $q->where('name', 'LIKE', "%{$query}%")
                  ->orWhere('address', 'LIKE', "%{$query}%")
                  ->orWhere('cperson', 'LIKE', "%{$query}%")
                  ->orWhere('contact', 'LIKE', "%{$query}%");
            });
        })
        ->orderBy('id', 'desc')
        ->paginate($perPage);

    return view('supplier.index', [
        'suppliers' => $suppliers,
        'query' => $query,
        'perPage' => $perPage,
        'perPageOptions' => [10, 20, 30, 50]
    ]);
}

    public function getSuppliers()
    {
        $suppliers = Supplier::all();
        return response()->json($suppliers);
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
        // Validate the incoming request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'cperson' => 'required|string',
            'contact' => 'required|string',
            'status' => 'required|boolean',
        ]);

        // Create a new supplier record
        Supplier::create($validatedData);

        // Redirect back to the supplier list with a success message
        return redirect()->route('supplier.index')->with('success', 'Supplier created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $supplier = Supplier::find($id);
        if (!$supplier) {
            return response()->json(['error' => 'Supplier not found'], 404);
        }
        return response()->json($supplier);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Supplier $supplier)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'cperson' => 'required|string',
            'contact' => 'required|string',
            'status' => 'required|boolean',
        ]);

        $supplier = Supplier::findOrFail($id);
        $supplier->update($validatedData); // Update the existing supplier

        return redirect()->route('supplier.index')->with('success', 'Supplier updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            // Find the supplier by ID
            $supplier = Supplier::findOrFail($id);

            // Soft delete the supplier
            $supplier->delete();

            // Redirect back with a success message
            return redirect()->route('supplier.index')->with('success', 'Supplier deleted successfully.');
        } catch (\Exception $e) {
            \Log::error('Error deleting supplier:', ['error' => $e->getMessage()]);

            // Return a JSON response with the error message
            return response()->json(['message' => 'Failed to delete the supplier.'], 500);
        }
    }

    public function getAllSuppliers()
    {
        // Fetch all suppliers
        $suppliers = Supplier::all();

        // Return the data as JSON
        return response()->json($suppliers);
    }
}
