@extends('layouts.app')

@section('content')
<div class="w-full h-full">
    <h1 class="text-2xl font-bold text-gray-800">Purchase Orders</h1>
    <div class="flex items-center justify-between my-4">
        <form action="{{ route('purchase-order.index') }}" method="GET" class="flex items-center">
            <input type="text" name="query" class="px-3 py-[5px] w-[350px] rounded border" placeholder="Po code, Amount, Supplier ...."
                value="{{ request('query') }}">
            <button type="submit" class="ml-2 bg-blue-500 text-white px-4 py-[6px] rounded hover:bg-blue-600">
                Search
            </button>
        </form>
        <div class="flex items-center justify-between">
            <a href="{{ route('purchase-order.create') }}"
                class="inline-block bg-blue-500 text-white px-4 py-2 rounded mb-4 hover:bg-blue-600">Create</a>
        </div>
    </div>

    @if(session('success'))
    <div class="bg-green-500 text-white p-2 rounded my-4 flex justify-between items-center">
        <span>{{ session('success') }}</span>
        <button class="text-white ml-2" onclick="this.parentElement.style.display='none';">
            <i class="fa fa-times"></i>
        </button>
    </div>
    @endif

    <div class="w-full h-auto">
        <table class="table w-full">
            <thead class="bg-[#3c8dbc] text-white">
                <tr>
                    <th class="px-4 py-2">ID</th>
                    <th class="px-4 py-2">PO Code</th>
                    <th class="px-4 py-2">Supplier</th>
                    <th class="px-4 py-2">Items</th>
                    <th class="px-4 py-2">Amount</th>
                    <th class="px-4 py-2 text-center">Status</th>
                    <th class="px-4 py-2 text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($purchaseOrders as $purchaseOrder)
                <tr class="hover:bg-gray-200 border-b bg-white">
                    <td class="px-4 py-2 text-center">{{ $purchaseOrder->id }}</td>
                    <td class="px-4 py-2 text-center">{{ $purchaseOrder->po_code }}</td>
                    <td class="px-4 py-2 text-center">{{ optional($purchaseOrder->supplier)->name }}</td>
                    <td class="px-4 py-2 text-center">{{ count($purchaseOrder->items) }}</td>
                    <td class="px-4 py-2 text-center">{{ number_format($purchaseOrder->amount, 2) }}</td>
                    <td class="px-4 py-2 text-center">
                        @if ($purchaseOrder->status == 0)
                        <span class="inline-block px-3 py-1 rounded-full bg-blue-500 text-white font-semibold">Pending</span>
                        @elseif ($purchaseOrder->status == 1)
                        <span class="inline-block px-3 py-1 rounded-full bg-orange-500 text-white font-semibold">Partially Received</span>
                        @else
                        <span class="inline-block px-3 py-1 rounded-full bg-green-500 text-white font-semibold">Received</span>
                        @endif
                    </td>
                    <td class="px-4 py-2">
                        <div class="flex items-center justify-center">
                            <a href="{{ route('purchase-order.show', $purchaseOrder->id) }}" class="text-blue-500 mx-1">
                                <i class="fa fa-eye mr-2"></i>
                            </a>
                            @if($purchaseOrder->status == 0)
                            <a href="{{ route('receiving.create', ['po', $purchaseOrder->id]) }}" class="text-yellow-500 mx-1">
                                <i class="fas fa-boxes mr-2"></i>
                            </a>
                            <a href="{{ route('purchase-order.edit', $purchaseOrder->id) }}" class="text-yellow-500 mx-1">
                                <i class="fa fa-pencil mr-2"></i>
                            </a>
                            <form action="{{ route('purchase-order.destroy', $purchaseOrder->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this back order?')" class="m-0">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 text-[24px] mx-1">
                                    <i class="fa fa-trash mr-2"></i>
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
                @if($purchaseOrders->count() == 0)
                <tr class="bg-white hover:bg-gray-200 border-b">
                    <td colspan="7" class="text-center py-4">No purchase orders found.</td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>

    @if($purchaseOrders->count() > 0)
    <x-pagination :pagination="$purchaseOrders" :per-page="$perPage" :per-page-options="[10, 20, 30, 50]" />
    @endif
</div>

<script>
</script>

@endsection
