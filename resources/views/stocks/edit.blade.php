@extends('layouts.app')
@section('content')
<div class="bg-white shadow-md rounded-lg p-6 max-w-3xl mx-auto">
    <h1 class="text-2xl font-bold mb-6 text-gray-800">Edit Stock</h1>
    <form action="{{ route('stocks.update', $stock->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label for="item_id" class="block text-gray-700 font-medium mb-2">Item ID</label>
            <input type="number" id="item_id" name="item_id" value="{{ $stock->item_id }}" required 
                class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
        </div>
        <div class="mb-4">
            <label for="quantity" class="block text-gray-700 font-medium mb-2">Quantity</label>
            <input type="number" id="quantity" name="quantity" value="{{ $stock->quantity }}" required 
                class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
        </div>
        <div class="mb-4">
            <label for="unit" class="block text-gray-700 font-medium mb-2">Unit</label>
            <input type="text" id="unit" name="unit" value="{{ $stock->unit }}" 
                class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
        </div>
        <div class="mb-4">
            <label for="price" class="block text-gray-700 font-medium mb-2">Price</label>
            <input type="number" step="0.01" id="price" name="price" value="{{ $stock->price }}" required 
                class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
        </div>
        <div class="mb-4">
            <label for="total" class="block text-gray-700 font-medium mb-2">Total</label>
            <input type="number" step="0.01" id="total" name="total" value="{{ $stock->total }}" required 
                class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
        </div>
        <div class="mb-4">
            <label for="type" class="block text-gray-700 font-medium mb-2">Type</label>
            <select id="type" name="type" required 
                class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                <option value="1" {{ $stock->type == 1 ? 'selected' : '' }}>IN</option>
                <option value="2" {{ $stock->type == 2 ? 'selected' : '' }}>OUT</option>
            </select>
        </div>
        <button type="submit" 
            class="bg-blue-500 text-white font-bold py-2 px-4 rounded hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
            Update Stock
        </button>
    </form>
</div>
@endsection
