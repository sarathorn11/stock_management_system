@extends('layouts.app')

@section('content')
<div class="w-full h-full p-8">
    <!-- Edit Form -->
    <form id="edit-form" action="{{ route('purchase-order.update', $purchaseOrder->id) }}" method="POST" class="mt-8">
        @csrf
        @method('PUT') <!-- Use PUT method for updates -->

        <div class="flex justify-between items-center mb-6">
            <!-- Breadcrumb -->
            <div class="flex items-center gap-2">
                <a href="{{ route('purchase-order.index') }}"
                    class="text-xl font-bold text-gray-800 hover:text-blue-500 hover:underline hover:cursor-pointer">
                    Purchase Order
                </a>
                <h1 class="text-xl font-bold text-gray-800">/</h1>
                <h1 class="text-xl font-bold text-gray-800 underline">Edit</h1>
            </div>

            
            <!-- Buttons -->
            <div class="flex space-x-4">
                <!-- Save Button -->
                <div>
                <button class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700" type="submit" form="edit-form">Save</button>
                    <a href="{{ route('purchase-order.index') }}"
                        class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition duration-300">
                        Cancel
                    </a>
                </div>
                
            </div>
            
        </div>

        <!-- P.O. Code and Supplier -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="text-blue-500 font-medium">P.O. Code</label>
                <input type="text" name="po_code" class="w-full border rounded-md p-2" value="{{ $purchaseOrder->po_code }}" readonly>
            </div>

            <div>
                <label for="supplier_id" class="text-blue-500 font-medium">Supplier</label>
                <select id="supplier_id" name="supplier_id" class="w-full border rounded-md p-2">
                    <option disabled>Select Supplier</option>
                    @foreach($suppliers as $supplier)
                        <option value="{{ $supplier->id }}" {{ $purchaseOrder->supplier_id == $supplier->id ? 'selected' : '' }}>
                            {{ $supplier->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <hr class="my-4">

        <!-- Items Section -->
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

        <!-- Items Table -->
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
                <!-- Pre-fill with existing items -->
                @foreach($purchaseOrder->items as $item)
                    <tr>
                        <td class="py-2 px-3 text-center border border-gray-400">
                            <button class="border border-red-500 text-red-500 px-2 py-1 rounded hover:bg-red-500 hover:text-white" type="button" onclick="deleteRow(this)">
                                <i class="fa fa-times"></i>
                            </button>
                        </td>
                        <td class="py-2 px-3 text-center border border-gray-400">
                            <input type="number" name="qty[]" class="w-12 border rounded-md p-1 text-center" value="{{ $item->quantity }}" min="0">
                            <input type="hidden" name="item_id[]" value="{{ $item->item_id }}">
                            <input type="hidden" name="unit[]" value="{{ $item->unit }}">
                            <input type="hidden" name="price[]" value="{{ $item->price }}">
                            <input type="hidden" name="total[]" value="{{ $item->total }}">
                        </td>
                        <td class="py-2 px-3 text-center border border-gray-400">{{ $item->unit }}</td>
                        <td class="py-2 px-3 border border-gray-400">{{ $item->item->name }}</td>
                        <td class="py-2 px-3 text-right border border-gray-400">{{ number_format($item->price, 2) }}</td>
                        <td class="py-2 px-3 text-right border border-gray-400">{{ number_format($item->total, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th class="text-right py-2 px-3 border border-gray-400" colspan="5">Sub Total</th>
                    <th class="text-right py-2 px-3 sub-total border border-gray-400">{{ number_format($purchaseOrder->subtotal, 2) }}</th>
                </tr>
                <tr>
                    <th class="text-right py-2 px-3 border border-gray-400" colspan="5">
                        Discount <input class="w-12 border rounded-md p-1 text-center" type="number" name="discount_perc" min="0" max="100" value="{{ $purchaseOrder->discount_perc }}">%
                        <input type="hidden" name="discount" value="{{ $purchaseOrder->discount }}">
                    </th>
                    <th class="text-right py-2 px-3 discount border border-gray-400">{{ number_format($purchaseOrder->discount, 2) }}</th>
                </tr>
                <tr>
                    <th class="text-right py-2 px-3 border border-gray-400" colspan="5">
                        Tax <input class="w-12 border rounded-md p-1 text-center" type="number" name="tax_perc" min="0" max="100" value="{{ $purchaseOrder->tax_perc }}">%
                        <input type="hidden" name="tax" value="{{ $purchaseOrder->tax }}">
                    </th>
                    <th class="text-right py-2 px-3 tax border border-gray-400">{{ number_format($purchaseOrder->tax, 2) }}</th>
                </tr>
                <tr>
                    <th class="text-right py-2 px-3 border border-gray-400" colspan="5">Total</th>
                    <th class="text-right py-2 px-3 grand-total border border-gray-400">{{ number_format($purchaseOrder->grand_total, 2) }}</th>
                </tr>
            </tfoot>
        </table>

        <!-- Remarks -->
        <div class="my-4">
            <label for="remarks" class="text-blue-500 font-medium">Remarks</label>
            <textarea id="remarks" name="remarks" rows="3" class="w-full border rounded-md p-2">{{ $purchaseOrder->remarks }}</textarea>
        </div>

        <!-- Save Button -->
        <!-- <div class="bg-gray-100 p-4 text-center">
            <button class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700" type="submit" form="edit-form">Save</button>
        </div> -->
    </form>
</div>

<!-- JavaScript for Dynamic Item Addition -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const addToListButton = document.getElementById('add_to_list');
        const itemTableBody = document.getElementById('item-list');
        const itemSelect = document.getElementById('item_id');
        const unitInput = document.getElementById('unit');
        const qtyInput = document.getElementById('qty');

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
                    <button class="border border-red-500 text-red-500 px-2 py-1 rounded hover:bg-red-500 hover:text-white" type="button" onclick="deleteRow(this)">
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

        function deleteRow(button) {
            const row = button.closest('tr');
            row.remove();
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

            const grandTotal = subtotal - discount + tax;

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
        itemSelect.addEventListener('change', function () {
            const selectedItem = itemSelect.options[itemSelect.selectedIndex];
            unitInput.value = selectedItem.getAttribute('data-unit');
        });
    });
</script>
@endsection