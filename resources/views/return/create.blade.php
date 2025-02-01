@extends('layouts.app')
@section('content')
<script src="https://cdn.tailwindcss.com"></script>
<div class="bg-white shadow-md rounded-lg p-6 max-w-full ">
    <h1 class="text-2xl font-bold mb-6 text-gray-800">Add Return List</h1>
    <form action="" method="POST" onsubmit="return false;">
        @csrf
        <div class="max-w-5xl mx-auto p-8 bg-gray-50 rounded-lg shadow-md space-y-6">
        
            <!-- Supplier Section -->
            <div class="grid grid-cols-12 gap-4">
              <div class="col-span-6">
                <label class="block text-sm font-medium text-gray-700 mb-1">Supplier</label>
                <input
                  type="text"
                  class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-200 focus:outline-none"
                />
              </div>
              <div class="col-span-6">
                <label class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                <input
                  type="text"
                  class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-200 focus:outline-none"
                />
              </div>
            </div>
          
            <!-- Item List Section -->
            <div>
              <h2 class="text-sm font-semibold text-gray-600 mb-4">List of Items</h2>
              <div class="grid grid-cols-12 gap-4 items-center">
                <div class="col-span-5">
                  <label class="block text-sm font-medium text-gray-700 mb-1">Item</label>
                  <input
                    type="text"
                    id="itemName"
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-200 focus:outline-none"
                  />
                </div>
                <div class="col-span-2">
                  <label class="block text-sm font-medium text-gray-700 mb-1">Qty</label>
                  <input
                    type="number"
                    id="itemQty"
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-200 focus:outline-none"
                  />
                </div>
                <div class="col-span-3">
                  <label class="block text-sm font-medium text-gray-700 mb-1">Price</label>
                  <input
                    type="text"
                    id="itemPrice"
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-200 focus:outline-none"
                  />
                </div>
                <div class="col-span-2">
                  <label class="block text-sm font-medium text-gray-700 mb-1 invisible">Action</label>
                  <button
                    type="button"
                    onclick="addItem()"
                    class="w-full px-4 py-2 text-white bg-blue-500 rounded-md hover:bg-blue-600">
                    Add
                  </button>
                </div>
              </div>
            </div>
          
            <!-- Table -->
            <div class="overflow-x-auto">
              <table class="w-full border-collapse border border-gray-200" id="itemsTable">
                <thead class="bg-gray-100">
                  <tr>
                    <th class="px-4 py-2 border border-gray-200">Qty</th>
                    <th class="px-4 py-2 border border-gray-200">Item</th>
                    <th class="px-4 py-2 border border-gray-200">Price</th>
                    <th class="px-4 py-2 border border-gray-200">Total</th>
                    <th class="px-4 py-2 border border-gray-200"></th>
                  </tr>
                </thead>
                <tbody>
                  <!-- Rows will be dynamically added here -->
                </tbody>
              </table>
            </div>
          
            <!-- Remark Section -->
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">Remarks</label>
              <textarea
                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-200 focus:outline-none"
                rows="3"
              ></textarea>
            </div>
          
            <!-- Total and Save Button -->
            <div class="flex justify-between items-center">
              <div id="totalAmount" class="text-lg font-semibold text-gray-700">Total: $0</div>
              <button class="px-6 py-2 bg-green-500 text-white font-semibold rounded-md hover:bg-green-600">
                Save
              </button>
            </div>
          </div>
    </form>
</div>

<script>
  let totalAmount = 0;

  function addItem() {
    const itemName = document.getElementById('itemName').value.trim();
    const itemQty = parseInt(document.getElementById('itemQty').value.trim(), 10);
    const itemPrice = parseFloat(document.getElementById('itemPrice').value.trim());

    if (!itemName || isNaN(itemQty) || isNaN(itemPrice)) {
      alert('Please fill in all fields with valid data.');
      return;
    }

    const total = itemQty * itemPrice;
    totalAmount += total;

    const tableBody = document.querySelector('#itemsTable tbody');
    const row = document.createElement('tr');
    row.className = 'hover:bg-gray-50';

    row.innerHTML = `
      <td class="px-4 py-2 border border-gray-200 text-center">${itemQty}</td>
      <td class="px-4 py-2 border border-gray-200">${itemName}</td>
      <td class="px-4 py-2 border border-gray-200 text-right">$${itemPrice.toFixed(2)}</td>
      <td class="px-4 py-2 border border-gray-200 text-right">$${total.toFixed(2)}</td>
      <td class="px-4 py-2 border border-gray-200 text-center">
        <button class="text-red-500 hover:text-red-700" onclick="removeItem(this, ${total})">&times;</button>
      </td>
    `;

    tableBody.appendChild(row);

    document.getElementById('totalAmount').textContent = `Total: $${totalAmount.toFixed(2)}`;

    // Clear input fields
    document.getElementById('itemName').value = '';
    document.getElementById('itemQty').value = '';
    document.getElementById('itemPrice').value = '';
  }

  function removeItem(button, total) {
    const row = button.parentElement.parentElement;
    row.remove();

    totalAmount -= total;
    document.getElementById('totalAmount').textContent = `Total: $${totalAmount.toFixed(2)}`;
  }
</script>
@endsection
