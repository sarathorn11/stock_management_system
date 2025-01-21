@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="w-full h-full">
  <h1 class="text-3xl font-bold text-gray-800 mb-4">Dashboard</h1>
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
    <div class="bg-white text-black rounded-lg shadow-lg p-3 flex">
      <div class="min-w-[66px] min-h-[66px] flex items-center justify-center bg-[#17a2b8] mr-3 rounded text-white">
        <i class="fas fa-th-list text-[30px]"></i>
      </div>
      <div class="flex-col w-full">
        <div class="text-lg font-semibold">PO Records</div>
        <div class="text-right text-[30px]">1</div>
      </div>
    </div>
    <div class="bg-white text-black rounded-lg shadow-lg p-3 flex">
      <div class="min-w-[66px] min-h-[66px] flex items-center justify-center bg-[#ffc107] mr-3 rounded text-white">
        <i class="fas fa-boxes text-[30px]"></i>
      </div>
      <div class="flex-col w-full">
        <div class="text-lg font-semibold">Receiving Records</div>
        <div class="text-right text-[30px]">1</div>
      </div>
    </div>
    <div class="bg-white text-black rounded-lg shadow-lg p-3 flex">
      <div class="min-w-[66px] min-h-[66px] flex items-center justify-center bg-[#007bff] mr-3 rounded text-white">
        <i class="fas fa-exchange-alt text-[30px]"></i>
      </div>
      <div class="flex-col w-full">
        <div class="text-lg font-semibold">BO Records</div>
        <div class="text-right text-[30px]">1</div>
      </div>
    </div>
    <div class="bg-white text-black rounded-lg shadow-lg p-3 flex">
      <div class="min-w-[66px] min-h-[66px] flex items-center justify-center bg-[#cd3545] mr-3 rounded text-white">
        <i class="fas fa-undo text-[30px]"></i>
      </div>
      <div class="flex-col w-full">
        <div class="text-lg font-semibold">Return Records</div>
        <div class="text-right text-[30px]">1</div>
      </div>
    </div>
  </div>
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
    <div class="bg-white text-black rounded-lg shadow-lg p-3 flex">
      <div class="min-w-[66px] min-h-[66px] flex items-center justify-center bg-[#28a745] mr-3 rounded text-white">
        <i class="fas fa-file-invoice-dollar text-[30px]"></i>
      </div>
      <div class="flex-col w-full">
        <div class="text-lg font-semibold">Sales Records</div>
        <div class="text-right text-[30px]">1</div>
      </div>
    </div>
    <div class="bg-white text-black rounded-lg shadow-lg p-3 flex">
      <div class="min-w-[66px] min-h-[66px] flex items-center justify-center bg-[#001f3f] mr-3 rounded text-white">
        <i class="fas fa-truck-loading text-[30px]"></i>
      </div>
      <div class="flex-col w-full">
        <div class="text-lg font-semibold">Suppliers</div>
        <div class="text-right text-[30px]">1</div>
      </div>
    </div>
    <div class="bg-white text-black rounded-lg shadow-lg p-3 flex">
      <div class="min-w-[66px] min-h-[66px] flex items-center justify-center bg-[#3c8dbc] mr-3 rounded text-white">
        <i class="fas fa-th-list text-[30px]"></i>
      </div>
      <div class="flex-col w-full">
        <div class="text-lg font-semibold">Items</div>
        <div class="text-right text-[30px]">1</div>
      </div>
    </div>
    <div class="bg-white text-black rounded-lg shadow-lg p-3 flex">
      <div class="min-w-[66px] min-h-[66px] flex items-center justify-center bg-[#20c997] mr-3 rounded text-white">
        <i class="fas fa-users text-[30px]"></i>
      </div>
      <div class="flex-col w-full">
        <div class="text-lg font-semibold">Users</div>
        <div class="text-right text-[30px]">1</div>
      </div>
    </div>
  </div>


</div>
@endsection