@extends('layouts.app')

@section('content')
<style>
    .bg-navy {
        background-color: #001f3f !important;
    }
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
<div class="w-full h-full">
    <h1 class="text-xl font-bold text-gray-800">Sale Record - {{ $sale->sales_code }}</h1>
    <div class="flex items-center justify-between my-4">
        <div></div>
        <div class="flex items-center justify-between">
            <button onclick="window.print()" class="bg-green-500 text-white px-6 py-2 rounded hover:bg-green-600 transition duration-300">
            <i class="fa fa-print mr-2"></i>Print
            </button>
        </div>
    </div>
    <div class="print card bg-white p-6 rounded-sm">
        <div class="card-body" id="print_out">
            <div class="container-fluid">
                <div class="grid grid-flow-row gap-4 grid-cols-3">
                  <div class="col-span-2">
                      <label class="text-blue-500 font-bold">Sale Code</label>
                      <div>{{ $sale->sales_code }}</div>
                  </div>
                  <div class="col-span-1">
                      <label for="supplier_id" class="text-blue-500 font-bold">Client Name</label>
                      <div>{{ $sale->client }}</div>
                  </div>
                </div>
                <h2 class="text-blue-500 font-bold py-2 mt-1">Items</h2>
                <table class="table-auto w-full border-collapse border border-gray-400" id="list">
                    <colgroup>
                        <col width="10%">
                        <col width="10%">
                        <col width="30%">
                        <col width="25%">
                        <col width="25%">
                    </colgroup>
                    <thead>
                        <tr class=" bg-gray-300">
                            <th class="text-center py-1 px-2 border border-gray-400">Qty</th>
                            <th class="text-center py-1 px-2 border border-gray-400">Unit</th>
                            <th class="text-center py-1 px-2 border border-gray-400">Item</th>
                            <th class="text-center py-1 px-2 border border-gray-400">Cost</th>
                            <th class="text-center py-1 px-2 border border-gray-400">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $total = 0; @endphp
                        @foreach($sale->saleItems as $item)
                            @php $total += $item->total; @endphp
                            <tr>
                                <td class="py-1 px-2 text-center border border-gray-400">{{ $item->quantity }}</td>
                                <td class="py-1 px-2 text-center border border-gray-400">{{ $item->item->unit }}</td>
                                <td class="py-1 px-2 border border-gray-400">
                                    {{ $item->item->name }} <br>
                                    {{ $item->item->description }}
                                </td>
                                <td class="py-1 px-2 text-right border border-gray-400">{{ number_format($item->price, 2) }}</td>
                                <td class="py-1 px-2 text-right border border-gray-400">{{ number_format($item->total, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th class="text-right py-1 px-2 border border-gray-400" colspan="4">Total</th>
                            <th class="text-right py-1 px-2 border border-gray-400 grand-total">{{ number_format($total, 2) }}</th>
                        </tr>
                    </tfoot>
                </table>
                <div class="grid grid-flow-col gap-4 grid-cols-3 mt-10">
                    <div class="col-span-2">
                    <label for="remarks" class="text-blue-500">Remarks</label>
                    <p>{{ $sale->remarks ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
