<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Kasir App') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans text-gray-900 antialiased bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen">

    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">

        <!-- Logo / App Name -->
        <div class="mb-6 text-center">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-blue-600 rounded-2xl shadow-lg mb-3">
                <span class="text-3xl">🧾</span>
            </div>
            <h1 class="text-2xl font-bold text-gray-800">Kasir App</h1>
            <p class="text-sm text-gray-500 mt-1">Sistem Informasi Point of Sale</p>
        </div>

        <!-- Card -->
        <div class="w-full sm:max-w-md px-6 py-8 bg-white shadow-xl rounded-2xl">
            {{ $slot }}
        </div>

    </div>
</body>
</html>
