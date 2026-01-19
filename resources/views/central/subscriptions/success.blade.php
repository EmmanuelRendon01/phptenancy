<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pago Exitoso') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-8 text-center">
                <div class="mb-6">
                    <svg class="w-20 h-20 text-green-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>

                <h3 class="text-3xl font-bold text-gray-900 mb-4">¡Suscripción Activada!</h3>
                <p class="text-gray-600 mb-8">
                    Tu suscripción al plan <span
                        class="font-semibold text-indigo-600">{{ ucfirst($tenant->plan) }}</span> ha sido activada
                    exitosamente.
                </p>

                <div class="space-y-3">
                    <a href="{{ route('tenants.index') }}"
                        class="inline-block bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-6 rounded">
                        Volver al Dashboard
                    </a>
                    <br>
                    <a href="http://{{ $tenant->domains->first()->domain }}.localhost:8000" target="_blank"
                        class="inline-block bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-3 px-6 rounded">
                        Ir a mi Tenant
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>