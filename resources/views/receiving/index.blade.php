@extends('layouts.app')

@section('content')
<div class="w-full h-full">
  <h1 class="text-xl font-bold text-gray-800">Receiving List</h1>

  <div class="flex items-center justify-between my-4">
    <input type="text" placeholder="Search..." class="px-3 py-2 w-[350px] rounded border-gray-300">
    <div class="flex items-center">
      <a href="{{ route('receiving.create') }}"
        class="inline-block bg-blue-500 text-white px-4 py-2 rounded mb-4 hover:bg-blue-600">Create</a>
      <a class="inline-block bg-gray-300 text-black px-4 py-2 rounded mb-4 hover:bg-gray-400 ml-2">
        <i class="fa fa-cog mr-2"></i> Option
      </a>
    </div>
  </div>

  @if(session('success'))
  <div class="bg-green-100 text-green-800 p-4 rounded mb-4">{{ session('success') }}</div>
  @endif

  <div class="w-full h-full">
    <form id="receivingForm" method="POST" action="#">
      @csrf
      <table class="table-auto w-full border-collapse border border-gray-300">
        <thead>
          <tr>
            <th class="px-4 py-4 border border-gray-300">
              <input type="checkbox" id="selectAll">
            </th>
            <th class="px-4 py-4 border border-gray-300">ID</th>
            <th class="px-4 py-4 border border-gray-300">Date Created</th>
            <th class="px-4 py-4 border border-gray-300">From</th>
            <th class="px-4 py-4 border border-gray-300">Items</th>
          </tr>
        </thead>
        <tbody>
          @foreach($receivings as $receiving)
          <tr class="bg-white hover:bg-gray-200 cursor-pointer" onclick="window.location.href='{{ route('receiving.show', $receiving->id) }}'">
            <td class="px-4 py-2 text-center border border-gray-300">
              <input type="checkbox" name="selected_ids[]" value="{{ $receiving->id }}" class="recordCheckbox" onclick="event.stopPropagation();">
            </td>
            <td class="px-4 py-2 text-center border border-gray-300">{{ $receiving->id }}</td>
            <td class="px-4 py-2 text-center border border-gray-300">{{ $receiving->created_at }}</td>
            <td class="px-4 py-2 text-center border border-gray-300">
              {{ $receiving->from_order == 1 ? 'PO' : 'BO' }}
            </td>
            <td class="px-4 py-2 text-center border border-gray-300">
              {{ $receiving->stock_ids }}
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>

      <!-- Custom Pagination Component for Purchase Orders -->
      @if($receivings->count() > 0)
          <x-pagination :pagination="$receivings" :per-page="$perPage" :per-page-options="[10, 20, 30, 50]" />
      @endif
    </form>
  </div>
</div>

<script>
  document.getElementById('selectAll').addEventListener('change', function () {
    let checkboxes = document.querySelectorAll('.recordCheckbox');
    checkboxes.forEach(checkbox => {
      checkbox.checked = this.checked;
    });
  });
</script>
@endsection
