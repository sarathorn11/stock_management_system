@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Stock Details</h1>
    <p><strong>ID:</strong> {{ $stock->id }}</p>
    <p><strong>Item ID:</strong> {{ $stock->item_id }}</p>
    <p><strong>Quantity:</strong> {{ $stock->quantity }}</p>
    <p><strong>Unit:</strong> {{ $stock->unit }}</p>
    <p><strong>Price:</strong> {{ $stock->price }}</p>
    <p><strong>Total:</strong> {{ $stock->total }}</p>
    <p><strong>Type:</strong> {{ $stock->type == 1 ? 'IN' : 'OUT' }}</p>
    <p><strong>Date Created:</strong> {{ $stock->date_created }}</p>
    <a href="{{ route('stocks.index') }}" class="btn btn-secondary">Back</a>
</div>
@endsection
