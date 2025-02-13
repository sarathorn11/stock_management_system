@extends('layouts.app')

@section('content')
<script src="https://cdn.tailwindcss.com"></script>
<div class="bg-white shadow-md rounded-lg p-6 max-w-full">
    <h1 class="text-2xl font-bold mb-6 text-gray-800">Add Return List</h1>
    <form action="{{ route('return.store') }}" method="POST" onsubmit="return false;">
        @csrf
        <div class="max-w-5xl mx-auto p-8  rounded-lg  space-y-6">
        
            <!-- Supplier Section -->
            <div class="grid grid-cols-12 gap-4">
              <div class="col-span-6">
                <label class="block text-sm font-medium text-gray-700 mb-1">Return Code</label>
                <input type="text" 
                       name="return_code" 
                       value="{{ old('return_code', 'Auto-Generated') }}" 
                       readonly
                       class="w-full px-4 py-2 border border-gray-300 rounded-md bg-gray-100 focus:outline-none">
              </div>

              <div class="col-span-6">
                <label class="block text-sm font-medium text-gray-700 mb-1">Supplier</label>
                <select
                    id="supplierSelect"
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-200 focus:outline-none"
                    onchange="loadItems(this.value)">
                    <option value="">Select a supplier</option>
                    @foreach($suppliers as $sup)
                        <option value="{{ $sup->supplier_id }}">{{ $sup->supplier_name }}</option>
                    @endforeach
                </select>
              </div>
            </div>
            {{ $suppliers }}

            <div>
              <h2 class="text-sm font-semibold text-gray-600 mb-4">List of Items</h2>
              <div class="grid grid-cols-12 gap-4 items-center">
                <div class="col-span-5">
                  <label class="block text-sm font-medium text-gray-700 mb-1">Item</label>
                  <select
                      class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-200 focus:outline-none"
                      id="itemsSelect">
                  </select>
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
                  <label class="block text-sm font-medium text-gray-700 mb-1">Unit</label>
                  <input
                    type="text"
                    id="itemUnit"
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
                    <th class="px-4 py-2 border border-gray-200">Unit</th>
                    <th class="px-4 py-2 border border-gray-200">Total</th>
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
  let totalAmount = 0; // Global variable to keep track of the total
  function loadItems(supplierId) {
    const suppliers = @json($suppliers); // Pass PHP data to JavaScript
    
    // Find the selected supplier by ID
    const supplier = suppliers.find(sup => sup.supplier_id == supplierId);
    
    // Get the items select dropdown
    const itemsSelect = document.getElementById('itemsSelect');
    itemsSelect.innerHTML = ''; // Clear existing options

    // If supplier exists, populate item options
    if (supplier) {
        supplier.items.forEach((item, index) => {
            const option = document.createElement('option');
            option.value = item.item_id;

            // Build option text to include stock_ids
            let stockText = '';
            if (item.stocks && item.stocks.length > 0) {
                stockText = ' - Stock IDs: ' + item.stocks.map(stock => stock.stock_id).join(', ');
            } else {
                stockText = ' - No Stocks';
            }

            option.textContent = `${item.item_name} - $${item.item_cost}${stockText}`;
            
            // Store item cost and stock IDs in dataset
            option.dataset.cost = item.item_cost;
            option.dataset.stocks = item.stocks.length > 0 
                ? item.stocks.map(stock => stock.stock_id).join(',') 
                : 'No Stock';

            // Select first item by default
            if (index === 0) {
                option.selected = true;
            }

            itemsSelect.appendChild(option);
        });

        // Calculate total based on selected item and quantity
        updateTotal();
    }
}

// Function to get stock IDs of the selected item
function getStockIds() {
    const selectedOption = document.getElementById('itemsSelect').selectedOptions[0];
    const stockIds = selectedOption.dataset.stocks;

    console.log("Stock IDs:", stockIds); // Log stock IDs
    return stockIds;
}

