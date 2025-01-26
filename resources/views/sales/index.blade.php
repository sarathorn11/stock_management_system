@extends('layouts.app')

@section('content')
<div id="content" class="w-full h-full">
  <h1 class="text-2xl font-bold text-gray-800">Sale List</h1>
  <div class="flex items-center justify-between my-4">
    <input id="search" type="text" placeholder="Search by Sales Code or Client..."
      class="px-3 py-2 w-[350px] rounded border">
    <div class="flex items-center justify-between">
      <a href="{{ route('sales.create') }}"
        class="inline-block bg-blue-500 text-white px-4 py-2 rounded mb-4 hover:bg-blue-600">Create</a>
      <a class="inline-block bg-gray-300 text-black px-4 py-2 rounded mb-4 hover:bg-gray-400 ml-2">
        <i class="fa fa-cog mr-2"></i>Option
      </a>
    </div>
  </div>

  @if(session('success'))
  <div class="bg-green-100 text-green-800 p-4 rounded mb-4">{{ session('success') }}</div>
  @endif

  <div class="w-full h-auto">
    <table class="table-auto w-full">
      <thead class="bg-blue-500 text-white">
        <tr>
          <th class="p-4">
            <input type="checkbox" id="select-all" class="select-all-checkbox w-[20px] h-[20px]">
          </th>
          <th class="p-4">No.</th>
          <th class="p-4">Sales Code</th>
          <th class="p-4">Client</th>
          <th class="p-4">Amount</th>
          <th class="p-4">Stock</th>
          <th class="p-4">Remarks</th>
          <th class="p-4">Actions</th>
        </tr>
      </thead>
      <tbody id="salesResults">
        @foreach($sales as $index => $sale)
        <tr class="bg-white hover:bg-gray-200">
          <td class="p-4 text-center">
            <input type="checkbox" class="sale-checkbox w-[20px] h-[20px]" data-id="{{ $sale->id }}">
          </td>
          <td class="p-4 text-center">{{ $index + 1 }}</td>
          <td class="p-4 text-center">{{ $sale->sales_code }}</td>
          <td class="p-4 text-center">{{ $sale->client }}</td>
          <td class="p-4 text-center">{{ $sale->formattedAmount }}</td>
          <td class="p-4 text-center">{{ $sale->stock ? $sale->stock->item_id : 'N/A' }}</td>
          <td class="p-4 text-center">{{ $sale->remarks }}</td>
          <td class="p-4 flex items-center justify-center">
            <a href="{{ route('sales.show', $sale->id) }}" class="text-blue-500 text-[24px] mx-1">
              <i class="fa fa-eye mr-2"></i>
            </a>
            <a href="{{ route('sales.edit', $sale->id) }}" class="text-yellow-500 text-[24px] mx-1">
              <i class="fa fa-pencil mr-2"></i>
            </a>
            <form action="{{ route('sales.destroy', $sale->id) }}" method="POST"
              onsubmit="return confirm('Are you sure you want to delete this sale?')" class="m-0">
              @csrf
              @method('DELETE')
              <button type="submit" class="text-red-500 text-[24px] mx-1">
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
  <x-pagination :pagination="$sales" :per-page="$perPage" :per-page-options="[$perPage, 5, 10, 25, 50]" />
  @endif
</div>
<script>
// Select/Deselect all checkboxes
document.getElementById('select-all').addEventListener('change', function() {
  const checkboxes = document.querySelectorAll('.sale-checkbox');
  checkboxes.forEach(checkbox => {
    checkbox.checked = this.checked;
  });
});

// Handle individual checkbox selection
document.querySelectorAll('.sale-checkbox').forEach(checkbox => {
  checkbox.addEventListener('change', function() {
    const selectAllCheckbox = document.getElementById('select-all');
    const allChecked = document.querySelectorAll('.sale-checkbox:checked').length === document
      .querySelectorAll('.sale-checkbox').length;
    selectAllCheckbox.checked = allChecked;
  });
});

document.getElementById('search').addEventListener('keyup', function() {
  let query = this.value;
  const searchUrl = '{{ route("sales.search") }}';

  fetch(`${searchUrl}?query=${query}`, {
      method: 'GET',
      headers: {
        'Accept': 'application/json',
      },
    })
    .then(response => response.json())
    .then(data => {
      let salesResults = document.getElementById('salesResults');
      salesResults.innerHTML = '';

      data.sales.data.forEach((sale, index) => {
        let row = document.createElement('tr');
        row.classList.add('bg-white', 'hover:bg-gray-200');

        row.innerHTML = `
          <td class="p-4 text-center">
            <input type="checkbox" class="sale-checkbox w-[20px] h-[20px]" data-id="{{ $sale->id }}">
          </td>
          <td class="p-4 text-center">${index + 1}</td>
          <td class="p-4 text-center">${sale.sales_code}</td>
          <td class="p-4 text-center">${sale.client}</td>
          <td class="p-4 text-center">${sale.formattedAmount}</td>
          <td class="p-4 text-center">${sale.stock ? sale.stock.item_id : 'N/A'}</td>
          <td class="p-4 text-center">${sale.remarks}</td>
          <td class="p-4 flex items-center justify-center">
            <a href="/sales/${sale.id}" class="text-blue-500 text-[24px] mx-1">
              <i class="fa fa-eye mr-2"></i>
            </a>
            <a href="/sales/${sale.id}/edit" class="text-yellow-500 text-[24px] mx-1">
              <i class="fa fa-pencil mr-2"></i>
            </a>
            <form action="/sales/${sale.id}" method="POST" onsubmit="return confirm('Are you sure you want to delete this sale?')" class="m-0">
              <input type="hidden" name="_method" value="DELETE">
              <button type="submit" class="text-red-500 text-[24px] mx-1">
                <i class="fa fa-trash mr-2"></i>
              </button>
            </form>
          </td>
        `;
        salesResults.appendChild(row);
      });
    });
});
</script>
@endsection