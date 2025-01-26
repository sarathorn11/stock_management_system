@extends('layouts.app')

@section('content')
<div class="w-full h-full">
  <h1 class="text-3xl font-bold text-gray-800">Purchase Order List</h1>
  <div class="flex items-center justify-between my-4">
    <input type="text" placeholder="Search..." class="px-3 py-2 w-[350px] rounded border-gray-300">
    <div class="flex items-center justify-between">
      <a href="{{ route('purchase-order.create') }}"
        class="inline-block bg-blue-500 text-white px-4 py-2 rounded mb-4 hover:bg-blue-600">Create</a>
      <a class="inline-block bg-gray-300 text-black px-4 py-2 rounded mb-4 hover:bg-gray-400 ml-2">
        <i class="fa fa-cog mr-2"></i>Option
      </a>
    </div>
  </div>
  <!-- @if(session('success'))
  <div class="bg-green-100 text-green-800 p-4 rounded mb-4">{{ session('success') }}</div>
  @endif -->
  <div class="w-full h-full">
    <table class="table-auto w-full">
      <thead class="bg-blue-500 text-white">
        <tr>
          <th class="px-4 py-4">ID</th>
          <th class="px-4 py-4">Date Created</th>
          <th class="px-4 py-4">PO Code</th>
          <th class="px-4 py-4">Supplier</th>
          <th class="px-4 py-4">Items</th>
          <th class="px-4 py-4">Status</th>
         
        </tr>
      </thead>
      <tbody>

        <tr class="bg-white hover:bg-gray-200">
          <td class="px-4 py-2 text-center">test</td>
          <td class="px-4 py-2 text-center">test</td>
          <td class="px-4 py-2 text-center">test</td>
          <td class="px-4 py-2 text-center">test</td>
          <td class="px-4 py-2 text-center">test</td>
          <td class="px-4 py-2 text-center">test</td>
       
        </tr>
      </tbody>
    </table>
  </div>
</div>

@endsection