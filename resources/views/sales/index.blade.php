@extends('layouts.app')

@section('content')
<div id="content" class="w-full h-full">
  <h1 class="text-xl font-bold text-gray-800">Sale List</h1>

  <div class="flex items-center justify-between my-4">
    <!-- Search Form -->
    <form action="{{ route('sales.index') }}" method="GET" class="flex items-center">
      <input type="text" name="query" class="px-3 py-[5px] w-[350px] rounded border" placeholder="Search ...."
        value="{{ request('query') }}">
      <button type="submit" class="ml-2 bg-blue-500 text-white px-4 py-[6px] rounded hover:bg-blue-600">
        Search
      </button>
    </form>

    <!-- Action Buttons -->
    <div class="flex items-center">
      <a href="{{ route('sales.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
        Create
      </a>
    </div>
  </div>

  <!-- Success Message -->
  @if(session('success'))
  <div id="successOrFailedMessage" class="bg-green-100 text-green-800 p-2 rounded mb-4">
    {{ session('success') }}
  </div>
  @endif

  <!-- Sales Table -->
  <div class="w-full h-auto">
    <table class="table-auto w-full border">
      <thead class="bg-[#3c8dbc] text-white">
        <tr>
          <th class="p-2">No.</th>
          <th class="p-2">Sales Code</th>
          <th class="p-2">Client</th>
          <th class="p-2">Amount</th>
          <th class="p-2">Stock</th>
          <th class="p-2">Remarks</th>
          <th class="p-2">Actions</th>
        </tr>
      </thead>
      <tbody id="salesResults">
        @forelse($sales as $index => $sale)
        <tr class="bg-white hover:bg-gray-200 border-b">
          <td class="p-2 text-center">{{ $index + 1 }}</td>
          <td class="p-2 text-center">{{ $sale->sales_code }}</td>
          <td class="p-2 text-center">{{ $sale->client }}</td>
          <td class="p-2 text-center">{{ $sale->formattedAmount }}</td>
          <td class="p-2 text-center">
            @foreach($sale->stocks as $stock)
            <span>{{ $stock->item->name }}</span><br>
            @endforeach
          </td>
          <td class="p-2 text-center max-w-[200px]">
            {{ \Illuminate\Support\Str::limit($sale->remarks, 20, '...') }}
          </td>
          <td class="px-4 py-2 text-center">
            <div class="flex items-center justify-center">
              <a href="{{ route('sales.show', $sale->id) }}" class="text-blue-500 mx-1">
                <i class="fa fa-eye mr-2"></i>
              </a>
              <a href="{{ route('sales.edit', $sale->id) }}" class="text-yellow-500 mx-1">
                <i class="fa fa-pencil mr-2"></i>
              </a>
              <form action="{{ route('sales.destroy', $sale->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this back order?')" class="m-0">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-red-500 text-[24px] mx-1">
                  <i class="fa fa-trash mr-2"></i>
                </button>
              </form>
            </div>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="8" class="text-center text-gray-500 py-4">No sales found.</td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <!-- Pagination -->
  @if($sales->count() > 0)
  <x-pagination :pagination="$sales" :per-page="$perPage" :per-page-options="[10, 20, 30, 50]" />
  @endif
</div>

<!-- JavaScript -->
<script>
  document.addEventListener('DOMContentLoaded', () => {
    const optionButton = document.getElementById('option-button');
    const optionMenu = document.getElementById('option-menu');

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

    // Add click event listeners to table rows
    const rows = document.querySelectorAll('tbody tr[data-id]');
    rows.forEach(row => {
      row.addEventListener('click', (event) => {
        // Prevent redirection if the user clicks on a checkbox or action button
        if (event.target.tagName === 'INPUT' || event.target.closest('a') || event.target.closest('button')) {
          return;
        }

        // Get the sale ID from the row's data-id attribute
        const saleId = row.getAttribute('data-id');

        // Redirect to the detail page
        window.location.href = `/sales/${saleId}`;
      });
    });
  });

  // Handle Bulk Delete action
  const deleteSelected = document.getElementById('delete-selected');
  if (deleteSelected) {
    deleteSelected.addEventListener('click', function(e) {
      e.preventDefault();

      // Get all selected sale IDs
      const selectedSaleIds = Array.from(document.querySelectorAll('.sale-checkbox:checked'))
        .map((checkbox) => checkbox.getAttribute('data-id'));

      if (selectedSaleIds.length > 0) {
        if (confirm('Are you sure you want to delete the selected sales?')) {
          // Send a DELETE request to the server
          fetch(`/sales/bulk-delete`, {
              method: 'DELETE',
              headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
              },
              body: JSON.stringify({
                ids: selectedSaleIds
              }),
            })
            .then((response) => {
              if (response.ok) {
                window.location.reload();
              } else {
                alert('Failed to delete the selected sales.');
              }
            })
            .catch((error) => {
              console.error('Error:', error);
              alert('An error occurred while deleting the sales.');
            });
        }
      } else {
        alert('Please select at least one sale to delete.');
      }
    });
  }
</script>

@endsection
