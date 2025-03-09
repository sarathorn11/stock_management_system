@extends('layouts.app')

@section('content')
<div>
    <h1 class="text-xl font-bold text-gray-800">Create Return List</h1>
    <form id="return-form" action="{{ route('returns.store') }}" method="POST" class="mt-8">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="text-blue-500 font-medium">Return Code</label>
                <input type="text" name="return_code" class="w-full border rounded-md p-2" value="{{ old('po_code') }}" readonly>
            </div>

            <div>
                <label for="supplier_id" class="text-blue-500 font-medium">Supplier</label>
                <select id="supplier_id" name="supplier_id" class="w-full border rounded-md p-2">
                    <option disabled selected>Select Supplier</option>
                    @foreach($suppliers as $supplier)
                        <option value="{{ $supplier->id }}" {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>
                            {{ $supplier->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <hr class="my-4">

        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
            <div class="col-span-1">
                <div class="form-group">
                    <label for="item_id" class="text-blue-500 font-medium">Item</label>
                    <select id="item_id" class="w-full border rounded-md p-2">
                        <option disabled selected>Select Item</option>
                    </select>
                </div>
            </div>

            <div class="col-span-1">
                <div class="form-group">
                    <label for="unit" class="text-blue-500 font-medium">Unit</label>
                    <input type="text" class="w-full border rounded-md p-2" id="unit" readonly>
                </div>
            </div>

            <div class="col-span-1">
                <div class="form-group">
                    <label for="qty" class="text-blue-500 font-medium">Qty</label>
                    <input type="number" step="any" class="w-full border rounded-md p-2" id="qty">
                </div>
            </div>

            <div class="col-span-1 text-center">
                <div class="form-group">
                    <button type="button" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-700" id="add_to_list">
                        Add to List
                    </button>
                </div>
            </div>
        </div>

        <hr class="my-4">

        <table class="w-full border-collapse border border-gray-300">
            <colgroup>
                <col class="w-[5%]">
                <col class="w-[10%]">
                <col class="w-[10%]">
                <col class="w-[25%]">
                <col class="w-[25%]">
                <col class="w-[25%]">
            </colgroup>
            <thead>
                <tr class="bg-gray-300">
                    <th class="py-2 px-3 text-center border border-gray-400"></th>
                    <th class="py-2 px-3 text-center border border-gray-400">Qty</th>
                    <th class="py-2 px-3 text-center border border-gray-400">Unit</th>
                    <th class="py-2 px-3 text-center border border-gray-400">Item</th>
                    <th class="py-2 px-3 text-center border border-gray-400">Cost</th>
                    <th class="py-2 px-3 text-center border border-gray-400">Total</th>
                </tr>
            </thead>
            <tbody id="item-list">
                <!-- Rows will be dynamically added here -->
            </tbody>
            <tfoot>
                <tr>
                    <th class="text-right py-2 px-3 border border-gray-400" colspan="5">Total</th>
                    <th class="text-right py-2 px-3 grand-total border border-gray-400">0</th>
                </tr>
            </tfoot>
        </table>

        <div class="my-4">
            <label for="remarks" class="text-blue-500 font-medium">Remarks</label>
            <textarea id="remarks" name="remarks" rows="3" class="w-full border rounded-md p-2">{{ old('remarks') }}</textarea>
        </div>
        <div class="bg-gray-100 p-4 text-center">
            <button class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700" type="submit">Save</button>
            <a href="{{ route('return.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-700">Cancel</a>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const addToListButton = document.getElementById('add_to_list');
        const itemTableBody = document.getElementById('item-list');
        const itemSelect = document.getElementById('item_id');
        const unitInput = document.getElementById('unit');
        const qtyInput = document.getElementById('qty');
        const supplierSelect = document.getElementById('supplier_id');
        const returnForm = document.getElementById('return-form');

        // Fetch items when the supplier is selected
        supplierSelect.addEventListener('change', function () {
            const supplierId = supplierSelect.value;

            // Check if a valid supplier is selected
            if (supplierId) {
                fetchItemsBySupplier(supplierId);
            } else {
                itemSelect.innerHTML = '<option disabled selected>Select Item</option>';
            }
        });

        // Function to fetch items based on selected supplier
        function fetchItemsBySupplier(supplierId) {
            fetch(`/returns/items/${supplierId}`)
                .then(response => response.json())
                .then(data => {
                    // Clear current items
                    itemSelect.innerHTML = '<option disabled selected>Select Item</option>';

                    // Append new items to the dropdown
                    data.items.forEach(item => {
                        const option = document.createElement('option');
                        option.value = item.id;
                        option.textContent = item.name;
                        option.setAttribute('data-unit', item.unit);
                        option.setAttribute('data-price', item.cost);
                        itemSelect.appendChild(option);
                    });

            // Re-attach the event listener after the options are added
            itemSelect.addEventListener('change', function () {
                const selectedItem = itemSelect.options[itemSelect.selectedIndex];
                unitInput.value = selectedItem.getAttribute('data-unit');
            });
                });
        }

        addToListButton.addEventListener('click', function () {
            const selectedItem = itemSelect.options[itemSelect.selectedIndex];
            const itemId = selectedItem.value;
            const itemName = selectedItem.text;
            const unit = selectedItem.getAttribute('data-unit');
            const price = parseFloat(selectedItem.getAttribute('data-price'));
            const qty = parseFloat(qtyInput.value);


            if (!itemId || !qty || qty <= 0) {
                alert('Please select an item and enter a valid quantity.');
                return;
            }

            const total = price * qty;

            const newRow = document.createElement('tr');
            newRow.innerHTML = `
                <td class="py-2 px-3 text-center border border-gray-400">
                    <button class="delete-row-btn border border-red-500 text-red-500 px-2 py-1 rounded hover:bg-red-500 hover:text-white" type="button">
                        <i class="fa fa-times"></i>
                    </button>
                </td>
                <td class="py-2 px-3 text-center border border-gray-400">
                    <input type="number" name="qty[]" class="w-12 border rounded-md p-1 text-center" value="${qty}" min="0">
                    <input type="hidden" name="item_id[]" value="${itemId}">
                    <input type="hidden" name="unit[]" value="${unit}">
                    <input type="hidden" name="price[]" value="${price}">
                    <input type="hidden" name="total[]" value="${total}">
                </td>
                <td class="py-2 px-3 text-center border border-gray-400">${unit}</td>
                <td class="py-2 px-3 border border-gray-400">${itemName}</td>
                <td class="py-2 px-3 text-right border border-gray-400">${price.toFixed(2)}</td>
                <td class="py-2 px-3 text-right border border-gray-400">${total.toFixed(2)}</td>
            `;
            itemTableBody.appendChild(newRow);

            updateTotals();
        });

        // Handle row deletion using event delegation
        itemTableBody.addEventListener('click', function (e) {
          // Ensure that the clicked element is a button (including the icon inside it)
          if (e.target.closest('.delete-row-btn')) {
              const row = e.target.closest('tr'); // Find the closest row (tr) element
              row.remove(); // Remove the row
              updateTotals();
          }
        });

        function updateTotals() {
          let subtotal = 0;
          document.querySelectorAll('input[name="total[]"]').forEach(input => {
              subtotal += parseFloat(input.value);
          });

          const grandTotal = subtotal;

          document.querySelector('.grand-total').textContent = grandTotal.toFixed(2);
        }

        returnForm.addEventListener('submit', function (event) {
            event.preventDefault(); // Prevent default form submission

            // Get supplier ID
            const supplierId = supplierSelect.value;

            // Prepare items array
            let items = [];
            document.querySelectorAll('#item-list tr').forEach(row => {
                const itemId = row.querySelector('input[name="item_id[]"]').value;
                const cost = parseFloat(row.querySelector('input[name="price[]"]').value);
                const quantity = parseInt(row.querySelector('input[name="qty[]"]').value);

                items.push({
                    item: {
                        id: itemId,
                        cost: cost
                    },
                    quantity: quantity
                });
            });

            // Prepare final data object
            const requestData = {
                supplier_id: supplierId,
                items: items
            };

            // Submit via Fetch API
            fetch(returnForm.action, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                },
                body: JSON.stringify(requestData)
            })
            .then(response => response.json())
            .then(data => {
                window.location.href = data.redirect;
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });
    });
</script>
@endsection
