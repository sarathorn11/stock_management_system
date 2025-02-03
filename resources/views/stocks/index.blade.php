@extends('layouts.app')

@section('content')
<div id="content" class="w-full h-full">
  <h1 class="text-xl font-bold text-gray-800">Stock List</h1>
  <div class="flex items-center justify-between my-4">
    <input id="search" type="text" placeholder="Search by Item ID..." class="px-3 py-[5px] w-[350px] rounded border">
    <div class="flex items-center justify-between">
      <a href="{{ route('stocks.create') }}"
        class="inline-block bg-blue-500 text-white px-4 py-[6px] rounded hover:bg-blue-600">Create</a>
      <a class="inline-block bg-gray-300 text-black px-4 py-[6px] rounded hover:bg-gray-400 ml-2">
        <i class="fa fa-cog mr-2"></i>Option
      </a>
    </div>
  </div>
  @if(session('success'))
  <div id="successOrFailedMessage" class="bg-green-100 text-green-800 p-2 rounded mb-4">{{ session('success') }}</div>
  @endif
  <div class="w-full h-auto">
    <table class="table-auto w-full">
      <thead class="bg-[#001f3f] text-white">
        <tr>
          <th class="p-2">
            <input type="checkbox" id="select-all" class="select-all-checkbox w-[18px] h-[18px]">
          </th>
          <th class="p-2">No.</th>
          <th class="p-2">Item ID</th>
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
          <td class="p-2 text-[14px] text-center">
            <input type="checkbox" class="stock-checkbox w-[18px] h-[18px]" data-id="{{ $stock->id }}">
          </td>
          <td class="p-2 text-[14px] text-center">{{ $index + 1 }}</td>
          <td class="p-2 text-[14px] text-center">{{ $stock->item_id }}</td>
          <td class="p-2 text-[14px] text-center">{{ $stock->quantity }}</td>
          <td class="p-2 text-[14px] text-center">{{ $stock->unit }}</td>
          <td class="p-2 text-[14px] text-center">{{ $stock->price }}</td>
          <td class="p-2 text-[14px] text-center">{{ $stock->total }}</td>
          <td class="p-2 text-[14px] text-center">{{ $stock->type == 1 ? 'IN' : 'OUT' }}</td>
          <td class="p-2 text-[14px] text-center">
            {{ \Carbon\Carbon::parse($stock->date_created)->format('Y-m-d h:i A') }}</td>
          <td class="p-2 flex items-center justify-center">
            <a href="{{ route('stocks.show', $stock->id) }}" class="text-blue-500 text-[18px] mx-1">
              <i class="fa fa-eye mr-2"></i>
            </a>
            <a href="{{ route('stocks.edit', $stock->id) }}" class="text-yellow-500 text-[18px] mx-1">
              <i class="fa fa-pencil mr-2"></i>
            </a>
            <form action="{{ route('stocks.destroy', $stock->id) }}" method="POST"
              onsubmit="return confirm('Are you sure you want to delete this stock?')" class="m-0">
              @csrf
              @method('DELETE')
              <button type="submit" class="text-red-500 text-[18px] mx-1">
                <i class="fa fa-trash mr-2"></i>
              </button>
            </form>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  @if($stocks->count() > 0)
  <x-pagination :pagination="$stocks" :per-page="$perPage" :per-page-options="[$perPage, 10, 20, 30, 50]" />
  @endif
</div>
<script>
let selectedStockIds = JSON.parse(localStorage.getItem('selectedStockIds')) || [];

function updateCheckboxSelections() {
  let checkboxes = document.querySelectorAll('.stock-checkbox');
  let selectAllCheckbox = document.getElementById('select-all');

  // Uncheck "Select All" when no checkboxes exist
  if (checkboxes.length === 0) {
    selectAllCheckbox.checked = false;
    selectAllCheckbox.disabled = true; // Disable when no checkboxes exist
    return;
  } else {
    selectAllCheckbox.disabled = false;
  }

  checkboxes.forEach(checkbox => {
    checkbox.checked = selectedStockIds.includes(checkbox.getAttribute('data-id'));
  });

  selectAllCheckbox.checked = checkboxes.length > 0 &&
    document.querySelectorAll('.stock-checkbox:checked').length === checkboxes.length;
}

document.addEventListener('DOMContentLoaded', updateCheckboxSelections);

document.getElementById('select-all').addEventListener('change', function() {
  let checkboxes = document.querySelectorAll('.stock-checkbox');
  selectedStockIds = [];

  checkboxes.forEach(checkbox => {
    checkbox.checked = this.checked;
    if (this.checked) {
      selectedStockIds.push(checkbox.getAttribute('data-id'));
    }
  });

  localStorage.setItem('selectedStockIds', JSON.stringify(selectedStockIds));
});

document.addEventListener('change', function(event) {
  if (event.target.classList.contains('stock-checkbox')) {
    const stockId = event.target.getAttribute('data-id');
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
setTimeout(function() {
  var successMessage = document.getElementById('successOrFailedMessage');
  if (successMessage) {
    successMessage.style.display = 'none';
  }
}, 2000);
</script>

@endsection