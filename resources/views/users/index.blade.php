@extends('layouts.app')

@section('content')
<div class="w-full h-full">
    <h2 class="text-2xl font-semibold mb-4">List User</h2>

    <div class="flex justify-between mb-3">
        <form action="{{ route('user.index') }}" method="GET" class="flex items-center my-4">
            <input type="text" name="query" class="px-3 py-[5px] w-[350px] rounded border" placeholder="Name, Gender,Email ...."
              value="{{ request('query') }}">
            <button type="submit" class="ml-2 bg-blue-500 text-white px-4 py-[6px] rounded hover:bg-blue-600">
              Search
            </button>
          </form> 
        <div>
            <button class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600"
                onclick="fetchUserDetails()">Create</button>
            <!-- <div class="relative inline-block">
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
            </div> -->
        </div>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full border rounded-lg shadow-sm text-left">
            <thead class="bg-[#3c8dbc] text-white">
                <tr>
                    <th class="px-4 py-2">No.</th>
                    <th class="px-4 py-2">Profile</th>
                    <th class="px-4 py-2">First Name</th>
                    <th class="px-4 py-2">Last Name</th>
                    <th class="px-4 py-2">Nickname</th>
                    <th class="px-4 py-2">Gender</th>
                    <th class="px-4 py-2">Email</th>
                    <th class="px-4 py-2">Role</th>
                    <th class="px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y">
                @foreach($users as $index => $user)
                <tr class="hover:bg-gray-50 border-b">
                    <td class="px-4 py-2">{{1 + $index}}</td>
                    <td class="px-4 py-2"><img
                            src="{{$user->profile_picture ? asset('storage/avatars/'.basename($user->profile_picture)) : asset('static/assets/images/default-avatar.png')}}"
                            class="w-10 h-10 rounded-full"></td>
                    <td class="px-4 py-2">{{$user->first_name}}</td>
                    <td class="px-4 py-2">{{$user->last_name}}</td>
                    <td class="px-4 py-2">{{$user->username}}</td>
                    <td class="px-4 py-2 capitalize">{{$user->gender}}</td>
                    <td class="px-4 py-2">{{$user->email}}</td>
                    <td class="px-4 py-2 capitalize">{{$user->role}}</td>
                    <td class="p-2 flex items-center justify-center">
                        <button class="text-blue-500 text-[18px] mx-1" onclick="fetchUserDetails({{ $user->id }})">
                            <i class="fa fa-eye"></i>
                        </button>
                        <button class="text-yellow-500 text-[18px] mx-1" onclick="fetchUserDetails({{ $user->id }})">
                            <i class="fa fa-pencil"></i>
                        </button>
                        <form action="{{ route('user.destroy', $user->id) }}" method="POST"
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
                @if($users->count() == 0)
                <tr class="bg-white hover:bg-gray-200 border-b">
                    <td colspan="9" class="text-center p-4">No results found.</td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
    <x-pagination :pagination="$users" :per-page="$perPage" :per-page-options="[$perPage, 10, 20, 30, 50]" />
</div>

