@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Stock</h1>

    <form action="{{ route('stocks.update', $stock->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="item_id" class="form-label">Item ID</label>
            <input type="number" class="form-control" id="item_id" name="item_id" value="{{ $stock->item_id }}" required>
        </div>
        <div class="mb-3">
            <label for="quantity" class="form-label">Quantity</label>
            <input type="number" class="form-control" id="quantity" name="quantity" value="{{ $stock->quantity }}" required>
        </div>
        <div class="mb-3">
            <label for="unit" class="form-label">Unit</label>
            <input type="text" class="form-control" id="unit" name="unit" value="{{ $stock->unit }}">
        </div>
        <div class="mb-3">
            <label for="price" class="form-label">Price</label>
            <input type="number" step="0.01" class="form-control" id="price" name="price" value="{{ $stock->price }}" required>
        </div>
        <div class="mb-3">
            <label for="total" class="form-label">Total</label>
            <input type="number" step="0.01" class="form-control" id="total" name="total" value="{{ $stock->total }}" required>
        </div>
        <div class="mb-3">
            <label for="type" class="form-label">Type</label>
            <select class="form-control" id="type" name="type" required>
                <option value="1" {{ $stock->type == 1 ? 'selected' : '' }}>IN</option>
                <option value="2" {{ $stock->type == 2 ? 'selected' : '' }}>OUT</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Update Stock</button>
    </form>
</div>
@endsection
