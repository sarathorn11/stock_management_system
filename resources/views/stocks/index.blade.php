@extends('layouts.app')

@section('content')
<div class="w-full h-full">
  <h1 class="text-3xl font-bold text-gray-800">Stock List</h1>
  <div class="flex items-center justify-between my-4">
    <input type="text" placeholder="Search..." class="px-3 py-2 w-[350px] rounded border-gray-300">
    <div class="flex items-center justify-between">
      <a href="{{ route('stocks.create') }}"
        class="inline-block bg-blue-500 text-white px-4 py-2 rounded mb-4 hover:bg-blue-600">Create</a>
      <a href="{{ route('stocks.create') }}"
        class="inline-block bg-gray-400 text-black px-4 py-2 rounded mb-4 hover:bg-blue-600 ml-2"><i
          class="fa fa-cog mr-2"></i>Option</a>
    </div>
  </div>
  @if(session('success'))
  <div class="bg-green-100 text-green-800 p-4 rounded mb-4">{{ session('success') }}</div>
  @endif
  <div class="overflow-x-auto">
    <table class="table-auto w-full">
      <thead class="bg-blue-500 text-white">
        <tr>
          <th class="px-4 py-4">ID</th>
          <th class="px-4 py-4">Item ID</th>
          <th class="px-4 py-4">Quantity</th>
          <th class="px-4 py-4">Unit</th>
          <th class="px-4 py-4">Price</th>
          <th class="px-4 py-4">Total</th>
          <th class="px-4 py-4">Type</th>
          <th class="px-4 py-4">Date Created</th>
          <th class="px-4 py-4">Actions</th>
        </tr>
      </thead>
      <tbody>
        @foreach($stocks as $stock)
        <tr class="bg-white hover:bg-gray-200">
          <td class="px-4 py-2 text-center">{{ $stock->id }}</td>
          <td class="px-4 py-2 text-center">{{ $stock->item_id }}</td>
          <td class="px-4 py-2 text-center">{{ $stock->quantity }}</td>
          <td class="px-4 py-2 text-center">{{ $stock->unit }}</td>
          <td class="px-4 py-2 text-center">{{ $stock->price }}</td>
          <td class="px-4 py-2 text-center">{{ $stock->total }}</td>
          <td class="px-4 py-2 text-center">{{ $stock->type == 1 ? 'IN' : 'OUT' }}</td>
          <td class="px-4 py-2 text-center">{{ $stock->date_created }}</td>
          <td class="px-4 py-2 text-center">
            <div class="relative inline-block text-left">
              <button type="button"
                class="text-gray-500 px-2 py-1 rounded text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                id="dropdownMenuButton{{ $stock->id }}">
                <i class="fas fa-chevron-down"></i>
              </button>
              <div class="dropdown-menu hidden absolute right-0 w-48 mt-2 bg-white shadow-lg rounded-md z-10"
                aria-labelledby="dropdownMenuButton{{ $stock->id }}">
                <div class="py-1">
                  <a href="{{ route('stocks.show', $stock->id) }}"
                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">View</a>
                  <a href="{{ route('stocks.edit', $stock->id) }}"
                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Edit</a>
                  <form action="{{ route('stocks.destroy', $stock->id) }}" method="POST"
                    onsubmit="return confirm('Are you sure you want to delete this stock?')" class="m-0">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                      class="block w-full px-4 py-2 text-sm text-red-500 hover:bg-red-100 text-left border-0 bg-transparent cursor-pointer">
                      Delete
                    </button>
                  </form>
                </div>
              </div>
            </div>
          </td>
          <script>
          document.getElementById('dropdownMenuButton{{ $stock->id }}').addEventListener('click', function() {
            const dropdown = document.querySelector('#dropdownMenuButton{{ $stock->id }}').nextElementSibling;
            dropdown.classList.toggle('hidden');
          });
          window.addEventListener('click', function(event) {
            if (!event.target.closest('.relative')) {
              const dropdowns = document.querySelectorAll('.dropdown-menu');
              dropdowns.forEach(dropdown => {
                dropdown.classList.add('hidden');
              });
            }
          });
          </script>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>

@endsection