<div id="modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
    <div class="bg-white w-full max-w-2xl p-6 rounded-lg shadow-lg">
        <h2 class="text-lg font-bold mb-4">Add/Edit Item</h2>
        <form id="userForm" class="space-y-4 grid grid-cols-1 md:grid-cols-2 gap-4" action="{{ route('user.store') }}"
            method="POST" enctype="multipart/form-data">
            <input id="user-id" type="text" name="id" hidden>
            @csrf
            <!-- Left Column -->
            <div>
                <label for="first-name" class="block text-sm font-medium text-gray-700">First Name</label>
                <input id="first-name" name="first_name" type="text" class="w-full rounded px-4 py-1"
                    placeholder="First name" required>
            </div>
            <div>
                <label for="last-name" class="block text-sm font-medium text-gray-700">Last Name</label>
                <input id="last-name" name="last_name" type="text" class="w-full rounded px-4 py-1"
                    placeholder="Last name" required>
            </div>
            <div>
                <label for="username" class="block text-sm font-medium text-gray-700">Nickname</label>
                <input id="username" name="username" type="text" class="w-full rounded px-4 py-1"
                    placeholder="User name" required>
            </div>
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input id="email" name="email" type="email" class="w-full rounded px-4 py-1" placeholder="Email"
                    required>
            </div>

            <div>
                <label for="gender" class="block text-sm font-medium text-gray-700">Gender</label>
                <select id="gender" name="gender" class="w-full rounded px-4 py-1" required>
                    <option value="">Select Gender</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                </select>
            </div>
            <div>
                <label for="role" class="block text-sm font-medium text-gray-700">Role</label>
                <select id="role" name="role" class="w-full rounded px-4 py-1" required>
                    <option value="">Select Role</option>
                    <option value="admin">Admin</option>
                    <option value="user">User</option>
                </select>
            </div>

            <!-- Right Column -->
            <div class="col-span-2">
                <label for="password" class="block text-gray-700 font-bold mb-2">Password</label>
                <div class="relative">
                    <input type="password" id="password" name="password" class="w-full px-4 py-1 border rounded-md"
                        placeholder="Enter your password">
                    <span class="absolute inset-y-0 right-0 flex items-center pr-3 cursor-pointer"
                        onclick="togglePassword('password', 'eyeIcon1')">
                        <i id="eyeIcon1" class="fas fa-eye-slash"></i>
                    </span>
                </div>
            </div>
            <div class="col-span-2">
                <label for="password_confirmation" class="block text-gray-700 font-bold mb-2">Confirm Password</label>
                <div class="relative">
                    <input type="password" id="password_confirmation" name="password_confirmation"
                        class="w-full px-4 py-1 border rounded-md" placeholder="Confirm your password">
                    <span class="absolute inset-y-0 right-0 flex items-center pr-3 cursor-pointer"
                        onclick="togglePassword('password_confirmation', 'eyeIcon2')">
                        <i id="eyeIcon2" class="fas fa-eye-slash"></i>
                    </span>
                </div>
            </div>

            <div class="col-span-2">
                <label for="profile-picture" class="cursor-pointer">
                    <i class="fas fa-upload text-2xl text-gray-600"></i>
                    <span class="text-sm text-gray-700">Upload Image</span>
                </label>
                <input hidden type="file" id="profile-picture" name="profile_picture" accept="image/*"
                    onchange="previewImage(this)">
                <div id="image-preview" class="flex justify-center">
                    <img id="avatar-preview" src="{{ asset('static/assets/images/default-avatar.png') }}"
                        class="w-24 h-24 rounded-full object-cover" alt="Avatar">
                </div>
            </div>

            <div class="col-span-2 flex justify-end space-x-2 mt-4">
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
        const form = document.getElementById('userForm');

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

    function fetchUserDetails(id = null) {
        toggleModal(true);
        if (id) {
            // Update action
            fetch(`/user/${id}`)
                .then(response => response.json())
                .then(data => {
                    console.log(data);
                    // Populate modal fields with data
                    document.getElementById('username').value = data.username;
                    document.getElementById('user-id').value = id;
                    document.getElementById('email').value = data.email;
                    document.getElementById('first-name').value = data.first_name;
                    document.getElementById('last-name').value = data.last_name;
                    document.getElementById('gender').value = data.gender;
                    document.getElementById('role').value = data.role;
                    document.getElementById('password').value = '';
                    document.getElementById('password_confirmation').value = '';
                    const preview = document.getElementById("avatar-preview");
                    // Define the base URL for assets from Laravel
                    const storageBaseUrl = "{{ asset('storage/avatars/') }}";
                    const defaultAvatar = "{{ asset('static/assets/images/default-avatar.png') }}";
                    // Set the image source dynamically
                    preview.src = data.profile_picture ? `${storageBaseUrl}/${data.profile_picture.split('/').pop()}` :
                        defaultAvatar;
                    // Set form action to the update route
                    document.getElementById('userForm').action = `/user/${id}`;
                    // Add a hidden input for the PUT method
                    const methodField = document.createElement('input');
                    methodField.type = 'hidden';
                    methodField.name = '_method';
                    methodField.value = 'PUT';
                    document.getElementById('userForm').appendChild(methodField);

                })
                .catch(error => console.error('Error fetching item details:', error));
        } else {
            // Clear modal fields
            document.getElementById('first-name').value = '';
            document.getElementById('last-name').value = '';
            document.getElementById('username').value = '';
            document.getElementById('email').value = '';
            document.getElementById('gender').value = '';
            document.getElementById('role').value = '';
            document.getElementById('profile-picture').value = '';
            // Create action
            document.getElementById('userForm').action = '/user';
            document.getElementById('userForm').method = 'POST';
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
        const form = document.getElementById('userForm');
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
        document.addEventListener("input", function(event) {
            if (event.target.closest("#userForm input, #userForm textarea, #userForm select")) {
                validateForm();
            }
        });

        document.addEventListener("change", function(event) {
            if (event.target.closest("#userForm input, #userForm textarea, #userForm select")) {
                validateForm();
            }
        });

        // Run validation on page load (for pre-filled data)
        validateForm();
    });
</script>
@endsection
