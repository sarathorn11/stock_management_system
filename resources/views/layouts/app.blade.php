<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="{{ asset('js/app.js') }}" defer></script>
</head>
<body>
    <nav>
        <!-- Add your navigation bar here -->
        <a href="{{ url('/') }}">Home</a>
        <a href="{{ route('stocks.index') }}">Stocks</a>
    </nav>

    <div class="container">
        @yield('content')
    </div>
</body>
</html>
