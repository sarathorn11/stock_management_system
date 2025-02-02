@extends('layouts.app')

@section('content')
<div id="content" class="w-full h-full">
  <h1 class="text-xl font-bold text-gray-800">List of Back Orders</h1>
  <div class="flex items-center justify-between my-4">
    <input id="searching" type="text" placeholder="Search by BO Code..." class="px-3 py-2 w-[350px] rounded border">
    <div class="flex items-center justify-between">
      <a class="inline-block bg-gray-300 text-black px-4 py-2 rounded mb-4 hover:bg-gray-400 ml-2">
        <i class="fa fa-cog mr-2"></i>Option
      </a>
    </div>
  </div>
  @if(session('success'))
  <div id="success-message" class="bg-green-100 text-green-800 p-4 rounded mb-4">{{ session('success') }}</div>
  @endif
  <div class="w-full h-auto">
    <table class="table-auto w-full border-collapse border border-gray-400">
      <thead class="bg-gray-300 text-black">
        <tr>
          <th class="p-4 border-b-[1px] border-gray-400">
            <input type="checkbox" id="select-all" class="select-all-checkbox">
          </th>
          <th class="p-4 border-b-[1px] border-gray-400">No.</th>
          <th class="p-4 border-b-[1px] border-gray-400">Date Created</th>
          <th class="p-4 border-b-[1px] border-gray-400">BO Code</th>
          <th class="p-4 border-b-[1px] border-gray-400">Supplier</th>
          <th class="p-4 border-b-[1px] border-gray-400">Items</th>
          <th class="p-4 border-b-[1px] border-gray-400">Status</th>
          <th class="p-4 border-b-[1px] border-gray-400">Actions</th>
        </tr>
      </thead>
      <tbody id="backOrderResults">
        @foreach($backOrders as $index => $row)
          <tr class="bg-white hover:bg-gray-200">
            <td class="p-2 text-center border-b-[1px] border-gray-400">
              <input type="checkbox" class="backorder-checkbox" data-id="{{ $row->id }}">
            </td>
            <td class="p-2 text-center border-b-[1px] border-gray-400">{{ $row->id }}</td>
            <td class="p-2 text-center border-b-[1px] border-gray-400">{{ date('Y-m-d H:i', strtotime($row->created_at)) }}</td>
            <td class="p-2 text-center border-b-[1px] border-gray-400">{{ $row->bo_code }}</td>
            <td class="p-2 text-center border-b-[1px] border-gray-400">{{ $row->supplier }}</td>
            <td class="p-2 text-center border-b-[1px] border-gray-400">{{ $row->items->count() }}</td>
            <td class="p-2 text-center border-b-[1px] border-gray-400">
              @if($row->status == 0)
                <span class="bg-blue-500 text-white px-4 py-1 rounded-full inline-block text-center">Pending</span>
              @elseif($row->status == 1)
                <span class="bg-orange-500 text-white px-4 py-1 rounded-full inline-block text-center">Partially received</span>
              @elseif($row->status == 2)
                <span class="bg-green-500 text-white px-4 py-1 rounded-full inline-block text-center">Received</span>
              @else
                <span class="bg-red-500 text-white px-4 py-1 rounded-full inline-block text-center">N/A</span>
              @endif
            </td>
            <td class="border-b-[1px] border-gray-400 p-2 text-center">
              <a href="{{ route('back-order.show', $row->id) }}" class="text-blue-500 mx-1">
                <i class="fa fa-eye mr-2"></i>
              </a>
              @if($row->status == 0)
                <a href="{{ route('back-order.edit', $row->id) }}" class="text-yellow-500 mx-1">
                  <i class="fas fa-boxes mr-2"></i>
                </a>
              @endif
              <!-- <form action="{{ route('back-order.destroy', $row->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this back order?')" class="m-0">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-red-500 text-[24px] mx-1">
                  <i class="fa fa-trash mr-2"></i>
                </button>
              </form> -->
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  @if($backOrders->count() > 0)
  <x-pagination :pagination="$backOrders" :per-page="$perPage" :per-page-options="[$perPage, 10, 20, 30, 50]" />
  @endif
