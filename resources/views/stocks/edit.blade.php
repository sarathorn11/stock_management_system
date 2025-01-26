@extends('layouts.app')
@section('content')
<div class="w-full h-full">
  <div class="flex items-center gap-2">
    <a href="{{ route('stocks.index') }}"
      class="text-2xl font-bold text-gray-800 hover:text-blue-500 hover:underline hover:cursor-pointer">Stock</a>
    <h1 class="text-2xl font-bold text-gray-800 ">/</h1>
    <h1 class="text-2xl font-bold text-gray-800 underline">Update</h1>
  </div>
  <div class="w-full h-auto bg-white p-8 mt-8">
    <form action="{{ route('stocks.update', $stock->id) }}" method="POST" class="m-0">
      @csrf
      @method('PUT')
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <div class="">
          <label for="item_id" class="block text-gray-700 font-medium mb-2">Item ID</label>
          <input type="number" id="item_id" name="item_id" value="{{ $stock->item_id }}" required
            class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
        </div>
        <div class="">
          <label for="quantity" class="block text-gray-700 font-medium mb-2">Quantity</label>
          <input type="number" id="quantity" name="quantity" value="{{ $stock->quantity }}" required
            class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
        </div>
        <div class="">
          <label for="unit" class="block text-gray-700 font-medium mb-2">Unit</label>
          <input type="text" id="unit" name="unit" value="{{ $stock->unit }}"
            class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
        </div>
        <div class="">
          <label for="price" class="block text-gray-700 font-medium mb-2">Price</label>
          <input type="number" step="0.01" id="price" name="price" value="{{ $stock->price }}" required
            class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
        </div>
      </div>
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <div class="">
          <label for="total" class="block text-gray-700 font-medium mb-2">Total</label>
          <input type="number" step="0.01" id="total" name="total" value="{{ $stock->total }}" required
            class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
        </div>
        <div class="">
          <label for="type" class="block text-gray-700 font-medium mb-2">Type</label>
          <select id="type" name="type" required
            class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
            <option value="1" {{ $stock->type == 1 ? 'selected' : '' }}>IN</option>
            <option value="2" {{ $stock->type == 2 ? 'selected' : '' }}>OUT</option>
          </select>
        </div>
        <div class="">
          <label for="date_created" class="block text-gray-700 font-medium mb-2">Date Created</label>
          <input type="datetime-local" id="date_created" name="date_created"
            class="w-full border border-gray-300 h-[45px] rounded-lg p-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
        </div>
      </div>
      <div class="flex items-center justify-end">
        <a href="{{ route('stocks.index') }}"
          class="bg-gray-300 text-black py-2 px-4 mr-2 rounded hover:bg-gray-400">Cancel</a>
        <button type="submit"
          class="bg-green-500 text-white font-bold py-2 px-4 rounded hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
          Update
        </button>
      </div>
    </form>
  </div>
</div>
@endsection