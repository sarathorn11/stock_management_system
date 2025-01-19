@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Stock List</h1>
    <a href="{{ route('stocks.create') }}" class="btn btn-primary mb-3">Add Stock</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Item ID</th>
                <th>Quantity</th>
                <th>Unit</th>
                <th>Price</th>
                <th>Total</th>
                <th>Type</th>
                <th>Date Created</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($stocks as $stock)
                <tr>
                    <td>{{ $stock->id }}</td>
                    <td>{{ $stock->item_id }}</td>
                    <td>{{ $stock->quantity }}</td>
                    <td>{{ $stock->unit }}</td>
                    <td>{{ $stock->price }}</td>
                    <td>{{ $stock->total }}</td>
                    <td>{{ $stock->type == 1 ? 'IN' : 'OUT' }}</td>
                    <td>{{ $stock->date_created }}</td>
                    <td>
                        <a href="{{ route('stocks.show', $stock->id) }}" class="btn btn-info btn-sm">View</a>
                        <a href="{{ route('stocks.edit', $stock->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('stocks.destroy', $stock->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