</div>

<script>
// Select/Deselect all checkboxes
document.getElementById('select-all').addEventListener('change', function() {
  const checkboxes = document.querySelectorAll('.backorder-checkbox');
  checkboxes.forEach(checkbox => {
    checkbox.checked = this.checked;
  });
});

// Handle individual checkbox selection
document.querySelectorAll('.backorder-checkbox').forEach(checkbox => {
  checkbox.addEventListener('change', function() {
    const selectAllCheckbox = document.getElementById('select-all');
    const allChecked = document.querySelectorAll('.backorder-checkbox:checked').length === document
      .querySelectorAll('.backorder-checkbox').length;
    selectAllCheckbox.checked = allChecked;
  });
});
console.log('🫡🫡🫡🫡🫡🫡🫡🫡🫡🫡🫡🫡🫡', document.getElementById('searching'))
document.getElementById('searching').addEventListener('keyup', function() {
  console.log('HI--------------')
  let query = this.value;
  const searchUrl = '{{ route("back-order.index") }}';

  // Make the AJAX request
  fetch(`${searchUrl}?query=${query}`, {
      method: 'GET',
      headers: {
        'Accept': 'application/json',
      },
    })
    .then(response => response.json())
    .then(data => {
      let backOrderResults = document.getElementById('backOrderResults');
      backOrderResults.innerHTML = ''; // Clear the current results

      data.backOrders.forEach((row, index) => {
        let tr = document.createElement('tr');
        tr.classList.add('bg-white', 'hover:bg-gray-200');

        tr.innerHTML = `
          <td class="p-4 text-center">
            <input type="checkbox" class="backorder-checkbox w-[20px] h-[20px]" data-id="${row.id}">
          </td>
          <td class="p-4 text-center">${index + 1}</td>
          <td class="p-4 text-center">${new Date(row.date_created).toLocaleString()}</td>
          <td class="p-4 text-center">${row.bo_code}</td>
          <td class="p-4 text-center">${row.supplier}</td>
          <td class="p-4 text-right">${row.items}</td>
          <td class="p-4 text-center">${row.status == 0 ? '<span class="bg-blue-500 text-white px-2 py-1 rounded-full inline-block text-center">Pending</span>' : row.status == 1 ? '<span class="bg-orange-500 text-white px-2 py-1 rounded-full inline-block text-center">Partially received</span>' : row.status == 2 ? '<span class="bg-green-500 text-white px-2 py-1 rounded-full inline-block text-center">Received</span>' : '<span class="bg-red-500 text-white px-2 py-1 rounded-full inline-block text-center">N/A</span>'}</td>
          <td class="p-4 flex items-center justify-center">
            <a href="/admin/back_order/view_bo?id=${row.id}" class="text-blue-500 text-[24px] mx-1">
              <i class="fa fa-eye mr-2"></i>
            </a>
            ${row.status == 0 ? `<a href="/admin/receiving/manage_receiving?bo_id=${row.id}" class="text-yellow-500 text-[24px] mx-1">
              <i class="fa fa-pencil mr-2"></i>
            </a>` : ''}
            <form action="/admin/back_order/delete_bo?id=${row.id}" method="POST" onsubmit="return confirm('Are you sure you want to delete this back order?')" class="m-0">
              <input type="hidden" name="_method" value="DELETE">
              <button type="submit" class="text-red-500 text-[24px] mx-1">
                <i class="fa fa-trash mr-2"></i>
              </button>
            </form>
          </td>
        `;
        backOrderResults.appendChild(tr);
      });
    });
});

// Hide success message after 5 seconds
setTimeout(() => {
  const successMessage = document.getElementById('success-message');
  if (successMessage) {
    successMessage.style.display = 'none';
  }
}, 5000);
</script>

@endsection