// Example: Call getStockIds() on item selection change
document.getElementById('itemsSelect').addEventListener('change', getStockIds);


  // function loadItems(supplierId) {
  //   const suppliers = @json($suppliers); // Pass the PHP data to JavaScript
    
  //   // Find the selected supplier data by ID
  //   const supplier = suppliers.find(sup => sup.supplier_id == supplierId);
    
  //   // Get the items select dropdown
  //   const itemsSelect = document.getElementById('itemsSelect');
  //   itemsSelect.innerHTML = ''; // Clear existing options

  //   // If supplier exists, populate the item options
  //   if (supplier) {
  //       supplier.items.forEach((item, index) => {
  //           const option = document.createElement('option');
  //           option.value = item.item_id;
  //           option.textContent = `${item.item_name} - $${item.item_cost}`;

  //           // Store the item cost in the option's dataset for later use
  //           option.dataset.cost = item.item_cost;

  //           // If it's the first item, set it as selected
  //           if (index === 0) {
  //               option.selected = true;
  //           }

  //           itemsSelect.appendChild(option);
  //       });
        
  //       // Calculate total based on selected item and quantity
  //       updateTotal();
  //   }
  // }
  

  function updateTotal() {
    const itemSelect = document.getElementById('itemsSelect');
    const itemCost = parseFloat(itemSelect.selectedOptions[0].dataset.cost);
    const itemQty = parseInt(document.getElementById('itemQty').value.trim(), 10);

    if (isNaN(itemQty) || itemQty <= 0) {
        totalAmount = 0;
    } else {
        totalAmount = itemCost * itemQty;
    }

    // Display the calculated total
    document.getElementById('totalAmount').textContent = `Total: $${totalAmount.toFixed(2)}`;
  }

  function addItem() {
    const itemSelect = document.getElementById('itemsSelect');
    const itemName = itemSelect.selectedOptions[0].textContent;
    const itemCost = parseFloat(itemSelect.selectedOptions[0].dataset.cost);
    const itemQty = parseInt(document.getElementById('itemQty').value.trim(), 10);
    const itemUnit = document.getElementById('itemUnit').value.trim();

    // Validate inputs
    if (!itemName || isNaN(itemQty) || itemQty <= 0 || !itemUnit) {
        alert('Please fill in all fields with valid data (Qty must be a positive number and Unit must not be empty).');
        return;
    }

    const tableBody = document.querySelector('#itemsTable tbody');
    const row = document.createElement('tr');
    row.className = 'hover:bg-gray-50';

    // Calculate total for the item
    const total = (itemQty * itemCost).toFixed(2);

    row.innerHTML = `
        <td class="px-4 py-2 border border-gray-200 text-center">${itemQty}</td>
        <td class="px-4 py-2 border border-gray-200">${itemName}</td>
        <td class="px-4 py-2 border border-gray-200 text-right">${itemUnit}</td>
        <td class="px-4 py-2 border border-gray-200 text-right">${total}</td>
        <td class="px-4 py-2 border border-gray-200 text-center">
          <button class="text-red-500 hover:text-red-700" onclick="removeItem(this, ${total})">&times;</button>
        </td>
    `;

    tableBody.appendChild(row);

    // Clear the form inputs after adding the item
    document.getElementById('itemQty').value = '';
    document.getElementById('itemUnit').value = '';

    // Update the total amount in the table
    totalAmount += parseFloat(total);
    document.getElementById('totalAmount').textContent = `Total: $${totalAmount.toFixed(2)}`;
  }

  function removeItem(button, total) {
    const row = button.parentElement.parentElement;
    row.remove();

    // Subtract the total of the removed item from the total amount
    totalAmount -= total;
    document.getElementById('totalAmount').textContent = `Total: $${totalAmount.toFixed(2)}`;
  }
</script>

{{-- <script>
  function loadItems(supplierId) {
    const suppliers = @json($suppliers); // Pass the PHP data to JavaScript
    
    // Find the selected supplier data by ID
    const supplier = suppliers.find(sup => sup.supplier_id == supplierId);
    
    // Get the items select dropdown
    const itemsSelect = document.getElementById('itemsSelect');
    
    // If supplier exists, populate the item options
    if (supplier) {
        supplier.items.forEach((item, index) => {
            const option = document.createElement('option');
            option.value = item.item_id;
            option.textContent = `${item.item_name},`;

            // If it's the first item, set it as selected
            if (index === 0) {
                option.selected = true;
            }

            itemsSelect.appendChild(option);
        });
    }
  }


    function addItem() {
    const itemName = document.getElementById('itemsSelect').value.trim();  // Item name from select dropdown
    const itemQty = parseInt(document.getElementById('itemQty').value.trim(), 10);
    const itemUnit = document.getElementById('itemUnit').value.trim();  // Item unit as a string

    // Validate inputs
    if (!itemName || isNaN(itemQty) || itemQty <= 0 || !itemUnit) {
        alert('Please fill in all fields with valid data (Qty must be a positive number and Unit must not be empty).');
        return;
    }

    const tableBody = document.querySelector('#itemsTable tbody');
    const row = document.createElement('tr');
    row.className = 'hover:bg-gray-50';

    // Calculate total for the item (assuming unit is a price, but you can adjust this logic)
    const total = (itemQty * parseFloat(itemUnit)).toFixed(2); // Assuming itemUnit is a price as a string

    row.innerHTML = `
        <td class="px-4 py-2 border border-gray-200 text-center">${itemQty}</td>
        <td class="px-4 py-2 border border-gray-200">${itemName}</td>
        <td class="px-4 py-2 border border-gray-200 text-right">${itemUnit}</td>
        <td class="px-4 py-2 border border-gray-200 text-right">${total}</td>
        <td class="px-4 py-2 border border-gray-200 text-center">
       <button class="text-red-500 hover:text-red-700" onclick="removeItem(this, ${total})">&times;</button>
        </td>
    `;

    tableBody.appendChild(row);

    // Clear the form inputs after adding the item
    document.getElementById('itemQty').value = '';
    document.getElementById('itemUnit').value = '';
  }

    function removeItem(button, total) {
        const row = button.parentElement.parentElement;
        row.remove();

        totalAmount -= total;
        document.getElementById('totalAmount').textContent = `Total: $${totalAmount.toFixed(2)}`;
    }
</script> --}}

@endsection
