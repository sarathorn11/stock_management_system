@extends('layouts.app')

@section('content')
<div class="w-full h-full">
  <div class="flex justify-between">
    <div class="flex items-center gap-2">
      <a href="{{ route('sales.index') }}"
        class="text-xl font-bold text-gray-800 hover:text-blue-500 hover:underline hover:cursor-pointer">Sale</a>
      <h1 class="text-xl font-bold text-gray-800 ">/</h1>
      <h1 class="text-xl font-bold text-gray-800 underline">Detail</h1>
    </div>
    <div class="flex items-center justify-end ">
      <a href="{{ route('sales.create') }}"
        class="inline-block bg-blue-500 text-white px-4 py-[6px] rounded hover:bg-blue-600 m-0">Create</a>
      <a class="inline-block bg-gray-300 text-black px-4 py-[6px] rounded hover:bg-gray-400 ml-2">
        Print
      </a>
    </div>
  </div>
  <div class="w-full h-auto bg-white p-6 my-6">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
      <p><strong class="text-gray-600">ID:</strong> {{ $sale->id }}</p>
      <p><strong class="text-gray-600">Sales Code:</strong> {{ $sale->sales_code }}</p>
      <p><strong class="text-gray-600">Client:</strong> {{ $sale->client }}</p>
      <p><strong class="text-gray-600">Amount:</strong> {{ $sale->amount }}</p>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
      <p><strong class="text-gray-600">Stock:</strong>
        @foreach ($sale->stocks as $stock)
        {{ $stock->item->name }}
        @endforeach
      </p>
    </div>
    <div class="w-full">
      <p><strong class="text-gray-600">Remarks:</strong> {{ $sale->remarks }}</p>
    </div>
  </div>
</div>
@endsection