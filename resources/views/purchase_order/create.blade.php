@extends('layouts.app')

@section('content')
<div>
    <h1 class="text-xl font-bold text-gray-800">Create Purchase Order</h1>
    <form id="receive-form" action="{{ route('purchase-order.store') }}" method="POST" class="mt-8">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="text-blue-500 font-medium">P.O. Code</label>
                <input type="text" name="po_code" class="w-full border rounded-md p-2" value="{{ old('po_code') }}" readonly>
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
                <input type="hidden" id="hidden_supplier_id" name="supplier_id" value="{{ old('supplier_id') }}">
            </div>
        </div>

        <hr class="my-4">

        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
            <div class="col-span-1">
                <div class="form-group">
                    <label for="item_id" class="text-blue-500 font-medium">Item</label>
                    <select id="item_id" class="w-full border rounded-md p-2">
                        <option disabled selected>Select Item</option>
                        @foreach($items as $item)
                        <option value="{{ $item->id }}" data-unit="{{ $item->unit }}" data-price="{{ $item->cost }}">
                            {{ $item->name }}
                        </option>
                        @endforeach
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
                    <th class="text-right py-2 px-3 border border-gray-400" colspan="5">Sub Total</th>
                    <th class="text-right py-2 px-3 sub-total border border-gray-400">0</th>
                </tr>
                <tr>
                    <th class="text-right py-2 px-3 border border-gray-400" colspan="5">
                        Discount <input class="w-12 border rounded-md p-1 text-center" type="number" name="discount_perc" min="0" max="100" value="0">%
                        <input type="hidden" name="discount" value="0">
                    </th>
                    <th class="text-right py-2 px-3 discount border border-gray-400">0</th>
                </tr>
                <tr>
                    <th class="text-right py-2 px-3 border border-gray-400" colspan="5">
                        Tax <input class="w-12 border rounded-md p-1 text-center" type="number" name="tax_perc" min="0" max="100" value="0">%
                        <input type="hidden" name="tax" value="0">
                    </th>
                    <th class="text-right py-2 px-3 tax border border-gray-400">0</th>
                </tr>
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
            <button id="submit-btn" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700" type="submit" form="receive-form">Save</button>
            <a href="{{ route('purchase-order.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-700">Cancel</a>
        </div>

    </form>


