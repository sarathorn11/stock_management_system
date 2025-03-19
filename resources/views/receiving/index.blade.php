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
            <th class="px-4 py-2">ID</th>
            <th class="px-4 py-2">From</th>
            <th class="px-4 py-2">Items</th>
            <th class="px-4 py-2">Date Created</th>
            <th class="px-4 py-2">Actions</th>
          </tr>
        </thead>
        <tbody>
          @foreach($receivings as $receiving)
          <tr class="bg-white hover:bg-gray-200 border-b">
            <td class="px-4 py-2 text-center">{{ $receiving->id }}</td>
            <td class="px-4 py-2 text-center">
              {{ $receiving->from_order == 1 ? $receiving->from->po_code : $receiving->from->bo_code }}
            </td>
            <td class="px-4 py-2 text-center">
              {{ count($receiving->from->items) }}
            </td>
            <td class="px-4 py-2 text-center">{{ $receiving->created_at }}</td>
            <td class="px-4 py-2 text-center">
              <div class="flex items-center justify-center">
                <a href="{{ route('receiving.show', $receiving->id) }}" class="text-blue-500 mx-1">
                  <i class="fa fa-eye mr-2"></i>
                </a>
                <a href="{{ route('receiving.edit', $receiving->id) }}" class="text-yellow-500 mx-1">
                  <i class="fa fa-pencil mr-2"></i>
                </a>
                <form action="{{ route('receiving.destroy', $receiving->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this back order?')" class="m-0">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="text-red-500 text-[24px] mx-1">
                    <i class="fa fa-trash mr-2"></i>
                  </button>
                </form>
              </div>
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
</script>
@endsection
