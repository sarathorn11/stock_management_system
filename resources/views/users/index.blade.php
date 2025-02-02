@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h2 class="text-2xl font-semibold mb-4">List User</h2>

    <div class="flex justify-between mb-3">
        <form action="{{ route('user.index') }}" method="GET">
            <input type="text" name="query" class="border border-gray-300 rounded px-4 py-2 w-2/4"
                placeholder="Search ...." value="{{ request('query') }}">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Search</button>
        </form>
        <div>
            <button class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600"
                onclick="fetchItemDetails()">Create</button>
            <div class="relative inline-block">
                <button onclick="clickAction()" class="flex items-center px-4 py-2 bg-gray-500 text-white rounded">
                    <i class="fas fa-cog"></i>
                    Action
                </button>
                <div id="action" onclick.outside="clickAction()"
                    class="absolute hidden mt-2 w-25 bg-white border rounded-lg shadow-md">
                    <button @click="" class="block w-full px-4 py-2 text-left hover:bg-gray-100">Print</button>
                    <button onclick="deleteSelectedRows()"
                        class="block w-full px-4 py-2 text-left text-red-600 hover:bg-gray-100">Delete</button>
                </div>
            </div>
        </div>
    </div>
    @if ($users->isEmpty())
    <p class="text-center text-danger">No results found 404</p>
    @else
    <div class="overflow-x-auto">
        <table class="w-full border rounded-lg shadow-sm text-left">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-3"><input type="checkbox" id="checkAll" onclick="toggleAllRows(this)"></th>
                    <th class="p-3">No.</th>
                    <th class="p-3">Avatar</th>
                    <th class="p-3">Name</th>
                    <th class="p-3">Gender</th>
                    <th class="p-3">Email</th>
                    <th class="p-3">Role</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y">
                @foreach($users as $index => $user)
                <tr onclick="fetchItemDetails({{ $user->id }})" data-id="{{$user->id}}" class="hover:bg-gray-50">
                    <td class="p-3"><input onclick="event.stopPropagation()" class="rowCheckbox" value="{{$user->id}}"
                            type="checkbox"></td>
                    <td class="p-3">{{1 + $index}}</td>
                    <td class="p-3"><img
                            src="{{$user->avatar ? asset('storage/avatars/'.basename($user->avatar)) : asset('static/assets/images/default-avatar.png')}}"
                            class="w-10 h-10 rounded-full"></td>
                    <td class="p-3">{{$user->name}}</td>
                    <td class="p-3 capitalize">{{$user->gender}}</td>
                    <td class="p-3">{{$user->email}}</td>
                    <td class="p-3 capitalize">{{$user->role}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <x-pagination :pagination="$users" :per-page="$perPage" :per-page-options="[$perPage, 10, 20, 30, 50]" />
    @endif
</div>


<div id="modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
    <div class="bg-white w-full max-w-md p-6 rounded-lg shadow-lg">
        <h2 class="text-lg font-bold mb-4">Add/Edit Item</h2>
        <form id="itemForm" class="space-y-4" action="{{ route('user.store') }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                <input id="name" name="name" type="text" class="border border-gray-300 w-full rounded px-4 py-2"
                    placeholder="User name" required>
            </div>
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input id="email" name="email" type="email" class="border border-gray-300 w-full rounded px-4 py-2"
                    placeholder="Email " required>
            </div>
            <select id="gender" name="gender" class="border border-gray-300 w-full rounded px-4 py-2" required>
                <option value="">Select Gender</option>
                <option value="male">Male</option>
                <option value="female">Female</option>
            </select>

            <div>
                <label for="password" class="block text-gray-700 font-bold mb-2">Password</label>
                <div class="relative">
                    <input type="password" id="password" name="password" class="w-full px-4 py-2 border rounded-md"
                        placeholder="Enter your password">
                    <span class="absolute inset-y-0 right-0 flex items-center pr-3 cursor-pointer"
                        onclick="togglePassword('password', 'eyeIcon1')">
                        <i id="eyeIcon1" class="fas fa-eye-slash"></i>
                    </span>
                </div>
            </div>

            <div>
                <label for="password_confirmation" class="block text-gray-700 font-bold mb-2">Confirm Password</label>
                <div class="relative">
                    <input type="password" id="password_confirmation" name="password_confirmation"
                        class="w-full px-4 py-2 border rounded-md" placeholder="Confirm your password">
                    <span class="absolute inset-y-0 right-0 flex items-center pr-3 cursor-pointer"
                        onclick="togglePassword('password_confirmation', 'eyeIcon2')">
                        <i id="eyeIcon2" class="fas fa-eye-slash"></i>
                    </span>
                </div>
            </div>

            <div>
                <label for="role" class="block text-sm font-medium text-gray-700">Role</label>
                <select id="role" name="role" class="border border-gray-300 w-full rounded px-4 py-2" required>
                    <option value="">Select Role</option>
                    <option value="admin">Admin</option>
                    <option value="user">User</option>
                </select>
            </div>
            <div class="mb-6">
                <label for="avatar" class="block text-gray-700 font-medium mb-2">Avatar(click here to change
                    image)</label>
                <input hidden type="file" id="avatar" name="avatar" class="w-full" accept="image/*"
                    onchange="previewImage(this)">

                <div for="avatar" id="image-preview" class="mt-2">
                    <img id="avatar-preview" src="{{ asset('static/assets/images/default-avatar.png') }}"
                        class="w-24 h-24 rounded-full object-cover" alt="Avatar">
                </div>
            </div>

            <div class="flex justify-end space-x-2 mt-4">
                <button type="button" class="px-4 py-2 bg-gray-300 rounded" onclick="toggleModal(false)">
                    Cancel
                </button>
                <button id="saveButton" type="submit"
                    class="px-4 py-2 bg-blue-500 text-white rounded opacity-50 cursor-not-allowed" disabled>
                    Save
                </button>
            </div>
        </form>
    </div>
</div>
<style>
</style>
<script>
    function previewImage(input) {
        const preview = document.getElementById("avatar-preview");

        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
            };
            reader.readAsDataURL(input.files[0]);
        } else {
            preview.src = "default-avatar.png"; // Fallback to default avatar
        }
    }

    function togglePassword(fieldId, iconId) {
        const passwordInput = document.getElementById(fieldId);
        const eyeIcon = document.getElementById(iconId);

        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            eyeIcon.classList.remove('fa-eye-slash');
            eyeIcon.classList.add('fa-eye');
        } else {
            passwordInput.type = 'password';
            eyeIcon.classList.remove('fa-eye');
            eyeIcon.classList.add('fa-eye-slash');
        }
    }


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
        fetch('/user/delete', {
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
                    window.location.assign('/user');
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
        console.log('Fetching item details:', id);
        toggleModal(true);
        if (id) {
            // Update action
            fetch(`/user/${id}`)
                .then(response => response.json())
                .then(data => {
                    console.log(data);
                    // Populate modal fields with data
                    document.getElementById('name').value = data.name;
                    document.getElementById('email').value = data.email;
                    document.getElementById('gender').value = data.gender;
                    document.getElementById('role').value = data.role;
                    document.getElementById('password').value = '';
                    document.getElementById('password_confirmation').value = '';
                    const preview = document.getElementById("avatar-preview");
                    preview.src = data.avatar ? `/storage/avatars/${data.avatar}` :
                        "{{ asset('static/assets/images/default-avatar.png') }}";

                    // Set form action to the update route
                    document.getElementById('itemForm').action = `/user/${id}`;
                    // Add a hidden input for the PUT method
                    const methodField = document.createElement('input');
                    methodField.type = 'hidden';
                    methodField.name = '_method';
                    methodField.value = 'PUT';
                    document.getElementById('itemForm').appendChild(methodField);

                })
                .catch(error => console.error('Error fetching item details:', error));
        } else {
            // Clear modal fields
            document.getElementById('name').value = '';
            document.getElementById('email').value = '';
            document.getElementById('gender').value = '';
            document.getElementById('role').value = '';
            document.getElementById('avatar').value = '';
            // Create action
            document.getElementById('itemForm').action = '/user';
            document.getElementById('itemForm').method = 'POST';
        }
    }

    function fetchSuppliers(id = null) {
        const supplierSelect = document.getElementById('supplier_id');

        // Clear existing options
        supplierSelect.innerHTML = '';

        // Fetch suppliers from the server
        fetch('/supplier', {
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
        const saveButton = document.getElementById('saveButton');

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
        const formElements = document.querySelectorAll("#itemForm input, #itemForm textarea, #itemForm select");

        formElements.forEach(element => {
            element.addEventListener("input", validateForm);
            element.addEventListener("change", validateForm);
        });

        // Run validation on page load (in case of pre-filled data)
        validateForm();
    });
</script>
@endsection