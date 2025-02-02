<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Stock Management System</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  @vite('resources/css/app.css')
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <script src="{{ asset('js/app.js') }}" defer></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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

    .space-y-2> :not([hidden])~ :not([hidden]) {
      margin-top: unset !important;
    }

    /* Hide the title when the sidebar is collapsed */
    .sidebar-collapsed #system-title {
      display: none;
    }

    .sidebar-collapsed .fa-bars {
      display: none;
    }

    .sidebar-collapsed .fa {
      display: block;
    }

    /* Sidebar collapsed and expanded widths */
    .sidebar-collapsed {
      width: 4rem;
    }

    .sidebar-expanded {
      width: 16rem;
    }

    /* Add smooth transition for width change */
    #sidebar {
      transition: width 0.3s ease-in-out;
    }
  </style>
</head>

<body>
  <div class="bg-gray-100 min-h-screen flex">
    <div id="sidebar" class="bg-gray-800 flex flex-col sidebar-expanded">
      <div class="p-4 flex items-center">
        <img src="{{ asset('static/assets/images/logo.png') }}" alt="Logo" class="min-h-[40px] min-w-[40px] max-h-[40px] max-w-[40px] mr-3">
        <span id="system-title" class="font-bold text-md text-[#3c8dbc]">Stock Management <span
            class="text-[#FFA100]">System</span></span>
      </div>
      <nav class="flex-1 space-y-2">
        <!-- Sidebar links -->
        <a href="{{ url('/') }}"
          class="ajax-link flex items-center p-3 pl-6 {{ request()->routeIs('dashboard') ? 'bg-white text-[#3c8dbc]' : 'text-gray-300 hover:text-white hover:bg-gray-700' }}">
          <i class="mr-3 nav-icon fas fa-tachometer-alt"></i>
          <span id="system-title">Dashboard</span>
        </a>
        <a href="{{ route('purchase-order.index') }}"
          class="flex items-center p-3 pl-6 {{ request()->routeIs('purchase-order.index') ? 'bg-white text-[#3c8dbc]' : 'text-gray-300 hover:text-white hover:bg-gray-700' }}">
          <i class="mr-3 nav-icon fas fa-th-list"></i>
          <span id="system-title">Purchase Order</span>
        </a>
        <a href="{{ route('receiving.index') }}"
          class="flex items-center p-3 pl-6  {{ request()->routeIs('receiving.index') ? 'bg-white text-[#3c8dbc]' : 'text-gray-300 hover:text-white hover:bg-gray-700' }}">
          <i class="mr-3 nav-icon fas fa-boxes"></i>
          <span id="system-title">Receiving</span>
        </a>
        <a href="{{ route('back-order.index') }}"
          class="flex items-center p-3 pl-6 {{ request()->routeIs('back-order.*') ? 'bg-white text-[#3c8dbc]' : 'text-gray-300 hover:text-white hover:bg-gray-700' }}">
          <i class="mr-3 nav-icon fas fa-exchange-alt"></i>
          <span id="system-title">Back Order</span>
        </a>
        <a class="flex items-center p-3 text-gray-300 hover:text-white hover:bg-gray-700 pl-6">
          <i class="mr-3 nav-icon fas fa-undo"></i>
          <span id="system-title">Return List</span>
        </a>
        <a href="{{ route('stocks.index') }}"
          class="ajax-link flex items-center p-3 pl-6 {{ request()->routeIs('stocks.*') ? 'bg-white text-[#3C8BDC]' : 'text-gray-300 hover:text-white hover:bg-gray-700' }}">
          <i class="mr-3 nav-icon fas fa-table"></i>
          <span id="system-title">Stock List</span>
        </a>
        <a href="{{ route('sales.index') }}"
          class="ajax-link flex items-center p-3 pl-6 {{ request()->routeIs('sales.*') ? 'bg-white text-[#3c8Bdc]' : 'text-gray-300 hover:text-white hover:bg-gray-700' }}">
          <i class="mr-3 nav-icon fas fa-file-invoice-dollar" style="font-size: 20px"></i>
          <span id="system-title">Sale List</span>
        </a>

        <!-- Maintenance Section -->
        <div id="system-title" class="mt-6 text-gray-400 uppercase text-xs tracking-wider ml-5 p-3">Maintenance</div>
        <a class="flex items-center p-3 text-gray-300 hover:text-white hover:bg-gray-700 pl-6">
          <i class="mr-3 nav-icon fas fa-truck-loading"></i>
          <span id="system-title">Supplier List</span>
        </a>
        <a href="{{ route('items.index') }}"
          class="flex items-center p-3 text-gray-300 hover:text-white hover:bg-gray-700 pl-6">
          <i class="mr-3 nav-icon fas fa-boxes"></i>
          <span id="system-title">Item List</span>
        </a>
        <a class="flex items-center p-3 text-gray-300 hover:text-white hover:bg-gray-700 pl-6">
          <i class="mr-3 nav-icon fas fa-users"></i>
          <span id="system-title">User List</span>
        </a>
        <a href="{{ route('setting.index') }}"
          class="ajax-link flex items-center p-3 pl-6 {{ request()->routeIs('setting.*') ? 'bg-white text-[#3C8BDC]' : 'text-gray-300 hover:text-white hover:bg-gray-700' }}">
          <i class="mr-3 nav-icon fas fa-cogs"></i>
          <span id="system-title">Settings</span>
        </a>
      </nav>
    </div>

    <!-- Content Area with scroll -->
    <div class="flex-1 bg-gray-100 h-full">
      <nav class="bg-[#3c8dbc] text-white py-4 px-6 flex justify-between items-center">
        <div class="">
          <button id="sidebar-toggle" class="text-white text-[18px] mr-4">
            <i class="fa fa-bars"></i>
          </button>
          {{ $setting->system_name }}
        </div>
        <div class="">
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
    $(document).ready(function () {
      console.log('Document is ready');

      // AJAX click handling
      $('.ajax-link').on('click', function (e) {
        e.preventDefault();
        const url = $(this).attr('href');
        $.ajax({
          url: url,
          type: 'GET',
          beforeSend: function () {
            console.log('AJAX request is being sent');
            $('#content').html('<div>Loading...</div>');
          },
          success: function (response) {
            console.log('AJAX request successful');
            const newContent = $(response).find('#content').html();
            $('#content').html(newContent);
            history.pushState(null, '', url);
          },
          error: function () {
            console.log('AJAX request failed');
            alert('Failed to load the page.');
          },
        });
      });

      window.addEventListener('popstate', function () {
        console.log('Handling popstate event');
        $.ajax({
          url: location.href,
          type: 'GET',
          success: function (response) {
            const newContent = $(response).find('#content').html();
            $('#content').html(newContent);
            // Check if sidebar is collapsed and adjust button
            if ($('#sidebar').hasClass('sidebar-collapsed')) {
              $('#sidebar-toggle').html('<i class="fa fa-bars" aria-hidden="true"></i>');
            }
          },
          error: function () {
            alert('Failed to load the page.');
          },
        });
      });

      // Sidebar toggle functionality with animation
      $('#sidebar-toggle').on('click', function () {
        $('#sidebar').toggleClass('sidebar-collapsed sidebar-expanded'); // Toggle between collapsed and expanded classes
        $('#sidebar-toggle').html('<i class="fa fa-bars" aria-hidden="true"></i>');
      });
    });
  </script>
</body>

</html>
