@extends('layouts.app')

@section('content')
<div class="w-full h-full">
  <h1 class="text-xl font-bold text-gray-800">Receiving List</h1>

  <div class="flex items-center justify-between my-4">
    <form action="{{ route('receiving.index') }}" method="GET">
      <input type="text" name="query" class="rounded px-4 py-2 w-2/4"
        placeholder="Search ...." value="{{ request('query') }}">
      <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Search</button>
    </form>
    <div class="flex items-center">
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
      <table class="table-auto w-full border-collapse">
        <thead class="bg-[#3c8dbc] text-white">
          <tr>
            <th class="px-4 py-2">
              <input type="checkbox" id="selectAll">
            </th>
            <th class="px-4 py-2">ID</th>
            <th class="px-4 py-2">From</th>
            <th class="px-4 py-2">Items</th>
            <th class="px-4 py-2">Date Created</th>
          </tr>
        </thead>
        <tbody>
          @foreach($receivings as $receiving)
          <tr class="bg-white hover:bg-gray-200 cursor-pointer border-b" onclick="window.location.href='{{ route('receiving.show', $receiving->id) }}'">
            <td class="px-4 py-2 text-center">
              <input type="checkbox" name="selected_ids[]" value="{{ $receiving->id }}" class="recordCheckbox" onclick="event.stopPropagation();">
            </td>
            <td class="px-4 py-2 text-center">{{ $receiving->id }}</td>
            <td class="px-4 py-2 text-center">
              {{ $receiving->from_order == 1 ? $receiving->from->po_code : $receiving->from->bo_code }}
            </td>
            <td class="px-4 py-2 text-center">
              {{ count($receiving->from->items) }}
            </td>
            <td class="px-4 py-2 text-center">{{ $receiving->created_at }}</td>
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
  document.getElementById('selectAll').addEventListener('change', function() {
    let checkboxes = document.querySelectorAll('.recordCheckbox');
    checkboxes.forEach(checkbox => {
      checkbox.checked = this.checked;
    });
  });
</script>
@endsection
