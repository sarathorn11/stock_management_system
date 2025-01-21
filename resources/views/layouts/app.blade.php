<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Stock Management System</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  @vite('resources/css/app.css')
  <script src="{{ asset('js/app.js') }}" defer></script>
  <style>
  html,
  body {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
  }

  .content {
    overflow-y: auto;
    height: calc(100vh - 64px);
  }
  </style>
</head>

<body>
  <div class="bg-gray-100 min-h-screen flex">
    <div class="bg-gray-800 w-64 flex flex-col">
      <div class="p-4 flex items-center">
        <img src="{{ asset('static/assets/images/logo.png') }}" alt="Logo" class="h-[50px] w-[50px] mr-3">
        <span class="font-bold text-md text-[#3C8DBC]">Stock Management <span
            class="text-[#FFA100]">System</span></span>
      </div>
      <nav class="flex-1 space-y-2">
        <!-- Sidebar links -->
        <!-- <a href="{{ route('dashboard') }}"
          class="flex items-center p-2 text-gray-300 hover:bg-gray-700 hover:text-white pl-6 {{ request()->routeIs('dashboard') ? 'bg-white text-[#3C8DBC]' : '' }}">
          <i class="fa fa-tachometer mr-3" aria-hidden="true"></i>
          Dashboard
        </a> -->
        <a
          class="flex items-center p-2 text-gray-300 hover:bg-gray-700 hover:text-white pl-6">
          <i class="fa fa-tachometer mr-3" aria-hidden="true"></i>
          Dashboard
        </a>
        <!-- <a href="{{ route('purchase-order.index') }}"
          class="flex items-center p-2 text-gray-300 hover:bg-gray-700 hover:text-white pl-6 {{ request()->routeIs('purchase-order.index') ? 'bg-white text-[#3C8DBC]' : '' }}">
          <i class="fas fa-file-alt mr-3"></i>
          Purchase Order
        </a> -->
        <a class="flex items-center p-2 text-gray-300 hover:bg-gray-700 hover:text-white pl-6">
          <i class="fas fa-file-alt mr-3"></i>
          Purchase Order
        </a>
        <!-- <a href="{{ route('receiving.index') }}"
          class="flex items-center p-2 text-gray-300 hover:bg-gray-700 hover:text-white pl-6 {{ request()->routeIs('receiving.index') ? 'bg-white text-[#3C8DBC]' : '' }}">
          <i class="fas fa-box mr-3"></i>
          Receiving
        </a> -->
        <a class="flex items-center p-2 text-gray-300 hover:bg-gray-700 hover:text-white pl-6 ">
          <i class="fas fa-box mr-3"></i>
          Receiving
        </a>
        <!-- <a href="{{ route('back-order.index') }}"
          class="flex items-center p-2 text-gray-300 hover:bg-gray-700 hover:text-white pl-6 {{ request()->routeIs('back-order.index') ? 'bg-white text-[#3C8DBC]' : '' }}">
          <i class="fas fa-undo mr-3"></i>
          Back Order
        </a> -->
        <a class="flex items-center p-2 text-gray-300 hover:bg-gray-700 hover:text-white pl-6">
          <i class="fas fa-undo mr-3"></i>
          Back Order
        </a>
        <!-- <a href="{{ route('return.index') }}"
          class="flex items-center p-2 text-gray-300 hover:bg-gray-700 hover:text-white pl-6 {{ request()->routeIs('return.index') ? 'bg-white text-[#3C8DBC]' : '' }}">
          <i class="fas fa-reply mr-3"></i>
          Return List
        </a> -->
        <a class="flex items-center p-2 text-gray-300 hover:bg-gray-700 hover:text-white pl-6">
          <i class="fas fa-reply mr-3"></i>
          Return List
        </a>
        <a href="{{ route('stocks.index') }}"
          class="flex items-center p-2 text-gray-300 hover:bg-gray-700 hover:text-white pl-6 {{ request()->routeIs('stocks.index') ? 'bg-white text-[#3C8DBC]' : '' }}">
          <i class="fas fa-warehouse mr-3"></i>
          Stocks
        </a>

        <!-- Maintenance Section -->
        <div class="mt-6 text-gray-400 uppercase text-xs tracking-wider">Maintenance</div>
        <!-- <a href="{{ route('supplier.index') }}"
          class="flex items-center p-2 text-gray-300 hover:bg-gray-700 hover:text-white pl-6 {{ request()->routeIs('supplier.index') ? 'bg-white text-[#3C8DBC]' : '' }}">
          <i class="fas fa-truck mr-3"></i>
          Supplier List
        </a> -->
        <a class="flex items-center p-2 text-gray-300 hover:bg-gray-700 hover:text-white pl-6">
          <i class="fas fa-truck mr-3"></i>
          Supplier List
        </a>
        <!-- <a href="{{ route('item.index') }}"
          class="flex items-center p-2 text-gray-300 hover:bg-gray-700 hover:text-white pl-6 {{ request()->routeIs('item.index') ? 'bg-white text-[#3C8DBC]' : '' }}">
          <i class="fas fa-boxes mr-3"></i>
          Item List
        </a> -->
        <a class="flex items-center p-2 text-gray-300 hover:bg-gray-700 hover:text-white pl-6">
          <i class="fas fa-boxes mr-3"></i>
          Item List
        </a>
        <!-- <a href="{{ route('user.index') }}"
          class="flex items-center p-2 text-gray-300 hover:bg-gray-700 hover:text-white pl-6 {{ request()->routeIs('user.index') ? 'bg-white text-[#3C8DBC]' : '' }}">
          <i class="fas fa-users mr-3"></i>
          User List
        </a> -->
        <a class="flex items-center p-2 text-gray-300 hover:bg-gray-700 hover:text-white pl-6">
          <i class="fas fa-users mr-3"></i>
          User List
        </a>
        <!-- <a href="{{ route('settings.index') }}"
          class="flex items-center p-2 text-gray-300 hover:bg-gray-700 hover:text-white pl-6 {{ request()->routeIs('settings.index') ? 'bg-white text-[#3C8DBC]' : '' }}">
          <i class="fas fa-cog mr-3"></i>
          Settings
        </a> -->
        <a class="flex items-center p-2 text-gray-300 hover:bg-gray-700 hover:text-white pl-6">
          <i class="fas fa-cog mr-3"></i>
          Settings
        </a>
      </nav>
    </div>

    <!-- Content Area with scroll -->
    <div class="flex-1 bg-gray-100 h-full">
      <nav class="bg-[#3C8DBC] text-white py-4 px-8">
        <div class="mx-auto flex justify-end items-center">
          <div class="space-x-4">
            Admin
          </div>
        </div>
      </nav>
      <div class="content p-8 bg-[#F4F6F9]">
        @yield('content')
      </div>
    </div>
  </div>
</body>

</html>