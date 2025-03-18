@extends('layouts.app')

@section('content')
<script src="https://cdn.tailwindcss.com"></script>
<div id="content" class="w-full h-full">
  <h1 class="text-xl font-bold text-gray-800">Supplier List</h1>
  <div class="flex items-center justify-between my-4">
    <input id="search" type="text" placeholder="Search by Item ID..." class="px-3 py-[5px] w-[350px] rounded border">
    <div class="flex items-center justify-between">
      <button class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600" onclick="openModal('create')">
        Create
      </button>
      <div class="inline-block bg-gray-300 text-black px-4 py-2 ml-2 relative" id="option-button">
        <i class="fa fa-cog mr-2"></i>Option
        <!-- Dropdown menu -->
        <div id="option-menu" class="absolute right-0 mt-2 w-48 bg-white rounded shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none z-10 hidden">
          <div class="py-1">
            <a href="#" id="edit-selected" class="text-gray-700 block px-4 py-2 text-sm hover:bg-gray-100">Edit</a>
            <a href="#" id="delete-selected" class="text-red-600 block px-4 py-2 text-sm hover:bg-gray-100">Delete</a>
          </div>
        </div>
      </div>
    </div>
  </div>
  @if(session('success'))
  <div class="bg-green-100 text-green-800 p-2 rounded mb-4">{{ session('success') }}</div>
  @endif
  <div class="w-full h-auto">
    <table class="table-auto w-full">
      <thead class="bg-[#3c8dbc] text-white">
        <tr>
          <th class="p-2">
            <input type="checkbox" id="select-all" class="select-all-checkbox w-[18px] h-[18px]">
          </th>
          <th class="p-2">No.</th>
          <th class="p-2">Supplier</th>
          <th class="p-2">Contact Person</th>
          <th class="p-2">Status</th>
        </tr>
      </thead>

      <tbody id="returnResults">
  @foreach($suppliers as $index => $supplier)
  <tr class="bg-white hover:bg-gray-200 cursor-pointer border-b">
    <td class="p-2 text-[14px] text-center">
      <input type="checkbox" class="return-checkbox w-[18px] h-[18px]" data-id="{{ $supplier->id }}">
    </td>
    <td class="p-2 text-[14px] text-center" onclick="openModal('view', {{ json_encode($supplier) }})">{{ $supplier->id }}</td>
    <td class="p-2 text-[14px] text-center" onclick="openModal('view', {{ json_encode($supplier) }})">{{ $supplier->name }}</td>
    <td class="p-2 text-[14px] text-center" onclick="openModal('view', {{ json_encode($supplier) }})">{{ $supplier->cperson }}</td>
    <td class="p-2 text-[14px] text-center" onclick="openModal('view', {{ json_encode($supplier) }})">
      <span class="text-white px-4 py-1 rounded-full inline-block text-center {{ $supplier->status ? 'bg-green-500' : 'bg-red-500' }}">
        {{ $supplier->status ? 'Active' : 'Inactive' }}
      </span>
    </td>
    
  </tr>
  @endforeach
</tbody>
    </table>
  </div>
  @if($suppliers->count() > 0)
  <x-pagination :pagination="$suppliers" :per-page="$perPage" :per-page-options="[$perPage, 10, 20, 30, 50]" />
  @endif

  <!-- Modal (Used for Create, Edit, and View) -->
  <div id="modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
    <div class="bg-white w-full max-w-md p-6 rounded-lg shadow-lg">
      <h2 id="modalTitle" class="text-lg font-bold mb-4"></h2>
      <form id="supplierForm" class="space-y-4" action="{{ isset($supplier) ? route('supplier.update', $supplier->id) : route('supplier.store') }}" method="POST">
        @csrf
        @if(isset($supplier))
          @method('PUT') <!-- Spoof PUT method for update -->
        @endif
        <input type="hidden" id="supplierId" name="id">
        <div>
          <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
          <input id="name" name="name" type="text" class="border border-gray-300 w-full rounded px-4 py-2"
            placeholder="Supplier name" required>
        </div>
        <div>
          <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
          <textarea name="address" id="address" placeholder="address"
            class="border border-gray-300 w-full rounded px-4 py-2" required></textarea>
        </div>
        <div>
          <label for="cperson" class="block text-sm font-medium text-gray-700">Contact Person</label>
          <input id="cperson" name="cperson" type="text" class="border border-gray-300 w-full rounded px-4 py-2"
            placeholder="Contact Person" required>
        </div>
        <div>
          <label for="contact" class="block text-sm font-medium text-gray-700">Contact #</label>
          <input id="contact" name="contact" type="text" class="border border-gray-300 w-full rounded px-4 py-2"
            placeholder="Contact" required>
        </div>
        <div>
          <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
          <select id="status" name="status" class="border border-gray-300 w-full rounded px-4 py-2" required>
            <option value="1">Active</option>
            <option value="0">Inactive</option>
          </select>
        </div>
        <div class="flex justify-end space-x-2 mt-4">
          <button type="button" class="px-4 py-2 bg-gray-300 rounded" onclick="toggleModal(false)">Close</button>
          <button type="button" id="editButton" class="px-4 py-2 bg-yellow-500 text-white rounded hidden">Edit</button>
          <button type="submit" id="saveButton" class="px-4 py-2 bg-blue-500 text-white rounded">Save</button>
        </div>
      </form>
    </div>
  </div>
