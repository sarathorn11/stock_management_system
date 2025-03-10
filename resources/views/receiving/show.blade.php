@extends('layouts.app')

@section('content')
<div class="w-full h-full p-8">
    <div class="flex justify-between items-center mb-6">
        <!-- Heading -->
        <h1 class="text-2xl font-bold">Receiving Detail</h1>

        <!-- Buttons Section -->
        <div class="flex space-x-4">
            <!-- Update Button -->
            <a href="#" class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600 transition duration-300">
                Update
            </a>

            <!-- Print Button -->
            <button onclick="window.print()" class="bg-green-500 text-white px-6 py-2 rounded hover:bg-green-600 transition duration-300">
                Print
            </button>
        </div>
    </div>
    
    <!-- Content to Print -->
    <div class="print">
        <div class="mb-6">
            <!-- Display P.O. Code or B.O. Code based on the source -->
            @if ($receiving->from_order == 1)
                <p><strong>P.O. Code:</strong> {{ $receiving->from->po_code ?? 'N/A' }}</p>
            @elseif ($receiving->from_order == 2)
                <p><strong>B.O. Code:</strong> {{ $receiving->from->bo_code ?? 'N/A' }}</p>
            @endif
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

                @php
                    $stockIds = json_decode($receiving->stock_ids, true);
                @endphp

                @foreach ($stockIds as $itemId => $itemDetails)
                    <tr>
                        <td class="border border-gray-300 px-4 py-2">{{ $itemDetails['quantity'] }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $itemDetails['unit'] }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $itemDetails['name'] }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ number_format($itemDetails['cost'], 2) }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ number_format($itemDetails['quantity'] * $itemDetails['cost'], 2) }}</td>
                    </tr>
                @endforeach

                <!-- Display subtotal, discount, tax, and total -->
                <tr class="bg-gray-100">
                    <td colspan="4" class="border border-gray-300 px-4 py-2 text-right"><strong>Sub total</strong></td>
                    <td class="border border-gray-300 px-4 py-2">{{ number_format($receiving->amount, 2) }}</td>
                </tr>
                <tr class="bg-gray-100">
                    <td colspan="4" class="border border-gray-300 px-4 py-2 text-right"><strong>Discount {{ $receiving->discount_perc }}%</strong></td>
                    <td class="border border-gray-300 px-4 py-2">{{ number_format($receiving->discount, 2) }}</td>
                </tr>
                <tr class="bg-gray-100">
                    <td colspan="4" class="border border-gray-300 px-4 py-2 text-right"><strong>Tax {{ $receiving->tax_perc }}%</strong></td>
                    <td class="border border-gray-300 px-4 py-2">{{ number_format($receiving->tax, 2) }}</td>
                </tr>
                <tr class="bg-gray-200">
                    <td colspan="4" class="border border-gray-300 px-4 py-2 text-right"><strong>Total</strong></td>
                    <td class="border border-gray-300 px-4 py-2">{{ number_format($receiving->amount - $receiving->discount + $receiving->tax, 2) }}</td>
                </tr>
            </tbody>
        </table>

        <div class="mt-6">
            <div>
                <p><strong>Remark:</strong></p>
                <p>{{ $receiving->remarks ?? 'N/A' }}</p>
            </div>
            <div>
                <p><strong>Status:</strong> {{ $receiving->status }}</p>
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