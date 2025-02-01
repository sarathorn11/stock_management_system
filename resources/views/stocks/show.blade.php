@extends('layouts.app')
@section('content')
<div class="w-full h-full">
  <div class="flex justify-between">
    <div class="flex items-center gap-2">
      <a href="{{ route('stocks.index') }}"
        class="text-xl font-bold text-gray-800 hover:text-blue-500 hover:underline hover:cursor-pointer">Stock</a>
      <h1 class="text-xl font-bold text-gray-800 ">/</h1>
      <h1 class="text-xl font-bold text-gray-800 underline">Detail</h1>
    </div>
    <div class="flex items-center justify-end">
      <a href="{{ route('stocks.create') }}"
        class="inline-block bg-blue-500 text-white px-4 py-[6px] rounded hover:bg-blue-600">Create</a>
      <a class="inline-block bg-gray-300 text-black px-4 py-[6px] rounded hover:bg-gray-400 ml-2">
        Print
      </a>
    </div>
  </div>
  <div class="w-full h-auto bg-white p-6 my-4">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
      <p><strong class="text-gray-600">ID:</strong> {{ $stock->id }}</p>
      <p><strong class="text-gray-600">Item ID:</strong> {{ $stock->item_id }}</p>
      <p><strong class="text-gray-600">Quantity:</strong> {{ $stock->quantity }}</p>
      <p><strong class="text-gray-600">Unit:</strong> {{ $stock->unit }}</p>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
      <p><strong class="text-gray-600">Price:</strong> {{ $stock->price }}</p>
      <p><strong class="text-gray-600">Total:</strong> {{ $stock->total }}</p>
      <p><strong class="text-gray-600">Type:</strong> {{ $stock->type == 1 ? 'IN' : 'OUT' }}</p>
      <p><strong class="text-gray-600">Date Created:</strong> {{ $stock->date_created }}</p>
    </div>
  </div>
</div>
@endsection