<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>DarkTasks - Login</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>

    <body class="bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100 min-h-screen flex items-center justify-center">
        <div class="w-full max-w-md mx-auto bg-white dark:bg-gray-800 shadow-lg rounded-lg p-6">
            {{ $slot }}
        </div>
    </body>
</html>
