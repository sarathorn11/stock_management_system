@extends('layouts.app')

@section('content')
<div class="container mx-auto">
    <h1 class="text-2xl font-bold text-gray-800">Purchase Orders</h1>
    <div class="flex items-center justify-between my-4">
      <input type="text" placeholder="Search..." class="px-3 py-2 w-[350px] rounded border-gray-300">
      <div class="flex items-center justify-between">
        <a href="{{ route('purchase-order.create') }}"
          class="inline-block bg-blue-500 text-white px-4 py-2 rounded mb-4 hover:bg-blue-600">Create</a>
        
        <!-- Dropdown for Options -->
        <div class="relative inline-block text-left">
          <button type="button" id="option-button" class="inline-block bg-gray-300 text-black px-4 py-2 rounded mb-4 hover:bg-gray-400 ml-2">
            <i class="fa fa-cog mr-2"></i>Option
          </button>

          <!-- Dropdown menu -->
          <div id="option-menu" class="absolute right-0 mt-2 w-48 bg-white rounded shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none z-10 hidden">
            <div class="py-1">
              <a href="#" class="text-gray-700 block px-4 py-2 text-sm">Edit</a>
              <a href="#" class="text-red-600 block px-4 py-2 text-sm">Delete</a>
            </div>
          </div>
        </div>
      </div>
    </div>
    @if(session('success'))
        <div class="bg-green-500 text-white p-2 rounded my-4">{{ session('success') }}</div>
    @endif
    <table class="table w-full">
        <thead>
            <tr>
                <th class="border px-4 py-2 text-center">
                    <input type="checkbox" id="select-all" class="cursor-pointer transform scale-125">
                </th>
                <th class="border px-4 py-2">ID</th>
                <th class="border px-4 py-2">PO Code</th>
                <th class="border px-4 py-2">Supplier</th>
                <th class="border px-4 py-2">Amount</th>
                <th class="border px-4 py-2 text-center">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($purchaseOrders as $purchaseOrder)
                <tr>
                    <td class="border px-4 py-2 text-center">
                        <input type="checkbox" class="select-record cursor-pointer transform scale-125" value="{{ $purchaseOrder->id }}">
                    </td>
                    <td class="border px-4 py-2">{{ $purchaseOrder->id }}</td>
                    <td class="border px-4 py-2">{{ $purchaseOrder->po_code }}</td>
                    <td class="border px-4 py-2">{{ $purchaseOrder->supplier->name }}</td>
                    <td class="border px-4 py-2">{{ number_format($purchaseOrder->amount, 2) }}</td>
                    <td class="border px-4 py-2 text-center">
                        @if ($purchaseOrder->status == 0)
                            <span class="inline-block px-3 py-1 rounded-full bg-blue-500 text-white font-semibold">Pending</span>
                        @elseif ($purchaseOrder->status == 1)
                            <span class="inline-block px-3 py-1 rounded-full bg-orange-500 text-white font-semibold">Partially Received</span>
                        @else
                            <span class="inline-block px-3 py-1 rounded-full bg-green-500 text-white font-semibold">Received</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script>
    // Show the dropdown menu when the button is clicked
    document.getElementById('option-button').addEventListener('click', function() {
        const menu = document.getElementById('option-menu');
        menu.classList.toggle('hidden');
    });

    // Close the dropdown if the user clicks anywhere outside the dropdown
    window.addEventListener('click', function(event) {
        const menu = document.getElementById('option-menu');
        const button = document.getElementById('option-button');
        if (!button.contains(event.target) && !menu.contains(event.target)) {
            menu.classList.add('hidden');
        }
    });

    // Select all checkboxes
    document.getElementById('select-all').addEventListener('change', function() {
        const checkboxes = document.querySelectorAll('.select-record');
        checkboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
    });
</script>

@endsection
