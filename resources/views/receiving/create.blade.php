@extends('layouts.app')

@section('content')
<div class="bg-white shadow-md rounded-lg p-6 max-w-3xl mx-auto">
    <h1 class="text-xl font-bold mb-6 text-gray-800">Add Receiving</h1>
    
    <form action="{{ route('receiving.store') }}" method="POST">
        @csrf
        
        <!-- From Field (Relationship to Supplier/Vendor) -->
        <div class="mb-4">
            <label for="from_id" class="block text-gray-700 font-medium mb-2">From</label>
            <input type="text" id="from_id" name="from_id" value="{{ old('from_id') }}" required 
                class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-500 focus:outline-none @error('from_id') border-red-500 @enderror">
            @error('from_id')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <!-- From Order Field (1 = PO, 2 = BO) -->
        <div class="mb-4">
            <label for="from_order" class="block text-gray-700 font-medium mb-2">From Order</label>
            <select id="from_order" name="from_order" class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-500 focus:outline-none @error('from_order') border-red-500 @enderror">
                <option value="1" {{ old('from_order') == 1 ? 'selected' : '' }}>PO</option>
                <option value="2" {{ old('from_order') == 2 ? 'selected' : '' }}>BO</option>
            </select>
            @error('from_order')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <!-- Amount Field -->
        <div class="mb-4">
            <label for="amount" class="block text-gray-700 font-medium mb-2">Amount</label>
            <input type="number" step="0.01" id="amount" name="amount" value="{{ old('amount') }}" required 
                class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-500 focus:outline-none @error('amount') border-red-500 @enderror">
            @error('amount')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <!-- Discount Percentage Field -->
        <div class="mb-4">
            <label for="discount_perc" class="block text-gray-700 font-medium mb-2">Discount Percentage</label>
            <input type="number" step="0.01" id="discount_perc" name="discount_perc" value="{{ old('discount_perc') }}" 
                class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-500 focus:outline-none @error('discount_perc') border-red-500 @enderror">
            @error('discount_perc')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <!-- Discount Field -->
        <div class="mb-4">
            <label for="discount" class="block text-gray-700 font-medium mb-2">Discount</label>
            <input type="number" step="0.01" id="discount" name="discount" value="{{ old('discount') }}" 
                class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-500 focus:outline-none @error('discount') border-red-500 @enderror">
            @error('discount')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <!-- Tax Percentage Field -->
        <div class="mb-4">
            <label for="tax_perc" class="block text-gray-700 font-medium mb-2">Tax Percentage</label>
            <input type="number" step="0.01" id="tax_perc" name="tax_perc" value="{{ old('tax_perc') }}" 
                class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-500 focus:outline-none @error('tax_perc') border-red-500 @enderror">
            @error('tax_perc')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <!-- Tax Field -->
        <div class="mb-4">
            <label for="tax" class="block text-gray-700 font-medium mb-2">Tax</label>
            <input type="number" step="0.01" id="tax" name="tax" value="{{ old('tax') }}" 
                class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-500 focus:outline-none @error('tax') border-red-500 @enderror">
            @error('tax')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <!-- Stock IDs Field -->
        <div class="mb-4">
            <label for="stock_ids" class="block text-gray-700 font-medium mb-2">Stock Items (IDs)</label>
            <input type="text" id="stock_ids" name="stock_ids" value="{{ old('stock_ids') }}" required 
                class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-500 focus:outline-none @error('stock_ids') border-red-500 @enderror">
            @error('stock_ids')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <!-- Remarks Field -->
        <div class="mb-4">
            <label for="remarks" class="block text-gray-700 font-medium mb-2">Remarks</label>
            <textarea id="remarks" name="remarks" rows="4" class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-500 focus:outline-none @error('remarks') border-red-500 @enderror">{{ old('remarks') }}</textarea>
            @error('remarks')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <!-- Submit Button -->
        <button type="submit" 
            class="bg-blue-500 text-white font-bold py-2 px-4 rounded hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
            Add Receiving
        </button>
    </form>
</div>
@endsection
