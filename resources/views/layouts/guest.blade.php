<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased text-gray-900">
    <div class="flex flex-col items-center min-h-screen pt-6 bg-white sm:justify-center sm:pt-0">
        <div>
            <x-application-logo />
            
        </div>
        <div class="w-full px-6 py-4 mt-6 overflow-hidden bg-white shadow-xl sm:max-w-md sm:rounded-lg">
            {{ $slot }}
        </div>
        <h3>Cargo v1.0</h3>
    </div>
</body>

</html>