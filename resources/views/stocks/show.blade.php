@extends('layouts.app')
@section('content')
<div class="w-full h-full">
    <h1 class="text-3xl font-bold text-gray-800 ">Stock Details</h1>
    <div class="w-full h-auto bg-white p-8 my-4">
        <div class="space-y-2">
            <p><strong class="text-gray-600">ID:</strong> {{ $stock->id }}</p>
            <p><strong class="text-gray-600">Item ID:</strong> {{ $stock->item_id }}</p>
            <p><strong class="text-gray-600">Quantity:</strong> {{ $stock->quantity }}</p>
            <p><strong class="text-gray-600">Unit:</strong> {{ $stock->unit }}</p>
            <p><strong class="text-gray-600">Price:</strong> {{ $stock->price }}</p>
            <p><strong class="text-gray-600">Total:</strong> {{ $stock->total }}</p>
            <p><strong class="text-gray-600">Type:</strong> {{ $stock->type == 1 ? 'IN' : 'OUT' }}</p>
            <p><strong class="text-gray-600">Date Created:</strong> {{ $stock->date_created }}</p>
        </div>
        <div class="mt-6">
            <a href="{{ route('stocks.index') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Back</a>
        </div>
    </div>
</div>
@endsection
