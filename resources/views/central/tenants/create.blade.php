<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Crear Nuevo Tenant') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">

                <form action="{{ route('tenants.store') }}" method="POST">
                    @csrf

                    <!-- Nombre -->
                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700">Nombre del Tenant</label>
                        <input type="text" name="name" id="name"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            value="{{ old('name') }}" required>
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="mb-4">
                        <label for="email" class="block text-sm font-medium text-gray-700">Email de Contacto</label>
                        <input type="email" name="email" id="email"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            value="{{ old('email') }}">
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Subdominio -->
                    <div class="mb-4">
                        <label for="subdomain" class="block text-sm font-medium text-gray-700">Subdominio</label>
                        <div class="mt-1 flex rounded-md shadow-sm">
                            <input type="text" name="subdomain" id="subdomain"
                                class="block w-full rounded-l-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                                value="{{ old('subdomain') }}" required placeholder="mi-empresa">
                            <span
                                class="inline-flex items-center px-3 rounded-r-md border border-l-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">
                                .localhost:8000
                            </span>
                        </div>
                        @error('subdomain')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Plan -->
                    <div class="mb-6">
                        <label for="plan" class="block text-sm font-medium text-gray-700">Plan de Suscripción</label>
                        <select name="plan" id="plan"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="basic" {{ old('plan') == 'basic' ? 'selected' : '' }}>Basic - Gratis</option>
                            <option value="pro" {{ old('plan') == 'pro' ? 'selected' : '' }}>Pro - $29/mes</option>
                            <option value="enterprise" {{ old('plan') == 'enterprise' ? 'selected' : '' }}>Enterprise -
                                $99/mes</option>
                        </select>
                        @error('plan')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Botones -->
                    <div class="flex justify-end gap-4">
                        <a href="{{ route('tenants.index') }}"
                            class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold py-2 px-4 rounded">
                            Cancelar
                        </a>
                        <button type="submit"
                            class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                            Crear Tenant
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>