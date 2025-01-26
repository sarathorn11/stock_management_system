@extends('layouts.app')
@section('content')
<div class="w-full h-full">
  <h1 class="text-3xl font-bold text-gray-800 ">Create Stock</h1>
  <div class="w-full h-auto bg-white p-8 my-4">
    <form action="{{ route('stocks.store') }}" method="POST" class="m-0">
      @csrf
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <div class="">
          <label for="item_id" class="block text-gray-700 font-medium mb-2">Item</label>
          <select id="item_id" name="item_id" required
            class="w-full border border-gray-300 h-[45px] rounded-lg p-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
            <option value="">Select Item</option>
            @foreach ($items as $item)
            <option value="{{ $item->id }}">{{ $item->name }}</option>
            @endforeach
          </select>
        </div>
        <div class="">
          <label for="quantity" class="block text-gray-700 font-medium mb-2">Quantity</label>
          <input type="number" id="quantity" name="quantity" required
            class="w-full border border-gray-300 h-[45px] rounded-lg p-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
        </div>
        <div class="">
          <label for="unit" class="block text-gray-700 font-medium mb-2">Unit</label>
          <input type="text" id="unit" name="unit"
            class="w-full border border-gray-300 h-[45px] rounded-lg p-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
        </div>
        <div class="">
          <label for="price" class="block text-gray-700 font-medium mb-2">Price</label>
          <input type="number" step="0.01" id="price" name="price" required
            class="w-full border border-gray-300 h-[45px] rounded-lg p-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
        </div>
      </div>
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <div class="">
          <label for="total" class="block text-gray-700 font-medium mb-2">Total</label>
          <input type="number" step="0.01" id="total" name="total" required
            class="w-full border border-gray-300 h-[45px] rounded-lg p-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
        </div>
        <div class="">
          <label for="type" class="block text-gray-700 font-medium mb-2">Type</label>
          <select id="type" name="type" required
            class="w-full border border-gray-300 h-[45px] rounded-lg p-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
            <option value="1">IN</option>
            <option value="2">OUT</option>
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
          class="bg-blue-500 text-white font-bold py-2 px-4 rounded hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
          Create
        </button>
      </div>
    </form>
  </div>
</div>
@endsection