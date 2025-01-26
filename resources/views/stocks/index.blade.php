@extends('layouts.app')

@section('content')
<div id="content" class="w-full h-full">
  <h1 class="text-3xl font-bold text-gray-800">Stock List</h1>
  <div class="flex items-center justify-between my-4">
    <input id="search" type="text" placeholder="Search by Item ID..." class="px-3 py-2 w-[350px] rounded border">
    <div class="flex items-center justify-between">
      <a href="{{ route('stocks.create') }}"
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
          <th class="p-4">ID</th>
          <th class="p-4">Item ID</th>
          <th class="p-4">Quantity</th>
          <th class="p-4">Unit</th>
          <th class="p-4">Price</th>
          <th class="p-4">Total</th>
          <th class="p-4">Type</th>
          <th class="p-4">Date Created</th>
          <th class="p-4">Actions</th>
        </tr>
      </thead>
      <tbody id="stockResults">
        @foreach($stocks as $stock)
        <tr class="bg-white hover:bg-gray-200">
          <td class="p-4 text-center">{{ $stock->id }}</td>
          <td class="p-4 text-center">{{ $stock->item_id }}</td>
          <td class="p-4 text-center">{{ $stock->quantity }}</td>
          <td class="p-4 text-center">{{ $stock->unit }}</td>
          <td class="p-4 text-center">{{ $stock->price }}</td>
          <td class="p-4 text-center">{{ $stock->total }}</td>
          <td class="p-4 text-center">{{ $stock->type == 1 ? 'IN' : 'OUT' }}</td>
          <td class="p-4 text-center">{{ \Carbon\Carbon::parse($stock->date_created)->format('Y-m-d h:i A') }}</td>
          <td class="p-4 flex items-center justify-center">
            <a href="{{ route('stocks.show', $stock->id) }}" class="text-blue-500 text-[24px] mx-1">
              <i class="fa fa-eye mr-2"></i>
            </a>
            <a href="{{ route('stocks.edit', $stock->id) }}" class="text-yellow-500 text-[24px] mx-1">
              <i class="fa fa-pencil mr-2"></i>
            </a>
            <form action="{{ route('stocks.destroy', $stock->id) }}" method="POST"
              onsubmit="return confirm('Are you sure you want to delete this stock?')" class="m-0">
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
  <x-pagination :pagination="$stocks" :per-page="$perPage" :per-page-options="[$perPage, 5, 10, 25, 50]" />
</div>

<script>
document.getElementById('search').addEventListener('keyup', function() {
  let query = this.value;
  const searchUrl = '{{ route("stocks.search") }}'; // This will generate the correct URL

  // Make the AJAX request
  fetch(`${searchUrl}?query=${query}`, {
      method: 'GET',
      headers: {
        'Accept': 'application/json',
      },
    })
    .then(response => response.json())
    .then(data => {
      let stockResults = document.getElementById('stockResults');
      stockResults.innerHTML = ''; // Clear the current results

      data.stocks.data.forEach(stock => {
        let row = document.createElement('tr');
        row.classList.add('bg-white', 'hover:bg-gray-200');

        row.innerHTML = `
          <td class="p-4 text-center">${stock.id}</td>
          <td class="p-4 text-center">${stock.item_id}</td>
          <td class="p-4 text-center">${stock.quantity}</td>
          <td class="p-4 text-center">${stock.unit}</td>
          <td class="p-4 text-center">${stock.price}</td>
          <td class="p-4 text-center">${stock.total}</td>
          <td class="p-4 text-center">${stock.type === 1 ? 'IN' : 'OUT'}</td>
          <td class="p-4 text-center">${new Date(stock.date_created).toLocaleString()}</td>
          <td class="p-4 flex items-center justify-center">
            <a href="/stocks/${stock.id}" class="text-blue-500 text-[24px] mx-1">
              <i class="fa fa-eye mr-2"></i>
            </a>
            <a href="/stocks/${stock.id}/edit" class="text-yellow-500 text-[24px] mx-1">
              <i class="fa fa-pencil mr-2"></i>
            </a>
            <form action="/stocks/${stock.id}" method="POST" onsubmit="return confirm('Are you sure you want to delete this stock?')" class="m-0">
              <input type="hidden" name="_method" value="DELETE">
              <button type="submit" class="text-red-500 text-[24px] mx-1">
                <i class="fa fa-trash mr-2"></i>
              </button>
            </form>
          </td>
        `;
        stockResults.appendChild(row);
      });
    });
});
</script>

@endsection