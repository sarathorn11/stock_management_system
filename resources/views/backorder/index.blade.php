@extends('layouts.app')

@section('content')
<div id="content" class="w-full h-full">
  <h1 class="text-xl font-bold text-gray-800">List of Back Orders</h1>
    <form  method="GET" class="flex items-center my-4">
      <input type="text" name="query" class="px-3 py-[5px] w-[350px] rounded border" placeholder="BO code ,Name , Supplier  ...."
        value="{{ request('query') }}">
      <button type="submit" class="ml-2 bg-blue-500 text-white px-4 py-[6px] rounded hover:bg-blue-600">
        Search
      </button>
    </form> 
  @if(session('success'))
  <div id="success-message" class="bg-green-100 text-green-800 p-4 rounded mb-4">{{ session('success') }}</div>
  @endif
  <div class="w-full h-auto">
    <table class="table-auto w-full border-collapse">
      <thead class="bg-[#3c8dbc] text-white">
        <tr>
          <th class="px-4 py-2">No.</th>
          <th class="px-4 py-2">Date Created</th>
          <th class="px-4 py-2">BO Code</th>
          <th class="px-4 py-2">Supplier</th>
          <th class="px-4 py-2">Items</th>
          <th class="px-4 py-2">Status</th>
          <th class="px-4 py-2">Actions</th>
        </tr>
      </thead>
      <tbody id="backOrderResults">
        @foreach($backOrders as $index => $row)
          <tr class="bg-white hover:bg-gray-200 border-b">
            <td class="px-4 py-2 text-center">{{ $row->id }}</td>
            <td class="px-4 py-2 text-center">{{ date('Y-m-d H:i', strtotime($row->created_at)) }}</td>
            <td class="px-4 py-2 text-center">{{ $row->bo_code }}</td>
            <td class="px-4 py-2 text-center">{{ $row->supplier }}</td>
            <td class="px-4 py-2 text-center">{{ $row->items->count() }}</td>
            <td class="px-4 py-2 text-center">
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
            <td class="px-4 py-2 text-center">
              <a href="{{ route('back-order.show', $row->id) }}" class="text-blue-500 mx-1">
                <i class="fa fa-eye mr-2"></i>
              </a>
              @if($row->status == 0)
                <a href="{{ route('receiving.create', ['bo', $row->id]) }}" class="text-yellow-500 mx-1">
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

document.getElementById('searching').addEventListener('keyup', function() {
  let query = this.value;
  const searchUrl = '{{ route("back-order.index") }}';

  // Construct the new URL with the search query
  const url = new URL(searchUrl);
  url.searchParams.set('query', query);
  url.searchParams.set('perPage', '{{ $perPage }}');

  // Redirect to the new URL
  window.location.href = url.toString();
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