</div>
<script>
  function openModal(mode, supplier = null) {
    const modal = document.getElementById('modal');
    const title = document.getElementById('modalTitle');
    const form = document.getElementById('supplierForm');
    const editButton = document.getElementById('editButton');
    const saveButton = document.getElementById('saveButton');

    form.reset();

    if (mode === 'create') {
        title.innerText = "Add Supplier";
        document.getElementById("supplierId").value = "";
        enableFields();
        editButton.classList.add("hidden");
        saveButton.classList.remove("hidden");
    }
    else if (mode === 'edit') {
        title.innerText = "Edit Supplier";
        populateForm(supplier);
        enableFields();
        editButton.classList.add("hidden");
        saveButton.classList.remove("hidden");
    }
    else if (mode === 'view') {
        title.innerText = "Supplier Details";
        populateForm(supplier);
        disableFields();
        editButton.classList.remove("hidden");
        saveButton.classList.add("hidden");

        // When clicking "Edit" inside View Mode
        editButton.onclick = function () {
            enableFields();
            title.innerText = "Edit Supplier"; // Change title to "Edit Supplier"
            editButton.classList.add("hidden");
            saveButton.classList.remove("hidden");
        };
    }

    modal.classList.remove('hidden');
  }

  function toggleModal(show) {
    document.getElementById('modal').classList.toggle('hidden', !show);
  }

  function populateForm(supplier) {
    document.getElementById("supplierId").value = supplier.id;
    document.getElementById("name").value = supplier.name;
    document.getElementById("address").value = supplier.address;
    document.getElementById("cperson").value = supplier.cperson;
    document.getElementById("contact").value = supplier.contact;
    document.getElementById("status").value = supplier.status;
  }

  function disableFields() {
    document.getElementById("name").disabled = true;
    document.getElementById("address").disabled = true;
    document.getElementById("cperson").disabled  = true;
    document.getElementById("contact").disabled  = true;
    document.getElementById("status").disabled = true;
  }

  function enableFields() {
    document.getElementById("name").disabled = false;
    document.getElementById("address").disabled = false;
    document.getElementById("cperson").disabled = false;
    document.getElementById("contact").disabled = false;
    document.getElementById("status").disabled = false;
  }

  document.getElementById("editButton").addEventListener("click", function() {
    enableFields();
    document.getElementById("editButton").classList.add("hidden");
    document.getElementById("saveButton").classList.remove("hidden");
  });

  // Dropdown functionality
  document.addEventListener('DOMContentLoaded', function() {
    const optionButton = document.getElementById('option-button');
    const optionMenu = document.getElementById('option-menu');
    const editSelected = document.getElementById('edit-selected');
    const deleteSelected = document.getElementById('delete-selected');

    let selectedSupplierId = null;

    // Toggle dropdown visibility
    if (optionButton && optionMenu) {
      optionButton.addEventListener('click', function(e) {
        e.stopPropagation(); // Prevent the click from bubbling up
        optionMenu.classList.toggle('hidden');
      });

      // Close dropdown when clicking outside
      document.addEventListener('click', function(e) {
        if (!optionButton.contains(e.target)) {
          optionMenu.classList.add('hidden');
        }
      });

      // Close dropdown when clicking on a dropdown item
      optionMenu.addEventListener('click', function(e) {
        optionMenu.classList.add('hidden');
      });
    }

    // Track the selected supplier ID when a checkbox is checked
    document.querySelectorAll('.return-checkbox').forEach(checkbox => {
      checkbox.addEventListener('change', function() {
        if (this.checked) {
          selectedSupplierId = this.dataset.id; // Set the selected supplier ID
          // Uncheck all other checkboxes
          document.querySelectorAll('.return-checkbox').forEach(otherCheckbox => {
            if (otherCheckbox !== this) {
              otherCheckbox.checked = false;
            }
          });
        } else {
          selectedSupplierId = null; // Clear the selected supplier ID
        }
      });
    });

    // Handle Edit action
    if (editSelected) {
      editSelected.addEventListener('click', function(e) {
        e.preventDefault();
        if (selectedSupplierId) {
          // Find the selected supplier from the table
          const selectedRow = document.querySelector(`.return-checkbox[data-id="${selectedSupplierId}"]`).closest('tr');
          const supplier = {
            id: selectedSupplierId,
            name: selectedRow.querySelector('td:nth-child(3)').innerText,
            cperson: selectedRow.querySelector('td:nth-child(4)').innerText,
            status: selectedRow.querySelector('td:nth-child(5) span').classList.contains('bg-green-500') ? 1 : 0,
          };
          openModal('edit', supplier); // Open the edit modal with the selected supplier data
        } else {
          alert('Please select a supplier to edit.');
        }
      });
    }

    // Handle Delete action
    if (deleteSelected) {
      deleteSelected.addEventListener('click', function(e) {
        e.preventDefault();
        if (selectedSupplierId) {
          if (confirm('Are you sure you want to delete this supplier?')) {
            // Send a DELETE request to the server
            fetch(`/supplier/${selectedSupplierId}`, {
              method: 'DELETE',
              headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
              },
            })
              .then(response => {
                window.location.reload();
              })
              .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while deleting the supplier.');
              });
          }
        } else {
          alert('Please select a supplier to delete.');
        }
      });
    }
  });
</script>
@endsection
