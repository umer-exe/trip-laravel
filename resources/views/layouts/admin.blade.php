<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Admin Panel' }} - Atlas Tours</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-100">
    <div class="min-h-screen">
        {{-- Admin Header --}}
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex">
                        {{-- Logo / Home Link --}}
                        <div class="shrink-0 flex items-center">
                            <a href="{{ route('admin.tours.index') }}" class="font-bold text-xl text-indigo-600">
                                Atlas Admin
                            </a>
                        </div>
                    </div>

                    <div class="flex items-center space-x-4">
                        {{-- View Site Link --}}
                        <a href="{{ route('home') }}" class="text-gray-600 hover:text-indigo-600 text-sm font-medium flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            View Site
                        </a>

                        {{-- Logout Button --}}
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-gray-600 hover:text-red-600 text-sm font-medium">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </header>

        {{-- Main Content --}}
        <main>
            @yield('content')
        </main>
    </div>
</body>
</html>
