@extends('layouts.app')

@section('content')
<div>
    <h1 class="text-xl font-bold text-gray-800">Edit Sale Record</h1>
    <form id="sale-form" action="{{ route('sales.update', $sale->id) }}" method="POST" class="mt-8">
        @csrf
        @method('PUT')
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="text-blue-500 font-medium">Sale Code</label>
                <input type="text" name="return_code" class="w-full border rounded-md p-2" value="{{ $sale->sales_code }}" readonly>
            </div>
            <div>
                <label class="text-blue-500 font-medium">Client Name</label>
                <input type="text" name="client" class="w-full border rounded-md p-2" value="{{ $sale->client }}">
            </div>
        </div>

        <hr class="my-4">

        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
            <div class="col-span-1">
                <div class="form-group">
                    <label for="item_id" class="text-blue-500 font-medium">Item</label>
                    <select id="item_id" class="w-full border rounded-md p-2">
                        <option disabled selected>Select Item</option>
                        @foreach ($items as $item)
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
                @php $total = 0; @endphp
                @foreach($sale->saleItems as $item)
                <tr>
                    <td class="py-2 px-3 text-center border border-gray-400">
                        <button class="delete-row-btn border border-red-500 text-red-500 px-2 py-1 rounded hover:bg-red-500 hover:text-white" type="button">
                            <i class="fa fa-times"></i>
                        </button>
                    </td>
                    <td class="py-2 px-3 text-center border border-gray-400">
                        <input type="number" name="qty[]" class="w-12 border rounded-md p-1 text-center" value="{{ $item->quantity }}" min="0">
                        <input type="hidden" name="item_id[]" value="{{ $item->item_id }}">
                        <input type="hidden" name="unit[]" value="{{ $item->item->unit }}">
                        <input type="hidden" name="price[]" value="{{ $item->price }}">
                        <input type="hidden" name="total[]" value="{{ $item->total }}">
                    </td>
                    <td class="py-2 px-3 text-center border border-gray-400">{{ $item->item->unit }}</td>
                    <td class="py-2 px-3 border border-gray-400">{{ $item->item->name }} <br> {{ $item->item->description }}</td>
                    <td class="py-2 px-3 text-right border border-gray-400">{{ number_format($item->price, 2) }}</td>
                    <td class="py-2 px-3 text-right border border-gray-400 total-cell">{{ number_format($item->total, 2) }}</td>
                </tr>
                @php $total += $item->total; @endphp
                @endforeach
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
            <button id="submit-btn" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700" type="submit">Save</button>
            <a href="{{ route('sales.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-700">Cancel</a>
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
        const submitBtn = document.getElementById('submit-btn');
        const client = document.querySelector('input[name="client"]');

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

        // Re-attach the event listener after the options are added
        itemSelect.addEventListener('change', function() {
            const selectedItem = itemSelect.options[itemSelect.selectedIndex];
            unitInput.value = selectedItem.getAttribute('data-unit');
        });

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
            toggleSubmitButton();
        });

        // Handle row deletion using event delegation
        itemTableBody.addEventListener('click', function(e) {
            // Ensure that the clicked element is a button (including the icon inside it)
            if (e.target.closest('.delete-row-btn')) {
                const row = e.target.closest('tr'); // Find the closest row (tr) element
                row.remove(); // Remove the row
                updateTotals();
                toggleSubmitButton();
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
    });
</script>
@endsection
