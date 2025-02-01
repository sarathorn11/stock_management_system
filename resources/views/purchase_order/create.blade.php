@extends('layouts.app')

@section('content')
<div class="container mx-auto">
    <h1 class="text-2xl font-bold mb-4">Add Purchase Order</h1>
   
    <form action="{{ route('purchase-order.store') }}"  method="POST" class="bg-white p-4 rounded shadow">
        @csrf
        <div class="mb-4">
            <label for="po_code" class="block text-gray-700">PO Code</label>
            <input type="text" id="po_code" name="po_code" class="w-full border rounded p-2" required>
        </div>
        <div class="mb-4">
            <label for="supplier_id" class="block text-gray-700">Supplier</label>
            <select id="supplier_id" name="supplier_id" class="w-full border rounded p-2" required>
                <option value="">Select Supplier</option>
                @foreach ($suppliers as $supplier)
                    <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-4">
            <label for="amount" class="block text-gray-700">Amount</label>
            <input type="number" step="0.01" id="amount" name="amount" class="w-full border rounded p-2" required>
        </div>
        <div class="mb-4">
            <label for="remarks" class="block text-gray-700">Remarks:</label>
            <textarea name="remarks" id="remarks" rows="4" class="w-full border rounded p-2"></textarea>
        </div>
        
        <div class="mb-4">
            <label for="status" class="block text-gray-700">Status</label>
            <select id="status" name="status" class="w-full border rounded p-2" required>
                <option value="0">Pending</option>
                <option value="1">Partially Received</option>
                <option value="2">Received</option>
            </select>
        </div>
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Create</button>
    </form>
</div>
@endsection
