<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    {{-- Required for React Fast Refresh in Laravel + Vite dev mode. --}}
    @viteReactRefresh
    @vite(['resources/css/app.css', 'resources/js/inertia-app.jsx'])
    @inertiaHead
</head>
<body class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] dark:text-[#EDEDEC] min-h-screen antialiased">
    @inertia
</body>
</html>
