<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'Admin'))</title>

    <link rel="icon" type="image/x-icon" href="{{ asset('images/logo.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/flowbite@4.0.1/dist/flowbite.min.css" rel="stylesheet" />

    {{-- Vite: Tailwind CSS + Flowbite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')
</head>

<body class="bg-gray-50 dark:bg-gray-900 antialiased">

    @include('layouts.partials.navbar-dashboard')

    <div class="flex pt-16 overflow-hidden bg-gray-50 dark:bg-gray-900">

        @include('layouts.partials.sidebar')

        <div id="main-content"
             class="relative w-full h-full overflow-y-auto bg-gray-50 lg:ml-64 dark:bg-gray-900">

            <main class="p-4 w-full">
                {{-- Flash message sukses --}}
                @if (session('success'))
                    <div class="mb-4 p-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400"
                         role="alert">
                        {{ session('success') }}
                    </div>
                @endif

                {{-- Flash message error --}}
                @if (session('error'))
                    <div class="mb-4 p-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400"
                         role="alert">
                        {{ session('error') }}
                    </div>
                @endif

                {{-- Konten halaman di-inject di sini --}}
                @yield('content')
            </main>

            {{-- @include('layouts.partials.footer-dashboard') --}}

        </div>
    </div>

    {{-- Script tambahan per halaman --}}
    <script src="https://cdn.jsdelivr.net/npm/flowbite@4.0.1/dist/flowbite.min.js"></script>
    {{-- <script src="https://cdn.jsdelivr.net/npm/simple-datatables@9.0.3"></script> --}}

    @stack('scripts')

</body>
</html>
