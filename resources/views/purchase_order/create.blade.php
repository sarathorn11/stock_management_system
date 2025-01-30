@extends('layouts.app')
@section('content')
<div class="bg-white shadow-md rounded-lg p-6 max-w-3xl mx-auto">
    <h1 class="text-xl font-bold mb-6 text-gray-800">Add Purchase Order</h1>
    <form action="" method="POST">
        @csrf
        <!-- <div class="mb-4">
            <label for="item_id" class="block text-gray-700 font-medium mb-2">Date Created</label>
            <input type="number" id="item_id" name="item_id" required 
                class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
        </div> -->
        <div class="mb-4">
            <label for="po_code" class="block text-gray-700 font-medium mb-2">PO Code</label>
            <input type="number" id="po_code" name="po_code" required 
                class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
        </div>
        <div class="mb-4">
            <label for="supplier_id" class="block text-gray-700 font-medium mb-2">Supplier</label>
            <input type="text" id="supplier_id" name="supplier_id" 
                class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
        </div>
        <div class="mb-4">
            <label for="amount" class="block text-gray-700 font-medium mb-2">Items</label>
            <input type="number" step="0.01" id="amount" name="amount" required 
                class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
        </div>
        <div class="mb-4">
            <label for="status" class="block text-gray-700 font-medium mb-2">Status</label>
            <select id="status" name="status" required 
                class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                <option value="1">IN</option>
                <option value="2">OUT</option>
            </select>
        </div>
        <button type="submit" 
            class="bg-blue-500 text-white font-bold py-2 px-4 rounded hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
            Add Purchase
        </button>
    </form>
</div>
@endsection
