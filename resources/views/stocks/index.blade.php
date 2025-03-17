@extends('layouts.app')

@section('content')
<div id="content" class="w-full h-full">
  <h1 class="text-xl font-bold text-gray-800">Stock List</h1>

  <!-- Search & Actions -->
  <div class="flex items-center justify-between my-4">
    <form action="{{ route('stocks.index') }}" method="GET" class="flex">
      <input type="text" name="query" class="px-3 py-[5px] w-[350px] rounded border" placeholder="Search ...."
        value="{{ request('query') }}">
      <button type="submit" class="bg-blue-500 text-white px-4 py-[6px] rounded hover:bg-blue-600 ml-2">Search</button>
    </form>

    <div class="flex">
      <a href="{{ route('stocks.create') }}"
        class="bg-blue-500 text-white px-4 py-[6px] rounded hover:bg-blue-600">Create</a>
      <div class="inline-block bg-gray-300 text-black px-4 py-2 ml-2 relative" id="option-button">
        <i class="fa fa-cog mr-2"></i>Option
        <!-- Dropdown menu -->
        <div id="option-menu" class="absolute right-0 mt-2 w-48 bg-white rounded shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none z-10 hidden">
          <div class="py-1">
            <a href="#" id="delete-selected" class="text-red-600 block px-4 py-2 text-sm hover:bg-gray-100">Delete</a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Success Message -->
  @if(session('success'))
  <div id="successOrFailedMessage" class="bg-green-100 text-green-800 p-2 rounded mb-4">
    {{ session('success') }}
  </div>
  @endif

  <!-- Stock Table -->
  <div class="w-full h-auto">
    @if($stocks->count() > 0)
    <table class="table-auto w-full">
      <thead class="bg-[#001f3f] text-white">
        <tr>
          <th class="p-2"><input type="checkbox" id="select-all" class="w-[18px] h-[18px]"></th>
          <th class="p-2">No.</th>
          <th class="p-2">Item</th>
          <th class="p-2">Total Quantity</th>
          <th class="p-2">Unit</th>
        </tr>
      </thead>
      <tbody id="stockResults">
        @foreach($stocks as $index => $stock)
        <tr class="bg-white hover:bg-gray-200 cursor-pointer" data-href="{{ route('stocks.show', $stock->item_id) }}">
          <td class="p-2 text-center">
            <input type="checkbox" class="stock-checkbox w-[18px] h-[18px]" data-id="{{ $stock->item_id }}">
          </td>
          <td class="p-2 text-center">{{ $index + 1 }}</td>
          <td class="p-2 text-center">{{ optional($stock->item)->name ?? 'N/A' }}</td>
          <td class="p-2 text-center">{{ number_format($stock->total_quantity) }}</td>
          <td class="p-2 text-center">{{ optional($stock->item)->unit ?? 'N/A' }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
    @else
    <p class="text-gray-600 text-center py-4">No stocks found.</p>
    @endif
  </div>

  <!-- Pagination -->
  @if($stocks->count() > 0)
  <x-pagination :pagination="$stocks" :per-page="$perPage" :per-page-options="[$perPage, 10, 20, 30, 50]" />
  @endif
</div>

<!-- JavaScript for Checkbox Selection, Delete Action, and Row Click -->
<script>
document.addEventListener('DOMContentLoaded', () => {
  const optionButton = document.getElementById('option-button');
  const optionMenu = document.getElementById('option-menu');
  const selectAllCheckbox = document.getElementById('select-all');
  const stockCheckboxes = document.querySelectorAll('.stock-checkbox');
  const deleteSelectedButton = document.getElementById('delete-selected');
  let selectedStockIds = JSON.parse(localStorage.getItem('selectedStockIds')) || [];

  // Toggle dropdown menu visibility
  optionButton.addEventListener('click', (event) => {
    event.stopPropagation(); // Prevent the click from bubbling up
    optionMenu.classList.toggle('hidden');
  });

  // Close the dropdown when clicking outside
  document.addEventListener('click', (event) => {
    if (!optionButton.contains(event.target) && !optionMenu.contains(event.target)) {
      optionMenu.classList.add('hidden');
    }
  });

  // Handle "Select All" checkbox
  selectAllCheckbox.addEventListener('change', function() {
    selectedStockIds = this.checked ? Array.from(stockCheckboxes).map(cb => cb.dataset.id) : [];
    stockCheckboxes.forEach(cb => cb.checked = this.checked);
    localStorage.setItem('selectedStockIds', JSON.stringify(selectedStockIds));
  });

  // Handle individual checkbox changes
  document.addEventListener('change', function(event) {
    if (event.target.classList.contains('stock-checkbox')) {
      const stockId = event.target.dataset.id;
      if (event.target.checked) {
        if (!selectedStockIds.includes(stockId)) {
          selectedStockIds.push(stockId);
        }
      } else {
        selectedStockIds = selectedStockIds.filter(id => id !== stockId);
      }
      localStorage.setItem('selectedStockIds', JSON.stringify(selectedStockIds));
      updateCheckboxSelections();
    }
  });

  // Handle "Delete Selected" button click
  deleteSelectedButton.addEventListener('click', async (event) => {
    event.preventDefault();

    if (selectedStockIds.length === 0) {
      alert('Please select at least one stock to delete.');
      return;
    }

    if (confirm('Are you sure you want to delete the selected stocks?')) {
      try {
        // Disable the delete button to prevent multiple clicks
        deleteSelectedButton.disabled = true;
        deleteSelectedButton.textContent = 'Deleting...';

        const response = await fetch('{{ route("stocks.delete-multiple") }}', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
          },
          body: JSON.stringify({ ids: selectedStockIds })
        });

        if (response.ok) {
          // Clear selected stock IDs after successful deletion
          localStorage.removeItem('selectedStockIds');
          window.location.reload(); // Reload the page after successful deletion
        } else {
          const errorData = await response.json();
          alert(errorData.error || 'Failed to delete selected stocks.');
        }
      } catch (error) {
        console.error('Error:', error);
        alert('An error occurred while deleting the stocks.');
      } finally {
        // Re-enable the delete button
        deleteSelectedButton.disabled = false;
        deleteSelectedButton.textContent = 'Delete';
      }
    }
  });

  // Handle row click to show details
  document.querySelectorAll('tbody tr[data-href]').forEach(row => {
    row.addEventListener('click', (event) => {
      // Ignore clicks on checkboxes
      if (event.target.tagName === 'INPUT' && event.target.classList.contains('stock-checkbox')) {
        return;
      }
      window.location.href = row.getAttribute('data-href');
    });
  });

  // Update checkbox selections based on localStorage
  function updateCheckboxSelections() {
    stockCheckboxes.forEach(cb => {
      cb.checked = selectedStockIds.includes(cb.dataset.id);
    });
    selectAllCheckbox.checked = selectedStockIds.length === stockCheckboxes.length;
  }

  // Hide success message after 2 seconds
  setTimeout(() => {
    const successMessage = document.getElementById('successOrFailedMessage');
    if (successMessage) successMessage.style.display = 'none';
  }, 2000);

  // Initialize checkbox selections
  updateCheckboxSelections();
});
</script>

@endsection