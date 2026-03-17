<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Driver & Trainer') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
    </head>
    <body class="font-sans antialiased bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
        <div class="min-h-screen">
            <nav class="bg-white border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex">
                            <div class="shrink-0 flex items-center gap-2">
                                <img src="{{ asset('images/logo.svg') }}" alt="Logo" class="block dark:hidden h-8 w-auto">
                                <img src="{{ asset('images/logo-dark.svg') }}" alt="Logo Dark" class="hidden dark:block h-8 w-auto">
                                <a href="{{ route('dashboard') }}" class="font-bold text-xl text-blue-600 dark:text-blue-500">
                                    Driver & Trainer
                                </a>
                            </div>
                        </div>
                        <div class="hidden sm:flex sm:items-center sm:ms-6">
                            @auth
                            <div class="flex items-center gap-4">
                                <span class="text-sm font-medium">{{ auth()->user()->full_name }}</span>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="text-sm text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-white">Cerrar Sesión</button>
                                </form>
                            </div>
                            @endauth
                        </div>
                        <div class="-me-2 flex items-center sm:hidden">
                            <button data-collapse-toggle="navbar-mobile" type="button" class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600" aria-controls="navbar-mobile" aria-expanded="false">
                                <span class="sr-only">Abrir menú</span>
                                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="hidden sm:hidden" id="navbar-mobile">
                    @auth
                    <div class="pt-2 pb-3 space-y-1">
                        <div class="px-4 py-2 text-sm text-gray-500 dark:text-gray-400">
                            {{ auth()->user()->full_name }}
                        </div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="block w-full text-left px-4 py-2 text-base font-medium text-gray-600 dark:text-gray-300 hover:bg-gray-100 hover:text-gray-800 dark:hover:bg-gray-700">Cerrar Sesión</button>
                        </form>
                    </div>
                    @endauth
                </div>
            </nav>

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
        
        <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
        @livewireScripts
    </body>
</html>
