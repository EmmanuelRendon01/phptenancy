<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ tenant('name') }} - Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body class="bg-gray-100">
    <!-- Navbar -->
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <h1 class="text-xl font-bold text-indigo-600">{{ tenant('name') }}</h1>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('tenant.dashboard') }}"
                        class="text-gray-700 hover:text-indigo-600 px-3 py-2 rounded-md text-sm font-medium">
                        Dashboard
                    </a>
                    <a href="{{ route('tenant.categories') }}"
                        class="text-gray-700 hover:text-indigo-600 px-3 py-2 rounded-md text-sm font-medium">
                        Categorías
                    </a>
                    <a href="{{ route('tenant.products') }}"
                        class="text-gray-700 hover:text-indigo-600 px-3 py-2 rounded-md text-sm font-medium">
                        Productos
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Contenido -->
    <main class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Dashboard</h2>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Card: Productos -->
                    <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg shadow-lg p-6 text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm opacity-80">Total Productos</p>
                                <p class="text-3xl font-bold">{{ \App\Models\Product::count() }}</p>
                            </div>
                            <svg class="w-12 h-12 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                        </div>
                        <a href="{{ route('tenant.products') }}" class="mt-4 inline-block text-sm underline">Ver
                            productos →</a>
                    </div>

                    <!-- Card: Categorías -->
                    <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-lg shadow-lg p-6 text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm opacity-80">Categorías</p>
                                <p class="text-3xl font-bold">{{ \App\Models\Category::count() }}</p>
                            </div>
                            <svg class="w-12 h-12 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                            </svg>
                        </div>
                        <a href="{{ route('tenant.categories') }}" class="mt-4 inline-block text-sm underline">Ver
                            categorías →</a>
                    </div>

                    <!-- Card: Stock Bajo -->
                    <div class="bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-lg shadow-lg p-6 text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm opacity-80">Stock Bajo</p>
                                <p class="text-3xl font-bold">
                                    {{ \App\Models\Product::where('stock', '<=', 10)->count() }}</p>
                            </div>
                            <svg class="w-12 h-12 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <a href="{{ route('tenant.products') }}" class="mt-4 inline-block text-sm underline">Revisar
                            inventario →</a>
                    </div>
                </div>

                <!-- Información del Tenant -->
                <div class="mt-8 bg-gray-50 rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Información del Tenant</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-600">ID</p>
                            <p class="font-semibold">{{ tenant('id') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Nombre</p>
                            <p class="font-semibold">{{ tenant('name') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Plan</p>
                            <p class="font-semibold capitalize">{{ tenant('plan') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Email</p>
                            <p class="font-semibold">{{ tenant('email') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    @livewireScripts
</body>

</html>