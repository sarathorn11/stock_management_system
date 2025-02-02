@extends('layouts.app')

@section('content')
<div id="content" class="w-full h-full">
  <h1 class="text-xl font-bold text-gray-800">Sale List</h1>
  <div class="flex items-center justify-between my-4">
    <input id="search" type="text" placeholder="Search by Sales Code or Client..."
      class="px-3 py-[5px] w-[350px] rounded border">
    <div class="flex items-center justify-between">
      <a href="{{ route('sales.create') }}"
        class="inline-block bg-blue-500 text-white px-4 py-[6px] rounded hover:bg-blue-600">Create</a>
      <a class="inline-block bg-gray-300 text-black px-4 py-[6px] rounded hover:bg-gray-400 ml-2">
        <i class="fa fa-cog mr-2"></i>Option
      </a>
    </div>
  </div>
  @if(session('success'))
  <div class="bg-green-100 text-green-800 p-2 rounded mb-4">{{ session('success') }}</div>
  @endif
  <div class="w-full h-auto">
    <table class="table-auto w-full">
      <thead class="bg-[#001f3f] text-white">
        <tr>
          <th class="p-2">
            <input type="checkbox" id="select-all" class="select-all-checkbox w-[18px] h-[18px]">
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
        @foreach($sales as $index => $sale)
        <tr class="bg-white hover:bg-gray-200">
          <td class="p-2 text-[14px] text-center">
            <input type="checkbox" class="sale-checkbox w-[18px] h-[18px]" data-id="{{ $sale->id }}">
          </td>
          <td class="p-2 text-[14px] text-center">{{ $index + 1 }}</td>
          <td class="p-2 text-[14px] text-center">{{ $sale->sales_code }}</td>
          <td class="p-2 text-[14px] text-center">{{ $sale->client }}</td>
          <td class="p-2 text-[14px] text-center">{{ $sale->formattedAmount }}</td>
          <td class="p-2 text-[14px] text-center">{{ $sale->stock ? $sale->stock->item_id : 'N/A' }}</td>
          <td class="p-2 text-[14px] text-center max-w-[100px]">{{ $sale->remarks }}</td>
          <td class="p-2 flex items-center justify-center">
            <a href="{{ route('sales.show', $sale->id) }}" class="text-blue-500 text-[18px] mx-1">
              <i class="fa fa-eye mr-2"></i>
            </a>
            <a href="{{ route('sales.edit', $sale->id) }}" class="text-yellow-500 text-[18px] mx-1">
              <i class="fa fa-pencil mr-2"></i>
            </a>
            <form action="{{ route('sales.destroy', $sale->id) }}" method="POST"
              onsubmit="return confirm('Are you sure you want to delete this sale?')" class="m-0">
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
  @if($sales->count() > 0)
  <x-pagination :pagination="$sales" :per-page="$perPage" :per-page-options="[$perPage, 10, 20, 30, 50]" />
  @endif
</div>
<script>
let selectedSaleIds = JSON.parse(localStorage.getItem('selectedSaleIds')) || [];

function updateCheckboxSelections() {
  let checkboxes = document.querySelectorAll('.sale-checkbox');
  let selectAllCheckbox = document.getElementById('select-all');

  // Disable "Select All" if no checkboxes exist
  if (checkboxes.length === 0) {
    selectAllCheckbox.checked = false;
    selectAllCheckbox.disabled = true; // Disable checkbox when no sales exist
    return;
  } else {
    selectAllCheckbox.disabled = false;
  }

  checkboxes.forEach(checkbox => {
    checkbox.checked = selectedSaleIds.includes(checkbox.getAttribute('data-id'));
  });

  selectAllCheckbox.checked = checkboxes.length > 0 &&
    document.querySelectorAll('.sale-checkbox:checked').length === checkboxes.length;
}

document.addEventListener('DOMContentLoaded', updateCheckboxSelections);

document.getElementById('select-all').addEventListener('change', function() {
  let checkboxes = document.querySelectorAll('.sale-checkbox');
  selectedSaleIds = [];

  checkboxes.forEach(checkbox => {
    checkbox.checked = this.checked;
    if (this.checked) {
      selectedSaleIds.push(checkbox.getAttribute('data-id'));
    }
  });

  localStorage.setItem('selectedSaleIds', JSON.stringify(selectedSaleIds));
});

document.addEventListener('change', function(event) {
  if (event.target.classList.contains('sale-checkbox')) {
    const saleId = event.target.getAttribute('data-id');
    if (event.target.checked) {
      if (!selectedSaleIds.includes(saleId)) {
        selectedSaleIds.push(saleId);
      }
    } else {
      selectedSaleIds = selectedSaleIds.filter(id => id !== saleId);
    }
    localStorage.setItem('selectedSaleIds', JSON.stringify(selectedSaleIds));
    updateCheckboxSelections();
  }
});
</script>

@endsection