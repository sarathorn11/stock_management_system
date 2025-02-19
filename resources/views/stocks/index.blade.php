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
      <a class="bg-gray-300 text-black px-4 py-[6px] rounded hover:bg-gray-400 ml-2">
        <i class="fa fa-cog mr-2"></i>Option
      </a>
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
          <th class="p-2">Quantity</th>
          <th class="p-2">Unit</th>
          <th class="p-2">Price</th>
          <th class="p-2">Total</th>
          <th class="p-2">Type</th>
          <th class="p-2">Date Created</th>
          <th class="p-2">Actions</th>
        </tr>
      </thead>
      <tbody id="stockResults">
        @foreach($stocks as $index => $stock)
        <tr class="bg-white hover:bg-gray-200">
          <td class="p-2 text-center">
            <input type="checkbox" class="stock-checkbox w-[18px] h-[18px]" data-id="{{ $stock->id }}">
          </td>
          <td class="p-2 text-center">{{ $index + 1 }}</td>
          <td class="p-2 text-center">{{ optional($stock->item)->name ?? 'N/A' }}</td>
          <td class="p-2 text-center">{{ number_format($stock->quantity) }}</td>
          <td class="p-2 text-center">{{ $stock->unit }}</td>
          <td class="p-2 text-center">${{ number_format($stock->price, 2) }}</td>
          <td class="p-2 text-center">${{ number_format($stock->total, 2) }}</td>
          <td class="p-2 text-center">{{ $stock->type == 1 ? 'IN' : 'OUT' }}</td>
          <td class="p-2 text-center">
            {{ \Carbon\Carbon::parse($stock->date_created)->format('Y-m-d h:i A') }}
          </td>
          <td class="p-2 flex items-center justify-center">
            <a href="{{ route('stocks.show', $stock->id) }}" class="text-blue-500 text-[18px] mx-1">
              <i class="fa fa-eye"></i>
            </a>
            <a href="{{ route('stocks.edit', $stock->id) }}" class="text-yellow-500 text-[18px] mx-1">
              <i class="fa fa-pencil"></i>
            </a>
            <form action="{{ route('stocks.destroy', $stock->id) }}" method="POST"
              onsubmit="return confirm('Are you sure you want to delete this stock?')" class="inline">
              @csrf
              @method('DELETE')
              <button type="submit" class="text-red-500 text-[18px] mx-1">
                <i class="fa fa-trash"></i>
              </button>
            </form>
          </td>
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

<!-- JavaScript for Checkbox Selection -->
<script>
document.addEventListener('DOMContentLoaded', () => {
  let selectedStockIds = JSON.parse(localStorage.getItem('selectedStockIds')) || [];
  const selectAllCheckbox = document.getElementById('select-all');
  const stockCheckboxes = document.querySelectorAll('.stock-checkbox');

  function updateCheckboxSelections() {
    stockCheckboxes.forEach(checkbox => {
      checkbox.checked = selectedStockIds.includes(checkbox.dataset.id);
    });

    selectAllCheckbox.checked = stockCheckboxes.length > 0 &&
      document.querySelectorAll('.stock-checkbox:checked').length === stockCheckboxes.length;
  }

  selectAllCheckbox.addEventListener('change', function() {
    selectedStockIds = this.checked ? Array.from(stockCheckboxes).map(cb => cb.dataset.id) : [];
    stockCheckboxes.forEach(cb => cb.checked = this.checked);
    localStorage.setItem('selectedStockIds', JSON.stringify(selectedStockIds));
  });

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

  setTimeout(() => {
    const successMessage = document.getElementById('successOrFailedMessage');
    if (successMessage) successMessage.style.display = 'none';
  }, 2000);

  updateCheckboxSelections();
});
</script>

@endsection