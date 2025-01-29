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
    <div class="bg-gray-800 min-w-64 max-w-64 flex flex-col">
      <div class="p-4 flex items-center">
        <img src="{{ asset('static/assets/images/logo.png') }}" alt="Logo" class="h-[50px] w-[50px] mr-3">
        <span class="font-bold text-md text-[#3c8dbc]">Stock Management <span
            class="text-[#FFA100]">System</span></span>
      </div>
      <nav class="flex-1 space-y-2">
        <!-- Sidebar links -->
        <a href="{{ url('/') }}"
          class="ajax-link flex items-center p-2 text-gray-300 hover:bg-gray-700 hover:text-white pl-6 {{ request()->routeIs('dashboard') ? 'bg-white text-[#3c8dbc]' : '' }}">
          <i class="mr-3 nav-icon fas fa-tachometer-alt"></i>
          Dashboard
        </a>
        <a href="{{ route('purchase-order.index') }}"
          class="flex items-center p-2 text-gray-300 hover:bg-gray-700 hover:text-white pl-6 {{ request()->routeIs('purchase-order.index') ? 'bg-white text-[#3c8dbc]' : '' }}">
          <i class="mr-3 nav-icon fas fa-th-list"></i>
          Purchase Order
        </a>
        <a href="{{ route('receiving.index') }}"
          class="flex items-center p-2 text-gray-300 hover:bg-gray-700 hover:text-white pl-6  {{ request()->routeIs('receiving.index') ? 'bg-white text-[#3c8dbc]' : '' }}">
          <i class="mr-3 nav-icon fas fa-boxes"></i>
          Receiving
        </a>
        <a class="flex items-center p-2 text-gray-300 hover:bg-gray-700 hover:text-white pl-6">
          <i class="mr-3 nav-icon fas fa-exchange-alt"></i>
          Back Order
        </a>
        <a class="flex items-center p-2 text-gray-300 hover:bg-gray-700 hover:text-white pl-6">
          <i class="mr-3 nav-icon fas fa-undo"></i>
          Return List
        </a>
        <a href="{{ route('stocks.index') }}"
          class="ajax-link flex items-center p-2 text-gray-300 hover:bg-gray-700 hover:text-white pl-6 {{ request()->routeIs('stocks.*') ? 'bg-white text-[#3C8BDC]' : '' }}">
          <i class="mr-3 nav-icon fas fa-table"></i>
          Stock List
        </a>
        <a href="{{ route('sales.index') }}"
          class="ajax-link flex items-center p-2 text-gray-300 hover:bg-gray-700 hover:text-white pl-6 {{ request()->routeIs('sales.*') ? 'bg-white text-[#3c8Bdc]' : '' }}">
          <i class="mr-3 nav-icon fas fa-file-invoice-dollar" style="font-size: 20px"></i>
          Sale List
        </a>

        <!-- Maintenance Section -->
        <div class="mt-6 text-gray-400 uppercase text-xs tracking-wider ml-5">Maintenance</div>
        <a class="flex items-center p-2 text-gray-300 hover:bg-gray-700 hover:text-white pl-6">
          <i class="mr-3 nav-icon fas fa-truck-loading"></i>
          Supplier List
        </a>
        <a class="flex items-center p-2 text-gray-300 hover:bg-gray-700 hover:text-white pl-6">
          <i class="mr-3 nav-icon fas fa-boxes"></i>
          Item List
        </a>
        <a class="flex items-center p-2 text-gray-300 hover:bg-gray-700 hover:text-white pl-6">
          <i class="mr-3 nav-icon fas fa-users"></i>
          User List
        </a>
        <a href="{{ route('setting.index') }}"
          class="ajax-link flex items-center p-2 text-gray-300 hover:bg-gray-700 hover:text-white pl-6 {{ request()->routeIs('setting.*') ? 'bg-white text-[#3C8BDC]' : '' }}">
          <i class="mr-3 nav-icon fas fa-cogs"></i>
          Settings
        </a>
      </nav>
    </div>

    <!-- Content Area with scroll -->
    <div class="flex-1 bg-gray-100 h-full">
      <nav class="bg-[#3c8dbc] text-white py-4 px-8">
        <div class="mx-auto flex justify-end items-center">
          <div class="space-x-4">
            Admin
          </div>
        </div>
      </nav>
      <div id="content" class="content p-6 bg-[#f3f6f9]">
        @yield('content')
      </div>
    </div>
  </div>
  <script>
  $(document).ready(function() {
    console.log('Document is ready');
    $('.ajax-link').on('click', function(e) {
      e.preventDefault(); 
      const url = $(this).attr('href');
      $.ajax({
        url: url,
        type: 'GET',
        beforeSend: function() {
          console.log('AJAX request is being sent');
          $('#content').html('<div>Loading...</div>');
        },
        success: function(response) {
          console.log('AJAX request successful');
          const newContent = $(response).find('#content').html();
          $('#content').html(newContent);
          history.pushState(null, '', url);
        },
        error: function() {
          console.log('AJAX request failed');
          alert('Failed to load the page.');
        },
      });
    });

    window.addEventListener('popstate', function() {
      console.log('Handling popstate event');
      $.ajax({
        url: location.href,
        type: 'GET',
        success: function(response) {
          const newContent = $(response).find('#content').html();
          $('#content').html(newContent);
        },
        error: function() {
          alert('Failed to load the page.');
        },
      });
    });
  });
  </script>
</body>

</html>