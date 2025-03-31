<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stock Management System</title>
    @vite('resources/css/app.css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="{{ asset('js/app.js') }}" defer></script>
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center" style="background-image: url('https://st5.depositphotos.com/32431760/74442/i/450/depositphotos_744429804-stock-photo-focused-asian-warehouse-worker-scanning.jpg'); background-size: cover; background-position: center;">
    <div class="bg-white rounded-lg shadow-lg p-6 max-w-md w-full mx-auto mt-10">
        <!-- <div class="flex justify-center mb-4">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-16 w-16 rounded-full">
        </div> -->
        <div class="text-center mb-4">
            <h1 class="text-2xl font-bold text-gray-800">Stock Management System</h1>
            <p class="text-gray-600">Login to your account</p>
        </div>
        @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-4 rounded mb-4" role="alert" aria-live="assertive">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form method="POST" action="{{ route('login') }}" class="mx-5">
            @csrf
            <div class="mb-4">
                <label for="email" class="block text-gray-700">Email</label>
                <input type="email" id="email" name="email" class="w-full border border-gray-300 rounded p-2 focus:ring focus:ring-blue-200" required aria-required="true">
            </div>
            <div class="mb-4">
                <label for="password" class="block text-gray-700">Password</label>
                <input type="password" id="password" name="password" class="w-full border border-gray-300 rounded p-2 focus:ring focus:ring-blue-200" required aria-required="true">
            </div>
            <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded hover:bg-blue-600 focus:outline-none focus:ring focus:ring-blue-300">
                Login
            </button>
        </form>
    </div>
</body>

</html>
