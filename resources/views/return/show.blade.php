@extends('layouts.app')

@section('content')
<div class="w-full h-full">
  <h1 class="text-3xl font-bold text-gray-800">Return List</h1>
  <div class="flex items-center justify-between my-4">
    <input type="text" placeholder="Search..." class="px-3 py-2 w-[350px] rounded border-gray-300">
    <div class="flex items-center justify-between">
      <a
        class="inline-block bg-green-500 text-white px-4 py-2 rounded mb-4 hover:bg-green-600">Update</a>
      <a class="inline-block bg-gray-300 text-black px-4 py-2 rounded mb-4 hover:bg-gray-400 ml-2">
        </i>Print
      </a>
    </div>
  </div>

  <div class="w-full h-full">
    <div class="max-w-4xl mx-auto p-4 border border-gray-300 rounded-lg">
        <!-- P.O. Code and Supplier Section -->
        <div class="flex justify-between mb-4">
          <div>
            <h2 class="text-sm font-medium text-gray-500">P.O. Code</h2>
            <p class="text-lg font-semibold text-gray-900">PO-0002</p>
          </div>
          <div>
            <h2 class="text-sm font-medium text-gray-500 text-right">Supplier</h2>
            <p class="text-lg font-semibold text-gray-900 text-right">Supplier 102</p>
          </div>
        </div>
      
        <!-- Order Table -->
        <div>
          <h2 class="text-lg font-semibold text-gray-900 mb-2">Order</h2>
          <table class="w-full text-left border-collapse border border-gray-300">
            <thead>
              <tr>
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
                <td class="border border-gray-300 px-4 py-2">
                  Items 102 <br />
                  sample only
                </td>
                <td class="border border-gray-300 px-4 py-2">200</td>
                <td class="border border-gray-300 px-4 py-2">60,000</td>
              </tr>
              <tr>
                <td class="border border-gray-300 px-4 py-2">200.00</td>
                <td class="border border-gray-300 px-4 py-2">pcs</td>
                <td class="border border-gray-300 px-4 py-2">
                  Items 102 <br />
                  sample only
                </td>
                <td class="border border-gray-300 px-4 py-2">205</td>
                <td class="border border-gray-300 px-4 py-2">41,000</td>
              </tr>
              <tr>
                <td colspan="4" class="text-right font-bold px-4 py-2 border border-gray-300">
                  Total
                </td>
                <td class="border border-gray-300 px-4 py-2 font-bold">101,000</td>
              </tr>
            </tbody>
          </table>
        </div>
      
        <!-- Remarks Section -->
        <div class="mt-4 flex justify-between">
          <div>
            <h2 class="text-sm font-medium text-gray-500">Remark</h2>
            <p class="text-gray-900">BO Receive (Partial)</p>
          </div>
          <div>
            <h2 class="text-sm font-medium text-blue-500 font-semibold text-right">PARTIALLY RECEIVED</h2>
          </div>
        </div>
      </div>
      
  </div>
</div>

@endsection