@extends('layouts.app')

@section('content')
<div class="w-full h-full">
    <h2 class="text-2xl font-semibold mb-4">List Item</h2>

    <div class="flex justify-between mb-3">
        <form action="{{ route('items.index') }}" method="GET" class="flex items-center">
            <input type="text" name="query" class="px-3 py-[5px] w-[350px] rounded border" placeholder="Name, Cost, Supplier ...."
                value="{{ request('query') }}">
            <button type="submit" class="ml-2 bg-blue-500 text-white px-4 py-[6px] rounded hover:bg-blue-600">
                Search
            </button>
        </form>

        <div>
            <button class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600"
                onclick="fetchItemDetails(null)">Create</button>
        </div>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full  rounded-lg">
            <thead class="bg-[#3c8dbc] text-white">
                <tr>
                    <th class="px-4 py-2">No.</th>
                    <th class="px-4 py-2">Name</th>
                    <th class="px-4 py-2">Cost</th>
                    <th class="px-4 py-2">Unit</th>
                    <th class="px-4 py-2">Supplier</th>
                    <th class="px-4 py-2">Date created</th>
                    <th class="px-4 py-2">Status</th>
                    <th class="px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($items as $index => $item)
                <tr class="bg-white hover:bg-gray-300 text-center border-b">
                    <td class="px-4 py-2 text-center">{{ $index + 1 }}</td>
                    <td class="px-4 py-2 text-center">{{ $item->name }}</td>
                    <td class="px-4 py-2 text-center">{{ $item->cost }}$</td>
                    <td class="px-4 py-2 text-center">{{ $item->unit }}</td>
                    <td class="px-4 py-2 text-center">{{ $item->supplier->name }}</td>
                    <td class="px-4 py-2 text-center">{{ $item->created_at->format('Y-m-d h:i a') }}</td>
                    <td class="px-4 py-2 text-center">
                        <span
                            class="px-3 py-1 text-white rounded-full {{ $item->status == '1' ? 'bg-green-500' : 'bg-red-500' }}">
                            {{ $item->status == '1' ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td class="p-2 flex items-center justify-center">
                        <button class="text-blue-500 text-[18px] mx-1" onclick="fetchItemDetails({{ $item->id }})">
                            <i class="fa fa-eye"></i>
                        </button>
                        <button class="text-yellow-500 text-[18px] mx-1" onclick="fetchItemDetails({{ $item->id }})">
                            <i class="fa fa-pencil"></i>
                        </button>
                        <form action="{{ route('items.destroy', $item->id) }}" method="POST"
                            onsubmit="return confirm('Are you sure you want to delete this return list?')" class="m-0">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 text-[18px] mx-1">
                                <i class="fa fa-trash mr-2"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
                @if($items->count() == 0)
                <tr class="bg-white hover:bg-gray-200 border-b">
                    <td colspan="8" class="text-center p-4">No results found.</td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
    <x-pagination :pagination="$items" :per-page="$perPage" :per-page-options="[$perPage, 10, 20, 30, 50]" />
</div>


<div id="modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
    <div class="bg-white w-full max-w-md p-6 rounded-lg shadow-lg">
        <h2 class="text-lg font-bold mb-4">Add/Edit Item</h2>
        <form id="itemForm" class="space-y-4" action="{{ route('items.store') }}" method="POST">
            @csrf
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                <input id="name" name="name" type="text" class="w-full rounded px-4 py-2" placeholder="Item name"
                    required>
            </div>
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                <textarea name="description" id="description" placeholder="Description"
                    class=" w-full rounded px-4 py-2" required></textarea>
            </div>

            <div>
                <label for="cost" class="block text-sm font-medium text-gray-700">Cost</label>
                <input name="cost" step="0.001" type="number" id="cost" min="0" placeholder="Cost"
                    class=" w-full rounded px-4 py-2" required>
            </div>
            <div>
                <label for="unit" class="block text-sm font-medium text-gray-700">Unit</label>
                <input name="unit" step="0.001" type="text" id="unit" min="0" placeholder="Unit"
                    class=" w-full rounded px-4 py-2" required>
            </div>

            <div>
                <label for="supplier_id" class="block text-sm font-medium text-gray-700">Supplier</label>
                <select id="supplier_id" name="supplier_id" class=" w-full rounded px-4 py-2" required>
                    <option value="">Select Supplier</option>
                    <option value="1">Supplier 001</option>
                    <option value="2">Supplier 002</option>
                </select>
            </div>

            <div>
                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                <select id="status" name="status" class="w-full rounded px-4 py-2" required>
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                </select>
            </div>
            @if($items->count() > 0)
            <div>
                <label id="created-at" class="block text-sm text-gray-700">
                    Created at: {{ $item->created_at }}
                </label>
            </div>
            @else
            <div>
                <label id="created-at" class="block text-sm text-gray-700">
                </label>
            </div>
            @endif
            <div class="flex justify-end space-x-2 mt-4">
                <button type="button" class="px-4 py-2 bg-gray-300 rounded" onclick="toggleModal(false)">
                    Cancel
                </button>
                <button id="saveItemForm" type="submit"
                    class="px-4 py-2 bg-blue-500 text-white rounded opacity-50 cursor-not-allowed" disabled>
                    Save
                </button>
            </div>
        </form>
    </div>
</div>
<script>
    function toggleAllRows(source) {
        const checkboxes = document.querySelectorAll('.rowCheckbox');
        checkboxes.forEach(checkbox => {
            checkbox.checked = source.checked;
        });
    }

    function deleteSelectedRows() {
        clickAction()
        const checkboxes = document.querySelectorAll('.rowCheckbox:checked');
        if (checkboxes.length === 0) {
            alert('Please select at least one item to delete.');
            return;
        }

        // Get selected item IDs
        const selectedIds = Array.from(checkboxes).map(checkbox => checkbox.value);
        // Send DELETE request to Laravel backend
        fetch('/items/delete', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    ids: selectedIds
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Remove deleted rows from the table
                    selectedIds.forEach(id => {
                        const row = document.querySelector(`tr[data-id="${id}"]`);
                        if (row) row.remove();
                    });

                    // Uncheck the "Check All" checkbox if all items are removed
                    document.getElementById('checkAll').checked = false;
                    window.location.assign('/items');
                } else {
                    alert('Failed to delete items.');
                }
            })
            .catch(error => console.error('Error deleting items:', error));
    }

    function clickAction() {
        const btnAction = document.getElementById('action');
        btnAction.classList.toggle('hidden');
    }

    function toggleModal(show) {
        const modal = document.getElementById('modal');
        const form = document.getElementById('itemForm');

        // Remove the _method input if it's present (for create action)
        const methodField = form.querySelector('input[name="_method"]');
        if (methodField) {
            methodField.remove();
        }

        // Reset form values when closing the modal
        if (!show) {
            form.reset();
        }

        modal.classList.toggle('hidden', !show);
    }

    function fetchItemDetails(id = null) {
        toggleModal(true);
        if (id) {
            // Update action
            fetch(`/items/${id}`)
                .then(response => response.json())
                .then(data => {
                    // Populate modal fields with data
                    document.getElementById('name').value = data.name;
                    document.getElementById('description').value = data.description;
                    document.getElementById('cost').value = data.cost;
                    document.getElementById('unit').value = data.unit;
                    document.getElementById('supplier_id').value = data.supplier_id;
                    document.getElementById('status').value = data.status;

                    // Set form action to the update route
                    document.getElementById('itemForm').action = `/items/${id}`;
                    document.getElementById('itemForm').method = 'POST';

                    // Add a hidden input for the PUT method
                    const methodField = document.createElement('input');
                    methodField.type = 'hidden';
                    methodField.name = '_method';
                    methodField.value = 'PUT';
                    document.getElementById('itemForm').appendChild(methodField);
                    fetchSuppliers(data.supplier_id);

                })
                .catch(error => console.error('Error fetching item details:', error));
        } else {
            // Clear modal fields
            document.getElementById('name').value = '';
            document.getElementById('description').value = '';
            document.getElementById('cost').value = '';
            document.getElementById('supplier_id').value = '';
            document.getElementById('status').value = '';
            document.getElementById('created-at').textContent = '';
            // Create action
            document.getElementById('itemForm').action = '/items';
            document.getElementById('itemForm').method = 'POST';
            fetchSuppliers();
        }
    }

    function fetchSuppliers(id = null) {
        const supplierSelect = document.getElementById('supplier_id');

        // Clear existing options
        supplierSelect.innerHTML = '';

        // Fetch suppliers from the server
        fetch('/suppliers', {
                headers: {
                    "X-Requested-With": "XMLHttpRequest"
                }
            })
            .then(response => response.json())
            .then(suppliers => {
                // Add a default option
                const defaultOption = document.createElement('option');
                defaultOption.value = '';
                defaultOption.text = 'Select Supplier';
                supplierSelect.appendChild(defaultOption);

                // Add supplier options to the dropdown
                suppliers.forEach(supplier => {
                    const option = document.createElement('option');
                    option.value = supplier.id;
                    option.text = supplier.name;
                    // Preselect the supplier if id matches
                    if (id !== null && supplier.id == id) {
                        option.selected = true;
                    }
                    supplierSelect.appendChild(option);
                });
            })
            .catch(error => console.error('Error fetching suppliers:', error));
    }

    document.addEventListener('click', (event) => {
        const action = document.getElementById('action');
        const actionButton = document.querySelector('.flex.items-center.px-4.py-2');

        if (action && !action.classList.contains('hidden') && !action.contains(event.target) && !actionButton
            .contains(event.target)) {
            action.classList.add('hidden');
        }
    });

    function validateForm() {
        const form = document.getElementById('itemForm');
        const saveButton = document.getElementById('saveItemForm');
        if (form.checkValidity()) {

            saveButton.disabled = false;
            saveButton.classList.remove("opacity-50", "cursor-not-allowed");
        } else {
            saveButton.disabled = true;
            saveButton.classList.add("opacity-50", "cursor-not-allowed");
        }
    }

    // Attach event listeners to input fields to trigger validation
    document.addEventListener("DOMContentLoaded", function() {
        document.addEventListener("input", function(event) {
            if (event.target.closest("#itemForm input, #itemForm textarea, #itemForm select")) {
                validateForm();
            }
        });

        document.addEventListener("change", function(event) {
            if (event.target.closest("#itemForm input, #itemForm textarea, #itemForm select")) {
                validateForm();
            }
        });

        validateForm();
    });
</script>
@endsection
