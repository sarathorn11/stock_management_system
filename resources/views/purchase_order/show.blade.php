@extends('layouts.app')

@section('content')
<div class="w-full h-full p-8">
    <!-- Header with Breadcrumb and Buttons -->
    <div class="flex justify-between items-center mb-6">
        <!-- Breadcrumb -->
        <div class="flex items-center gap-2">
            <a href="{{ route('purchase-order.index') }}"
                class="text-xl font-bold text-gray-800 hover:text-blue-500 hover:underline hover:cursor-pointer">
                Purchase Order
            </a>
            <h1 class="text-xl font-bold text-gray-800">/</h1>
            <h1 class="text-xl font-bold text-gray-800 underline">Detail</h1>
        </div>

        <!-- Buttons -->
        <div class="flex space-x-4">
            <form action="{{ route('purchase-order.receive', $purchaseOrder->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to receive this purchase order?');">
                @csrf
                <button type="submit"
                    class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600 transition duration-300">
                    Receive
                </button>
            </form>
            <a href="{{ route('purchase-order.edit', $purchaseOrder->id) }}"
            class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600 transition duration-300">
                Edit
            </a>
            <button onclick="window.print()"
                class="bg-green-500 text-white px-6 py-2 rounded hover:bg-green-600 transition duration-300">
                Print
            </button>
        </div>
    </div>

    <!-- Content to Print -->
    <div class="print">
        <!-- Purchase Order Details -->
        <div class="mb-6">
            <p><strong>P.O. Code:</strong> {{ $purchaseOrder->po_code }}</p>
            <p><strong>Supplier:</strong> {{ $purchaseOrder->supplier->name }}</p>
        </div>

        <h2 class="text-xl font-semibold mb-4">Order</h2>
        <table class="w-full border-collapse border border-gray-300 mb-6">
            <thead>
                <tr class="bg-gray-200">
                    <th class="border border-gray-300 px-4 py-2">Qty</th>
                    <th class="border border-gray-300 px-4 py-2">Unit</th>
                    <th class="border border-gray-300 px-4 py-2">Items</th>
                    <th class="border border-gray-300 px-4 py-2">Cost</th>
                    <th class="border border-gray-300 px-4 py-2">Total</th>
                </tr>
            </thead>
            <tbody>
                <!-- Loop through items -->
                @foreach ($purchaseOrder->items as $item)
                    <tr>
                        <td class="border border-gray-300 px-4 py-2">{{ number_format($item->quantity, 2) }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $item->unit }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $item->item->name }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ number_format($item->price, 2) }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ number_format($item->total, 2) }}</td>
                    </tr>
                @endforeach

                <!-- Subtotal -->
                <tr class="bg-gray-100">
                    <td colspan="4" class="border border-gray-300 px-4 py-2 text-right"><strong>Sub total</strong></td>
                    <td class="border border-gray-300 px-4 py-2">{{ number_format($purchaseOrder->subtotal, 2) }}</td>
                </tr>

                <!-- Discount -->
                <tr class="bg-gray-100">
                    <td colspan="4" class="border border-gray-300 px-4 py-2 text-right">
                        <strong>Discount {{ $purchaseOrder->discount_perc }}%</strong>
                    </td>
                    <td class="border border-gray-300 px-4 py-2">{{ number_format($purchaseOrder->discount, 2) }}</td>
                </tr>

                <!-- Tax -->
                <tr class="bg-gray-100">
                    <td colspan="4" class="border border-gray-300 px-4 py-2 text-right">
                        <strong>Tax {{ $purchaseOrder->tax_perc }}%</strong>
                    </td>
                    <td class="border border-gray-300 px-4 py-2">{{ number_format($purchaseOrder->tax, 2) }}</td>
                </tr>

                <!-- Total -->
                <tr class="bg-gray-200">
                    <td colspan="4" class="border border-gray-300 px-4 py-2 text-right"><strong>Total</strong></td>
                    <td class="border border-gray-300 px-4 py-2">{{ number_format($purchaseOrder->amount, 2) }}</td>
                </tr>
            </tbody>
        </table>

        <!-- Remark Section -->
        <div class="mt-6">
            <div>
                <p><strong>Remark:</strong></p>
                <p>{{ $purchaseOrder->remarks ?? 'No remarks' }}</p>
            </div>
        </div>
    </div>
</div>

<style>
    @media print {
        /* Hide everything except the content inside the .print class */
        body * {
            visibility: hidden;
        }
        .print, .print * {
            visibility: visible;
        }
        /* Ensure the printable content takes full width */
        .print {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
        }
    }
</style>
@endsection