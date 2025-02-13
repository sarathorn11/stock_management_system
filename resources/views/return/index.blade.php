@extends('layouts.app')

@section('content')
<script src="https://cdn.tailwindcss.com"></script>
<div id="content" class="w-full h-full">
  <h1 class="text-xl font-bold text-gray-800">Return List</h1>
  <div class="flex items-center justify-between my-4">
    <input id="search" type="text" placeholder="Search by Item ID..." class="px-3 py-[5px] w-[350px] rounded border">
    <div class="flex items-center justify-between">
      <a href="{{ route('return.create') }}"
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
          <th class="p-2">Return Code</th>
          <th class="p-2">Supplier</th>
          {{-- <th class="p-2">Stock</th> --}}
          {{-- <th class="p-2">Amount</th> --}}
          <th class="p-2">Items</th>
          <th class="p-2">Actions</th>
        </tr>
      </thead>
      <tbody id="returnResults">
        @foreach($returns as $index => $return)
        <tr class="bg-white hover:bg-gray-200">
          <td class="p-2 text-[14px] text-center">
            <input type="checkbox" class="return-checkbox w-[18px] h-[18px]" data-id="{{ $return->id }}">
          </td>
          <td class="p-2 text-[14px] text-center">{{ $return->return_code }}</td>
          <td class="p-2 text-[14px] text-center">{{ $return->supplier_id }}</td>
          {{-- <td class="p-2 text-[14px] text-center">{{ $return->stock_id }}</td> --}}
          {{-- <td class="p-2 text-[14px] text-center">{{ $return->amount }}</td> --}}
          <td class="p-2 text-[14px] text-center">{{ $return->Items }}</td>
          <td class="p-2 text-[14px] text-center">
            {{-- {{ \Carbon\Carbon::parse($return->date_created)->format('Y-m-d h:i A') }}</td> --}}
          <td class="p-2 flex items-center justify-center">
            <a href="{{ route('return.show', $return->id) }}" class="text-blue-500 text-[18px] mx-1">
              <i class="fa fa-eye mr-2"></i>
            </a>
            <a href="{{ route('return.edit', $return->id) }}" class="text-yellow-500 text-[18px] mx-1">
              <i class="fa fa-pencil mr-2"></i>
            </a>
            <form action=" " method="POST"
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
      </tbody>
    </table>
  </div>
  @if($returns->count() > 0)
  <x-pagination :pagination="$returns" :per-page="$perPage" :per-page-options="[$perPage, 10, 20, 30, 50]" />
  @endif
</div>
<script>
  let selectedReturnIds = JSON.parse(localStorage.getItem('selectedReturnIds')) || [];

function updateCheckboxSelections() {
  document.querySelectorAll('.return-checkbox').forEach(checkbox => {
    checkbox.checked = selectedReturnIds.includes(checkbox.getAttribute('data-id'));
  });
  document.getElementById('select-all').checked = document.querySelectorAll('.return-checkbox:checked').length ===
    document.querySelectorAll('.return-checkbox').length;
}

document.addEventListener('DOMContentLoaded', updateCheckboxSelections);

document.getElementById('select-all').addEventListener('change', function() {
  selectedReturnIds = [];
  document.querySelectorAll('.return-checkbox').forEach(checkbox => {
    checkbox.checked = this.checked;
    if (this.checked) {
      selectedReturnIds.push(checkbox.getAttribute('data-id'));
    }
  });
  localStorage.setItem('selectedReturnIds', JSON.stringify(selectedReturnIds));
});

document.addEventListener('change', function(event) {
  if (event.target.classList.contains('return-checkbox')) {
    const returnId = event.target.getAttribute('data-id');
    if (event.target.checked) {
      if (!selectedReturnIds.includes(returnId)) {
        selectedReturnIds.push(ReturnId);
      }
    } else {
      selectedReturnIds = selectedReturnIds.filter(id => id !== returnId);
    }
    localStorage.setItem('selectedReturnIds', JSON.stringify(selectedReturnIds));
    updateCheckboxSelections();
  }
});
</script>
@endsection