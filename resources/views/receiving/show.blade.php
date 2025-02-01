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
            <p><strong>P.O. Code:</strong> P0-0002</p>
            <p><strong>FROM B.O CODE:</strong> B0-003</p>
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
                <tr>
                    <td class="border border-gray-300 px-4 py-2">300.00</td>
                    <td class="border border-gray-300 px-4 py-2">boxes</td>
                    <td class="border border-gray-300 px-4 py-2">Items 102 sample only</td>
                    <td class="border border-gray-300 px-4 py-2">200</td>
                    <td class="border border-gray-300 px-4 py-2">60,000</td>
                </tr>
                <tr>
                    <td class="border border-gray-300 px-4 py-2">200.00</td>
                    <td class="border border-gray-300 px-4 py-2">pcs</td>
                    <td class="border border-gray-300 px-4 py-2">Items 102 sample only</td>
                    <td class="border border-gray-300 px-4 py-2">205</td>
                    <td class="border border-gray-300 px-4 py-2">41,000</td>
                </tr>
                <tr class="bg-gray-100">
                    <td colspan="4" class="border border-gray-300 px-4 py-2 text-right"><strong>Sub total</strong></td>
                    <td class="border border-gray-300 px-4 py-2">101,000.00</td>
                </tr>
                <tr class="bg-gray-100">
                    <td colspan="4" class="border border-gray-300 px-4 py-2 text-right"><strong>Discount 5%</strong></td>
                    <td class="border border-gray-300 px-4 py-2">5,050.00</td>
                </tr>
                <tr class="bg-gray-100">
                    <td colspan="4" class="border border-gray-300 px-4 py-2 text-right"><strong>Tax 12%</strong></td>
                    <td class="border border-gray-300 px-4 py-2">11,514.00</td>
                </tr>
                <tr class="bg-gray-200">
                    <td colspan="4" class="border border-gray-300 px-4 py-2 text-right"><strong>Total</strong></td>
                    <td class="border border-gray-300 px-4 py-2">107,464.00</td>
                </tr>
            </tbody>
        </table>

        <div class="mt-6">
            <p><strong>Remark:</strong></p>
            <p>BO Receive (Partial)</p>
            <p>PARTIALLY RECEIVED</p>
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