</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const addToListButton = document.getElementById('add_to_list');
        const itemTableBody = document.getElementById('item-list');
        const itemSelect = document.getElementById('item_id');
        const unitInput = document.getElementById('unit');
        const qtyInput = document.getElementById('qty');
        const supplierSelect = document.getElementById('supplier_id');
        const hiddenSupplierInput = document.getElementById('hidden_supplier_id');
        const submitBtn = document.getElementById('submit-btn');

        function toggleSubmitButton() {
            if (itemTableBody.children.length > 0) {
                submitBtn.disabled = false;
                submitBtn.classList.remove('bg-gray-300');
                submitBtn.classList.add('bg-blue-500', 'hover:bg-blue-700');
            } else {
                submitBtn.disabled = true;
                submitBtn.classList.add('bg-gray-300');
                submitBtn.classList.remove('bg-blue-500', 'hover:bg-blue-700');
            }
        }

        // Call toggleSubmitButton on page load
        toggleSubmitButton();


        // Fetch items when the supplier is selected
        supplierSelect.addEventListener('change', function() {
            const supplierId = supplierSelect.value;
            hiddenSupplierInput.value = supplierId;

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
                    itemSelect.addEventListener('change', function() {
                        const selectedItem = itemSelect.options[itemSelect.selectedIndex];
                        unitInput.value = selectedItem.getAttribute('data-unit');
                    });
                });
        }

        addToListButton.addEventListener('click', function() {
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
            // Check if the item already exists in the list
            let itemExists = false;
            document.querySelectorAll('#item-list tr').forEach(row => {
                const existingItemId = row.querySelector('input[name="item_id[]"]').value;
                if (existingItemId === itemId) {
                    const existingQtyInput = row.querySelector('input[name="qty[]"]');
                    const existingTotalInput = row.querySelector('input[name="total[]"]');
                    const newQty = parseFloat(existingQtyInput.value) + qty;
                    const newTotal = price * newQty;

                    existingQtyInput.value = newQty;
                    existingTotalInput.value = newTotal.toFixed(2);
                    row.querySelector('.total-cell').textContent = newTotal.toFixed(2);

                    itemExists = true;
                }
            });

            if (!itemExists) {
                const newRow = document.createElement('tr');
                newRow.innerHTML = `
                    <td class="py-2 px-3 text-center border border-gray-400">
                        <button class="delete-row-btn border border-red-500 text-red-500 px-2 py-1 rounded hover:bg-red-500 hover:text-white" type="button">
                            <i class="fa fa-times"></i>
                        </button>
                    </td>
                    <td class="py-2 px-3 text-center border border-gray-400">
                        <input type="number" name="qty[]" class="w-12 border rounded-md p-1 text-center" value="${qty}" min="0" onchange="updateRowTotal(this)">
                        <input type="hidden" name="item_id[]" value="${itemId}">
                        <input type="hidden" name="unit[]" value="${unit}">
                        <input type="hidden" name="price[]" value="${price}">
                        <input type="hidden" name="total[]" value="${total}">
                    </td>
                    <td class="py-2 px-3 text-center border border-gray-400">${unit}</td>
                    <td class="py-2 px-3 border border-gray-400">${itemName}</td>
                    <td class="py-2 px-3 text-right border border-gray-400">${price.toFixed(2)}</td>
                    <td class="py-2 px-3 text-right border border-gray-400 total-cell">${total.toFixed(2)}</td>
                `;
                itemTableBody.appendChild(newRow);
            }

            updateTotals();
            // Disable supplier select if there are items in the list
            if (itemTableBody.children.length > 0) {
                supplierSelect.disabled = true;
            }
            toggleSubmitButton();
        });

        window.updateRowTotal = function(input) {
            console.log("updateRowTotal");
            const row = input.closest('tr');
            const qty = parseFloat(input.value);
            const price = parseFloat(row.querySelector('input[name="price[]"]').value);
            const total = qty * price;

            row.querySelector('input[name="total[]"]').value = total.toFixed(2);
            row.querySelector('.total-cell').textContent = total.toFixed(2);

            updateTotals();
        }

        function updateTotals() {
            let subtotal = 0;
            document.querySelectorAll('input[name="total[]"]').forEach(input => {
                subtotal += parseFloat(input.value);
            });

            const discountPerc = parseFloat(document.querySelector('input[name="discount_perc"]').value) || 0;
            const discount = (subtotal * discountPerc) / 100;

            const taxPerc = parseFloat(document.querySelector('input[name="tax_perc"]').value) || 0;
            const tax = (subtotal * taxPerc) / 100;

            const grandTotal = subtotal - discount - tax;

            document.querySelector('.sub-total').textContent = subtotal.toFixed(2);
            document.querySelector('.discount').textContent = discount.toFixed(2);
            document.querySelector('.tax').textContent = tax.toFixed(2);
            document.querySelector('.grand-total').textContent = grandTotal.toFixed(2);

            // Update hidden inputs for discount and tax
            document.querySelector('input[name="discount"]').value = discount;
            document.querySelector('input[name="tax"]').value = tax;
        }

        document.querySelector('input[name="discount_perc"]').addEventListener('input', updateTotals);
        document.querySelector('input[name="tax_perc"]').addEventListener('input', updateTotals);

        // Update unit when item is selected
        itemSelect.addEventListener('change', function() {
            const selectedItem = itemSelect.options[itemSelect.selectedIndex];
            unitInput.value = selectedItem.getAttribute('data-unit');
        });

        // Handle row deletion using event delegation
        itemTableBody.addEventListener('click', function(e) {
            // Ensure that the clicked element is a button (including the icon inside it)
            if (e.target.closest('.delete-row-btn')) {
                const row = e.target.closest('tr'); // Find the closest row (tr) element
                row.remove(); // Remove the row
                updateTotals();
                toggleSubmitButton(); // Update submit button state
            }
        });
    });
</script>
@endsection
