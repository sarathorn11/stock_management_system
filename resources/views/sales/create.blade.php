@extends('layouts.app')
@section('content')
<div class="w-full h-full">
  <div class="flex items-center gap-2">
    <a href="{{ route('sales.index') }}"
      class="text-2xl font-bold text-gray-800 hover:text-blue-500 hover:underline hover:cursor-pointer">Sale</a>
    <h1 class="text-2xl font-bold text-gray-800 ">/</h1>
    <h1 class="text-2xl font-bold text-gray-800 underline">Create</h1>
  </div>
  <div class="w-full h-auto bg-white p-8 my-8">
    <form action="{{ route('sales.store') }}" method="POST" class="m-0">
      @csrf
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <div>
          <label for="sales_code" class="block text-gray-700 font-medium mb-2">Sales Code</label>
          <input type="text" id="sales_code" name="sales_code" required
            class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
        </div>
        <div>
          <label for="client" class="block text-gray-700 font-medium mb-2">Client</label>
          <input type="text" id="client" name="client" required
            class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
        </div>
        <div>
          <label for="amount" class="block text-gray-700 font-medium mb-2">Amount</label>
          <input type="number" id="amount" name="amount" required step="0.01"
            class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
        </div>
        <div>
          <label for="stock_id" class="block text-gray-700 font-medium mb-2">Stock</label>
          <select id="stock_id" name="stock_id" required
            class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
            @foreach ($stocks as $stock)
            <option value="{{ $stock->id }}">{{ $stock->item_id }} ({{ $stock->quantity }} {{ $stock->unit }})</option>
            @endforeach
          </select>
        </div>
      </div>
      <div class="mb-6">
        <label for="remarks" class="block text-gray-700 font-medium mb-2">Remarks</label>
        <textarea id="remarks" name="remarks"
          class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"></textarea>
      </div>
      <div class="flex items-center justify-end">
        <a href="{{ route('sales.index') }}"
          class="bg-gray-300 text-black py-2 px-4 mr-2 rounded hover:bg-gray-400">Cancel</a>
        <button type="submit"
          class="bg-blue-500 text-white font-bold py-2 px-4 rounded hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
          Create
        </button>
      </div>
    </form>
  </div>
</div>
@endsection