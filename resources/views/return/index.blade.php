@extends('layouts.app')

@section('content')
<script src="https://cdn.tailwindcss.com"></script>
<div id="content" class="w-full h-full">
  <h1 class="text-xl font-bold text-gray-800">Return List</h1>
  <div class="flex items-center justify-between my-4">
    <form method="GET" class="flex items-center my-4">
      <input type="text" name="query" class="px-3 py-[5px] w-[350px] rounded border"
          placeholder=" Return Code, Stock ID, Supplier Name, Amount, Remarks..."
          value="{{ request('query') }}">
      <button type="submit" class="ml-2 bg-blue-500 text-white px-4 py-[6px] rounded hover:bg-blue-600">
          Search
      </button>
  </form>
  
    <div class="flex items-center justify-between">
      <a href="{{ route('return.create') }}"
        class="inline-block bg-blue-500 text-white px-4 py-[6px] rounded hover:bg-blue-600">Create</a>
    </div>
  </div>
  @if(session('success'))
  <div id="successOrFailedMessage" class="bg-green-100 text-green-800 p-2 rounded mb-4">{{ session('success') }}</div>
  @endif
  <div class="w-full h-auto">
    <table class="table-auto w-full">
      <thead class="bg-[#3c8dbc] text-white">
        <tr>
          <th class="p-2">No.</th>
          <th class="p-2">Return Code</th>
          <th class="p-2">Supplier</th>
          <th class="p-2">Items</th>
          <th class="p-2">Created Date</th>
          <th class="p-2">Actions</th>
        </tr>
      </thead>
      <tbody id="returnResults">
        @foreach($returns as $index => $return)
        <tr class="bg-white hover:bg-gray-200 border-b">
          <td class="p-2 text-[14px] text-center">{{ $return->id }}</td>
          <td class="p-2 text-[14px] text-center">{{ $return->return_code }}</td>
          <td class="p-2 text-[14px] text-center">{{ $return->supplier->name }}</td>
          <td class="p-2 text-[14px] text-center">{{ count(json_decode($return->stock_ids)) }}</td>
          <td class="p-2 text-[14px] text-center">{{ $return->created_at }}</td>
          <td class="p-2 flex items-center justify-center">
            <a href="{{ route('return.show', $return->id) }}" class="text-blue-500 text-[18px] mx-1">
              <i class="fa fa-eye mr-2"></i>
            </a>
            <a href="{{ route('return.edit', $return->id) }}" class="text-yellow-500 text-[18px] mx-1">
              <i class="fa fa-pencil mr-2"></i>
            </a>
            <form action="{{ route('return.destroy', $return->id) }}" method="POST"
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
        @if($returns->count() == 0)
        <tr class="bg-white hover:bg-gray-200 border-b">
          <td colspan="6" class="text-center p-4">No results found.</td>
        </tr>
        @endif
      </tbody>
    </table>
  </div>
  @if($returns->count() > 0)
  <x-pagination :pagination="$returns" :per-page="$perPage" :per-page-options="[$perPage, 10, 20, 30, 50]" />
  @endif
</div>
<script>
  // Auto-hide success message after 2 seconds
  setTimeout(() => {
    document.getElementById('successOrFailedMessage')?.remove();
  }, 2000);
</script>
@endsection
