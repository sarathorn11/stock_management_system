<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = $request->input('query'); // Get search input
        $perPage = $request->input('perPage', 10); // Get perPage input, default is 10

        // Query items with search filter
        $items = Item::with('supplier')
            ->when($query, function ($queryBuilder) use ($query) {
                return $queryBuilder->where('name', 'LIKE', "%{$query}%")
                    ->orWhere('description', 'LIKE', "%{$query}%");
            })
            ->paginate($perPage); // Apply pagination

        return view('items.index', [
            'items' => $items,
            'query' => $query,
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
        // Validate request
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'supplier_id' => 'required|exists:suppliers,id',
            'cost' => 'required|numeric|min:0',
            'status' => 'required|in:1,0',
        ]);

        // Create a new item
        Item::create([
            'name' => $request->name,
            'description' => $request->description,
            'supplier_id' => $request->supplier_id,
            'cost' => $request->cost,
            'status' => $request->status,
        ]);

        // Redirect back with success message
        return redirect()->route('items.index')->with('success', 'Item created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $item = Item::with('supplier')->findOrFail($id);
        return response()->json($item);
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Item $item)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'cost' => 'required|numeric|min:0',
            'supplier_id' => 'required|exists:suppliers,id',
            'status' => 'required|in:1,0',
        ]);

        $item = Item::findOrFail($id);
        $item->update($validated);

        return redirect()->route('items.index')->with('success', 'Item updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:items,id',
        ]);

        Item::destroy($request->id);
        return response()->json(['message' => 'Item deleted successfully.', 'success' => true]);
    }

    public function deleteSelected(Request $request)
    {
        // Validate that 'ids' is an array
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:items,id', // Ensure each ID exists in the 'items' table
        ]);

        // Delete multiple items
        Item::whereIn('id', $request->ids)->delete();
        return response()->json(['message' => 'Selected items deleted successfully.', 'success' => true]);
    }
}
