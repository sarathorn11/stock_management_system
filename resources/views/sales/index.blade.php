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
      <a href="{{ route('sales.create') }}" class="bg-blue-500 text-white px-4 py-[6px] rounded hover:bg-blue-600">
        Create
      </a>
      <a class="bg-gray-300 text-black px-4 py-[6px] rounded hover:bg-gray-400 ml-2">
        <i class="fa fa-cog mr-2"></i> Option
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
      <thead class="bg-[#001f3f] text-white">
        <tr>
          <th class="p-2">
            <input type="checkbox" id="select-all" class="w-[18px] h-[18px]" aria-label="Select all sales">
          </th>
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
        <tr class="bg-white hover:bg-gray-200">
          <td class="p-2 text-center">
            <input type="checkbox" class="sale-checkbox w-[18px] h-[18px]" data-id="{{ $sale->id }}">
          </td>
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
          <td class="p-2 flex items-center justify-center space-x-2">
            <a href="{{ route('sales.show', $sale->id) }}" class="text-blue-500 text-[18px]">
              <i class="fa fa-eye"></i>
            </a>
            <a href="{{ route('sales.edit', $sale->id) }}" class="text-yellow-500 text-[18px]">
              <i class="fa fa-pencil"></i>
            </a>
            <form action="{{ route('sales.destroy', $sale->id) }}" method="POST" class="inline"
              onsubmit="return confirm('Are you sure you want to delete this sale?')">
              @csrf
              @method('DELETE')
              <button type="submit" class="text-red-500 text-[18px]">
                <i class="fa fa-trash"></i>
              </button>
            </form>
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
  let selectedSaleIds = JSON.parse(localStorage.getItem('selectedSaleIds')) || [];
  const checkboxes = document.querySelectorAll('.sale-checkbox');
  const selectAllCheckbox = document.getElementById('select-all');

  // Function to update the selection state
  function updateCheckboxSelections() {
    checkboxes.forEach(checkbox => {
      checkbox.checked = selectedSaleIds.includes(checkbox.getAttribute('data-id'));
    });

    selectAllCheckbox.checked = checkboxes.length > 0 &&
      document.querySelectorAll('.sale-checkbox:checked').length === checkboxes.length;

    selectAllCheckbox.disabled = checkboxes.length === 0; // Disable if no sales exist
  }

  // Initialize checkbox state
  updateCheckboxSelections();

  // Select all toggle
  selectAllCheckbox.addEventListener('change', function() {
    selectedSaleIds = this.checked ? [...checkboxes].map(cb => cb.getAttribute('data-id')) : [];
    checkboxes.forEach(cb => cb.checked = this.checked);
    localStorage.setItem('selectedSaleIds', JSON.stringify(selectedSaleIds));
  });

  // Individual checkbox selection
  document.addEventListener('change', event => {
    if (event.target.classList.contains('sale-checkbox')) {
      const saleId = event.target.getAttribute('data-id');
      event.target.checked ? selectedSaleIds.push(saleId) : selectedSaleIds = selectedSaleIds.filter(id =>
        id !== saleId);
      localStorage.setItem('selectedSaleIds', JSON.stringify(selectedSaleIds));
      updateCheckboxSelections();
    }
  });

  // Auto-hide success message after 2 seconds
  setTimeout(() => {
    document.getElementById('successOrFailedMessage')?.remove();
  }, 2000);
});
</script>

@endsection